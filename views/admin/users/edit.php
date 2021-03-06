<?php $this->includeHeader('admin'); ?>
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= \App\Helpers\Url::makeUrl(); ?>">Главная</a></li>
            <li class="breadcrumb-item"><a href="<?= \App\Helpers\Url::makeUrl('user', 'index'); ?>">Список пользователей</a></li>
            <li class="breadcrumb-item active" aria-current="page">Редактирование</li>
        </ol>
    </nav>
    <div class="py-5 text-center">
        <h2>Редактировать пользователя</h2>
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
            <form class="needs-validation" novalidate="" method="POST">
                <div class="mb-3">
                    <label for="name">Имя</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="" value="<?php echo $user['name']; ?>" required="true">
                </div>
                <div class="mb-3">
                    <label for="email">E-mail</label>
                    <input type="text" class="form-control" name="email" id="email" placeholder="" value="<?php echo $user['email']; ?>" required="true">
                </div>
                <hr class="mb-4">
                <div class="mb-3">
                    <label for="password">Пароль</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="" value="" required="true">
                </div>
                <hr class="mb-4">
                <div class="mb-3 form-check">
                    <input type="hidden" name="moderation" value="0">
                    <input type="checkbox" class="form-check-input" id="moderation" name="moderation" value="1" <?php if ($user['moderation']) { ?> checked="checked" <?php } ?>>
                    <label class="form-check-label" for="moderation">Модерация</label>
                </div>
                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Отправить</button>
            </form>
        </div>
    </div>
    <?php $this->includeHeader('footer'); ?>
