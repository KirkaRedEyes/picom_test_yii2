<?php
/**
 * @var $this yii\web\View
 * @var string $action - действие пользователя
 * @var array $users - пользователи
 **/

$this->title = 'Дабвить пользователя';
?>

<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Имя</th>
        <th scope="col">Фамилия</th>
        <th scope="col">Телефон</th>
        <th scope="col">Email</th>
        <th scope="col">Адрес</th>
        <th scope="col">Зарегистрирован</th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>
    <?php
    $number = 1;
    $monthes = [
        '01' => 'января',
        '02' => 'февраля',
        '03' => 'марта',
        '04' => 'апреля',
        '05' => 'мая',
        '06' => 'июня',
        '07' => 'июля',
        '08' => 'августа',
        '09' => 'сентября',
        '10' => 'октября',
        '11' => 'ноября',
        '12' => 'декабря',
    ];

    foreach ($users as $user) {
        $month = $monthes[date('m', $user['registered_at'])];
        ?>
        <tr>
            <th scope="row"><?= $number++ ?></th>
            <td><?= $user['first_name']?></td>
            <td><?= $user['last_name']?></td>
            <td><?= $user['phone']?></td>
            <td><?= $user['email']?></td>
            <td><?= implode(', ', $user['location']) ?></td>
            <td><?= date('d ' . $month . ' Y H:i:s', $user['registered_at']) ?></td>
            <td>
                <a href="/remove-from-<?= ($action == 'db') ? 'data-base' : 'file'?>?id=<?= $user['id']?>"
                   class="btn btn-danger">Удалить</a>
            </td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>
<div class="container-fluid">
    <a class="btn btn-success float-right"
       href="/generate-<?= ($action == 'db') ? 'data-base' : 'file'?>"
       role="button">Сгенерировать в <?= ($action == 'db') ? 'базе' : 'файле'?></a>
</div>
