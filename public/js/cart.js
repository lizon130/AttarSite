// Global cart functions
window.cartFunctions = {
    // Get CSRF token from meta tag or hidden input
    getCsrfToken: function() {
        return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
               document.querySelector('input[name="_token"]')?.value || '';
    },

    // Add to cart function
    addToCart: function(productId, quantity = 1) {
        const csrfToken = this.getCsrfToken();
        
        $.ajax({
            url: '/cart/add',
            method: 'POST',
            data: {
                _token: csrfToken,
                product_id: productId,
                quantity: quantity
            },
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message || 'Product added to cart');
                    cartFunctions.updateCartCount();
                }
            },
            error: function(xhr) {
                if (xhr.status === 401) {
                    toastr.error('Please login to add to cart');
                } else {
                    toastr.error('Failed to add to cart');
                }
            }
        });
    },

    // Update cart count in badge
    updateCartCount: function() {
        $.ajax({
            url: '/cart/count',
            method: 'GET',
            success: function(response) {
                $('.badge-cart').text(response.count || 0);
            },
            error: function() {
                // Silently fail
            }
        });
    },

    // Redirect to cart
    goToCart: function() {
        window.location.href = '/cart';
    },

    // Initialize cart count on page load
    init: function() {
        this.updateCartCount();
    }
};

// Initialize on page load
$(document).ready(function() {
    cartFunctions.init();
});