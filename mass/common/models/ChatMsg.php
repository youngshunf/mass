<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "chat_msg".
 *
 * @property integer $id
 * @property integer $chatid
 * @property string $sender
 * @property string $type
 * @property string $content
 * @property integer $is_read
 * @property string $created_at
 */
class ChatMsg extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chat_msg';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['chatid', 'is_read'], 'integer'],
            [['content'], 'string'],
            [['sender'], 'string', 'max' => 64],
            [['type'], 'string', 'max' => 20],
            [['created_at'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'chatid' => 'Chatid',
            'sender' => 'Sender',
            'type' => 'Type',
            'content' => 'Content',
            'is_read' => 'Is Read',
            'created_at' => 'Created At',
        ];
    }
}
