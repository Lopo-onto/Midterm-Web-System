<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>
<?= view('partials/nav') ?>

<main class="container">
    <section class="hero">
        <div class="eyebrow">About AccountHub</div>
        <h1>A practical workspace for everyday store operations.</h1>
        <p>AccountHub brings product inventory, customer and staff records, and transaction history into one secure workspace.</p>
    </section>

    <section class="grid">
        <div class="card"><h3>Inventory</h3><p>Product images, prices, and stock levels stay together in the catalog.</p></div>
        <div class="card"><h3>Transactions</h3><p>Sales are recorded with their staff member and totals, while stock is reduced safely.</p></div>
        <div class="card"><h3>Staff access</h3><p>Management pages are available only after staff sign-in.</p></div>
    </section>
</main>

<footer>AccountHub · Store management</footer>
</body>
</html>
