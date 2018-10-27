<?php
namespace frontend\controllers;

use frontend\models\Xml;
use Yii;
use yii\web\Controller;

/**
 * Site controller
 */
class XmlController extends Controller
{
    public function beforeAction()
    {
        $this->enableCsrfValidation = false;
        return true;
    }

    public function actionImport()
    {
        $xml = new Xml();

        /*$ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
        curl_setopt($ch, CURLOPT_URL, 'https://hasttings.ru/diler/fast.yml');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "name=ksg&pass=qwertydas123");
        $result = curl_exec($ch);

        curl_close($ch);
        var_dump($result);
        die();*/

        ////////////////////////////////////////////////////////////////////////////////
        $stark = simplexml_load_file('http://xn----dtbgdaodln4afhyim1m.com/price/?sklad=moscow');
        $starkArray = [];

        foreach($stark->products->product as $product) {
            foreach($product->offers->offer as $offer) {
                $available = (string) $offer->amount;
                $artikul = (string) $offer->id;
                $price = (int) $product->price;

                $starkArray[$artikul]['price'] = $price;
                $starkArray[$artikul]['available'] = $available;
            }
        }

        $xml->loadXml('stark', $starkArray, 6);
        ////////////////////////////////////////////////////////////////////////////////
        $svenson = simplexml_load_file('https://jorgen-svensson.com/ru/data.yml');
        $svensonArray = [];

        foreach($svenson->shop->offers->offer as $offer) {
            $available = (string) $offer->param;
            $artikul = (string) $offer->vendorCode;
            $price = (int) $offer->price;

            $svensonArray[$artikul]['price'] = $price;
            $svensonArray[$artikul]['available'] = $available;
        }

        $xml->loadXml('jorgen-svensson', $svensonArray, 2);
        ////////////////////////////////////////////////////////////////////////////////
        $driada = simplexml_load_file('http://driada-sport.ru/data/files/XML_prise_s.xml');
        $driadaArray = [];

        foreach($driada->price as $offer) {
            $values = $offer->attributes();
            $available = (string) $values['Остаток'];
            $artikul = (string) $values['Артикул'];
            $price = (int) $values['Цена'];

            $driadaArray[$artikul]['price'] = $price;
            $driadaArray[$artikul]['available'] = $available;
        }

        $xml->loadXml('driada', $driadaArray, 1);
        ////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////

        //echo '<pre>',print_r($driada->shop->offers),'</pre>';
    }
}