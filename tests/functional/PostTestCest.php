<?php

namespace functional;

use FunctionalTester;

class PostTestCest
{

    public function _before(FunctionalTester $I)
    {
        $I->amOnPage('/index.php?r=post/index');
    }

    // Перевірка заголовка сторінки
    public function titleSee(FunctionalTester $I)
    {
        $I->see('Пости', 'h1.page-title');
    }

    // Перевірка наявності форми фільтрації
    public function filterFormSee(FunctionalTester $I)
    {
        $I->seeElement('form');
        $I->see('Фільтрація');
        $I->seeElement('input[name="PostSearch[searchText]"]');
        $I->seeElement('select[name="PostSearch[category_id]"]');
        $I->seeElement('select[name="PostSearch[tag_id]"]');
    }

    // Перевірка наявності постів
    public function postSee(FunctionalTester $I)
    {
        $I->seeElement('.post-card');
        $I->seeElement('.post-title');
        $I->seeElement('.post-text');
        $I->seeElement('.post-date');
        $I->seeElement('.post-image img');
    }

    // Перевірка пагінації
    public function paginationSee(FunctionalTester $I)
    {
        $I->seeElement('.pagination');
    }

    // Перевірка фільтрації постів за категорією
    public function filterByCategory(FunctionalTester $I)
    {
        $I->amOnPage('/index.php?r=post/index&PostSearch[category_id]=2');

        $I->seeElement('.post-card');

        $I->see('Здорове харчування'); 
    }
}
