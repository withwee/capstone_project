<!-- Main Sidebar Container -->
<aside class="main-sidebar" style="
    background: linear-gradient(180deg, #6c2eb7 0%, #7e3edb 100%);
    color: #fff;
    min-height: 100vh;
    width: 220px;
    display: flex;
    flex-direction: column;
    align-items: stretch;
    box-shadow: 2px 0 10px rgba(108,46,183,0.2);
    overflow-y: auto;
    transition: all 0.3s ease-in-out;
">
    <!-- Brand Logo -->
    <div style="padding: 1rem 1.5rem; text-align: left; border-bottom: 1px solid rgba(255,255,255,0.1);">
        <a href="<?php echo e(route('home')); ?>" style="text-decoration:none; color:#fff;">
            <div style="font-size:1.2rem; font-weight:700; letter-spacing:1px;"><?php echo e(config('app.name')); ?></div>
        </a>
    </div>

    <!-- Sidebar Menu -->
    <nav style="flex:1; padding:1rem 0;">
        <ul class="nav flex-column" style="list-style:none; padding:0 1rem; margin:0;">
            <?php
                $menu = [
                    ['route' => 'home', 'icon' => 'fas fa-tachometer-alt', 'label' => __('dashboard.title')],
                    ['route' => 'products.index', 'icon' => 'fas fa-box-open', 'label' => __('product.title')],
                    ['route' => 'cart.index', 'icon' => 'fas fa-cart-plus', 'label' => __('cart.title')],
                    ['route' => 'orders.index', 'icon' => 'fas fa-receipt', 'label' => __('order.title')],
                    ['route' => 'customers.index', 'icon' => 'fas fa-users', 'label' => __('customer.title')],
                    ['route' => 'suppliers.index', 'icon' => 'fas fa-truck', 'label' => 'Suppliers'],
                    ['route' => 'settings.index', 'icon' => 'fas fa-cogs', 'label' => __('settings.title')],
                    ['route' => 'logout', 'icon' => 'fas fa-sign-out-alt', 'label' => __('common.Logout')],
                ];
            ?>

            <?php $__currentLoopData = $menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="nav-item" style="margin-bottom:8px;">
                <a href="<?php echo e(route($item['route'])); ?>" class="nav-link" style="
                    display:flex; align-items:center; gap:10px;
                    color:#f5f5f5; padding:0.7rem 0.9rem;
                    border-radius:10px; transition: all 0.2s ease;
                    text-decoration:none;
                "
                onmouseover="this.style.backgroundColor='rgba(255,255,255,0.1)';"
                onmouseout="this.style.backgroundColor='transparent';">
                    <i class="<?php echo e($item['icon']); ?>" style="font-size:1.2rem;"></i>
                    <span style="font-size:1rem; font-weight:500;"><?php echo e($item['label']); ?></span>
                </a>
            </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </nav>
</aside>
<?php /**PATH D:\laragon\www\pos-capstone\resources\views/layouts/partials/sidebar.blade.php ENDPATH**/ ?>