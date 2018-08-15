<?php
namespace frontend\controllers;

use common\models\Product;
use frontend\models\Compare;
use frontend\models\Favourite;
use Yii;
use yii\web\Controller;

/**
 * Site controller
 */
class CompareController extends Controller
{
    public function actionAdd()
    {
        $id = $_POST['id'];

        if (isset($_COOKIE['compare'])) {
            $ids = $_COOKIE['compare'];
            $ids = json_decode($ids, true);
        } else {
            $ids = [];
        }

        if(empty($ids)){
            $ids[0] = $id;
        }else{
            $new = true;

            foreach($ids as $value){
                if($value == $id){
                    $new = false;
                    break;
                }
            }

            if($new){
                $ids[] = $id;
            }
        }

        $ids = json_encode($ids);
        setcookie("compare", $ids, strtotime( '+30 days' ), '/');

        return 'success';
    }

    public function actionDelete()
    {
        $id = $_POST['id'];

        if (isset($_COOKIE['compare'])) {
            $ids = $_COOKIE['compare'];
            $ids = json_decode($ids, true);
        } else {
            $ids = [];
        }

        if (!empty($ids)) {
            if (in_array($id, $ids)) {
                foreach($ids as $key => $value) {
                    if ($value == $id) {
                        unset($ids[$key]);
                    }
                }
            } else {
                return 'Такого элемента нет';
            }
        } else {
            return 'Сравнение пустое';
        }

        $ids = json_encode($ids);
        setcookie("compare", $ids, strtotime( '+30 days' ), '/');

        return 'success';
    }

    public function actionCount()
    {
        return Compare::getCount();
    }
}
