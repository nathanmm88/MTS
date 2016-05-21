<?php
//set some values here to save haing to build the values every time
$subTotal = $this->Entity->get('Order')->getTotal(false);
$total = $this->Entity->get('Order')->getTotal();
$items = $this->Entity->get('Order')->getItems();
?>
<?php echo $this->Form->create($order, array('novalidate' => true)); ?>
<div id="sidebar-content">
    <h3>Your order <i class="icon_cart_alt pull-right"></i></h3>
    <?php if (count($items) > 0) { ?>

        <table class="table table_summary">
            <tbody>
                <?php foreach ($items as $orderItemKey => $orderItem) { ?>
                    <?php $item = $this->Entity->get('Menu')->getItem($orderItem->getItemId(), $orderItem->getVariationId()) ?>
                    <tr>
                        <td>
                            <a class="remove-item" href="#" data-order-item="<?php echo $orderItemKey; ?>"><i class="icon_minus_alt">-</i></a> <?php echo $item->getFullName(); ?>
                        </td>
                        <td>
                            <strong class="pull-right"><?php echo $this->Takeaway->formatMoney($item->getPrice()); ?></strong>
                        </td>
                    </tr>
                <?php } ?>  
                <tr class="<?php echo $this->Entity->get('Order')->meetsMinimumOrderAmount($subTotal) ? '' : 'alert alert-warning'; ?>">
                    <td>Subtotal</td>
                    <td><strong class="pull-right"><?php echo $this->Takeaway->formatMoney($subTotal); ?></strong></td>
                </tr>
                <?php if ($this->Entity->get('Order')->isDelivery()) { ?>
                    <tr>
                        <td>Delivery</td>
                        <td><strong class="pull-right"><?php echo $this->Takeaway->formatMoney($this->Entity->get('Order')->getAddress()->getDeliveryCost()); ?></strong></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td><b>Total</b></td>
                    <td><strong class="pull-right"><?php echo $this->Takeaway->formatMoney($total); ?></strong></td>
                </tr>
            </tbody>
        </table> 
        <?php if(!$this->Entity->get('Order')->meetsMinimumOrderAmount($subTotal)) { ?>
            <?php if ($this->Entity->get('Order')->isDelivery()) { ?>
                <p class="alert alert-warning">Your order hasn't yet met the minimum delivery amount of <?php echo $this->Takeaway->getMinimumDeliveryAmount() ?></p>
            <?php } else { ?>
                <p class="alert alert-warning">Your order hasn't yet met the minimum collection amount of <?php echo $this->Takeaway->getMinimumCollectionAmount() ?></p>
            <?php } ?>
        <?php } ?>  
    <?php } else { ?>
        <p class="alert alert-warning">Your order is empty, please use the menu to add items to your order.</p>
    <?php } ?>
    <?php echo $this->Form->submit('Checkout', array('class' => 'btn btn-primary btn-lg btn-block')); ?>    
</div>
<?php echo $this->Form->end(); ?>