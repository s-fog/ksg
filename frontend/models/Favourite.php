<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class Favourite extends Model
{
    public static function inFavourite($id) {
        if (isset($_COOKIE['favourite']) && !empty($_COOKIE['favourite'])) {
            $ids = $_COOKIE['favourite'];
            $ids = json_decode($ids, true);
        } else {
            $ids = [];
        }

        if (in_array($id, $ids)) {
            return true;
        } else {
            return false;
        }
    }

    public static function getCount() {
        if (isset($_COOKIE['favourite']) && !empty($_COOKIE['favourite'])) {
            $ids = $_COOKIE['favourite'];
            $ids = json_decode($ids, true);
        } else {
            $ids = [];
        }

        return count($ids);
    }

    public static function getIds() {
        $result = [];

        foreach (json_decode($_COOKIE['favourite'], true) as $item) {
            $result[] = (int) $item;
        }
        
        return $result;
    }
}
