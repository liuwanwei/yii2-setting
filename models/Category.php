<?php

namespace buddysoft\setting\models;

use Yii;

/**
 * This is the model class for table "bs_setting_category".
 *
 * @property integer $id
 * @property string $category
 * @property string $title
 * @property integer $weight
 * @property string $createdAt
 * @property string $updatedAt
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bs_setting_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category', 'title'], 'required'],
            [['weight'], 'integer'],
            [['category'], 'unique'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['category', 'title'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category' => 'Category',
            'title' => 'Title',
            'weight' => 'Weight',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
        ];
    }
}
