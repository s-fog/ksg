<?php

namespace backend\models;

use Yii;
use yii\imagine\Image;
use yii\web\UploadedFile;

/**
 * This is the model class for table "order".
 */
class UploadFileDynamicForm extends \yii\base\Model
{
    public static function upload($model, $currentModel, $index, $attribute, $attributeFile, $thumbs = array(), $watermark = false) {
        $file = UploadedFile::getInstance($model, $attributeFile);

        $modelClassName = str_replace('\\', '/', $model->className());
        preg_match("#[a-zA-z]+/[a-zA-z]+/([a-zA-z]+)$#siU", $modelClassName, $match);
        $className = $match[1];
        $attributeFileOrigin = preg_replace('#^\[[0-9]+\](.*)$#siU', '$1', $attributeFile);

        if ($file) {
            $name = md5($file->baseName.time());
            $extention = $file->extension;

            if ($_FILES[$className]['type'][$index][$attributeFileOrigin] == 'image/jpeg' || $_FILES[$className]['type'][$index][$attributeFileOrigin] == 'image/jpg') {
                $filename = '/uploads/'.$name.'.'.$extention;
                $image = imagecreatefromjpeg($_FILES[$className]['tmp_name'][$index][$attributeFileOrigin]);
                $flag = imagejpeg ($image, Yii::getAlias('@www').$filename, 75);
                imagedestroy($image);
            } else if ($_FILES[$className]['type'][$index][$attributeFileOrigin] == 'image/png') {
                $filename = '/uploads/'.$name.'.'.$extention;
                $image = imagecreatefrompng($_FILES[$className]['tmp_name'][$index][$attributeFileOrigin]);
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
                    UploadFileDynamicForm::doThumb($file, $filename, $thumb, $watermark);
                }
            } else {
                $result = false;
            }
        } else {
            $result = false;
        }


        if (!empty($_FILES[$className]['name'][$index][$attributeFileOrigin])) {
            if ($result) {
                //Удаляем старое изображение
                if ($currentModel) {
                    if ($currentModel->image != $result) {
                        $firstPartOfFilename = basename(explode('.', $currentModel->image)[0]);

                        if (!empty($firstPartOfFilename)) {
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
                }
                //Удаляем старое изображение END
                return $result;
            }
        } else {
            return $_POST[$className][$index][preg_replace('#^\[[0-9]+\](.*)$#siU', '$1', $attribute)];
        }
    }

    public static function doThumb($file, $image, $thumb, $watermark) {
        $fileGabarits = getimagesize($_SERVER['DOCUMENT_ROOT'].'/www'.$image)[3];
        $fileWidth = (int) str_replace(['"', 'width', '='], ['', '', ''], explode(' ', $fileGabarits)[0]);
        $fileHeight = (int) str_replace(['"', 'height', '='], ['', '', ''], explode(' ', $fileGabarits)[1]);
        $thumbWidth = (int) explode('x', $thumb)[0];
        $thumbHeight = (int) explode('x', $thumb)[1];
        $filename = explode('.', basename($image));
        $thumbCut = explode('x', $thumb);

        $thumbPath = '/images/thumbs/'.$filename[0].'-'.$thumbCut[0].'-'.$thumbCut[1].'.'.$filename[1];

        if (!file_exists(Yii::getAlias('@www') . $thumbPath)) {
            if ($fileWidth > $thumbWidth && $fileHeight > $thumbHeight) {
                Image::thumbnail('@www' . $image, $thumbCut[0], $thumbCut[1])
                    ->save(Yii::getAlias('@www'.$thumbPath), ['quality' => 80]);
            } else {
                $file->saveAs(Yii::getAlias('@www').$thumbPath);
            }
        }
    }
}
