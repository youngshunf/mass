<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "oil_rec".
 *
 * @property integer $id
 * @property integer $orderid
 * @property integer $num
 * @property integer $status
 * @property string $user_guid
 * @property integer $created_at
 * @property integer $updated_at
 */
class OilRec extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'oil_rec';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['orderid', 'num', 'status', 'created_at', 'updated_at'], 'integer'],
            [['user_guid'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'orderid' => 'Orderid',
            'num' => 'Num',
            'status' => 'Status',
            'user_guid' => 'User Guid',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
