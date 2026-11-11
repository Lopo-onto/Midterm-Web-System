<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales history | AccountHub</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>
<?= view('partials/nav') ?>
<main class="container">
    <div class="page-heading">
        <div><div class="eyebrow">Transactions</div><h2>Sales history</h2><p>Completed sales recorded by your staff.</p></div>
        <a class="button" href="<?= site_url('sales/create') ?>">Record sale</a>
    </div>
    <?php foreach (['success', 'error'] as $type): ?>
        <?php if ($message = session()->getFlashdata($type)): ?>
            <div class="alert <?= $type === 'success' ? 'success' : '' ?>" role="status"><?= esc($message) ?></div>
        <?php endif; ?>
    <?php endforeach; ?>
    <div class="table-tools">
        <input class="search-input" type="search" placeholder="Search sales" aria-label="Search sales" data-table-filter="sales-table">
    </div>
    <div class="table-wrap">
        <table id="sales-table">
            <thead><tr><th>Sale</th><th>Product</th><th>Customer</th><th>Staff member</th><th>Quantity</th><th>Total</th><th>Date</th></tr></thead>
            <tbody>
                <?php foreach ($sales as $sale): ?>
                    <tr data-filter-row>
                        <td>#<?= (int) $sale['id'] ?></td>
                        <td><strong><?= esc($sale['product_name'] ?? 'Deleted product') ?></strong></td>
                        <td><?= esc($sale['customer_name'] ?? 'Walk-in') ?></td>
                        <td><?= esc($sale['seller_name'] ?? 'Former staff') ?></td>
                        <td><?= (int) $sale['quantity'] ?></td>
                        <td>₱<?= number_format((float) $sale['total_price'], 2) ?></td>
                        <td><?= esc($sale['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php if (!$sales): ?>
                    <tr><td class="empty-state" colspan="7">No sales have been recorded yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>
</body>
</html>