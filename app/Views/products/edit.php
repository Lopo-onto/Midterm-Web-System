<!DOCTYPE html>
<html lang="en">
<head>
       <meta charset="UTF-8">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <title>Edit product | AccountHub</title>
       <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>
<?= view('partials/nav') ?>
<main class="container">
       <div class="page-heading">
              <div><div class="eyebrow">Inventory · Edit</div><h2>Edit product</h2><p>Update product details, pricing, or stock.</p></div>
              <a class="button secondary" href="<?= site_url('products') ?>">Back to products</a>
       </div>
       <?php if ($errors = session()->getFlashdata('errors')): ?>
              <div class="alert" role="alert"><ul><?php foreach ($errors as $error): ?><li><?= esc($error) ?></li><?php endforeach; ?></ul></div>
       <?php endif; ?>
       <form class="form-card" action="<?= site_url('products/update/' . $product['id']) ?>" method="post" enctype="multipart/form-data">
              <?= csrf_field() ?>
              <div class="form-grid">
                     <div class="form-field full">
                            <label for="name">Product name</label>
                            <input id="name" type="text" name="name" value="<?= esc(old('name', $product['name'])) ?>" maxlength="150" required>
                     </div>
                     <div class="form-field">
                            <label for="price">Price</label>
                            <input id="price" type="number" name="price" min="0" step="0.01" value="<?= esc(old('price', $product['price'])) ?>" required>
                     </div>
                     <div class="form-field">
                            <label for="stock_quantity">Stock</label>
                            <input id="stock_quantity" type="number" name="stock_quantity" min="0" step="1" value="<?= esc(old('stock_quantity', $product['stock_quantity'])) ?>" required>
                     </div>
                     <div class="form-field full">
                            <label for="image">Product image</label>
                            <?php if (!empty($product['image'])): ?>
                                   <img class="image-preview" id="product-image-preview" src="<?= base_url('uploads/products/' . esc($product['image'])) ?>" alt="Current product image">
                            <?php else: ?>
                                   <img class="image-preview" id="product-image-preview" alt="Image preview" hidden>
                            <?php endif; ?>
                              <input id="image" type="file" name="image" accept=".jpg,.jpeg,.png,.webp" data-image-input="product-image-preview">
                              <span class="form-hint">Leave empty to keep the current image. JPG, PNG, or WebP, up to 2 MB.</span>
                     </div>
              </div>
              <div class="form-actions">
                     <button class="button" type="submit">Save changes</button>
                     <a class="button ghost" href="<?= site_url('products') ?>">Cancel</a>
              </div>
       </form>
</main>
</body>
</html>