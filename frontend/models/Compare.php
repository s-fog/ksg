<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class Compare extends Model
{
    public static function inCompare($id) {
        if (isset($_COOKIE['compare']) && !empty($_COOKIE['compare'])) {
            $ids = $_COOKIE['compare'];
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
        if (isset($_COOKIE['compare']) && !empty($_COOKIE['compare'])) {
            $ids = $_COOKIE['compare'];
            $ids = json_decode($ids, true);
        } else {
            $ids = [];
        }

        return count($ids);
    }
}
