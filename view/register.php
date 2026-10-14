<?php


$title = "Register";

ob_start();
?>

    <section class="authPage">
      <div class="authCard">
        <?php if (!empty($_SESSION['errors'])): ?>
          <div class="authAlert authAlert--error" role="alert" aria-live="assertive">
            <i class="ri-error-warning-line" aria-hidden="true"></i>
            <div>
              <p class="authAlert__title">Unable to create your account</p>
              <ul>
                <?php foreach ($_SESSION['errors'] as $error): ?>
                  <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
          <?php unset($_SESSION['errors']); ?>
        <?php endif; ?>

      <form class="authForm" action="index.php?action=register" method="post">
        <h1>Create your account</h1>
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
        <div class="inputBoxFlex">
            <div class="inputBox">
            <label for="name">Name *</label>
            <input id="name" type="text" name="name" autocomplete="name" maxlength="50"  required>
        </div>
         <div class="inputBox">
            <label for="name">Last Name *</label>
            <input id="name" type="text" name="lastName" autocomplete="lastname" maxlength="50" required>
        </div>
        </div>
         
        <div class="inputBox">
            <label for="email">Email *</label>
            <input id="email" type="email" name="email" autocomplete="email" maxlength="254" required>
        </div>
        <div class="inputBox">
            <label for="password">Password *</label>
            <input class="password" id="password" type="password" name="password" autocomplete="new-password" minlength="8" maxlength="72" required>
        </div>
          <div class="inputBox">
            <label for="password">Confirm Password *</label>
            <input class="password" id="password" type="password" name="confirmPassword" autocomplete="new-password" minlength="8" maxlength="72" required>
        </div>
      
        <input class="formBTN" type="submit" name="register" value="Register">
        <p class="formLink">Already have an account? <a href="index.php?action=showLogin">Log in</a></p>
    </form>
      </div>
    </section>

<?php $content = ob_get_clean() ?>
<?php require_once 'layout.php'; ?>
