<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "comment_new".
 *
 * @property integer $id
 * @property integer $newsid
 * @property integer $user_guid
 * @property string $content
 * @property string $reply_to
 * @property string $created_at
 */
class CommentNew extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment_new';
    }

    /**
     * @inheritdoc
     */
//     public function rules()
//     {
//         return [
//             [['newsid', 'user_guid'], 'integer'],
//             [['content', 'created_at'], 'string', 'max' => 255],
//             [['reply_to'], 'string', 'max' => 10]
//         ];
//     }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'newsid' => 'Newsid',
            'user_guid' => 'User Guid',
            'content' => '评论内容',
            'reply_to' => '回复',
            'created_at' => 'Created At',
        ];
    }
}
