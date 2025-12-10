<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class LoginForm extends Model
{

    // пошта, пароль і чи запам'ятати
    public $email; 
    public $password;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array правила для перевірки
     */
    public function rules()
    {
        return [

            [['email', 'password'], 'required', 'message' => 'Дане поле є обов’язковим до заповнення!'],
            ['email', 'validateEmail'],
            ['password', 'validatePassword'],
            ['rememberMe', 'boolean'],

        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'Пошта',
            'password' => 'Пароль',
            'rememberMe' => 'Запам’ятати мене',
        ];
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

    // валідація для пароля
    public function validatePassword($attribute, $params)
    {
        $password = $this->$attribute;

        if (strlen($password) < 8 || strlen($password) > 32) {
            $this->addError($attribute, 'Довжина пароля має бути мінімум 8 і максимум 32 символи.');
        } elseif (!preg_match('/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[^a-zA-Z\d]).{8,}$/', $password)) {
            $this->addError($attribute, 'Пароль повинен містити латинські літери, цифри та спеціальні символи.');
        } else {
            // якщо базові перевірки пройшли
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($password)) {
                $this->addError($attribute, 'Невірна пошта або пароль.');
            }
        }
    }

    /**
     * Logs in a user using the provided name and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[email]]
     *
     * @return User|null
     */
    public function getUser() {

        if ($this->_user === false) {
            $this->_user = User::findByEmail($this->email);
        }

        return $this->_user;
    }
}


