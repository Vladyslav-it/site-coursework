<?php

namespace tests\functional;

use FunctionalTester;

class LoginFormCest
{
    public function _before(FunctionalTester $I)
    {
        // відкрив сторінку авторизації
        $I->amOnPage('/index.php?r=auth/login');
    
    }

    // тест: пусті поля
    public function emptyFields(FunctionalTester $I)
    {
        
        $I->submitForm('form', [
            'LoginForm[email]' => '',
            'LoginForm[password]' => '',
        ]);

        $I->see('Дане поле є обов’язковим до заповнення!', '.field-loginform-email .help-block');
        $I->see('Дане поле є обов’язковим до заповнення!', '.field-loginform-password .help-block');
        
    }

    // тест: некоректна пошта
    public function errorEmail(FunctionalTester $I)
    {
        $I->submitForm('form', [
            'LoginForm[email]' => 'владислав@@gmail',
            'LoginForm[password]' => 'fdsfsd23!',
        ]);
        $I->see('Допустимі символи: латинські літери, цифри, крапка, тире та підкреслення.');
    }

    // тест: некоректна довжина пароля
    public function errorLengthPassword(FunctionalTester $I)
    {
        $I->submitForm('form', [
            'LoginForm[email]' => 'vladyslav.miroshnicenko@gmail.com',
            'LoginForm[password]' => 'short',
        ]);
        $I->see('Довжина пароля має бути мінімум 8 і максимум 32 символи.');
    }

    // тест: неправильні дані
    public function lognWrong(FunctionalTester $I)
    {
        $I->submitForm('form', [
            'LoginForm[email]' => 'vlad@gmail.com',
            'LoginForm[password]' => 'Valid123!',
        ]);
        $I->see('Невірна пошта або пароль.');
    }

    // тест: валідні дані
    public function valigLogin(FunctionalTester $I)
    {
        $I->submitForm('form', [
            'LoginForm[email]' => 'vladyslav.miroshnicenko@gmail.com',
            'LoginForm[password]' => 'qwerty123;', 
        ]);

        $I->see('Вийти (Владислав)');
    }
}
