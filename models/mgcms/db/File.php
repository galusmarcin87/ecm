<?php
namespace app\models\mgcms\db;

use app\components\mgcms\MgHelpers;
use \app\models\mgcms\db\base\File as BaseFile;

use \mgcms\lightbox\Lightbox;
use yii\db\Expression;
use \yii\helpers\Html;

\rmrevin\yii\module\File\component\Image::$thumbnailBackgroundAlpha = 0;

/**
 * This is the model class for table "file".,
 * @property string $link
 * @property string $thumb
 * @property string $imageSrc
 * @property string $image
 * @property string $linkUrl
 */
class File extends BaseFile
{

  use \mootensai\relation\RelationTrait;

  public $lightBoxTitle;

  /**
   * @inheritdoc
   */
  public function rules()
  {
    return array_replace_recursive(parent::rules(), [
        [['size', 'image_bad', 'created_by'], 'integer'],
        [['mime', 'name', 'origin_name'], 'string', 'max' => 255],
        [['sha1'], 'string', 'max' => 40]
    ]);
  }

  public function getLink()
  {
    return \yii\helpers\Html::a($this->origin_name, $this->getWebPath());
  }

  public function getLinkUrl(){
    return $this->getWebPath();
  }

  public function getThumb($width = 150, $height = 150, $lightBox = true, $mode = \Imagine\Image\ManipulatorInterface::THUMBNAIL_INSET, $htmlOptions = [])
  {
    $iniPrev = ini_get('display_errors');
    ini_set('display_errors', 'Off');
    if (!$this->isImage()) {
      return false;
    }
    ini_set('memory_limit','8000M');
    $src = str_replace('\\', '/', (string) $this->image()->thumbnail($width, $height, $mode));
    $img = Html::img($src, \yii\helpers\ArrayHelper::merge($htmlOptions, ['alt' => $this->origin_name]));
    if ($lightBox) {
      Lightbox::widget();
      return Html::a($img, $this->getWebPath(), ['data-lightbox' => 'lightbox', 'target' => '_blank', 'title' => $this->lightBoxTitle]);
    }
    ini_set('display_errors', $iniPrev);
    return $img;
  }

  public function getImageSrc($width = false, $height = false, $mode = \Imagine\Image\ManipulatorInterface::THUMBNAIL_OUTBOUND)
  {
    $iniPrev = ini_get('display_errors');
    ini_set('display_errors', 'Off');

    $src = false;
    if ($width && !$height) {
      ini_set('memory_limit','150M');
      $src = $this->image()->resizeByWidth($width);
    } elseif (!$width && $height) {
      ini_set('memory_limit','150M');
      $src = $this->image()->resizeByHeight($height);
    } elseif ($width && $height) {
      ini_set('memory_limit','150M');
      $src = $this->image()->thumbnail($width, $height, $mode);
    } else {
      $src = $this->getWebPath();
    }
    ini_set('display_errors', $iniPrev);
    return str_replace('\\', '/', (string) $src);
  }

  public function getImage($width = false, $height = false, $htmlOptions = [], $mode = \Imagine\Image\ManipulatorInterface::THUMBNAIL_INSET)
  {
    return Html::img($this->getImageSrc($width, $height, $mode), \yii\helpers\ArrayHelper::merge(['alt' => $this->origin_name], $htmlOptions));
  }

  public function delete()
  {
    try {
      $path = $this->getWebPath();
      preg_match('/upload\/\d+\/\d+/', $path, $mathes);
      if (!isset($mathes[0])) {
        \app\components\mgcms\MgHelpers::log('File name not match');
        return parent::delete();
      }
      \yii\helpers\FileHelper::removeDirectory(\Yii::getAlias('@webroot/' . $mathes[0]));
      \yii\helpers\FileHelper::removeDirectory(\Yii::getAlias('@webroot/' . str_replace('upload', 'storage', $mathes[0])));
    } catch (Exception $e) {
      return false;
    }

    return parent::delete();
  }

  public function __toString()
  {
    return $this->isImage() ? $this->thumb : $this->link;
  }

  public static function push(\rmrevin\yii\module\File\resources\ResourceInterface $Resource){

      $file = parent::push($Resource);
      $file->created_by = MgHelpers::getUserModel()->id;
      $file->save();

      return $file;
  }



}
