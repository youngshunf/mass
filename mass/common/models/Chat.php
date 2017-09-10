<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "chat".
 *
 * @property integer $id
 * @property string $members
 * @property string $created_at
 */
class Chat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at'], 'integer'],
            [['members'], 'string', 'max' => 1024]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'members' => 'Members',
            'created_at' => 'Created At',
        ];
    }
}
