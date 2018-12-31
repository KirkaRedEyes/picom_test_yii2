<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Site;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    /**
     * Получение данных из базы данных
     *
     * @return string
     */
    public function actionLoadFromDataBase()
    {
        $modelSite = new Site();

        return $this->render('index', [
            'action' => 'db',
            'users' => $modelSite->loadFromDB()
        ]);
    }

    /**
     * Получение данных из файла user
     *
     * @return string
     */
    public function actionLoadFromFile()
    {
        $modelSite = new Site();

        return $this->render('index', [
            'action' => 'file',
            'users' => $modelSite->loadFromFile()
        ]);
    }

    /**
     * Заполнение таблицы users
     *
     * @return string|false.
     */
    public function actionGenerateDataBase()
    {
        $modelSite = new Site();
        if ($modelSite->generateDB())
            return $this->actionLoadFromDataBase();

        return false;
    }

    /**
     * Удаление user по id из базы данных
     *
     * @param integer $id
     *
     * @return string|false.
     */
    public function actionRemoveFromDataBase($id)
    {
        $modelSite = new Site();

        if ($modelSite->removeFromDB($id))
            return $this->actionLoadFromDataBase();

        return false;
    }

    /**
     * Заполнение файла user
     *
     * @return string|false.
     */
    public function actionGenerateFile()
    {
        $modelSite = new Site();

        if ($modelSite->generateFile())
            return $this->actionLoadFromFile();

        return false;
    }

    /**
     * Удаление user по id из файла
     *
     * @param integer $id
     *
     * @return string|false.
     */
    public function actionRemoveFromFile($id)
    {
        $modelSite = new Site();

        if ($modelSite->removeFromFile($id))
            return $this->actionLoadFromFile();

        return false;
    }
}
