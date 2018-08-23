<?php

namespace backend\models;

use Yii;
use yii\imagine\Image;
use yii\web\UploadedFile;

/**
 * This is the model class for table "order".
 */
class UploadFile extends \yii\base\Model
{
    public static function upload($model, $currentModel, $attribute, $attributeFile, $thumbs = array(), $watermark = false) {
        var_dump($attributeFile);die();
        $file = UploadedFile::getInstance($model, $attributeFile);

        $modelClassName = str_replace('\\', '/', $model->className());
        preg_match("#[a-zA-z]+/[a-zA-z]+/([a-zA-z]+)$#siU", $modelClassName, $match);
        $className = $match[1];

        if ($file) {
            $name = md5($file->baseName.time());
            $extention = $file->extension;

            if ($_FILES[$className]['type'][$attributeFile] == 'image/jpeg' || $_FILES[$className]['type'][$attributeFile] == 'image/jpg') {
                $filename = '/uploads/'.$name.'.'.$extention;
                $image = imagecreatefromjpeg($_FILES[$className]['tmp_name'][$attributeFile]);
                $flag = imagejpeg ($image, Yii::getAlias('@www').$filename, 75);
                imagedestroy($image);
            } else if ($_FILES[$className]['type'][$attributeFile] == 'image/png') {
                $filename = '/uploads/'.$name.'.'.$extention;
                $image = imagecreatefrompng($_FILES[$className]['tmp_name'][$attributeFile]);
                imagealphablending($image, false);
                imagesavealpha($image, true);
                $flag = imagepng($image, Yii::getAlias('@www').$filename, 9);
                imagedestroy($image);
            } else {
                $filename = '/uploads/'.$name.'.'.$extention;
                $flag = $file->saveAs(Yii::getAlias('@www').$filename);
            }


            if ($flag) {
                $result = $filename;

                foreach($thumbs as $thumb) {
                    UploadFile::doThumb($filename, $thumb, $watermark);
                }
            } else {
                $result = false;
            }
        } else {
            $result = false;
        }


        if (!empty($_FILES[$className]['name'][$attributeFile])) {
            if ($result) {
                //Удаляем старое изображение
                if ($currentModel && !empty($currentModel->$attribute)) {
                    if ($currentModel->$attribute != $result) {
                        $firstPartOfFilename = basename(explode('.', $currentModel->$attribute)[0]);

                        $uploadPath = Yii::getAlias('@uploadPath');
                        $uploadPaths = glob($uploadPath . '/*');

                        foreach ($uploadPaths as $fileItem) {
                            if (is_file($fileItem)) {
                                if (strstr($fileItem, $firstPartOfFilename)) {
                                    unlink($fileItem);
                                }
                            }
                        }

                        $thumbsPath = Yii::getAlias('@thumbsPath');
                        $thumbsPaths = glob($thumbsPath . '/*');

                        foreach ($thumbsPaths as $fileItem) {
                            if (is_file($fileItem)) {
                                if (strstr($fileItem, $firstPartOfFilename)) {
                                    unlink($fileItem);
                                }
                            }
                        }
                    }
                }
                //Удаляем старое изображение END

                return $result;
            }
        } else {
            return $_POST[$className][$attribute];
        }
    }

    public static function doThumb($image, $thumb, $watermark) {
        $filename = explode('.', basename($image));
        $thumbCut = explode('x', $thumb);

        $thumbPath = '/images/thumbs/'.$filename[0].'-'.$thumbCut[0].'-'.$thumbCut[1].'.'.$filename[1];

        if (!file_exists(Yii::getAlias('@www') . $thumbPath)) {
            Image::thumbnail('@www' . $image, $thumbCut[0], $thumbCut[1])
                ->save(Yii::getAlias('@www'.$thumbPath), ['quality' => 80]);
        }
    }
}
