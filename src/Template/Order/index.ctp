<?php echo $this->Form->create(); ?>
<?php echo $this->Form->hidden('delivery_postcode'); ?>
<div class="row">
    <div class="col-sm-12">
        <?php if ($this->Entity->get('Takeaway')->getSettings()->isActive()) { ?>
            <div class="row">
                <?php if ($this->Entity->get('Takeaway')->getSettings()->getAcceptDeliveryOrders()) { ?>
                    <div class="col-sm-5 text-center">
                        <a id="wantsDelivery" class="btn btn-primary col-xs-12" href="#"><?php echo $this->Content->get('label.delivery'); ?></a>
                        <div id="lookupPostcode" class="row hidden">
                            <div class="col-xs-12 validate">
                                <?php
                                echo $this->Form->text('postcode', array(
                                    'class' => 'form-control',
                                    'placeholder' => 'Postcode',
                                    'default' => $this->Entity->get('Order')->getAddress()->getPostcode()
                                ))
                                ?>
                            </div>
                            <div class="col-xs-12">
                                <a id="searchPostcode" class="btn btn-primary col-xs-12"><?php echo $this->Content->get('label.get_delivery_options'); ?></a>
                            </div>
                        </div>
                        <div id="unableToDeliver" class='alert alert-danger hidden'>
                            <p><?php echo $this->Content->get('validation.postcode.do_not_deliver');?> <br/><span class='postcodeContainer'></span></p>
                            <a class='change-postcode' href='#'><?php echo $this->Content->get('label.postcode_change');?></a>
                        </div>
                        <?php echo $this->Form->button('Deliver to <span class=\'postcodeContainer\'></span>', array(
                            'div' => false,
                            'id' => 'deliveryBtn',
                            'class' => 'btn btn-primary col-xs-12 hidden',
                            'name' => ORDER_TYPE_DELIVERY
                        )); ?>
                        <div id='postcodeDeliveryDetails' class='hidden'>
                            <p>Delivery Cost <br/><i class='postcodeContainer'></i> - <i class='delivery-cost'></i> <a class='change-postcode' href='#'>Change</a></p>
                        </div>
                        <div id='deliveryDetails'>
                            <p><?php echo $this->Content->get('content.order_index.estimated_waiting_time'); ?> <br/><i><?php echo $this->Takeaway->getDeliveryWaitingTime(); ?></i></p>
                            <p><?php echo $this->Content->get('content.order_index.minimum_order_amount'); ?> <br/><i><?php echo $this->Takeaway->getMinimumDeliveryAmount(); ?></i></p>
                            <p><?php echo $this->Content->get('content.order_index.payment_methods'); ?> <br/><i><?php echo $this->Takeaway->getPaymentMethods(\App\Entity\TakeawayEntity::ORDER_TYPE_DELIVERY); ?></i></p>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($this->Entity->get('Takeaway')->getSettings()->getAcceptDeliveryAndCollectionOrders()) { ?>
                    <div class="col-sm-2 text-center hidden-xs or-txt">Or</div>
                    <hr class="hidden-sm hidden-md hidden-lg"/>
                <?php } ?>
                <?php if ($this->Entity->get('Takeaway')->getSettings()->getAcceptCollectionOrders()) { ?>
                    <div class="col-sm-5 text-center">
                        <?php echo $this->Form->button($this->Content->get('label.collection'), array(
                            'div' => false,
                            'id' => 'wantsCollection',
                            'class' => 'btn btn-primary col-xs-12',
                            'name' => ORDER_TYPE_COLLECTION
                        )); ?>
                        <p><?php echo $this->Content->get('content.order_index.estimated_waiting_time'); ?> <br/><i><?php echo $this->Takeaway->getCollectionWaitingTime(); ?></i></p>
                        <p><?php echo $this->Content->get('content.order_index.minimum_order_amount'); ?> <br/><i><?php echo $this->Takeaway->getMinimumCollectionAmount(); ?></i></p>
                        <p><?php echo $this->Content->get('content.order_index.payment_methods'); ?> <br/><i><?php echo $this->Takeaway->getPaymentMethods(\App\Entity\TakeawayEntity::ORDER_TYPE_COLLECTION); ?></i></p>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <div class="alert alert-danger">Online orders are currently unavailable. <a href="#">Click here</a> to view our offline menu</div>
        <?php } ?>
    </div>
</div>
<hr/>
<div id="viewContactDetailsContainer" class="row">
    <div class="col-xs-12 text-center">
        <a id="viewContactDetails" href="#"><?php echo $this->Content->get('label.show_contact_details'); ?></a>
    </div>
</div>
<div id="contactDetails" class="row">
    <div class="col-sm-6">
        <h3><?php echo $this->Content->get('label.contact_details'); ?></h3>
        <div class="row">
            <div class="col-xs-4 text-right contact-label label-div"><?php echo $this->Content->get('label.telephone'); ?>:</div>
            <div class="col-xs-8">
                <?php echo $this->Entity->get('Takeaway')->getTelephone(); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4 text-right contact-label label-div"><?php echo $this->Content->get('label.email'); ?>:</div>
            <div class="col-xs-8">
                <?php echo $this->Entity->get('Takeaway')->getEmail(); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4 text-right contact-label label-div"><?php echo $this->Content->get('label.address'); ?>:</div>
            <div class="col-xs-8">
                <?php echo $this->Takeaway->getAddress('<br/>'); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <h3><?php echo $this->Content->get('label.opening_hours'); ?></h3>
        <?php echo $this->Takeaway->getOpeningHours(); ?>
    </div>
</div>
<?php echo $this->Form->end(); ?>