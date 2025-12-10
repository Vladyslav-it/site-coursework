<?php

namespace app\models;

use Yii;

use yii\base\Model;

class EntryForm extends Model

{

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
            [['name', 'email', 'password'], 'required'],

            ['name', 'match', 'pattern' => $fullNameRegex, 'message' => 'Допустимі символи: українські літери, пробіл, апостроф та дефіс.'],

            ['email', 'match', 'pattern' => $emailRegex, 'message' => 'Допустимі символи: латинські літери, цифри, крапка, тире та підкреслення.'],

            ['password', 'match', 'pattern' => $passwordRegex, 'message' => 'Пароль повинен містити латинські літери, цифри та спеціальні символи, і бути від ' . $minLength . ' до ' . $maxLength . ' символів.'],
        ];

    }

}