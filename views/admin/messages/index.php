<?php $this->includeHeader('admin'); ?>
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= \App\Helpers\Url::makeUrl(); ?>">Главная</a></li>
            <li class="breadcrumb-item active" aria-current="page">Список сообщений</li>
        </ol>
    </nav>
    <div class="py-5 text-center">
        <h2>Список сообщений</h2>
    </div>

    <div class="row">
        <div class="col-8 offset-md-2">
            <?php if (count($errors)) { ?>
                <ul class="alert-danger">
                    <?php foreach ($errors as $error) { ?>
                        <li><?= $error; ?></li>
                    <?php } ?>
                </ul>
            <?php } ?>
            <?php if (\App\Helpers\Session::has('success_message')) { ?>
                <ul class="alert-danger">
                    <li><?= \App\Helpers\Session::get('success_message', true); ?></li>
                </ul>
            <?php } ?>
            <?php if (count($messages) > 0) { ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Пользователь</th>
                            <th scope="col">Тема</th>
                            <th scope="col">Сообщение</th>
                            <th scope="col">Дата</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($messages as $message) { ?>
                            <tr <?php if ($message['is_new']) { ?> class="table-info" <?php } ?>>
                                <td><?= $message['id'] ?></td>
                                <td><a target="_blank" href="<?= \App\Helpers\Url::makeUrl('user', 'edit', ['id' => $message['user_id']]); ?>"><?= $message['user_name'] ?></a></td>
                                <td><?= $message['subject'] ?></td>
                                <td><?= $message['message'] ?></td>
                                <td><?= date('d.m.y H:i:s', $message['created_at']) ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } ?>
        </div>
    </div>
    <?php $this->includeHeader('footer'); ?>

