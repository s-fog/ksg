<?php

namespace common\models;

use Yii;
use \common\models\base\News as BaseNews;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "news".
 */
class News extends BaseNews
{

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                [
                    'class' => \nsept\behaviors\CyrillicSlugBehavior::className(),
                    'attribute' => 'name',
                    'slugAttribute' => 'alias',
                    'immutable' => true,
                    'ensureUnique' => true,
                ],
            ]
        );
    }

    public function rules()
    {
        return [
            [['name', 'introtext'], 'required'],
            [['seo_description', 'html', 'html2', 'introtext'], 'string'],
            [['sort_order'], 'integer'],
            [['name', 'alias', 'seo_h1', 'seo_title', 'seo_keywords'], 'string', 'max' => 255],
            [['image'], 'required', 'on' => 'create'],
            [['image'], 'image', 'maxSize' => 1000000,  'minWidth' => 260, 'minHeight' => 150, 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
        ];
    }
}
