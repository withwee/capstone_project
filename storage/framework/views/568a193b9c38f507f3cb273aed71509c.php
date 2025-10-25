

<?php $__env->startSection('title', __('product.Product_List')); ?>
<?php $__env->startSection('content-header', __('product.Product_List')); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('plugins/sweetalert2/sweetalert2.min.css')); ?>">
<style>
    .card.product-list {
        border-radius: 16px;
        box-shadow: 0 2px 10px rgba(108, 46, 183, 0.1);
    }

    .card-header {
        background: linear-gradient(135deg, #6c2eb7, #a084e8);
        color: #fff;
        border-radius: 16px 16px 0 0;
        padding: 1rem 1.5rem;
    }

    .btn-gradient {
        background: linear-gradient(135deg, #6c2eb7, #a084e8);
        color: #fff;
        font-weight: 600;
        border: none;
        border-radius: 10px;
        padding: 0.6rem 1rem;
        transition: all 0.3s ease;
    }

    .btn-gradient:hover {
        background: linear-gradient(135deg, #5b22a1, #9270db);
        transform: translateY(-1px);
        color: #fff;
    }

    .table th {
        background-color: #f5f2fc;
        color: #4b0082;
        font-weight: 600;
    }

    .table td {
        vertical-align: middle;
    }

    .product-img {
        width: 45px;
        height: 45px;
        object-fit: cover;
        border-radius: 6px;
    }

    .badge-success {
        background-color: #6c2eb7 !important;
    }

    .pagination {
        justify-content: center;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="card product-list shadow-sm">
    <div class="card-header d-flex align-items-center justify-content-between" style="background: linear-gradient(135deg, #6c2eb7, #a084e8); border-radius: 12px 12px 0 0; padding: 1rem 1.5rem;">
        <h4 class="mb-0 text-white d-flex align-items-center">
            <i class="fas fa-box-open me-2"></i> Daftar Produk
        </h4>
        <a href="<?php echo e(route('products.create')); ?>" class="btn" 
           style="background-color: #fff; color: #6c2eb7; font-weight: 600; border-radius: 8px; padding: 0.5rem 1rem; display: flex; align-items: center; gap: 6px;">
            <i class="fas fa-plus"></i> Tambah Produk
        </a>
    </div>

    <div class="card-body" style="background-color: #fff; border-radius: 0 0 12px 12px;">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="align-middle text-center" style="background-color: #f5f2fc; color: #4b0082;">
                    <tr>
                        <th>ID</th>
                        <th>Nama Produk</th>
                        <th>Gambar</th>
                        <th>Barcode</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Dibuat</th>
                        <th>Diubah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($product->id); ?></td>
                        <td><?php echo e($product->name); ?></td>
                        <td><img class="product-img" src="<?php echo e(Storage::url($product->image)); ?>" alt=""></td>
                        <td><?php echo e($product->barcode); ?></td>
                        <td><?php echo e(config('settings.currency_symbol')); ?> <?php echo e(number_format($product->price, 0)); ?></td>
                        <td><?php echo e($product->quantity); ?></td>
                        <td>
                            <span class="badge badge-<?php echo e($product->status ? 'success' : 'danger'); ?>">
                                <?php echo e($product->status ? __('common.Active') : __('common.Inactive')); ?>

                            </span>
                        </td>
                        <td><?php echo e($product->created_at); ?></td>
                        <td><?php echo e($product->updated_at); ?></td>
                        <td>
                            <a href="<?php echo e(route('products.edit', $product)); ?>" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-sm btn-danger btn-delete" data-url="<?php echo e(route('products.destroy', $product)); ?>">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="10" class="text-muted py-4">Belum ada data produk</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            <?php echo e($products->links()); ?>

        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script src="{{ asset('plugins/sweetalert2/sweetalert2

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\pos-capstone\resources\views/products/index.blade.php ENDPATH**/ ?>