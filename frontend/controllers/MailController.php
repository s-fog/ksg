<?php

namespace frontend\controllers;

use frontend\models\CallbackForm;
use frontend\models\PopupForm;
use frontend\models\TechForm;
use Yii;

class MailController extends \yii\web\Controller
{
    public function actionIndex() {
        if (isset($_POST['CallbackForm'])) {
            if (!empty($_POST['CallbackForm']) && isset($_POST['CallbackForm']['type']) && !strlen($_POST['CallbackForm']['BC'])) {
                $form = new CallbackForm();
                $post = $_POST['CallbackForm'];
                $files = (isset($_FILES['CallbackForm'])) ? $_FILES['CallbackForm'] : [];
                $form->send($post, $files);
            }
        }
        if (isset($_POST['OneClickForm'])) {
            if (!empty($_POST['OneClickForm']) && isset($_POST['OneClickForm']['type']) && !strlen($_POST['OneClickForm']['BC'])) {
                //create Order
            }
        }
    }
}
