<?php

namespace app\models;

use yii\db\ActiveRecord;

class Comment extends ActiveRecord
{
    public static function tableName()
    {
        return 'comment';
    }

    public function rules()
    {
        return [
            [['text'], 'required', 'message' => 'Для відправки коментаря введіть спочатку його!'],
            [['text'], 'string', 'max' => 255, 'tooLong' => 'Ви перевищили більше 255 символів!'],
            [['user_id', 'post_id'], 'integer'],

            ['text', 'validateComment'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'text' => 'Текст коментаря',
        ];
    }


    public function validateComment($attribute, $params)
    {
        $value = $this->$attribute;

        if (!preg_match('/^[a-zA-Zа-яА-ЯіїєґІЇЄҐ0-9\'",\.\-:;–—\?!() ]+$/u', $value)) {
            $this->addError($attribute, 'Допустимі символи: українські та латинські літери, цифри, кома, крапка, лапки, дефіс, тире, знак питання, знак оклику та дужки.');
            return;
        }

        if (preg_match('/\s{2,}/', $value)) {
            $this->addError($attribute, 'Коментар не може містити кілька пробілів поспіль.');
            return;
        }
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getPost()
    {
        return $this->hasOne(Post::class, ['id' => 'post_id']);
    }

    /* для відповідей */
    public function getReplies()
    {
        return $this->hasMany(Comment::class, ['parent_id' => 'id'])
            ->orderBy(['created_at' => SORT_ASC]);
    }
    /* для відповідей */
    public function getParent()
    {
        return $this->hasOne(Comment::class, ['id' => 'parent_id']);
    }
}
