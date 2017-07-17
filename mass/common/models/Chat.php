<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "chat".
 *
 * @property integer $id
 * @property string $from
 * @property string $to
 * @property string $content
 * @property integer $is_read
 * @property string $created_at
 * @property string $text
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
            [['content'], 'string'],
            [['is_read', 'created_at'], 'integer'],
            [['from', 'to'], 'string', 'max' => 48],
            [['text'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from' => 'From',
            'to' => 'To',
            'content' => 'Content',
            'is_read' => 'Is Read',
            'created_at' => 'Created At',
            'text' => 'Text',
        ];
    }
}
