<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property int $phone
 * @property string $email
 * @property string $location
 * @property int $registered_at
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'phone', 'email', 'location', 'registered_at'], 'required'],
            [['registered_at'], 'integer'],
            [['location'], 'string'],
            [['first_name', 'last_name', 'phone', 'email'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'phone' => 'Телефон',
            'email' => 'Email',
            'location' => 'Адрес',
            'registered_at' => 'Зарегистрирован',
        ];
    }
}
