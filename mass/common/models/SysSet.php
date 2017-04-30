<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sys_set".
 *
 * @property integer $id
 * @property integer $keep_expire
 * @property integer $withdraw_deposit
 */
class SysSet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sys_set';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['keep_expire','keep_expire_oil','keep_expire_other', 'withdraw_deposit','deposit_rate','car_deposit_rate','top_rate','top_frozen'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'keep_expire' => '申诉期限(天)',
            'keep_expire_oil' => '加油履约期限(天)',
            'keep_expire_other' => '其他履约期限(天)',
            'withdraw_deposit' => '普通履约期限(天)',
            'deposit_rate'=>'普通商品保证金比例(%)',
            'car_deposit_rate'=>'车类保证金比例(%)',
            'top_rate'=>'保证金上限(元)',
            'top_frozen'=>'冻结金额上限(元)'
        ];
    }
}
