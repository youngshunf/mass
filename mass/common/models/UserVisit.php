<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_visit".
 *
 * @property integer $id
 * @property string $user_guid
 * @property integer $cateid
 * @property integer $goodsid
 * @property integer $created_at
 */
class UserVisit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_visit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cateid', 'goodsid', 'created_at'], 'integer'],
            [['user_guid'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_guid' => 'User Guid',
            'cateid' => 'Cateid',
            'goodsid' => 'Goodsid',
            'created_at' => 'Created At',
        ];
    }
}
