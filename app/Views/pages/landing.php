<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store operations | AccountHub</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>
<?= view('partials/nav') ?>

<main class="container">
    <section class="hero">
        <div class="eyebrow">Store management</div>
        <h1>Everything at the counter, in one place.</h1>
        <p>Manage your inventory, serve customers, and keep every transaction recorded.</p>
        <div class="actions">
            <a class="button" href="<?= base_url('sales/create') ?>">Record a sale</a>
            <a class="button secondary" href="<?= base_url('products') ?>">Manage products</a>
        </div>
    </section>

    <section class="grid" aria-label="Store management">
        <a class="card" href="<?= base_url('products') ?>"><h3>Products</h3><p>Catalog, prices, images, and stock levels.</p></a>
        <a class="card" href="<?= base_url('sales') ?>"><h3>Sales history</h3><p>Review completed transactions and totals.</p></a>
        <a class="card" href="<?= base_url('customers') ?>"><h3>Customers</h3><p>Maintain customer records and contact details.</p></a>
        <a class="card" href="<?= base_url('users') ?>"><h3>Staff</h3><p>Manage staff profiles and sign-in accounts.</p></a>
    </section>
</main>

</body>
</html>
