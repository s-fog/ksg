<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

class Forms extends Model
{
    public $name;
    public $phone;
    public $email;
    public $text;
    public $file;
    public $reason;
    public $city_name;
    public $tariff_name;
    public $videoName;
    public $district;
    public $city;
    public $usl_type;
    public $BC;

    public function send($post, $files) {
        $labels = array(
            'name' => 'Имя',
            'phone' => 'Телефон',
            'email' => 'Эл. адрес',
            'text' => 'Текст',
        );

        $type = $post['type'];
        $msg = '';
        $to = 's-fog@yandex.ru';
        $headers = "Content-type: text/html; charset=\"utf-8\"\r\n";
        $headers .= "From: <$to>\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Date: ". date('D, d M Y h:i:s O') ."\r\n";
        unset($post['type']);
        unset($post['agree']);
        unset($post['file']);

        foreach($post as $name=>$value){
            $label = array_key_exists($name, $labels) ? $labels[$name] : $name;
            $value = htmlspecialchars($value);
            if(strlen($value)) {
                if ($name == 'url') {
                    $msg .= "<p><b>$label</b>: <a href='$value'>$value</a></p>";
                } else {
                    $msg .= "<p><b>$label</b>: $value</p>";
                }
            }
        }

        $body = $msg;
        if (!empty($files) && !empty($files['name']['file'][0])) {
            $msg .= 'Плюс к этому письму приложен файл';
            $boundary = "--" . md5(uniqid(time()));
            $headers = "MIME-Version: 1.0;\r\n";
            $headers .= "From: <$to>\r\n";
            $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"";
            $body = "--$boundary\n";
            $body .= "Content-Type: text/html; charset=UTF-8\r\n";
            $body .= "Content-Transfer-Encoding: base64\r\n";
            $body .= "\r\n";
            $body .= chunk_split(base64_encode($msg));

            $i = 0;
            while($i < count($files['name']['file'])) {
                $fp = fopen($files["tmp_name"]['file'][$i], "rb");

                if (!$fp) {
                    echo "Cannot open file";
                    exit();
                }

                $data = fread($fp, filesize($files["tmp_name"]['file'][$i]));
                fclose($fp);
                $name = $files["name"]['file'][$i];

                $body .= "\r\n\r\n--$boundary\r\n";
                $body .= "Content-Type: " . $files["type"]['file'][$i] . "; name=\"$name\"\r\n";
                $body .= "Content-Transfer-Encoding: base64 \r\n";
                $body .= "Content-Disposition: attachment; filename=\"$name\"\r\n";
                $body .= "\r\n";
                $body .= chunk_split(base64_encode($data));

                $i++;
            }

            $body .= "\r\n--$boundary--\r\n";
        }

        $emailSendError = false;
        foreach(explode(',', $to) as $email) {
            if(!mail($email, $type, $body, $headers)) {
                $emailSendError = true;
            }
        }

        if ($emailSendError) {
            echo 'error';
        } else {
            echo 'success';
        }
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'phone' => 'Телефон',
            'email' => 'Эл. адрес',
            'text' => 'Текст',
        ];
    }
}