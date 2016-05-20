<?php echo $this->Form->create($order, array('novalidate' => true)); ?>
<div id="sidebar-content">
    <h3>Your order <i class="icon_cart_alt pull-right"></i></h3>
    <table class="table table_summary">
        <tbody>
            <?php foreach ($this->Entity->get('Order')->getItems() as $orderItemKey => $orderItem) { ?>
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
        </tbody>
    </table>   
    <?php echo $this->Form->submit('Checkout', array('class' => 'btn btn-primary btn-lg btn-block')); ?>    
</div>
<?php echo $this->Form->end(); ?>