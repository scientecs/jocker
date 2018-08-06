<footer class="my-5 pt-5 text-muted text-center text-small">
    <p class="mb-1">© 2017-2018 Consult Ltd.</p>
    <ul class="list-inline">
        <li class="list-inline-item"><a href="<?= App\Helpers\Url::makeUrl(); ?>">Главная</a></li>
        <?php if (!App\Helpers\User::isLogged()) { ?>
            <li class="list-inline-item"><a href="<?= App\Helpers\Url::makeUrl('auth', 'register'); ?>">Регистрация</a></li>
            <li class="list-inline-item"><a href="<?= App\Helpers\Url::makeUrl('auth', 'login'); ?>">Авторизация</a></li>
        <?php } else { ?>
            <a class="py-2 d-none d-md-inline-block" href="<?= App\Helpers\Url::makeUrl('auth', 'logout'); ?>">Выйти</a>
        <?php } ?>
    </ul>
</footer>
</div>
</body>
</html>