<?php $this->includeHeader(); ?>
<div class="container">
    <div class="py-5 text-center">
        <h2>Регистрация</h2>
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
                    <input type="text" class="form-control" name="name" id="name" placeholder="" value="<?php echo isset($inputs['name']) ? $inputs['name'] : "" ?>" required="true">
                    <div class="invalid-feedback">
                        Имя обязательно для заполнения.
                    </div>
                </div>
                <hr class="mb-4">
                <div class="mb-3">
                    <label for="email">E-mail</label>
                    <input type="text" class="form-control" name="email" id="email" placeholder="" value="<?php echo isset($inputs['email']) ? $inputs['email'] : "" ?>" required="true">
                    <div class="invalid-feedback">
                        E-mail обязательно для заполнения.
                    </div>
                </div>
                <hr class="mb-4">
                <div class="mb-3">
                    <label for="password">Пароль</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="" value="" required="true">
                    <div class="invalid-feedback">
                        Пароль обязателен для заполнения.
                    </div>
                </div>
                <hr class="mb-4">
                <div class="mb-3">
                    <label for="repassword">Повторите пароль</label>
                    <input type="password" class="form-control" name="repassword" id="repassword" placeholder="" value="" required="true">
                    <div class="invalid-feedback">
                        Введите пароль еще раз.
                    </div>
                </div>
                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Отправить</button>
            </form>
        </div>
    </div>
<?php $this->includeFooter(); ?>
