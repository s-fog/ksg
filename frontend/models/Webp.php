<?php

namespace frontend\models;

use Dompdf\Dompdf;
use Dompdf\Options;
use Dompdf\Renderer;
use Yii;

/**
 * This is the model class for table "config".
 */
class Webp extends \yii\base\Component
{
    public static function checkWebp() {
        if (isset($_SERVER['HTTP_ACCEPT'])) {
            if(strpos( $_SERVER['HTTP_ACCEPT'], 'image/webp') !== false ) {
                return true;
            }
        }

        return false;
    }

    public static function replaceToWebp($string) {
        if (self::checkWebp()) {
            $aliasWWW = Yii::getAlias('@www');
            ///////////////////////////////////////////////////
            preg_match_all('#\<img src="([^"]+)"#siU', $string, $matchImgs);

            foreach($matchImgs[1] as $img) {
                $string = self::checkAndReplace($string, $img, $aliasWWW);
            }

            ///////////////////////////////////////////////////
            preg_match_all('#background-image:[\s]+url\(([^\)]+)\)#siU', $string, $matchBgs);

            foreach($matchBgs[1] as $img) {
                $string = self::checkAndReplace($string, $img, $aliasWWW);
            }

            ///////////////////////////////////////////////////
            preg_match_all('#\<a href="([^"]+)"#siU', $string, $matchLinks);

            foreach($matchLinks[1] as $img) {
                $string = self::checkAndReplace($string, $img, $aliasWWW);
            }

            ///////////////////////////////////////////////////
            preg_match_all('#data-src="([^"]+)"#siU', $string, $matchSrc);

            foreach($matchSrc[1] as $img) {
                $string = self::checkAndReplace($string, $img, $aliasWWW);
            }
        }

        return $string;
    }

    public static function checkAndReplace($string, $img, $aliasWWW) {
        $filename = explode('.', $img);

        if (isset($filename[1])) {
            if (in_array($filename[1], ['jpg', 'png'])) {
                if (file_exists($aliasWWW.$filename[0].'.webp')) {
                    $string = str_replace($img, $filename[0].'.webp', $string);
                }
            }
        }

        return $string;
    }
}
