<?php

namespace app\models;

use Yii;
use \app\models\base\Category as BaseCategory;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "category".
 */
class Category extends BaseCategory
{

public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
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
    public static function getList($id = 0, $level = 0)
    {
        $list = array();
        $text_level = str_repeat("~~ ", $level);
        $condition = ($id == 0) ? 'category_id is NULL' : 'category_id=' . (int) $id;
        $models = Category::find()->where($condition)->all();

        foreach ($models as $model) {
            $level = ($model->category_id == NULL) ? 0 : $level;
            $list = array_merge($list, array(array('id' => $model->id, 'name' => $text_level . $model->name)));
            $childList = Category::getList($model->id, ++$level);
            if (count($childList) > 0)
                $list = array_merge($list, $childList);
        }
        return $list;
    }
}
