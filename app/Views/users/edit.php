<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User | AccountHub</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>
<?= view('partials/nav') ?>

<main class="container">
    <div class="page-heading">
        <div>
            <div class="eyebrow">Users · Edit record</div>
            <h2>Edit staff member</h2>
            <p>Update profile details or set a new password.</p>
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

    <form class="form-card" action="<?= base_url('/users/update/'.$users['id']) ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <p class="form-intro">Leave the password empty to keep the current one.</p>

        <div class="form-grid">
            <div class="form-field">
                <label for="username">Username</label>
                <input
                    id="username"
                    type="text"
                    name="username"
                    value="<?= esc(old('username', $users['username'])) ?>"
                    placeholder="e.g. psantos"
                >
                <span class="form-hint">Use a username that identifies this account clearly.</span>
            </div>

            <div class="form-field">
                <label for="full_name">Full Name</label>
                <input
                    id="full_name"
                    type="text"
                    name="full_name"
                    value="<?= esc(old('full_name', $users['full_name'])) ?>"
                    placeholder="e.g. Pedro Santos"
                >
                <span class="form-hint">Enter the user's complete display name.</span>
            </div>

            <div class="form-field">
                <label for="password">New password</label>
                <input id="password" type="password" name="password" autocomplete="new-password" minlength="8">
                <span class="form-hint">Leave empty to keep the current password.</span>
            </div>

            <div class="form-field">
                <?php if (!empty($users['avatar'])): ?>
                    <img class="image-preview" id="staff-avatar-preview" src="<?= base_url('uploads/users/' . esc($users['avatar'])) ?>" alt="Current profile image">
                <?php else: ?>
                    <img class="image-preview" id="staff-avatar-preview" alt="Image preview" hidden>
                <?php endif; ?>
                <label for="avatar">Profile image</label>
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
            <button class="button" type="submit">Update user</button>
            <a class="button secondary" href="<?= base_url('users') ?>">Cancel</a>
        </div>
    </form>
</main>

<footer>User Accounts · AccountHub</footer>
</body>
</html>
