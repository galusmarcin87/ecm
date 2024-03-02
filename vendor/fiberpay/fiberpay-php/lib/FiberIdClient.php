<?php

namespace FiberPay;

use Exception;
use JWT;
use GuzzleHttp\Client as Client;
use Illuminate\Http\Request;

/**
 * Class FiberIdClient
 * @package App\Clients\
 */
class FiberIdClient
{
    public static $ENCRYPTION_METHOD = 'aes-256-cbc';

    /** @var string */
    private $url;

    /** @var string */
    private $apiKey;

    /** @var string */
    private $secret;

    /** @var string */
    private $callbackUrl;

    /** @var string */
    private $redirectUrl;

    /** @var string */
    private $description;

    public function __construct($apiKey, $apiSecret, $testServer = false)
    {
        $this->url = $testServer  ? 'https://apiver3.fiberpay.pl/api/orders': 'https://apiver.fiberpay.pl/api/orders';
        $this->apiKey = $apiKey;
        $this->secret = $apiSecret;
    }

    public function createOrder($type, $description, $callbackUrl, $redirectUrl)
    {
        $data = [
            'type' => $type,
            'description' => $description,
            'callbackUrl' => $callbackUrl,
            'redirectUrl' => $redirectUrl,
        ];

        $jwt = $this->encodeJWT($data);
        $ret = $this->callPost($jwt, $this->url);

        return $this->decodeAndDecrypt($ret);
    }

    public function handleCallback(Request $request)
    {
        if ($request->header('API-Key') !== $this->apiKey) {
            throw new Exception('Api Key invalid');
        }

        $payload = $this->decodeAndDecrypt($request->getContent());

        return 'OK';
    }

    /**
     * @param mixed $data
     *
     * @return string
     */
    private function encodeJWT($data)
    {
        return JWT::encode($data, $this->secret);
    }

    /**
     * @param string $jwt
     *
     * @return object
     */
    private function decodeJWT(string $jwt)
    {
        try {
            return JWT::decode($jwt, $this->secret, ['HS256']);
        } catch (\Exception $e) {
            echo '<pre>';
            echo var_dump($e);
            echo '</pre>';
            exit;
        }
    }

    /**
     * @param string $ciphertext
     * @param string $secret
     * @param string $iv
     *
     * @throws \Exception
     *
     * @return string plaintext
     */
    private function decrypt($ciphertext, $secret, $iv)
    {
        $plaintext = openssl_decrypt($ciphertext, self::$ENCRYPTION_METHOD, $secret, 0, $iv);

        if ($plaintext === false) {
            throw new Exception('Decryption failure');
        }

        return $plaintext;
    }

    public function decodeAndDecrypt(string $payload)
    {
        $decoded = $this->decodeJWT($payload);
        $data = $this->decrypt($decoded->payload, hex2bin($this->secret), hex2bin($decoded->iv));
        return json_decode($data);
    }

    private function callPost($post, $url)
    {
        $config = [
            'headers' => [
                'API-Key' => $this->apiKey,
                'Accept' => 'application/json',
            ],
        ];

        $client = new Client($config);
        $response = $client->post($url, ['body' => $post]);

        return $response->getBody();
    }
}
