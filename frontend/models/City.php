<?php

namespace frontend\models;

use Exception;
use Yii;
use yii\base\Model;

class City extends Model
{
    public static function setCity() {
        $session = Yii::$app->session;
        $sessionCity = $session->get('city');

        if (!$sessionCity) {
            $city = '';

            try {
                $ip = $_SERVER['REMOTE_ADDR'];
                if ($ip == '127.0.0.1') $ip = '5.3.164.145';
                $xml = file_get_contents("http://ipgeobase.ru:7020/geo?ip=$ip");
                $str = iconv('windows-1251', 'utf-8', $xml);
                preg_match('#<city>([^<]+)</city><region>([^<]+)</region>#siU', $str, $match);

                if (isset($match[1]) && !empty($match[1]) && isset($match[2]) && !empty($match[2])) {
                    $city = $match[1];
                    $region = $match[2];

                    if ($city !== 'Москва') {
                        if ($region == 'Московская область') {
                            $city = 'Москва';
                        } else {
                            $city = 'Others';
                        }
                    } else {
                        $city = 'Москва';
                    }
                } else {
                    $city = 'Москва';
                }
            } catch (Exception $e) {
                $city = 'Москва';
            }

            $session->set('city', $city);
            return;
        } else {
            return;
        }
    }

    public static function getCity() {
        $session = Yii::$app->session;
        $sessionCity = $session->get('city');

        if (!$sessionCity) {
            return 'Москва';
        } else {
            return $sessionCity;
        }
    }
}