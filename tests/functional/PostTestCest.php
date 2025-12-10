<?php

namespace functional;

use FunctionalTester;

class PostTestCest {
    
    // сторінка відкривається і містить заголовок
    public function PageLoad(FunctionalTester $I)
    {
        $I->amOnPage('/index.php?r=post/index');
        $I->see('Поради щодо харчування', 'h1');
    }

    //  чи є хоч один пост
    public function seePost(FunctionalTester $I)
    {
        $I->amOnPage('/index.php?r=post/index');
        $I->seeElement('.post-card');
    }

    // чи відображається назва поста 
    public function postTitle(FunctionalTester $I)
    {
        $I->amOnPage('/index.php?r=post/index');
        $I->seeElement('.post-title');
    }

    // чи відображається опис поста 
    public function postDescription(FunctionalTester $I)
    {
        $I->amOnPage('/index.php?r=post/index');
        $I->seeElement('.post-text');
    }

    // чи дата створення (публікації) присутня
    public function postDate(FunctionalTester $I)
    {
        $I->amOnPage('/index.php?r=post/index');
        $I->see('Дата публікації (створення):', '.post-date');
    }

    // чи відображається зображення поста 
    public function postImage(FunctionalTester $I)
    {
        $I->amOnPage('/index.php?r=post/index');
        $I->seeElement('.post-image img');
    }

    // чи є пагінація 
    public function paginationVisible(FunctionalTester $I)
    {
        $I->amOnPage('/index.php?r=post/index');
        $I->seeElement('.pagination');
    }

}
