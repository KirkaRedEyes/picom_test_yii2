О работе
---------
Потратил 3 часа

Настройка
---------
Переименовать .env.example в .env

Запустить Docker и в консоли выполнить
```
$ docker-compose up --build -d
```
Подключиться к рабочему контейнеру 'picom_test_php'
```
$ docker exec -it picom_test_php sh
```
Зайти в папку 'web'
```
# cd web
```
Загрузить пакеты выполнив
```
# composer install
```
Добавить таблицы выполнив миграции
```
# php yii migrate
```
