

<?php $__env->startSection('title', 'Keranjang Belanja'); ?>
<?php $__env->startSection('content-header', 'Keranjang Belanja'); ?>

<?php $__env->startSection('css'); ?>
<style>
    .cart-container {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(108, 46, 183, 0.1);
    }
    
    .cart-header {
        background: linear-gradient(135deg, #6c2eb7, #a084e8);
        color: #fff;
        padding: 1rem 1.5rem;
        border-radius: 15px 15px 0 0;
    }

    .cart-body {
        padding: 2rem;
    }

    .search-barcode {
        max-width: 400px;
    }

    .customer-input {
        max-width: 400px;
    }

    .cart-items {
        margin-top: 2rem;
    }

    .cart-total {
        font-size: 1.25rem;
        font-weight: bold;
        color: #6c2eb7;
    }

    .btn-checkout {
        background: linear-gradient(135deg, #6c2eb7, #a084e8);
        color: #fff;
        padding: 0.75rem 2rem;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-checkout:hover {
        background: linear-gradient(135deg, #5b22a1, #9270db);
        transform: translateY(-1px);
        color: #fff;
    }

    .table th {
        background-color: #f5f2fc;
        color: #4b0082;
        font-weight: 600;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<div class="cart-container">
    <div class="cart-header">
        <h4 class="mb-0">
            <i class="fas fa-shopping-cart mr-2"></i> Keranjang Belanja
        </h4>
    </div>

    <div class="cart-body">
        <!-- Input Nama Customer -->
        <div class="customer-input mb-4">
            <label for="customer_name" class="form-label">Nama Customer</label>
            <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Masukkan nama customer">
        </div>

        <!-- Search Barcode -->
        <div class="search-barcode mb-4">
            <label for="barcode" class="form-label">Scan Barcode</label>
            <div class="input-group">
                <input type="text" class="form-control" id="barcode" name="barcode" placeholder="Scan atau masukkan barcode" autofocus>
                <button class="btn btn-outline-secondary" type="button" id="searchBarcode">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>

        <!-- Cart Items Table -->
        <div class="cart-items">
            <table class="table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="cartItems">
                    <!-- Cart items will be dynamically added here -->
                </tbody>
            </table>
        </div>

        <!-- Cart Summary -->
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="cart-total">
                Total: <span id="cartTotal">Rp 0</span>
            </div>
            <button class="btn btn-checkout" id="checkoutButton">
                <i class="fas fa-check-circle mr-2"></i> Selesaikan Pesanan
            </button>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Focus on barcode input
    document.getElementById('barcode').focus();

    // Handle barcode input
    document.getElementById('barcode').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            searchProduct(this.value);
        }
    });

    // Handle search button click
    document.getElementById('searchBarcode').addEventListener('click', function() {
        const barcode = document.getElementById('barcode').value;
        searchProduct(barcode);
    });

    // Handle checkout button click
    document.getElementById('checkoutButton').addEventListener('click', function() {
        const customerName = document.getElementById('customer_name').value;
        if (!customerName) {
            alert('Mohon masukkan nama customer');
            document.getElementById('customer_name').focus();
            return;
        }
        checkout();
    });
});

function searchProduct(barcode) {
    if (!barcode) {
        alert('Mohon masukkan kode barcode');
        return;
    }

    // Show loading indicator
    const searchButton = document.getElementById('searchBarcode');
    const originalContent = searchButton.innerHTML;
    searchButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    searchButton.disabled = true;

    fetch(`/products/search?barcode=${barcode}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.product) {
                addToCart(data.product);
                document.getElementById('barcode').value = '';
            } else {
                alert(data.message || 'Produk tidak ditemukan');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mencari produk. Silakan coba lagi.');
        })
        .finally(() => {
            // Restore button state
            searchButton.innerHTML = originalContent;
            searchButton.disabled = false;
            document.getElementById('barcode').focus();
        });
}

function addToCart(product) {
    const cartItems = document.getElementById('cartItems');
    let existingRow = [...cartItems.children].find(row => 
        row.dataset.productId == product.id
    );

    if (existingRow) {
        const qtyInput = existingRow.querySelector('input[type="number"]');
        qtyInput.value = parseInt(qtyInput.value) + 1;
    } else {
        const row = document.createElement('tr');
        row.dataset.productId = product.id;
        row.innerHTML = `
            <td>${product.name}</td>
            <td>Rp ${product.price.toLocaleString()}</td>
            <td>
                <div class="input-group" style="width: 150px">
                    <button class="btn btn-outline-secondary" onclick="changeQty(this, -1)">-</button>
                    <input type="number" class="form-control text-center" value="${product.quantity}" min="1">
                    <button class="btn btn-outline-secondary" onclick="changeQty(this, 1)">+</button>
                </div>
            </td>
            <td class="item-total">Rp ${(product.price * product.quantity).toLocaleString()}</td>
            <td><button class="btn btn-danger btn-sm" onclick="removeRow(this)"><i class="fas fa-trash"></i></button></td>
        `;
        cartItems.appendChild(row);
    }
    updateCartTotal();
}

function changeQty(button, delta) {
    const input = button.parentElement.querySelector('input');
    let newVal = parseInt(input.value) + delta;
    if (newVal < 1) newVal = 1;
    input.value = newVal;

    const row = button.closest('tr');
    const priceText = row.cells[1].textContent.replace(/[^\d]/g, '');
    const price = parseFloat(priceText) || 0;
    row.querySelector('.item-total').textContent = `Rp ${(price * newVal).toLocaleString()}`;

    updateCartTotal();
}

function removeRow(button) {
    button.closest('tr').remove();
    updateCartTotal();
}


function updateCartItem(productId, quantity) {
    fetch(`/admin/cart/update`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ product_id: productId, quantity: quantity })
    })
    .then(response => response.json())
    .then(data => {
        updateCartDisplay(data.cart);
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengupdate keranjang');
    });
}

function updateCartTotal() {
    const rows = document.querySelectorAll('#cartItems tr');
    let total = 0;

    rows.forEach(row => {
        const priceText = row.cells[1].textContent.replace(/[^\d]/g, '');
        const qtyInput = row.querySelector('input[type="number"]');
        const price = parseFloat(priceText) || 0;
        const qty = parseInt(qtyInput.value) || 0;
        total += price * qty;
    });

    document.getElementById('cartTotal').textContent = `Rp ${total.toLocaleString()}`;
}

function removeCartItem(productId) {
    fetch(`/admin/cart/remove`, {
        method: 'POST', // pastikan route menerima POST
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ product_id: productId })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Response not OK: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        if (data.success && data.cart) {
            updateCartDisplay(data.cart);
            updateCartTotal(); // tambahkan agar total otomatis update
        } else {
            alert(data.message || 'Gagal menghapus produk dari keranjang');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat menghapus item. Coba lagi nanti.');
    });
}

function checkout() {
    const customerName = document.getElementById('customer_name').value;
    const cartItems = document.querySelectorAll('#cartItems tr');

    if (!customerName.trim()) {
        Swal.fire('Peringatan', 'Mohon isi nama customer', 'warning');
        return;
    }

    if (cartItems.length === 0) {
        Swal.fire('Peringatan', 'Keranjang masih kosong', 'warning');
        return;
    }

    // kirim data ke server (belum implementasi backend)
    Swal.fire('Sukses', 'Pesanan berhasil diselesaikan', 'success');
}

function updateCartDisplay(cart) {
    const cartItems = document.getElementById('cartItems');
    const cartTotal = document.getElementById('cartTotal');
    
    // Clear current items
    cartItems.innerHTML = '';
    
    // Add each item to the table
    cart.items.forEach(item => {
        cartItems.innerHTML += `
            <tr>
                <td>${item.name}</td>
                <td>Rp ${item.price.toLocaleString()}</td>
                <td>
                    <div class="input-group" style="width: 150px">
                        <button class="btn btn-outline-secondary" onclick="updateCartItem(${item.id}, ${item.quantity - 1})">-</button>
                        <input type="number" class="form-control text-center" value="${item.quantity}" 
                               onchange="updateCartItem(${item.id}, this.value)">
                        <button class="btn btn-outline-secondary" onclick="updateCartItem(${item.id}, ${item.quantity + 1})">+</button>
                    </div>
                </td>
                <td>Rp ${(item.price * item.quantity).toLocaleString()}</td>
                <td>
                    <button class="btn btn-danger btn-sm" onclick="removeCartItem(${item.id})">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
    });
    
    // Update total
    cartTotal.textContent = `Rp ${cart.total.toLocaleString()}`;

    function searchProduct(barcode) {
    if (!barcode.trim()) {
        Swal.fire('Peringatan', 'Mohon masukkan kode barcode', 'warning');
        return;
    }

    const searchButton = document.getElementById('searchBarcode');
    const originalContent = searchButton.innerHTML;
    searchButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    searchButton.disabled = true;

    fetch(`/products/search?barcode=${encodeURIComponent(barcode)}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => {
        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
        return response.json();
    })
    .then(data => {
        if (data.success && data.product) {
            addToCart(data.product);
            document.getElementById('barcode').value = '';
            updateCartTotal();
        } else {
            Swal.fire('Gagal', data.message || 'Produk tidak ditemukan', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error', 'Terjadi kesalahan saat mencari produk', 'error');
    })
    .finally(() => {
        searchButton.innerHTML = originalContent;
        searchButton.disabled = false;
        document.getElementById('barcode').focus();
    });
}

}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\pos-capstone\resources\views/cart/index.blade.php ENDPATH**/ ?>