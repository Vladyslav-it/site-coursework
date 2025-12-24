<?php

namespace app\models;

use Yii;

use app\modules\admin\models\Posts;


/**
 * This is the model class for table "post_tag".
 *
 * @property int $id
 * @property int $post_id
 * @property int $tag_id
 *
 * @property Posts $post
 * @property Tag $tag
 */
class PostTag extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'post_tag';
    }

    public function rules()
    {
        return [
            [['post_id', 'tag_id'], 'required'],
            [['post_id', 'tag_id'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Пост',
            'tag_id' => 'Тег',
        ];
    }

    public function getPost()
    {
        return $this->hasOne(Posts::class, ['id' => 'post_id']);
    }

    public function getTag()
    {
        return $this->hasOne(Tag::class, ['id' => 'tag_id']);
    }
}
