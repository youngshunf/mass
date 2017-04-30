<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cate_template".
 *
 * @property integer $id
 * @property string $user_guid
 * @property integer $cateid
 * @property string $template_fields
 * @property integer $created_at
 * @property integer $updated_at
 */
class CateTemplate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cate_template';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cateid', 'created_at', 'updated_at'], 'integer'],
            [['template_fields'], 'string'],
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
            'cateid' => '分类id',
            'template_fields' => '模板栏位',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    public function getCate() {
        return $this->hasOne(GoodsCate::className(), ['id'=>'cateid']);
    }
}
