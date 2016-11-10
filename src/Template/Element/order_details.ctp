<?php
//set some values here to save haing to build the values every time
$subTotal = $this->Entity->get('Order')->getTotal(false);
$total = $this->Entity->get('Order')->getTotal();
$items = $this->Entity->get('Order')->getItems();
?>
<div id="sidebar-content">
    <h3>Your order <i class="icon_cart_alt pull-right"></i></h3>
    <?php if (count($items) > 0) { ?>

        <table class="table table_summary">
            <tbody>
                <?php foreach ($items as $orderItemKey => $orderItem) { ?>
                    <?php $item = $this->Entity->get('Menu')->getItem($orderItem->getItemId(), $orderItem->getVariationId()) ?>
                    <tr>
                        <td>
                            <?php echo $item->getFullName(); ?>
                            <?php if ($orderItem->hasNotes() || $this->Entity->get('Order')->itemHasCondiments($orderItemKey)) { ?>
                                <p class="note"><b>Notes:</b></p>
                            <?php } ?>

                            <?php if ($this->Entity->get('Order')->itemHasCondiments($orderItemKey)) { ?>
                                <?php foreach ($this->Entity->get('Order')->getCondimentsForItemId($orderItemKey) as $condimentInfo) { ?>
                                    <?php
                                    $condimentType = $this->Entity->get('Menu')->getCondimentTypeForItem($orderItem->getId(), $condimentInfo['type_id']);
                                    $condiment = $this->Entity->get('Menu')->getCondimentForType($condimentInfo['type_id'], $condimentInfo['id']);
                                    ?>
                                    <?php if ($condiment instanceof \App\Entity\Menu\CondimentEntity) { ?>
                                        <p class="note"><b><?php echo $condimentType->getDescription() ?></b> - <?php echo $condiment->getDescription(); ?></p>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                            <?php if ($orderItem->hasNotes()) { ?>
                                <p class="note">
                                    <?php echo $orderItem->getNotes(); ?>
                                </p>
                            <?php } ?>
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
        <?php if (!$this->Entity->get('Order')->meetsMinimumOrderAmount($subTotal)) { ?>
            <?php if ($this->Entity->get('Order')->isDelivery()) { ?>
                <p class="alert alert-warning">Your order hasn't yet met the minimum delivery amount of <?php echo $this->Takeaway->getMinimumDeliveryAmount() ?></p>
            <?php } else { ?>
                <p class="alert alert-warning">Your order hasn't yet met the minimum collection amount of <?php echo $this->Takeaway->getMinimumCollectionAmount() ?></p>
            <?php } ?>
        <?php } ?>
        <?php if ($this->Entity->get('Order')->isDelivery()) { ?>
            <p class="alert alert-info text-center">Delivering to <strong><?php echo $this->Entity->get('Order')->getAddress()->getPostcode(); ?></strong> at approximately <strong><?php echo $this->Entity->get('Order')->getEstimatedTime('g:ia'); ?></strong></p>
            <?php if ($this->Entity->get('Takeaway')->getSettings()->getAcceptCollectionOrders()) { ?>
            <?php } ?>
        <?php } else { ?>
            <p class="alert alert-info text-center">Collection from <br/><?php echo $this->Takeaway->getAddress('<br/>') ?> <br/> at approximately <strong><?php echo $this->Entity->get('Order')->getEstimatedTime('g:ia'); ?></strong></p>
        <?php } ?>
    <?php } else { ?>
        <p class="alert alert-warning">Your order is empty, please use the menu to add items to your order.</p>
    <?php } ?>

</div>