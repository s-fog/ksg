<?php

namespace common\models;

use Yii;
use \common\models\base\Textpage as BaseTextpage;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "textpage".
 */
class Textpage extends BaseTextpage
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
        return ArrayHelper::merge(
            parent::rules(),
            [
                # custom validation rules
            ]
        );
    }

    public function getUrl() {
        if ($this->type == 0) {
            return Url::to(['site/index', 'alias' => $this->alias]);
        } else if ($this->type == 1) {
            $parent = Textpage::findOne(8);
        } else if ($this->type == 2) {
            $parent = Textpage::findOne(9);
        } else {
            return '';
        }

        return Url::to(['site/index', 'alias' => $parent->alias, 'alias2' => $this->alias]);
    }

    public function getBackendUrl() {
        if ($this->type == 0) {
            return '/'.$this->alias;
        } else if ($this->type == 1) {
            $parent = Textpage::findOne(8);
        } else if ($this->type == 2) {
            $parent = Textpage::findOne(9);
        } else {
            return '';
        }

        return '/'.$parent->alias.'/'.$this->alias;
    }
    
    public static function getSurveyPage() {
        return Yii::$app->cache->getOrSet('surveyPage', function() {
            return Textpage::findOne(21);
        }, 5);
    }
}
