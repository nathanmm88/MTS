<?php echo $this->Form->create(); ?>
<?php echo $this->Form->hidden('delivery_postcode'); ?>
<div class="row">
    <div class="col-sm-12">
        <?php if ($this->Takeaway->isOnline()) { ?>
            <div class="row">
                <?php if ($this->Takeaway->isDelivering()) { ?>
                    <div class="col-sm-5 text-center">
                        <a id="wantsDelivery" class="btn btn-primary col-xs-12" href="#">Delivery</a>
                        <div id="lookupPostcode" class="row hidden">
                            <div class="col-xs-12 validate">
                                <?php
                                echo $this->Form->text('postcode', array(
                                    'class' => 'form-control',
                                    'placeholder' => 'Postcode'
                                ))
                                ?>
                            </div>
                            <div class="col-xs-12">
                                <a id="searchPostcode" class="btn btn-primary col-xs-12">Get delivery options</a>
                            </div>
                        </div>
                        <div id="unableToDeliver" class='alert alert-danger hidden'>
                            <p>Sorry, we don't currently deliver to <br/><span class='postcodeContainer'></span></p>
                            <a class='change-postcode' href='#'>Change</a>
                        </div>
                        <?php echo $this->Form->button('Deliver to <span class=\'postcodeContainer\'></span>', array(
                            'div' => false,
                            'id' => 'deliveryBtn',
                            'class' => 'btn btn-primary col-xs-12 hidden',
                            'value' => 'delivery'
                        )); ?>
                        <div id='postcodeDeliveryDetails' class='hidden'>
                            <p>Delivery Cost <br/><i class='postcodeContainer'></i> - <i class='delivery-cost'></i> <a class='change-postcode' href='#'>Change</a></p>
                        </div>
                        <div id='deliveryDetails'>
                            <p>Estimated waiting time <br/><i><?php echo $this->Takeaway->getDeliveryWaitingTime(); ?></i></p>
                            <p>Minimum order amount <br/><i><?php echo $this->Takeaway->getMinimumDeliveryAmount(); ?></i></p>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($this->Takeaway->isDeliveryAndCollection()) { ?>
                    <div class="col-sm-2 text-center hidden-xs or-txt">Or</div>
                    <hr class="hidden-sm hidden-md hidden-lg"/>
                <?php } ?>
                <?php if ($this->Takeaway->isCollection()) { ?>
                    <div class="col-sm-5 text-center">
                        <?php echo $this->Form->button('Collection', array(
                            'div' => false,
                            'id' => 'wantsCollection',
                            'class' => 'btn btn-primary col-xs-12',
                            'name' => 'collection'
                        )); ?>
                        <p>Estimated waiting time <br/><i><?php echo $this->Takeaway->getCollectionWaitingTime(); ?></i></p>
                        <p>Minimum order amount <br/><i><?php echo $this->Takeaway->getMinimumCollectionAmount(); ?></i></p>
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
        <a id="viewContactDetails" href="#">Show contact details</a>
    </div>
</div>
<div id="contactDetails" class="row">
    <div class="col-sm-6">
        <h3>Contact Details</h3>
        <div class="row">
            <div class="col-xs-4 text-right contact-label label-div">Telephone:</div>
            <div class="col-xs-8">
                <?php echo Cake\Core\Configure::read('takeaway.contact_details.telephone'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4 text-right contact-label label-div">Email:</div>
            <div class="col-xs-8">
                <?php echo Cake\Core\Configure::read('takeaway.contact_details.email'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4 text-right contact-label label-div">Address:</div>
            <div class="col-xs-8">
                <?php echo $this->Takeaway->getAddress('<br/>'); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <h3>Opening Hours</h3>
        <?php echo $this->Takeaway->getOpeningHours(); ?>
    </div>
</div>
<?php echo $this->Form->end(); ?>