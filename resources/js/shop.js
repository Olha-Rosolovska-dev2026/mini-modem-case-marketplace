/*
 * Developer: Olha Rosolovska
 * Project: Mini Modem Case - CMS & Marketplace
 * File: Storefront interactions
 */

document.addEventListener('DOMContentLoaded', () => {
    // Quantity steppers on the product detail page.
    document.querySelectorAll('[data-quantity-input]').forEach((input) => {
        document.querySelectorAll(`[data-quantity-step="${input.dataset.quantityInput}"]`).forEach((button) => {
            button.addEventListener('click', () => {
                const step = Number(button.dataset.step || 1);
                const next = Math.max(1, Math.min(99, Number(input.value || 1) + step));
                input.value = next;
            });
        });
    });

    // Collapse mobile filter panel.
    const filterToggle = document.getElementById('filterToggle');
    const filterPanel = document.getElementById('filterPanel');
    if (filterToggle && filterPanel) {
        filterToggle.addEventListener('click', () => filterPanel.classList.toggle('hidden'));
    }
});
