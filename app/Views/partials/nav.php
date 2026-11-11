<nav class="nav">
    <div class="nav-inner">
        <a class="brand" href="<?= base_url('/') ?>">Account<span>Hub</span></a>
        <div class="links">
            <a class="<?= uri_string() === '' ? 'is-active' : '' ?>" href="<?= base_url('/') ?>">Home</a>
            <a class="<?= strpos(uri_string(), 'customers') === 0 ? 'is-active' : '' ?>" href="<?= base_url('/customers') ?>">Customers</a>
            <a class="<?= strpos(uri_string(), 'users') === 0 ? 'is-active' : '' ?>" href="<?= base_url('/users') ?>">Staff</a>
            <a class="<?= strpos(uri_string(), 'products') === 0 ? 'is-active' : '' ?>" href="<?= base_url('/products') ?>">Products</a>
            <a class="<?= strpos(uri_string(), 'sales') === 0 ? 'is-active' : '' ?>" href="<?= base_url('/sales') ?>">Sales</a>
            <a href="<?= base_url('/about') ?>">About</a>
            <a href="<?= base_url('/logout') ?>">Log out</a>
        </div>
    </div>
</nav>
<script src="<?= base_url('js/app.js') ?>" defer></script>