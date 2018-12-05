<?php
namespace frontend\controllers;

use backend\models\Sitemap;
use backend\models\UML;
use Exception;
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
        UML::doIt();
        return Yii::getAlias('@www');
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
        try {
            $fitnessBoutique = simplexml_load_file('https://www.fitness-boutique.ru/system/files/dealer/stock_fitness-boutique_xml_0.xml');
            $fitnessBoutiqueArray = [];

            foreach($fitnessBoutique->shop->offers->offer as $offer) {
                $available = 10;
                $artikul = (string) $offer->param;
                $price = (int) $offer->price;

                $fitnessBoutiqueArray[$artikul]['price'] = $price;
                $fitnessBoutiqueArray[$artikul]['available'] = $available;
            }

            $xml->loadXml('fitnessBoutique', $fitnessBoutiqueArray, 8, true);
        } catch(Exception $e) {
            $xml->sendMessage("Ошибка при парсинге прайс листа KSG", $e->getMessage());
        }
        ////////////////////////////////////////////////////////////////////////////////
        try {
            $soulfit = simplexml_load_file('http://soulfitnes.ru/wp-content/plugins/saphali-export-yml2/export.yml');
            $soulfitArray = [];

            foreach($soulfit->shop->offers->offer as $offer) {
                $available = (string) $offer->attributes()->{'available'};
                $artikul = (string) $offer->vendorCode;
                $price = (int) $offer->price;

                $soulfitArray[$artikul]['price'] = $price;
                $soulfitArray[$artikul]['available'] = $available;
            }

            $xml->loadXml('soulfit', $soulfitArray, 4);
        } catch(Exception $e) {
            $xml->sendMessage("Ошибка при парсинге прайс листа KSG", $e->getMessage());
        }
        ////////////////////////////////////////////////////////////////////////////////
        try {
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
        } catch(Exception $e) {
            $xml->sendMessage("Ошибка при парсинге прайс листа KSG", $e->getMessage());
        }
        ////////////////////////////////////////////////////////////////////////////////
        try {
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
        } catch(Exception $e) {
            $xml->sendMessage("Ошибка при парсинге прайс листа KSG", $e->getMessage());
        }
        ////////////////////////////////////////////////////////////////////////////////
        try {
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
        } catch(Exception $e) {
            $xml->sendMessage("Ошибка при парсинге прайс листа KSG", $e->getMessage());
        }

        ////////////////////////////////////////////////////////////////////////////////
        //echo '<pre>',print_r($driada->shop->offers),'</pre>';
    }
}