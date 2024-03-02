<?php

use app\components\mgcms\MgHelpers;


$this->registerJsFile('/js/vendor/web3.min.js');
$this->registerJsFile('/js/vendor/eth.tx.min.js');

?>

<script>
    $(document).ready(async function () {
        window.web3 = new Web3(new Web3.providers.HttpProvider('<?= $ethProvider?>'));

        window.jsonABI = <?= \yii\helpers\Json::encode($tokenAbi)?>;
        window.tokenAddress = '<?= $tokenAddress?>';
        window.receiverAddress = '<?= $receiverAddress?>';
        window.senderAddress = '<?= $senderAddress?>';
        window.privateKey = '<?= $privateKey?>';


        const amount = 0.001;
            window.contract = new web3.eth.Contract(jsonABI, tokenAddress);


        const balanceOfHolder = await contract.methods.balanceOf(senderAddress).call();
        const balanceOfReceiver = await contract.methods.balanceOf(receiverAddress).call();

        //console.log(balanceOfReceiver, balanceOfHolder);

        web3.eth.getTransactionCount(senderAddress, 'pending')
            .then(nonce => {
                // Prepare the transaction data for the transfer function
                const tokenAmount = '1'; // Amount of tokens to transfer
                const transferData = contract.methods.transfer(receiverAddress, tokenAmount).encodeABI();

                console.log(nonce);
                // Build the transaction object
                const txParams = {
                    from: senderAddress,
                    to: receiverAddress,
                    gas: web3.utils.toHex(300000), // Adjust gas limit as needed
                    gasPrice: web3.utils.toHex(web3.utils.toWei('10', 'gwei')), // Adjust gas price as needed
                    data: transferData,
                    nonce: nonce,
                };

                // Sign the transaction
                const tx = new EthereumTx(txParams, { chain: '97' }); // Specify the chain, e.g., 'bsc testnet' or 'mainnet'
                const privateKeyBuffer = Buffer.from(privateKey.slice(2), 'hex');
                tx.sign(privateKeyBuffer);

                // Serialize the signed transaction
                const serializedTx = '0x' + tx.serialize().toString('hex');

                // Send the transaction
                web3.eth.sendSignedTransaction(serializedTx)
                    .on('transactionHash', (hash) => {
                        console.log('Transaction Hash:', hash);
                    })
                    .on('receipt', (receipt) => {
                        console.log('Transaction Receipt:', receipt);
                        // Check if the transaction was successful based on the receipt
                        if (receipt.status) {
                            console.log('Transaction was successful!');
                        } else {
                            console.error('Transaction failed.');
                        }
                    })
                    .on('error', (error) => {
                        console.error('Error:', error.message);
                    });
            })
            .catch(error => {
                console.error('Error fetching nonce:', error.message);
            });


    });
</script>
