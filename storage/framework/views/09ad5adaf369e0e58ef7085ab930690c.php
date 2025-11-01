

<?php $__env->startSection('title', __('order.Orders_List')); ?>
<?php $__env->startSection('content-header', __('order.Orders_List')); ?>
<?php $__env->startSection('content-actions'); ?>
<a href="<?php echo e(route('cart.index')); ?>" class="btn btn-primary"><?php echo e(__('cart.title')); ?></a>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-7"></div>
            <div class="col-md-5">
                <form action="<?php echo e(route('orders.index')); ?>">
                    <div class="row">
                        <div class="col-md-5">
                            <input type="date" name="start_date" class="form-control" value="<?php echo e(request('start_date')); ?>" />
                        </div>
                        <div class="col-md-5">
                            <input type="date" name="end_date" class="form-control" value="<?php echo e(request('end_date')); ?>" />
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-outline-primary" type="submit"><?php echo e(__('order.submit')); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th><?php echo e(__('order.ID')); ?></th>
                    <th><?php echo e(__('order.Customer_Name')); ?></th>
                    <th><?php echo e(__('order.Total')); ?></th>
                    <th><?php echo e(__('order.Received_Amount')); ?></th>
                    <th><?php echo e(__('order.Status')); ?></th>
                    <th><?php echo e(__('order.To_Pay')); ?></th>
                    <th><?php echo e(__('order.Created_At')); ?></th>
                    <th><?php echo e(__('order.Actions')); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($order->id); ?></td>
                    <td><?php echo e($order->getCustomerName()); ?></td>
                    <td><?php echo e(config('settings.currency_symbol')); ?> <?php echo e($order->formattedTotal()); ?></td>
                    <td><?php echo e(config('settings.currency_symbol')); ?> <?php echo e($order->formattedReceivedAmount()); ?></td>
                    <td>
                        <?php if($order->receivedAmount() == 0): ?>
                            <span class="badge badge-danger"><?php echo e(__('order.Not_Paid')); ?></span>
                        <?php elseif($order->receivedAmount() < $order->total()): ?>
                            <span class="badge badge-warning"><?php echo e(__('order.Partial')); ?></span>
                        <?php elseif($order->receivedAmount() == $order->total()): ?>
                            <span class="badge badge-success"><?php echo e(__('order.Paid')); ?></span>
                        <?php elseif($order->receivedAmount() > $order->total()): ?>
                            <span class="badge badge-info"><?php echo e(__('order.Change')); ?></span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo e(config('settings.currency_symbol')); ?> <?php echo e(number_format($order->total() - $order->receivedAmount(), 2)); ?></td>
                    <td><?php echo e($order->created_at); ?></td>
                    <td>
                        <button
                            class="btn btn-sm btn-secondary btnShowInvoice"
                            data-toggle="modal"
                            data-target="#modalInvoice"
                            data-order-id="<?php echo e($order->id); ?>"
                            data-customer-name="<?php echo e($order->getCustomerName()); ?>"
                            data-total="<?php echo e($order->total()); ?>"
                            data-received="<?php echo e($order->receivedAmount()); ?>"
                            data-items="<?php echo e(json_encode($order->items)); ?>"
                            data-created-at="<?php echo e($order->created_at); ?>"
                            data-payment="<?php echo e(isset($order->payments) && count($order->payments) > 0 ? $order->payments[0]->amount : 0); ?>">
                            <ion-icon size="samll" name="eye"></ion-icon>
                        </button>

                        <?php if($order->total() > $order->receivedAmount()): ?>
                            <!-- Button for Partial Payment -->
                            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#partialPaymentModal" data-orders-id="<?php echo e($order->id); ?>" data-remaining-amount="<?php echo e($order->total() - $order->receivedAmount()); ?>">
                                Pay Partial Amount
                            </button>
                            <!-- Partial Payment Modal -->
                            <div class="modal fade" id="partialPaymentModal" tabindex="-1" role="dialog" aria-labelledby="partialPaymentModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="partialPaymentModalLabel">Pay Partial Amount</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="partialPaymentForm" method="POST" action="<?php echo e(route('orders.partial-payment')); ?>">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="order_id" id="modalOrderId" value="">
                                                <div class="form-group">
                                                    <label for="partialAmount">Enter Amount to Pay</label>
                                                    <input type="number" class="form-control" step="0.01" id="partialAmount" name="amount" value="<?php echo e($order->total() - $order->receivedAmount()); ?>">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Submit Payment</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th></th>
                    <th><?php echo e(config('settings.currency_symbol')); ?> <?php echo e(number_format($total, 2)); ?></th>
                    <th><?php echo e(config('settings.currency_symbol')); ?> <?php echo e(number_format($receivedAmount, 2)); ?></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
        <?php echo e($orders->render()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('model'); ?>
<!-- Modal -->
<div class="modal fade" id="modalInvoice" tabindex="-1" role="dialog" aria-labelledby="modalInvoiceLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalInvoiceLabel">Next Gen POS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Placeholder for dynamic content -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Use event delegation to bind to the document for dynamically generated elements
    $(document).on('click', '.btnShowInvoice', function(event) {
        console.log("Modal show event triggered!");

        // Fetch data from the clicked button
        var button = $(this); // Button that triggered the modal
        var orderId = button.data('order-id');
        var customerName = button.data('customer-name');
        var totalAmount = button.data('total');
        var receivedAmount = button.data('received');
        var payment = button.data('payment');
        var createdAt = button.data('created-at');
        var items = button.data('items'); // Ensure this is correctly passed as a JSON

        // Log the data to ensure it's being captured correctly
        console.log({
            orderId,
            customerName,
            totalAmount,
            receivedAmount,
            createdAt,
            items
        });

        // Open the modal
        $('#modalInvoice').modal('show');

        // Populate the modal body with dynamic data (you can extend this part)
        var modalBody = $('#modalInvoice').find('.modal-body');

        // Construct items HTML if items exist
        var itemsHTML = '';
        if (items) {
            items.forEach(function(item, index) {
                itemsHTML += `
            <tr>
                <td>${index + 1}</td>
                <td>${item.product.name}</td>
                <td>${item.description || 'N/A'}</td>
                <td>${parseFloat(item.product.price).toFixed(2)}</td>
                <td>${item.quantity}</td>
                <td>${(parseFloat(item.product.price) * item.quantity).toFixed(2)}</td>
            </tr>
        `;
            });
        }

        // Update the modal body content
        modalBody.html(`
    <div class="card">
        <div class="card-header">
            Invoice <strong>${createdAt.split('T')[0]}</strong>
            <span class="float-right"> <strong>Status:</strong> ${

                        receivedAmount == 0?
                            '<span class="badge badge-danger"><?php echo e(__('order.Not_Paid')); ?></span>':
                        receivedAmount < totalAmount ?
                            '<span class="badge badge-warning"><?php echo e(__('order.Partial')); ?></span>':
                        receivedAmount == totalAmount?
                            '<span class="badge badge-success"><?php echo e(__('order.Paid')); ?></span>':
                        receivedAmount > totalAmount?
                            '<span class="badge badge-info"><?php echo e(__('order.Change')); ?></span>':''
            }</span>


        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <h6 class="mb-3">To: <strong>${customerName || 'N/A'}</strong></h6>
                </div>
            </div>
            <div class="table-responsive-sm">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Item</th>
                            <th>Description</th>
                            <th>Unit Cost</th>
                            <th>Qty</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${itemsHTML}
                    </tbody>
                    <tfoot>
                      <tr>
                        <th class="text-right" colspan="5">
                          Total
                        </th>
                        <th class="right">
                          <strong><?php echo e(config('settings.currency_symbol')); ?> ${totalAmount}</strong>
                        </th>
                      </tr>

                      <tr>
                        <th class="text-right" colspan="5">
                          Paid
                        </th>
                        <th class="right">
                          <strong><?php echo e(config('settings.currency_symbol')); ?> ${receivedAmount}</strong>
                        </th>
                      </tr>
                    </tfood>
                </table>
            </div>
        </div>
    </div>
  </div>
</div>
`);
    });
    $(document).ready(function() {
    // Event handler when the partial payment modal is triggered
    $('#partialPaymentModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal

        // Get the order ID from data-attributes
        var orderId = button.data('orders-id');
        var remainingAmount = button.data('remaining-amount');

        // Find modal and set the order ID in the hidden field
        var modal = $(this);
        modal.find('#modalOrderId').val(orderId);
        modal.find('#partialAmount').attr('max', remainingAmount); // Set max value for partial payment
    });
});

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\pos-capstone\resources\views/orders/index.blade.php ENDPATH**/ ?>