<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record sale | AccountHub</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>
<?= view('partials/nav') ?>
<main class="container">
    <div class="page-heading">
        <div><div class="eyebrow">Transactions · New</div><h2>Record a sale</h2><p>Choose an item and quantity. Stock is checked again when you submit.</p></div>
        <a class="button secondary" href="<?= site_url('sales') ?>">Sales history</a>
    </div>
    <?php if ($message = session()->getFlashdata('error')): ?>
        <div class="alert" role="alert"><?= esc($message) ?></div>
    <?php endif; ?>
    <?php if ($errors = session()->getFlashdata('errors')): ?>
        <div class="alert" role="alert"><ul><?php foreach ($errors as $error): ?><li><?= esc($error) ?></li><?php endforeach; ?></ul></div>
    <?php endif; ?>
    <form class="form-card" method="post" action="<?= site_url('sales/store') ?>" data-sale-form>
        <?= csrf_field() ?>
        <div class="form-grid">
            <div class="form-field full">
                <label for="product_id">Product</label>
                <select id="product_id" name="product_id" data-sale-product required>
                    <option value="">Select a product</option>
                    <?php foreach ($products as $product): ?>
                        <option value="<?= $product['id'] ?>" data-price="<?= esc($product['price']) ?>" data-stock="<?= (int) $product['stock_quantity'] ?>" <?= (string) old('product_id') === (string) $product['id'] ? 'selected' : '' ?> <?= (int) $product['stock_quantity'] < 1 ? 'disabled' : '' ?>>
                            <?= esc($product['name']) ?> · ₱<?= number_format((float) $product['price'], 2) ?> · <?= (int) $product['stock_quantity'] ?> in stock
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-field">
                <label for="customer_id">Customer <span class="form-hint">Optional</span></label>
                <select id="customer_id" name="customer_id">
                    <option value="">Walk-in customer</option>
                    <?php foreach ($customers as $customer): ?>
                        <option value="<?= $customer['id'] ?>" <?= (string) old('customer_id') === (string) $customer['id'] ? 'selected' : '' ?>><?= esc($customer['full_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-field">
                <label for="quantity">Quantity</label>
                <input id="quantity" type="number" name="quantity" min="1" step="1" value="<?= esc(old('quantity', '1')) ?>" data-sale-quantity required>
            </div>
        </div>
        <div class="sale-summary" data-sale-summary>
            <span data-sale-stock>Choose a product to see stock</span>
            <span>Sale total <strong data-sale-total>₱0.00</strong></span>
        </div>
        <p class="form-hint">Recorded under <?= esc(session()->get('full_name') ?? session()->get('username')) ?>.</p>
        <div class="form-actions">
            <button class="button" type="submit" <?= !$products ? 'disabled' : '' ?>>Complete sale</button>
            <a class="button ghost" href="<?= site_url('sales') ?>">Cancel</a>
        </div>
    </form>
</main>
</body>
</html>