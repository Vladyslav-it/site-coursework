<?php

namespace app\models;

use Yii;

use app\modules\admin\models\Posts;


/**
 * This is the model class for table "tag".
 *
 * @property int $id
 * @property string $title
 *
 * @property PostTag[] $postTags
 * @property Posts[] $posts
 */
class Tag extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'tag';
    }

    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Назва тегу',
        ];
    }

    public function getPostTags()
    {
        return $this->hasMany(PostTag::class, ['tag_id' => 'id']);
    }

    public function getPosts()
    {
        return $this->hasMany(Posts::class, ['id' => 'post_id'])
            ->viaTable('post_tag', ['tag_id' => 'id']);
    }
}
