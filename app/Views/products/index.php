<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products | AccountHub</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>
<?= view('partials/nav') ?>
<main class="container">
    <div class="page-heading">
        <div>
            <div class="eyebrow">Inventory</div>
            <h2>Products</h2>
            <p>Manage your catalog, pricing, images, and available stock.</p>
        </div>
        <div class="page-actions">
            <a class="button" href="<?= site_url('products/create') ?>">Add product</a>
        </div>
    </div>

    <?php foreach (['success', 'error'] as $type): ?>
        <?php if ($message = session()->getFlashdata($type)): ?>
            <div class="alert <?= $type === 'success' ? 'success' : '' ?>" role="status"><?= esc($message) ?></div>
        <?php endif; ?>
    <?php endforeach; ?>

    <div class="table-tools">
        <input class="search-input" type="search" placeholder="Search products" aria-label="Search products" data-table-filter="products-table">
    </div>
    <div class="table-wrap">
        <table id="products-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>In stock</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr data-filter-row>
                        <td>
                            <?php if (!empty($product['image'])): ?>
                                <img class="product-thumb" src="<?= base_url('uploads/products/' . esc($product['image'])) ?>" alt="<?= esc($product['name']) ?>">
                            <?php else: ?>
                                <span class="product-thumb" aria-label="No image"></span>
                            <?php endif; ?>
                        </td>
                        <td><strong><?= esc($product['name']) ?></strong></td>
                        <td>₱<?= number_format((float) $product['price'], 2) ?></td>
                        <td><span class="badge <?= (int) $product['stock_quantity'] < 5 ? 'low' : '' ?>"><?= (int) $product['stock_quantity'] ?></span></td>
                        <td>
                            <div class="table-actions">
                                <a class="button secondary small" href="<?= site_url('products/edit/' . $product['id']) ?>">Edit</a>
                                <form action="<?= site_url('products/delete/' . $product['id']) ?>" method="post" data-confirm="Delete this product? Products with sales history cannot be deleted.">
                                    <?= csrf_field() ?>
                                    <button class="button danger small" type="submit">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (!$products): ?>
                    <tr><td class="empty-state" colspan="5">No products yet. Add your first product to start building inventory.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>
</body>
</html>