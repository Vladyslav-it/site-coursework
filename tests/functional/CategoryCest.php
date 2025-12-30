<?php

namespace tests\functional;

use FunctionalTester;
use app\models\User;

use app\models\Category;
use Yii;


class PostsCest
{
    public function _before(FunctionalTester $I)
    {

        $admin = User::findOne(['email' => 'vladyslav.miroshnicenko333@gmail.com']);

        if (!$admin) {
            $admin = new User();
            $admin->name  = 'Владислав';
            $admin->email = 'vladyslav.miroshnicenko333@gmail.com';
            $admin->password = Yii::$app->security->generatePasswordHash('trfghfgtrg123;');
            $admin->isAdmin = 1;
            $admin->save(false);
        }

        Yii::$app->user->login($admin);
    }


    // перевіряємо сторінку зі списком категорій (READ)
    public function listRead(FunctionalTester $I)
    {
        $I->amOnRoute('admin/category/index');

        $I->see('Категорії');
        $I->see('Створити категорію');
    }
    

    //  створення категорії (CREATE)
    public function createPost(FunctionalTester $I)
    {

       $category = new Category(); 
       $category->title = 'Тест категорія'; 
       
       $category->save(false); 
       $I->seeRecord(Category::class, ['title' => 'Тест категорія']);
    }

    //  оновлення категорії (UPDATE)
    public function updatePost(FunctionalTester $I)
    {

        $category = new Category(); 
        $category->title = 'Стара категорія'; 
        $category->save(false); 
        
        $id = $category->id; 
        
        $category->title = 'Оновлена категорія'; 
        $category->save(false); 
        $I->seeRecord(Category::class, ['id' => $id, 'title' => 'Оновлена категорія']);
    }

    // ВИДАЛЕННЯ категорії (DELETE)
    public function deletePost(FunctionalTester $I)
    {

        $category = new Category(); 
        $category->title = 'На видалення'; 
        $category->save(false); 
        
        $id = $category->id; 
        
        $I->seeRecord(Category::class, ['id' => $id]); 
        $I->amOnRoute('admin/category/delete', ['id' => $id]); 
        $I->dontSeeRecord(Category::class, ['id' => $id]);


    }
}
