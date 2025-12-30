<?php

class EntryFormCest {

    public function _before(\FunctionalTester $I) {

        $I->amOnPage('/index.php?r=site/entry');
    }

    // пусті поля
    public function emptyFormError(\FunctionalTester $I) {

        $I->click('Надіслати');
        $I->see('Name cannot be blank');
        $I->see('Email cannot be blank');
        $I->see('Password cannot be blank');
    }

    // некоректре ім'я
    public function invalidNameError(\FunctionalTester $I) 
    {
        $I->submitForm('form', [
            'EntryForm[name]' => 'Vladyslav',
            'EntryForm[email]' => 'vlaf.efrf@gmail.com',
            'EntryForm[password]' => 'vhass;6734dgh',
        ]);
        $I->see('Допустимі символи: українські літери, пробіл, апостроф та дефіс.');
    }

    // некоректна пошта
    public function invalidEmailError(\FunctionalTester $I) {

        $I->submitForm('form', [
            'EntryForm[name]' => 'Владислав',
            'EntryForm[email]' => 'влад.ferfre@gmail.com',
            'EntryForm[password]' => 'vhass;6734dgh',
        ]);
        $I->see('Допустимі символи: латинські літери, цифри, крапка, тире та підкреслення.');
    }

    // некоректний пароль
    public function invalidPasswordError(\FunctionalTester $I) {

        $I->submitForm('form', [
            'EntryForm[name]' => 'Владислав',
            'EntryForm[email]' => 'vlaf.efrf@gmail.com',
            'EntryForm[password]' => 'еекпекпе23234;',
        ]);
        $I->see('Пароль повинен містити латинські літери, цифри та спеціальні символи');
    }

    // валідні дані
    public function validData(\FunctionalTester $I) {
        $I->submitForm('form', [
            'EntryForm[name]' => 'Владислав',
            'EntryForm[email]' => 'vlaf.efrf@gmail.com',
            'EntryForm[password]' => 'vhass;6734dgh',
        ]);
        $I->see('Ви вказали наступну інформацію:');
        $I->see('Ім’я: Владислав');
        $I->see('Адреса електронної пошти: vlaf.efrf@gmail.com');
        $I->see('Пароль: vhass;6734dgh');
    }
}
