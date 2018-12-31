<?php
/**
 * Created by PhpStorm.
 * User: TTaRazut
 * Date: 30.12.2018
 * Time: 13:29
 */

namespace app\models;

use Yii;

class Site
{
    /** @var string путь к пользователям в файле */
    private static $_pathUsers = '../data/users';

    /**
     * Получение данных из базы данных
     *
     * @return array.
     */
    public function loadFromDB()
    {
        Yii::$app->cache->get('db');

        if (!isset($users) || empty($users)) {
            $users = User::find()->asArray()->all();

            if (is_array($users)) {
                foreach ($users as $k => $user) {
                    $users[$k]['location'] = json_decode($user['location'], 1);
                }
            }

//            Cache::set('db', $users);
            Yii::$app->cache->add('db', $users);
            Yii::info('Load from db');
        } else {
            Yii::info('Load from cache');
        }

        if (empty($users)) $users = [];

        return $users;
    }

    /**
     * Заполнение таблицы users
     *
     * @return boolean.
     */
    public function generateDB()
    {
        User::deleteAll();

        $users_log = []; // Для логов
        $getUsers = json_decode(file_get_contents('https://randomuser.me/api/?results=5&nat=gb'), true);
        foreach ($getUsers['results'] as $data) {
            $location = json_encode([
                'street' => $data['location']['street'],
                'city' => $data['location']['city'],
                'state' => $data['location']['state'],
                'postcode' => $data['location']['postcode'],
            ]);

            $user = new User();

            $user->first_name = $data['name']['first'];
            $user->last_name = $data['name']['last'];
            $user->phone = $data['phone'];
            $user->email = $data['email'];
            $user->location = $location;
            $user->registered_at = strtotime($data['registered']['date']);

            $user->save();

            $users_log[] = [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'location' => $user->phone,
                'email' => $user->email,
                'phone' => $user->location,
                'registered_at' => $user->registered_at
            ];
        }

        Yii::debug('Fills db', $users_log);
        Yii::$app->cache->delete('db');

        return true;
    }

    /**
     * Удаление user по id из базы данных
     *
     * @param integer $id
     *
     * @return boolean.
     */
    public function removeFromDB($id)
    {
        User::findOne($id)->delete();

        Yii::$app->cache->delete('db');
        Yii::info('Remove from db ' . $id);

        return true;
    }

    /**
     * Получение данных из файла user
     *
     * @return array.
     */
    public function loadFromFile()
    {
        if (file_exists(static::$_pathUsers))
            $users = json_decode(file_get_contents(static::$_pathUsers), 1);

        if (empty($users)) $users = [];

        Yii::info('Load from file');

        return $users;
    }

    /**
     * Заполнение файла user
     *
     * @return boolean.
     */
    public function generateFile()
    {
        $users = [];
        $getUsers = json_decode(file_get_contents('https://randomuser.me/api/?results=5&nat=gb'), true)['results'];
        foreach ($getUsers as $data) {
            $uuid = uniqid();
            $location = [
                'street' => $data['location']['street'],
                'city' => $data['location']['city'],
                'state' => $data['location']['state'],
                'postcode' => $data['location']['postcode'],
            ];

            $users[$uuid] = [
                'id' => $uuid,
                'first_name' => $data['name']['first'],
                'last_name' => $data['name']['last'],
                'location' => $location,
                'email' => $data['email'],
                'phone' => $data['phone'],
                'registered_at' => strtotime($data['registered']['date']),
            ];
        }

        if (!is_dir(dirname(static::$_pathUsers)))
            mkdir(dirname(static::$_pathUsers), 0777, true);

        file_put_contents(static::$_pathUsers, json_encode($users));

        Yii::debug('Fills files', $users);

        return true;
    }

    /**
     * Удаление user по id из файла
     *
     * @param integer $id
     *
     * @return boolean.
     */
    public function removeFromFile($id)
    {
        $users = json_decode(file_get_contents(static::$_pathUsers), 1);
        unset($users[$id]);
        file_put_contents(static::$_pathUsers, json_encode($users));

        Yii::info('Remove from file ' . $id);

        return true;
    }
}