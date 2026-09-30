<?php

$title = "Log In";

ob_start();
?>
    <section class="authPage">
        <div class="authCard">
            <?php if (!empty($_SESSION['errors'])): ?>
                <div class="authAlert authAlert--error" role="alert" aria-live="assertive">
                    <i class="ri-error-warning-line" aria-hidden="true"></i>
                    <div>
                        <p class="authAlert__title">Unable to sign in</p>
                        <ul>
                            <?php foreach ($_SESSION['errors'] as $error): ?>
                                <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <?php unset($_SESSION['errors']); ?>
            <?php endif; ?>

        <form class="authForm" action="index.php?action=login" method="post">
        <h1>Welcome back</h1>
        <div class="inputBox">
            <label for="email">Email *</label>
            <input id="email" type="email" name="email" autocomplete="email" required>
        </div>
        <div class="inputBox">
            <label for="password">Password *</label>
            <input id="password" type="password" name="password" autocomplete="current-password" required>
        </div>
        <a href="">forgot password ?</a>
        <input class="formBTN" type="submit" name="login" value="Log In">
        <p class="formLink">Don't have an account? <a href="index.php?action=showRegister">Create an account</a></p>
    </form>
        </div>
    </section>

<?php $content = ob_get_clean() ?>
<?php require_once 'layout.php'; ?>
