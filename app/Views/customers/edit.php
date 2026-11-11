<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer | AccountHub</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>
<?= view('partials/nav') ?>

<main class="container">
    <div class="page-heading">
        <div>
            <div class="eyebrow">Customers · Edit record</div>
            <h2>Edit Customer</h2>
            <p>Update contact details or replace the customer image.</p>
        </div>

        <div class="page-actions">
            <a class="button secondary" href="<?= base_url('customers') ?>">Back to customers</a>
            <a class="button ghost" href="<?= base_url('users') ?>">User accounts</a>
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

    <form class="form-card" action="<?= site_url('/customers/update/'.$customers['id']) ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <p class="form-intro">Name and email are required. Leave the image field empty to keep the current image.</p>

        <div class="form-grid">
            <div class="form-field full">
                <label for="full_name">Full Name</label>
                <input
                    id="full_name"
                    type="text"
                    name="full_name"
                    value="<?= esc(old('full_name', $customers['full_name'])) ?>"
                    placeholder="e.g. Pedro Santos"
                    required
                >
            </div>

            <div class="form-field">
                <label for="email">Email Address</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="<?= esc(old('email', $customers['email'])) ?>"
                    placeholder="e.g. pedro@example.com"
                    required
                >
                <span class="form-hint">Enter a valid email address.</span>
            </div>

            <div class="form-field">
                <label for="phone">Phone Number</label>
                <input
                    id="phone"
                    type="text"
                    name="phone"
                    value="<?= esc(old('phone', $customers['phone'])) ?>"
                    placeholder="e.g. 09123456789"
                >
                <span class="form-hint">Optional customer contact number.</span>
            </div>
            <div class="form-field">
                <?php if (!empty($customers['avatar'])): ?>
                    <img class="image-preview" id="customer-avatar-preview" src="<?= base_url('uploads/customers/' . esc($customers['avatar'])) ?>" alt="Current customer image">
                <?php else: ?>
                    <img class="image-preview" id="customer-avatar-preview" alt="Image preview" hidden>
                <?php endif; ?>
                <label for="avatar">Change Avatar</label>
                <input
                    id="avatar"
                    type="file"
                    name="avatar"
                    accept=".jpg,.jpeg,.png,.webp"
                    data-image-input="customer-avatar-preview"
                >
                <span class="form-hint">Upload a profile picture (max 2MB).</span>
            </div>
        </div>

        <div class="form-actions">
            <button class="button" type="submit">Update customer</button>
            <a class="button secondary" href="<?= base_url('customers') ?>">Cancel</a>
        </div>
    </form>
</main>

</body>
</html>
