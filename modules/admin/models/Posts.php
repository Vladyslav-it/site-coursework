<?php

namespace app\modules\admin\models;

use Yii;

use app\models\User;
use app\models\Category;
use app\models\Tag;
use app\models\PostTag;

use yii\web\UploadedFile;
use yii\helpers\BaseStringHelper;


/**
 * This is the model class for table "posts".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string|null $image
 * @property string|null $source
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property Tag[] $tags
 * @property int $user_id
 * @property int|null $category_id
 *
 * @property Category $category
 * @property Comment[] $comments
 * @property PostTag[] $postTags
 * @property User $user
 */
class Posts extends \yii\db\ActiveRecord
{

    /** @var UploadedFile|null */
    public $imageFile;

    public $filename;
    public $string;

    public $tagIds = [];


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image', 'source'], 'default', 'value' => null],
            [['title', 'description', 'user_id'], 'required', 'message' => 'Дане поле є обов’язковим до заповнення!'],

            [['created_at', 'updated_at'], 'safe'],
            [['user_id', 'category_id'], 'integer'],
            [['category_id'], 'required', 'message' => 'Оберіть категорію!'],

            [['source'], 'string', 'max' => 255, 'tooLong' => 'Ви перевищили більше 255 символів!'],

            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],

            // валідація для заголовка і описа
            ['title', 'validateTitle'],
            ['description', 'validateDescription'],

            // Валідація файлу зображ
            [
                'imageFile',
                'file',
                'skipOnEmpty' => true,
                'extensions' => 'png, jpg, jpeg',
                'maxSize' => 5 * 1024 * 1024,
            ],

            ['tagIds', 'required', 'message' => 'Оберіть хоча б один тег!'],
            [['tagIds'], 'each', 'rule' => ['integer'], 'skipOnEmpty' => false],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'description' => 'Опис',
            'image' => 'Зображення',
            'source' => 'Джерела',
            'created_at' => 'Створено',
            'updated_at' => 'Оновлено',

            'user_id' => 'User ID',
            'category_id' => 'Категорія',

            'tagIds' => 'Теги',
            'imageFile' => 'Зображення',

        ];
    }

    public function validateTitle($attribute, $params)
    {
        $value = $this->$attribute;

        if (!preg_match('/^[a-zA-Zа-яА-ЯіїєґІЇЄҐ0-9\'",\.\-:;– ]+$/u', $value)) {
            $this->addError($attribute, 'Допустимі символи: українські та латинські літери, цифри, кома, крапка, лапки та дефіс.');
            return;
        }

        if (preg_match('/\s{2,}/', $value)) {
            $this->addError($attribute, 'Заголовок не може містити кілька пробілів поспіль.');
            return;
        }

        if (mb_strlen($value) < 3 || mb_strlen($value) > 50) {
            $this->addError($attribute, 'Заголовок повинен бути від 3 до 50 символів.');
            return;
        }
    }

    public function validateDescription($attribute, $params)
    {
        $value = $this->$attribute;


        if (mb_strlen($value) < 30 || mb_strlen($value) > 1500) {
            $this->addError($attribute, 'Опис повинен бути від 30 до 1500 символів.');
            return;
        }
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    // public function getComments()
    // {
    //     return $this->hasMany(Comment::class, ['post_id' => 'id']);
    // }

    /**
     * Gets query for [[PostTags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPostTags()
    {
        return $this->hasMany(PostTag::class, ['post_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    // для тегів get
    public function getTags()
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])
            ->viaTable('post_tag', ['post_id' => 'id']);
    }


    // для тегів
    public function saveTags()
    {
        PostTag::deleteAll(['post_id' => $this->id]);

        if (is_array($this->tagIds)) {
            foreach ($this->tagIds as $tagId) {
                $pt = new PostTag();
                $pt->post_id = $this->id;
                $pt->tag_id = $tagId;
                $pt->save();
            }
        }

        $this->updated_at = date('Y-m-d H:i:s'); 
        $this->save(false, ['updated_at']);
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->imageFile = UploadedFile::getInstance($this, 'imageFile');

        if ($this->imageFile) {

            // генеруємо
            $this->string = substr(uniqid('image'), 0, 12);
            $fileName = $this->string . '.' . $this->imageFile->extension;

            //  шлях
            $path = Yii::getAlias('@webroot/images/' . $fileName);

            // Зберіг 
            if ($this->imageFile->saveAs($path)) {
                $this->image = 'images/' . $fileName;
            }
        }

        return true;
    }
}


   // public function beforeSave($insert)
    // {
    //     if ($this->isNewRecord) {
    //         $this->image = UploadedFile::getInstance($this, 'image');

    //         if ($this->image) {
    //             $this->string = substr(uniqid('image'), 0, 12);
    //             $this->filename = '@webroot/images/' . $this->string . '.' . $this->image->extension;
    //             $this->image->saveAs($this->filename);
    //             $this->image = '/' . $this->filename;
    //         }

    //         // $this->text_preview = BaseStringHelper::truncate($this->description, 250, '...');
    //     } else {
    //         $this->image = UploadedFile::getInstance($this, 'image');
    //         if ($this->image) {
    //             $this->image->saveAs(substr($this->image, 1));
    //         }
    //     }

    //     return parent::beforeSave($insert);
    // }
