<?php

namespace app\models;
use Yii;


/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property integer $isAdmin
 *
 * 
 */

class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface {

    public static function tableName() {
        return 'user';
    }
    
    public function rules() {
        return [
            [['isAdmin'], 'integer'],
            [['name', 'email', 'password'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Ім’я',
            'email' => 'Пошта',
            'password' => 'Пароль',
            'isAdmin' => 'Чи адмін',
        ];
    }


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return User::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        //
    }

    public static function findByEmail($email)
    {
        return User::find()->where(['email'=>$email])->one();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        //
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        //
    }

    public function validatePassword($password) {

        return Yii::$app->security->validatePassword($password, $this->password);

    }

    public function create()
    {
        return $this->save(false);
    }
}
