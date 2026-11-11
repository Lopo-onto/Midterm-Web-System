<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Login | AccountHub</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body class="login-page">
<main class="login-panel">
    <a class="login-brand" href="<?= base_url('/') ?>">Account<span>Hub</span></a>
    <div class="eyebrow">Staff access</div>
    <h1>Welcome back</h1>
    <p class="login-subtitle">Sign in to pick up right where you left off.</p>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert" role="alert"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert" role="alert">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form class="login-form" action="<?= base_url('/login') ?>" method="post">
        <?= csrf_field() ?>
        <div class="login-field">
            <label for="username">Username</label>
            <input id="username" type="text" name="username" value="<?= esc(old('username')) ?>" autocomplete="username" required autofocus>
        </div>
        <div class="login-field">
            <label for="password">Password</label>
            <div class="password-wrap">
                <input id="password" type="password" name="password" autocomplete="current-password" required>
                <button class="password-toggle" type="button" data-password-toggle="password" aria-label="Show password">Show</button>
            </div>
        </div>
        <button class="button full" type="submit">Sign in</button>
    </form>
</main>
<script src="<?= base_url('js/app.js') ?>" defer></script>
</body>
</html>
