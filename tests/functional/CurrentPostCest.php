<?php

namespace tests\functional;

use FunctionalTester;

class CurrentPostCest
{
    public function _before(FunctionalTester $I)
    {
        // сторінка  поста з ID = 1
        $I->amOnPage('/index.php?r=post/view&id=1');
    }

    // Перевірка заголовка статті
    public function titleSee(FunctionalTester $I)
    {
        $I->seeElement('h1.post-title');
    }

    // Перевірка наявності тегів
    public function tagSee(FunctionalTester $I)
    {
        $I->seeElement('.post-tags .tag-chip');
    }

    // Перевірка кнопок поділитися
    public function shareBtnSee(FunctionalTester $I)
    {
        $I->see('Поділитися:');
        $I->seeElement('.btn-share-facebook');
        $I->seeElement('.btn-share-viber');
    }

    // Перевірка блоку коментарів
    public function commentSee(FunctionalTester $I)
    {
        $I->see('Коментарі');
        $I->seeElement('.comment-list');
    }

    // Перевірка додавання коментаря
    public function addComment(FunctionalTester $I)
    {

        $I->amLoggedInAs(8); // ID користувача, який існує 

        // Надсилання форми коментаря
        $I->submitForm('form', [
            'Comment[text]' => 'Це мій тестовий коментар',
        ]);

        // Перевіряємо чи з’явився
        $I->see('Це мій тестовий коментар', '.comment-text');
    }
}
