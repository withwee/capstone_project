<?php if(Session::has('error')): ?>
<div class="alert alert-danger">
    <?php echo e(Session::get('error')); ?>

</div>
<?php endif; ?><?php /**PATH D:\laragon\www\pos-capstone\resources\views/layouts/partials/alert/error.blade.php ENDPATH**/ ?>