<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers | AccountHub</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>
<?= view('partials/nav') ?>

<main class="container">
    <div class="page-heading">
        <div>
            <div class="eyebrow">Directory</div>
            <h2>Customers</h2>
            <p>Maintain customer contact details and purchase history.</p>
        </div>

        <div class="page-actions">
            <a class="button" href="<?= base_url('customers/new') ?>">Add customer</a>
        </div>
    </div>

    <?php foreach (['success', 'error'] as $type): ?>
        <?php if ($message = session()->getFlashdata($type)): ?>
            <div class="alert <?= $type === 'success' ? 'success' : '' ?>" role="status"><?= esc($message) ?></div>
        <?php endif; ?>
    <?php endforeach; ?>

    <div class="table-tools">
        <input class="search-input" type="search" placeholder="Search customers" aria-label="Search customers" data-table-filter="customers-table">
    </div>
    <div class="table-wrap">
        <table id="customers-table">
            <thead>
                <tr>
                    <th>Avatar</th>
                    <th>#</th>
                    <th>Full name</th>
                    <th>Email</th>
                    <th>Phone number</th>
                    <th>Created at</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                    <?php foreach ($customers as $index => $customer): ?>
                    <tr data-filter-row>
                        <td>
                            <?php if (!empty($customer['avatar'])): ?>
                                <img class="avatar-thumb" src="<?= base_url('uploads/customers/' . esc($customer['avatar'])) ?>" alt="">
                            <?php else: ?>
                                <span class="avatar-fallback" aria-hidden="true"><?= esc(strtoupper(substr($customer['full_name'], 0, 1))) ?></span>
                            <?php endif; ?>
                        </td>
                        <td><?= $index + 1 ?></td>
                        <td><strong><?= esc($customer['full_name']) ?></strong></td>
                        <td><?= esc($customer['email']) ?></td>
                        <td><?= esc($customer['phone'] ?? '') ?></td>
                        <td><?= esc($customer['created_at']) ?></td>
                        <td>
                            <div class="table-actions">
                                <a class="button secondary small" href="<?= base_url('customers/edit/' . $customer['id']) ?>">Edit</a>
                                <form action="<?= base_url('customers/delete/' . $customer['id']) ?>" method="post" data-confirm="Delete this customer? Past sales will remain in history.">
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

</body>
</html>
