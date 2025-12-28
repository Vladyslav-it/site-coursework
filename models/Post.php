<?php

namespace app\models;

use yii\db\ActiveRecord;

class Post extends ActiveRecord {
    public static function tableName() {

        return 'posts';

    }

    public function getCategory() { 
        return $this->hasOne(Category::class, ['id' => 'category_id']); 
    } 
    
    public function getTags() { 
        return $this->hasMany(Tag::class, ['id' => 'tag_id']) ->viaTable('post_tag', ['post_id' => 'id']);
    }

    public function getAuthor() { 
        return $this->hasOne(User::class, ['id' => 'user_id']); 
    }

}