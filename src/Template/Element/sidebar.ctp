<?php echo $this->Form->create($order, array('novalidate' => true)); ?>
<div id="sidebar-content">
    <?php
    $order = $this->Entity->get('Order');
    pr($order->getItems());
    ?>
    <h3>Your order <i class="icon_cart_alt pull-right"></i></h3>
    <table class="table table_summary">
        <tbody>
            <?php foreach ($this->Takeaway->getBasket() as $item) { ?>
                <tr>
                    <td>
                        <a class="remove_item" href="#0"><i class="icon_minus_alt"></i></a> <strong><?php echo $item['amount']; ?>x</strong> <?php echo $item['name']; ?>
                    </td>
                    <td>
                        <strong class="pull-right"><?php echo $this->Takeaway->formatMoney($item['price']); ?></strong>
                    </td>
                </tr>
            <?php } ?>            
        </tbody>
    </table>   
    <?php echo $this->Form->submit('Checkout', array('class' => 'btn btn-primary btn-lg btn-block')); ?>    
    <?php echo date('d-m-Y H:i:s'); ?>
</div>
<?php echo $this->Form->end(); ?>