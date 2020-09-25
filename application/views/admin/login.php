<div class="login-page-wrapper">
    
    <div class="login-form-wrapper">
        <?php if ($errorMsg!='') : ?>
            <div class="error-msg"><?=$errorMsg ?></div>
        <?php endif; ?>
        <div class="login-form-header-wrapper">
            <h3 class="login-form-header"><?=$title ?></h3>
        </div>
        <form class="login-form" method="POST" action="login">
            <label for="login">Логин:</label>
            <input type="text" class="login-input" name="login" id="login">
            <label for="password">Пароль:</label>
            <input type="password" class="password-input" name="password" id="password">
            <button class="submit-button" name="login-submit" type="submit">Войти</button>
        </form>
    </div>
</div>