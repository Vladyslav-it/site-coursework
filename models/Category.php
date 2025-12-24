<?php

namespace app\models;

use Yii;

use app\modules\admin\models\Posts;


/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $title
 *
 * @property Posts[] $posts
 */

class Category extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'category';
    }

    public function rules()
    {
        return [
            // Перевірка на пустоту 
            ['title', 'required', 'message' => 'Дане поле є обов’язковим до заповнення!'],
            [['title'], 'string', 'max' => 255],


            // унікальність назви 
            ['title', 'unique', 'targetClass' => self::class, 'message' => 'Така категорія вже існує.'], 
            
            // кастомна перевірка на допустимі символи 
            ['title', 'validateTitle'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Назва категорії',
        ];
    }

    public function validateTitle($attribute, $params)
    {
        $value = $this->$attribute;

        if (!preg_match('/^[a-zA-Zа-яА-ЯіїєґІЇЄҐ0-9\'",\.\-:;– ]+$/u', $value)) {
            $this->addError($attribute, 'Допустимі символи: українські та латинські літери, цифри, кома, крапка, лапки та дефіс.');
            return;
        }

        if (preg_match('/\s{2,}/', $value)) {
            $this->addError($attribute, 'Назва категорії не може містити кілька пробілів поспіль.');
            return;
        }

        if (mb_strlen($value) < 3 || mb_strlen($value) > 50) {
            $this->addError($attribute, 'Назва категорії повинна бути від 3 до 50 символів.');
            return;
        }
    }

    public function getPosts()
    {
        return $this->hasMany(Posts::class, ['category_id' => 'id']);
    }
}
