document.addEventListener('click', (event) => {
    const toggle = event.target.closest('[data-password-toggle]');
    if (toggle) {
        const field = document.getElementById(toggle.dataset.passwordToggle);
        if (field) {
            const visible = field.type === 'password';
            field.type = visible ? 'text' : 'password';
            toggle.textContent = visible ? 'Hide' : 'Show';
            toggle.setAttribute('aria-label', `${visible ? 'Hide' : 'Show'} password`);
        }
    }
});

document.querySelectorAll('[data-image-input]').forEach((input) => {
    input.addEventListener('change', async () => {
        const preview = document.getElementById(input.dataset.imageInput);
        const file = input.files && input.files[0];
        if (!preview || !file) return;

        const showPreview = (image) => {
            if (preview.dataset.objectUrl) URL.revokeObjectURL(preview.dataset.objectUrl);
            preview.dataset.objectUrl = URL.createObjectURL(image);
            preview.src = preview.dataset.objectUrl;
        };

        showPreview(file);
        preview.hidden = false;

        if (typeof createImageBitmap !== 'function' || typeof DataTransfer !== 'function') return;

        try {
            const bitmap = await createImageBitmap(file);
            const scale = Math.min(1, 1200 / Math.max(bitmap.width, bitmap.height));
            if (scale === 1) {
                bitmap.close();
                return;
            }

            const canvas = document.createElement('canvas');
            canvas.width = Math.round(bitmap.width * scale);
            canvas.height = Math.round(bitmap.height * scale);
            canvas.getContext('2d').drawImage(bitmap, 0, 0, canvas.width, canvas.height);
            bitmap.close();

            const resizedBlob = await new Promise((resolve) => canvas.toBlob(resolve, file.type, 0.86));
            if (!resizedBlob) return;

            const resizedFile = new File([resizedBlob], file.name, { type: file.type, lastModified: file.lastModified });
            const transfer = new DataTransfer();
            transfer.items.add(resizedFile);
            input.files = transfer.files;
            showPreview(resizedFile);
        } catch {
            // The server still validates and stores the original when browser resizing is unavailable.
        }
    });
});

document.querySelectorAll('[data-table-filter]').forEach((input) => {
    input.addEventListener('input', () => {
        const table = document.getElementById(input.dataset.tableFilter);
        if (!table) return;

        const query = input.value.trim().toLocaleLowerCase();
        table.querySelectorAll('[data-filter-row]').forEach((row) => {
            row.hidden = !row.textContent.toLocaleLowerCase().includes(query);
        });
    });
});

document.querySelectorAll('[data-sale-form]').forEach((form) => {
    const product = form.querySelector('[data-sale-product]');
    const quantity = form.querySelector('[data-sale-quantity]');
    const stockText = form.querySelector('[data-sale-stock]');
    const totalText = form.querySelector('[data-sale-total]');
    const summary = form.querySelector('[data-sale-summary]');
    const submit = form.querySelector('[type="submit"]');

    const updateSummary = () => {
        const option = product.options[product.selectedIndex];
        const stock = Number(option.dataset.stock || 0);
        const price = Number(option.dataset.price || 0);
        const count = Number(quantity.value || 0);
        const hasProduct = Boolean(product.value);
        const overStock = hasProduct && count > stock;
        const hasAvailableProducts = [...product.options].some((item) => item.value && Number(item.dataset.stock) > 0);

        stockText.textContent = hasProduct
            ? (overStock ? `Only ${stock} available` : `${stock} available`)
            : (hasAvailableProducts ? 'Choose a product to see stock' : 'No products are in stock');
        totalText.textContent = new Intl.NumberFormat(undefined, { style: 'currency', currency: 'PHP' }).format(price * count);
        summary.classList.toggle('is-error', overStock);
        quantity.max = hasProduct ? String(stock) : '';
        quantity.setCustomValidity(overStock ? `Only ${stock} unit(s) are in stock.` : '');
        submit.disabled = !hasProduct || overStock || !hasAvailableProducts;
    };

    product.addEventListener('change', updateSummary);
    quantity.addEventListener('input', updateSummary);
    updateSummary();
});

document.querySelectorAll('[data-confirm]').forEach((form) => {
    form.addEventListener('submit', (event) => {
        if (!window.confirm(form.dataset.confirm)) event.preventDefault();
    });
});
