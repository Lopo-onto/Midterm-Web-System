<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff | AccountHub</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>
<?= view('partials/nav') ?>

<main class="container">
    <div class="page-heading">
        <div>
            <div class="eyebrow">Directory</div>
            <h2>Staff</h2>
            <p>Manage staff access, profiles, and sign-in accounts.</p>
        </div>

        <div class="page-actions">
            <a class="button" href="<?= base_url('users/new') ?>">Add staff member</a>
        </div>
    </div>

    <?php foreach (['success', 'error'] as $type): ?>
        <?php if ($message = session()->getFlashdata($type)): ?>
            <div class="alert <?= $type === 'success' ? 'success' : '' ?>" role="status"><?= esc($message) ?></div>
        <?php endif; ?>
    <?php endforeach; ?>

    <div class="table-tools">
        <input class="search-input" type="search" placeholder="Search staff" aria-label="Search staff" data-table-filter="staff-table">
    </div>
    <div class="table-wrap">
        <table id="staff-table">
            <thead>
                <tr>
                    <th>Avatar</th>
                    <th>#</th>
                    <th>Username</th>
                    <th>Full name</th>
                    <th>Created at</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $index => $user): ?>
                    <tr data-filter-row>
                        <td>
                            <?php if (!empty($user['avatar'])): ?>
                                <img class="avatar-thumb" src="<?= base_url('uploads/users/' . esc($user['avatar'])) ?>" alt="">
                            <?php else: ?>
                                <span class="avatar-fallback" aria-hidden="true"><?= esc(strtoupper(substr($user['full_name'], 0, 1))) ?></span>
                            <?php endif; ?>
                        </td>
                        <td><?= $index + 1 ?></td>
                        <td><strong><?= esc($user['username']) ?></strong></td>
                        <td><?= esc($user['full_name']) ?></td>
                        <td><?= esc($user['created_at']) ?></td>
                        <td>
                            <div class="table-actions">
                                <a class="button secondary small" href="<?= base_url('users/edit/' . $user['id']) ?>">Edit</a>
                                <form action="<?= base_url('users/delete/' . $user['id']) ?>" method="post" data-confirm="Delete this staff account?">
                                    <?= csrf_field() ?>
                                    <button class="button danger small" type="submit">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<footer>Staff · AccountHub</footer>
</body>
</html>
