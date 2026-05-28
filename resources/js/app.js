//import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

function updateWishlistButton(button, added) {
    const svg = button.querySelector('svg');
    if (svg) {
        svg.setAttribute('fill', added ? 'currentColor' : 'none');
    }

    const label = button.querySelector('.wishlist-label');
    if (label) {
        label.textContent = added ? 'Đã thích' : 'Thêm vào yêu thích';
    }

    button.setAttribute('aria-pressed', added ? 'true' : 'false');
}

function updateWishlistCount(count) {
    const wishlistCount = document.getElementById('wishlist-count');
    if (wishlistCount) {
        wishlistCount.textContent = count;
    }
}

function removeProductCard(button) {
    const productCard = button.closest('.product-card');
    if (productCard) {
        productCard.remove();
    }
}

async function handleWishlistClick(event) {
    const button = event.target.closest('.wishlist-toggle');
    if (!button) {
        return;
    }

    event.preventDefault();

    const url = button.dataset.url;
    if (!url) {
        return;
    }

    if (!csrfToken) {
        console.error('CSRF token not found.');
        return;
    }

    button.disabled = true;

    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({}),
        });

        if (!response.ok) {
            throw new Error(`Wishlist toggle failed with status ${response.status}`);
        }

        const data = await response.json();

        if (data.success) {
            updateWishlistButton(button, data.added);
            updateWishlistCount(data.count);

            if (data.removed) {
                removeProductCard(button);
            }
        } else {
            throw new Error('Wishlist toggle response returned success=false');
        }
    } catch (error) {
        console.error(error);
    } finally {
        button.disabled = false;
    }
}

document.addEventListener('click', handleWishlistClick);

Alpine.start();
