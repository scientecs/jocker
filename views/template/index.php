<?php $this->includeHeader(); ?>
<div class="container">
    <div class="py-5 text-center">
        <h2>Напишите администратору</h2>
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
                <ul class="alert-success">
                    <li><?= \App\Helpers\Session::get('success_message', true); ?></li>
                </ul>
            <?php } ?>
            <form class="needs-validation" novalidate="" method="POST" action="<?= App\Helpers\Url::makeUrl('index', 'send'); ?>">
                <div class="mb-3">
                    <label for="firstName">Тема</label>
                    <input type="subject" name="subject" class="form-control" id="subject" placeholder="" value="" required="true">
                </div>
                <hr class="mb-4">
                <div class="form-group">
                    <label for="message">Сообщение</label>
                    <textarea class="form-control" name="message" rows="9" id="message"></textarea>
                </div>
                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Отправить</button>
            </form>
        </div>
    </div>
    <?php $this->includeFooter(); ?>
