<?php

namespace frontend\models;

use common\models\Product;
use Yii;
use yii\base\Model;

class Forms extends Model
{
    public $name;
    public $phone;
    public $email;
    public $text;
    public $opinion;
    public $review_product_id;
    public $BC;

    public function send($post, $files) {
        $labels = array(
            'name' => 'Имя',
            'phone' => 'Телефон',
            'email' => 'Эл. адрес',
            'text' => 'Текст',
            'opinion' => 'Мнение',
            'review_product_id' => 'Ссылка на товар в админки',
        );

        $type = $post['type'];
        $msg = '';
        $to = 's-fog@yandex.ru';
        $to = Yii::$app->params['adminEmail'];
        unset($post['type']);
        unset($post['agree']);
        unset($post['file']);

        foreach($post as $name=>$value){
            $label = array_key_exists($name, $labels) ? $labels[$name] : $name;
            $value = htmlspecialchars($value);
            if(strlen($value)) {
                if ($name == 'review_product_id') {
                    $u = $_SERVER['HTTP_HOST'].'/officeback/product/update?id='.$value.'#w3-tab4';
                    $product = Product::findOne($value);
                    $msg .= '<p><b>'.$label.'</b>: <a href="'.$u.'">'.$product->name.'</a></p>';
                } else {
                    $msg .= "<p><b>$label</b>: $value</p>";
                }
            }
        }

        $emailSendError = false;
        foreach(explode(',', $to) as $email) {
            if(!Yii::$app->mailer->compose()
                ->setFrom($to)
                ->setTo($email)
                ->setSubject($type)
                ->setHtmlBody($msg)
                ->send()) {
                $emailSendError = true;
            }
        }

        if ($emailSendError) {
            return 'error';
        } else {
            return 'success';
        }
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'phone' => 'Телефон',
            'email' => 'Эл. адрес',
            'text' => 'Текст',
            'opinion' => 'Мнение',
        ];
    }
}