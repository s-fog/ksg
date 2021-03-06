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
use yii\queue\JobInterface;


class Sitemap extends Model implements JobInterface
{
    public function execute($queue)
    {
        $dom = new DOMDocument('1.0', 'utf-8');
        $urlset = $dom->createElement('urlset');
        $xmlns = $dom->createAttribute('xmlns');
        $xmlns->value = "http://www.sitemaps.org/schemas/sitemap/0.9";
        $urlset->appendChild($xmlns);

        foreach(Textpage::find()->orderBy(['name' => SORT_ASC])->all() as $model) {
            $url = $dom->createElement('url');
            $loc = $dom->createElement('loc', Yii::$app->params['frontendHost'].htmlspecialchars($model->backendUrl));
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
            $loc = $dom->createElement('loc', Yii::$app->params['frontendHost'].$newsPageUrl.'/'.$model->alias);
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
            $loc = $dom->createElement('loc', Yii::$app->params['frontendHost'].'/'.$brandsPageUrl.'/'.$model->alias);
            $url->appendChild($loc);
            $changefreq = $dom->createElement('changefreq', 'daily');
            $url->appendChild($changefreq);
            $priority = $dom->createElement('priority', 0.8);
            $url->appendChild($priority);
            $urlset->appendChild($url);
        }

        foreach(Category::find()->where(['active' => 1])->orderBy(['name' => SORT_ASC])->all() as $model) {
            $url = $dom->createElement('url');
            $loc = $dom->createElement('loc', Yii::$app->params['frontendHost'].$model->getUrl(true));
            $url->appendChild($loc);
            $changefreq = $dom->createElement('changefreq', 'daily');
            $url->appendChild($changefreq);
            $priority = $dom->createElement('priority', 0.8);
            $url->appendChild($priority);
            $urlset->appendChild($url);
        }

        foreach(Product::find()->orderBy(['name' => SORT_ASC])->all() as $model) {
            $url = $dom->createElement('url');
            $loc = $dom->createElement('loc', Yii::$app->params['frontendHost'].$model->url);
            $url->appendChild($loc);
            $changefreq = $dom->createElement('changefreq', 'daily');
            $url->appendChild($changefreq);
            $priority = $dom->createElement('priority', 0.8);
            $url->appendChild($priority);
            $urlset->appendChild($url);
        }

        $dom->appendChild($urlset);
        $dom->save(Yii::getAlias('@www').'/sitemap.xml');
    }
}
