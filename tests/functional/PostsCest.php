<?php

namespace tests\functional;

use FunctionalTester;
use app\models\User;
use app\modules\admin\models\Posts;
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


    // перевіряємо сторінку зі списком статей (READ)
    public function listRead(FunctionalTester $I)
    {
        $I->amOnRoute('admin/posts/index');

        $I->see('Статті');
        $I->see('Створити статтю');

    }

    //  створення статті (CREATE)
    public function createPost(FunctionalTester $I)
    {
        $admin = User::findOne(['email' => 'vladyslav.miroshnicenko333@gmail.com']);

        $post = new Posts();
        $post->title        = 'Тест заголовок';
        $post->description  = 'Тест опису.';
        $post->category_id  = 1;
        $post->tagIds       = [1];
        $post->source       = 'https://example.com';
        $post->user_id      = $admin->id;
        $post->created_at   = date('Y-m-d H:i:s');

        $post->save(false);
        $post->saveTags();

        $I->seeRecord(Posts::class, [
            'title' => 'Тест заголовок',
        ]);
    }

    //  оновлення статті (UPDATE)
    public function updatePost(FunctionalTester $I)
    {
        $admin = User::findOne(['email' => 'vladyslav.miroshnicenko333@gmail.com']);

        $post = new Posts();
        $post->title        = 'Старий заголовок';
        $post->description  = 'Старий опис';
        $post->category_id  = 1;
        $post->tagIds       = [1];
        $post->user_id      = $admin->id;
        $post->created_at   = date('Y-m-d H:i:s');
        $post->save(false);
        $post->saveTags();

        $id = $post->id;

        // Оновлення
        $post->title       = 'Оновлений заголовок';
        $post->description = 'Оновлений опис';
        $post->tagIds      = [1];
        $post->save(false);
        $post->saveTags();

        $I->seeRecord(Posts::class, [
            'id'    => $id,
            'title' => 'Оновлений заголовок',
        ]);
    }

    // ВИДАЛЕННЯ СТАТТІ (DELETE)
    public function deletePost(FunctionalTester $I)
    {
        $admin = User::findOne(['email' => 'vladyslav.miroshnicenko333@gmail.com']);

        $post = new Posts();
        $post->title        = 'На видалення';
        $post->description  = 'Опис на видалення';
        $post->category_id  = 1;
        $post->tagIds       = [1];
        $post->user_id      = $admin->id;
        $post->created_at   = date('Y-m-d H:i:s');
        $post->save(false);
        $post->saveTags();

        $id = $post->id;

        $I->seeRecord(Posts::class, ['id' => $id]);

        $I->amOnRoute('admin/posts/delete', ['id' => $id]);
        $I->dontSeeRecord(Posts::class, ['id' => $id]);


    }
}
