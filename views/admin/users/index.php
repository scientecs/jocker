<?php $this->includeHeader('admin'); ?>
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= \App\Helpers\Url::makeUrl(); ?>">Главная</a></li>
            <li class="breadcrumb-item active" aria-current="page">Список пользователей</li>
        </ol>
    </nav>
    <div class="py-5 text-center">
        <h2>Список пользователей</h2>
    </div>

    <form class="needs-validation" novalidate="" method="POST" action="<?= App\Helpers\Url::makeUrl('user', 'send'); ?>">
        <div class="row">
            <div class="col-sm-8">
                <?php if (count($errors)) { ?>
                    <ul class="alert-danger">
                        <?php foreach ($errors as $error) { ?>
                            <li><?= $error; ?></li>
                        <?php } ?>
                    </ul>
                <?php } ?>
                <?php if (\App\Helpers\Session::has('success_message')) { ?>
                    <ul class="alert-success">
                        <li><?= \App\Helpers\Session::get('success_message', true); ?></li>
                    </ul>
                <?php } ?>
                <a href="<?= \App\Helpers\Url::makeUrl('user', 'create'); ?>" class="btn btn-primary">Создать</a>
                <?php if (count($users) > 0) { ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">ID</th>
                                <th scope="col">Имя</th>
                                <th scope="col">E-mail</th>
                                <th scope="col">Модерация</th>
                                <th scope="col">Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user) { ?>
                                <tr>
                                    <th>
                                        <input type="hidden" name="users[<?= $user['id'] ?>]" value="0">
                                        <input type="checkbox" name="users[<?= $user['id'] ?>]" value="1">
                                    </th>
                                    <th><?= $user['id'] ?></th>
                                    <td><?= $user['name'] ?></td>
                                    <td><?= $user['email'] ?></td>
                                    <td><?= $user['moderation'] ? 'Прошел модерацию' : 'На модерации'; ?></td>
                                    <td>
                                        <a href="<?= \App\Helpers\Url::makeUrl('user', 'edit', ['id' => $user['id']]) ?>">Редактировать</a>
                                        <?php if ($user['role_alias'] !== "admin") { ?>
                                            <a href="<?= \App\Helpers\Url::makeUrl('user', 'remove', ['id' => $user['id']]) ?>">Удалить</a>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } ?>
            </div>
            <div class="col-sm-3 offset-sm-1 blog-sidebar">
                <div class="sidebar-module">
                    <h4>Напишите пользователям</h4>
                    <div class="mb-3">
                        <label for="subject">Тема</label>
                        <input type="text" class="form-control" name="subject" id="subject" placeholder="" value="<?php echo isset($inputs['subject']) ? $inputs['subject'] : "" ?>" required="true">
                    </div>
                    <hr class="mb-4">
                    <div class="form-group">
                        <label for="message">Сообщение</label>
                        <textarea class="form-control" name="message" rows="9" id="message"></textarea>
                    </div>
                    <hr class="mb-4">
                    <button class="btn btn-primary btn-lg btn-block" type="submit">Отправить</button>
                </div>
            </div>
        </div>
    </form>
    <?php $this->includeHeader('footer'); ?>
