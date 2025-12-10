<?php

namespace app\models;

use Yii;

use yii\base\Model;

class SignupForm extends Model {

    public $name;
    public $email;
    public $password;
    
    public function rules() {

        $minLength = 8;
        $maxLength = 32;

        // допустипі символи і їхня кількість
        $passwordRegex = '/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[^a-zA-Z\d]).{' . $minLength . ',' . $maxLength . '}$/';
        $emailRegex = '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
        $fullNameRegex = '/^[А-Яа-яІіЇїЄєҐґ\'\- ]+$/u';

        return [
            [['name', 'email', 'password'], 'required', 'message' => 'Дане поле є обов’язковим до заповнення!'],

            ['name', 'validateName'],
            ['email', 'validateEmail'],
            ['password', 'validatePassword'],

            // унікальність email
            [
                'email',
                'unique',
                'targetClass' => 'app\models\User',
                'targetAttribute' => 'email',
                'message' => 'Ця електронна пошта вже використовується.'
            ],

        ];

    }

    public function attributeLabels()
    {
        return [
            'name' => 'Ім’я',
            'email' => 'Пошта',
            'password' => 'Пароль',
        ];
    }

    // валідація для імені
    public function validateName($attribute, $params)
    {
        $fullName = $this->$attribute;
        $moreSpaceRegex = '/\s{2,}/';
        $fullNameRegex = '/^[А-Яа-яІіЇїЄєҐґ\'\- ]+$/u';

        if (!preg_match($fullNameRegex, $fullName)) {
            $this->addError($attribute, 'Допустимі символи: українські літери, пробіл, апостроф та дефіс.');
        } elseif (preg_match($moreSpaceRegex, $fullName)) {
            $this->addError($attribute, 'ПІБ не може містити кілька пробілів поспіль.');
        } elseif (mb_strlen($fullName) < 5 || mb_strlen($fullName) > 70) {
            $this->addError($attribute, 'Ім’я має містити від 5 до 70 символів.');
        }

    }

    // валідація для пошти
    public function validateEmail($attribute, $params)
    {
        $email = $this->$attribute;

        if (preg_match('/\s/', $email)) {
            $this->addError($attribute, 'Email не може містити пробіли.');
        } elseif (!preg_match('/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
            $this->addError($attribute, 'Допустимі символи: латинські літери, цифри, крапка, тире та підкреслення.');
        } elseif (strlen($email) > 70) {
            $this->addError($attribute, 'Вибачте, але ми не приймаємо Email довші за 70 символів.');
        }
    }

    // валідація ддля пароля
    public function validatePassword($attribute, $params)
    {
        $password = $this->$attribute;
        $minLength = 8;
        $maxLength = 32;
        $passwordRegex = '/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[^a-zA-Z\d]).{8,}$/';

        if (strlen($password) < $minLength || strlen($password) > $maxLength) {
            $this->addError($attribute, 'Довжина пароля має бути мінімум 8 і максимум 32 символи.');
        } elseif (!preg_match($passwordRegex, $password)) {
            $this->addError($attribute, 'Пароль повинен містити латинські літери, цифри та спеціальні символи.');
        }
    }

    public function signup()
    {
        if($this->validate()) {

            $user = new User();
            $user->attributes = $this->attributes;

            $user->password = Yii::$app->security->generatePasswordHash($this->password);
            

            return $user->create();
            
        }
    }
}