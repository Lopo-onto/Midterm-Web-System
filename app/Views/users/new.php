<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New User | AccountHub</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>
<?= view('partials/nav') ?>

<main class="container">
    <div class="page-heading">
        <div>
            <div class="eyebrow">Users · New record</div>
            <h2>Add staff member</h2>
            <p>Create a staff sign-in and profile.</p>
        </div>

        <div class="page-actions">
            <a class="button secondary" href="<?= base_url('users') ?>">Back to users</a>
            <a class="button ghost" href="<?= base_url('customers') ?>">Customer accounts</a>
        </div>
    </div>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert" role="alert">
            <strong>Please check the form.</strong>
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form class="form-card" action="<?= base_url('users/create') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <p class="form-intro">A password of at least 8 characters is required. The password is stored as a secure hash.</p>

        <div class="form-grid">
            <div class="form-field">
                <label for="username">Username</label>
                <input
                    id="username"
                    type="text"
                    name="username"
                    value="<?= esc(old('username')) ?>"
                    placeholder="e.g. psantos"
                    required
                >
                <span class="form-hint">Use a username that identifies this account clearly.</span>
            </div>

            <div class="form-field">
                <label for="full_name">Full Name</label>
                <input
                    id="full_name"
                    type="text"
                    name="full_name"
                    value="<?= esc(old('full_name')) ?>"
                    placeholder="e.g. Pedro Santos"
                    required
                >
                <span class="form-hint">Enter the user's complete display name.</span>
            </div>

            <div class="form-field">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" autocomplete="new-password" minlength="8" required>
                <span class="form-hint">Use at least 8 characters.</span>
            </div>

            <div class="form-field">
                    <label for="avatar">Profile image</label>
                    <img class="image-preview" id="staff-avatar-preview" alt="Image preview" hidden>
                    <input
                        id="avatar"
                        type="file"
                        name="avatar"
                        accept=".jpg,.jpeg,.png,.webp"
                        data-image-input="staff-avatar-preview"
                    >
                    <span class="form-hint">Upload a profile picture (max 2MB).</span>
            </div>
        </div>

        <div class="form-actions">
            <button class="button" type="submit">Save user</button>
            <a class="button secondary" href="<?= base_url('users') ?>">Cancel</a>
        </div>
    </form>
</main>

<footer>User Accounts · AccountHub</footer>
</body>
</html>
