<?php

namespace backend\models;

use common\models\Brand;
use common\models\Category;
use common\models\News;
use common\models\Product;
use common\models\Textpage;
use DOMDocument;
use Yii;
use yii\helpers\Url;


class Sitemap extends Model
{
    public static function doIt()
    {
        $dom = new DOMDocument('1.0', 'utf-8');
        $urlset = $dom->createElement('urlset');
        $xmlns = $dom->createAttribute('xmlns');
        $xmlns->value = "http://www.sitemaps.org/schemas/sitemap/0.9";
        $urlset->appendChild($xmlns);

        foreach(Textpage::find()->orderBy(['name' => SORT_ASC])->all() as $model) {
            $url = $dom->createElement('url');
            $loc = $dom->createElement('loc', 'https://'.$_SERVER['HTTP_HOST'].htmlspecialchars($model->backendUrl));
            $url->appendChild($loc);
            $changefreq = $dom->createElement('changefreq', 'daily');
            $url->appendChild($changefreq);
            $priority = $dom->createElement('priority', 0.8);
            $url->appendChild($priority);
            $urlset->appendChild($url);
        }

        $newsPageUrl = Textpage::findOne(13)->backendUrl;

        foreach(News::find()->orderBy(['created_at' => SORT_DESC])->all() as $model) {
            $url = $dom->createElement('url');
            $loc = $dom->createElement('loc', 'https://'.$_SERVER['HTTP_HOST'].$newsPageUrl.'/'.$model->alias);
            $url->appendChild($loc);
            $changefreq = $dom->createElement('changefreq', 'daily');
            $url->appendChild($changefreq);
            $priority = $dom->createElement('priority', 0.8);
            $url->appendChild($priority);
            $urlset->appendChild($url);
        }

        $brandsPageUrl = Textpage::findOne(2)->alias;

        foreach(Brand::find()->orderBy(['name' => SORT_ASC])->all() as $model) {
            $url = $dom->createElement('url');
            $loc = $dom->createElement('loc', 'https://'.$_SERVER['HTTP_HOST'].'/'.$brandsPageUrl.'/'.$model->alias);
            $url->appendChild($loc);
            $changefreq = $dom->createElement('changefreq', 'daily');
            $url->appendChild($changefreq);
            $priority = $dom->createElement('priority', 0.8);
            $url->appendChild($priority);
            $urlset->appendChild($url);
        }

        foreach(Category::find()->where(['active' => 1])->orderBy(['name' => SORT_ASC])->all() as $model) {
            $url = $dom->createElement('url');
            $loc = $dom->createElement('loc', 'https://'.$_SERVER['HTTP_HOST'].$model->getUrl(true));
            $url->appendChild($loc);
            $changefreq = $dom->createElement('changefreq', 'daily');
            $url->appendChild($changefreq);
            $priority = $dom->createElement('priority', 0.8);
            $url->appendChild($priority);
            $urlset->appendChild($url);
        }

        foreach(Product::find()->orderBy(['name' => SORT_ASC])->all() as $model) {
            $url = $dom->createElement('url');
            $loc = $dom->createElement('loc', 'https://'.$_SERVER['HTTP_HOST'].$model->url);
            $url->appendChild($loc);
            $changefreq = $dom->createElement('changefreq', 'daily');
            $url->appendChild($changefreq);
            $priority = $dom->createElement('priority', 0.8);
            $url->appendChild($priority);
            $urlset->appendChild($url);
        }

        $dom->appendChild($urlset);
        var_dump($dom->save('../sitemap.xml'));
    }
}
