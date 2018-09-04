<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class Get extends Model
{
    public static function value($name) {
        if (strstr($_SERVER['REQUEST_URI'], '?')) {
            $requestUri = explode('?', $_SERVER['REQUEST_URI'])[1];
            preg_match_all('#([^=&]+)=([^&]+)#', $requestUri, $match);
            $GET = array();

            foreach($match[1] as $index => $value) {
                $GET[$value] = urldecode($match[2][$index]);
            }

            if (array_key_exists($name, $GET)) {
                return $GET[$name];
            } else {
                return '';
            }
        } else {
            return '';
        }
    }
}
