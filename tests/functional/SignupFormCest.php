<?php

namespace tests\functional;

use FunctionalTester;

class SignupFormCest
{
    public function _before(FunctionalTester $I)
    {
        // відкрив сторінку реєстрації
        $I->amOnPage('/index.php?r=auth/signup');
    }

    // тест: пусті поля
    public function emptyFields(FunctionalTester $I)
    {
        $I->submitForm('form', [
            'SignupForm[name]' => '',
            'SignupForm[email]' => '',
            'SignupForm[password]' => '',
        ]);

        $I->see('Дане поле є обов’язковим до заповнення!', '.field-signupform-name .help-block');
        $I->see('Дане поле є обов’язковим до заповнення!', '.field-signupform-email .help-block');
        $I->see('Дане поле є обов’язковим до заповнення!', '.field-signupform-password .help-block');
    }

    // тест: некоректне ім’я
    public function errorName(FunctionalTester $I)
    {
        $I->submitForm('form', [
            'SignupForm[name]' => 'Влад123',
            'SignupForm[email]' => 'vladyslav.miroshnicenko@gmail.com',
            'SignupForm[password]' => 'vladid123!',
        ]);
        $I->see('Допустимі символи: українські літери, пробіл, апостроф та дефіс.');
    }

    // тест: некоректна пошта
    public function errorEmail(FunctionalTester $I)
    {
        $I->submitForm('form', [
            'SignupForm[name]' => 'Владислав',
            'SignupForm[email]' => 'invalidfdавввав@gmail',
            'SignupForm[password]' => 'vladid123!',
        ]);
        $I->see('Допустимі символи: латинські літери, цифри, крапка, тире та підкреслення.');
    }

    // тест: некоректний пароль
    public function errorPassword(FunctionalTester $I)
    {
        $I->submitForm('form', [
            'SignupForm[name]' => 'Владислав',
            'SignupForm[email]' => 'vladyslav.miroshnicenko@gmail.com',
            'SignupForm[password]' => 'qwertyqwerty',
        ]);
        $I->see('Пароль повинен містити латинські літери, цифри та спеціальні символи.');
    }

    // тест: email вже існує
    public function emailFind(FunctionalTester $I)
    {
        $I->submitForm('form', [
            'SignupForm[name]' => 'Владислав',
            'SignupForm[email]' => 'vladyslav.miroshnicenko@gmail.com', 
            'SignupForm[password]' => 'vladid123!',
        ]);
        $I->see('Ця електронна пошта вже використовується.');
    }

    // тест: успішна реєстрація
    public function valigSignup(FunctionalTester $I)
    {
        $I->submitForm('form', [
            'SignupForm[name]' => 'Джонатан',
            'SignupForm[email]' => 'jhon.marko@gmail.com', // унікал email
            'SignupForm[password]' => 'qwerty123;',
        ]);

        //  редірект на логін, перевіряємо через заголовок
        $I->see('Авторизація', 'h4'); 

    }
}