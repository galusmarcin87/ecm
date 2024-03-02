<?php
namespace app\components\mgcms\docRepl;

use ZipArchive;
/**
 * $engine = new docRepl();
    $engine->loadTemplate('Template.docx');
    $engine->replace(array(
        'name' => 'name example',
        'address' => 'address example',
        'city' => 'city example'
    ));

    $tempName = md5(time()).'.docx';

    $engine->save($tempName);

    header('Content-Disposition: attachment; filename="output.docx"');

    echo file_get_contents($tempName);

    unlink($tempName);
 */
class docRepl extends \yii\base\Component {

  public $tmp;
  private static $archive = null;

  public function loadTemplate($path) {

    $zip = new ZipArchive;
    $res = $zip->open($path);
    if ($res === TRUE) {
      $randName = md5(time());
      mkdir($randName);
      $zip->extractTo($randName);
      $zip->close();

      $this->tmp = $randName;
    } else {
      
    }
  }

  public function recursiveRead($dir, $local = '') {

    self::$archive->addEmptyDir($local);

    $files = scandir($dir);
    unset($files[0]);
    unset($files[1]);

    foreach ($files as $file) {

      if (is_dir($dir . DIRECTORY_SEPARATOR . $file)) {
        $this->recursiveRead($dir . DIRECTORY_SEPARATOR . $file, $local . DIRECTORY_SEPARATOR . $file);
      } else {
        self::$archive->addFile($dir . DIRECTORY_SEPARATOR . $file, $local . DIRECTORY_SEPARATOR . $file);
      }
    }
  }

  public function save($filename) {

    $path = $this->tmp;
    self::$archive = new ZipArchive;
    self::$archive->open($filename, ZipArchive::CREATE);

    $files = scandir($path);

    unset($files[0]);
    unset($files[1]);

    foreach ($files as $file) {

      if (is_dir($path . DIRECTORY_SEPARATOR . $file)) {
        $this->recursiveRead($path . DIRECTORY_SEPARATOR . $file, $file);
      } else {
        self::$archive->addFile($path . DIRECTORY_SEPARATOR . $file, $file);
      }
    }



    self::$archive->close();

    self::removeDir($this->tmp);
  }

  public function replace($repData) {

    $data = file_get_contents($this->tmp . DIRECTORY_SEPARATOR . 'word' . DIRECTORY_SEPARATOR . 'document.xml');
    
    foreach ($repData as $key => $val) {
      if($key =='id')
        continue;

      $data = str_replace('{'.$key.'}', $val, $data);
     }
    file_put_contents($this->tmp . DIRECTORY_SEPARATOR . 'word' . DIRECTORY_SEPARATOR . 'document.xml', $data);
  }

  public static function removeDir($dir) {

    if (!file_exists($dir))
      return false;


    $files = scandir($dir);
    unset($files[0]);
    unset($files[1]);

    foreach ($files as $file) {

      if (is_dir($dir . '/' . $file))
        self::removeDir($dir . '/' . $file);
      else {
        unlink($dir . '/' . $file);
      }
    }

    rmdir($dir);

    return null;
  }

}
