<?php echo $this->Form->create($confirmation, array('novalidate' => true)); ?>
<h1>Complete order</h1>
<div class="row">
    <div class="col-md-6">
        <?php echo $this->Form->label('first_name', 'First name', ['class' => 'control-label']); ?>
        <?php echo $this->Form->text('first_name', ['class' => 'form-control', 'default' => $this->Entity->get('Order')->getFirstName()]); ?>
        <?php echo $this->Form->isFieldError('first_name') ? $this->Form->error('first_name') : ''; ?>
    </div>
    <div class="col-md-6">
        <?php echo $this->Form->label('surname', 'Surname', ['class' => 'control-label']); ?>
        <?php echo $this->Form->text('surname', ['class' => 'form-control', 'default' => $this->Entity->get('Order')->getSurname()]); ?>
        <?php echo $this->Form->isFieldError('surname') ? $this->Form->error('surname') : ''; ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <?php echo $this->Form->label('email', 'Email address', ['class' => 'control-label']); ?>
        <?php echo $this->Form->text('email', ['class' => 'form-control', 'default' => $this->Entity->get('Order')->getEmail()]); ?>
        <?php echo $this->Form->isFieldError('email') ? $this->Form->error('email') : ''; ?>
    </div>
    <div class="col-md-6">
        <?php echo $this->Form->label('telephone', 'Telephone', ['class' => 'control-label']); ?>
        <?php echo $this->Form->text('telephone', ['class' => 'form-control', 'default' => $this->Entity->get('Order')->getTelephone()]); ?>
        <?php echo $this->Form->isFieldError('telephone') ? $this->Form->error('telephone') : ''; ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12">
                <?php echo $this->Form->label('address_line_one', 'House name/number', ['class' => 'control-label']); ?>
                <?php echo $this->Form->text('address_line_one', ['class' => 'form-control', 'default' => $this->Entity->get('Order')->getAddress()->getAddressLineOne()]); ?>
                <?php echo $this->Form->isFieldError('address_line_one') ? $this->Form->error('address_line_one') : ''; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php echo $this->Form->label('address_line_two', 'Street', ['class' => 'control-label']); ?>
                <?php echo $this->Form->text('address_line_two', ['class' => 'form-control', 'default' => $this->Entity->get('Order')->getAddress()->getAddressLineTwo()]); ?>
                <?php echo $this->Form->isFieldError('address_line_two') ? $this->Form->error('address_line_two') : ''; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php echo $this->Form->label('address_line_three', 'Town', ['class' => 'control-label']); ?>
                <?php echo $this->Form->text('address_line_three', ['class' => 'form-control', 'default' => $this->Entity->get('Order')->getAddress()->getAddressLineThree()]); ?>
                <?php echo $this->Form->isFieldError('address_line_three') ? $this->Form->error('address_line_three') : ''; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php echo $this->Form->label('address_line_four', 'County', ['class' => 'control-label']); ?>
                <?php echo $this->Form->text('address_line_four', ['class' => 'form-control', 'default' => $this->Entity->get('Order')->getAddress()->getAddressLineFour()]); ?>
                <?php echo $this->Form->isFieldError('address_line_four') ? $this->Form->error('address_line_four') : ''; ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12">
                <?php if($this->Entity->get('Order')->isType(\App\Entity\TakeawayEntity::ORDER_TYPE_DELIVERY)){ ?>
                    <?php echo $this->Form->label('delivery_time', 'When would you like us to deliver?', ['class' => 'control-label']); ?>
                    <?php echo $this->Form->select('delivery_time', $this->Entity->get('Order')->getDeliveryTimeOptions(), ['class' => 'form-control', 'default' => $this->Entity->get('Order')->getDeliveryTime()]); ?>
                    <?php echo $this->Form->isFieldError('delivery_time') ? $this->Form->error('delivery_time') : ''; ?>
                <?php } else if ($this->Entity->get('Order')->isType(\App\Entity\TakeawayEntity::ORDER_TYPE_COLLECTION)){ ?>
                    <?php echo $this->Form->label('collection_time', 'When would you like to pick up your order?', ['class' => 'control-label']); ?>
                    <?php echo $this->Form->select('collection_time', $this->Entity->get('Order')->getCollectionTimeOptions(), ['class' => 'form-control', 'default' => $this->Entity->get('Order')->getCollectionTime()]); ?>
                    <?php echo $this->Form->isFieldError('collection_time') ? $this->Form->error('collection_time') : ''; ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <?php
        $postcodeParams = ['class' => 'form-control', 'default' => $this->Entity->get('Order')->getAddress()->getPostcode()];
        if ($this->Entity->get('Order')->isDelivery()) {
            $postcodeParams['readonly'] = 'readonly';
        }
        ?>
        <?php echo $this->Form->label('postcode', 'Postcode', ['class' => 'control-label']); ?>
        <?php echo $this->Form->text('postcode', $postcodeParams); ?>
        <?php if ($this->Entity->get('Order')->isDelivery()) { ?>
            <a href="<?php echo $this->Step->getStepLink('order_index'); ?>"><i>Change postcode</i></a>
        <?php } ?>
        <?php echo $this->Form->isFieldError('postcode') ? $this->Form->error('postcode') : ''; ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?php echo $this->Form->checkbox('allergy_disclaimer'); ?>
        <?php echo $this->Form->label('allergy_disclaimer', 'I confirm I have read and understand the <a href="#" id="open-allergy-disclaimer">allergy disclaimer</a>', ['class' => 'control-label', 'escape' => false]); ?>            
        <?php echo $this->Form->isFieldError('allergy_disclaimer') ? $this->Form->error('allergy_disclaimer') : ''; ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?php echo $this->Form->checkbox('terms'); ?>
        <?php echo $this->Form->label('terms', 'I confirm I have read and agree to the <a href="#" id="open-terms">terms and conditions</a>', ['class' => 'control-label', 'escape' => false]); ?>            
        <?php echo $this->Form->isFieldError('terms') ? $this->Form->error('terms') : ''; ?>
    </div>
</div>
<div id="confirmBtns" class="row">
    <?php if ($this->Entity->get('Takeaway')->getSettings()->hasPaymentType(\App\Entity\Takeaway\SettingsEntity::PAYMENT_METHOD_CASH, $this->Entity->get('Order')->getType())) { ?>
        <div  class="col-md-6 text-center">
            <?php
            echo $this->Form->button('<i class="fa fa-money"></i> Pay with cash', array(
                'div' => false,
                'class' => 'btn btn-primary btn-lg btn-block',
                'name' => PAYMENT_TYPE_CASH
            ));
            ?>
        </div>
    <?php } ?>
    <?php if ($this->Entity->get('Takeaway')->getSettings()->hasPaymentType(\App\Entity\Takeaway\SettingsEntity::PAYMENT_METHOD_PAYPAL, $this->Entity->get('Order')->getType())) { ?>
        <div class="col-sm-6 text-center">
            <?php
            echo $this->Form->button('<i class="fa fa-paypal"></i> Pay by PayPal', array(
                'div' => false,
                'class' => 'btn btn-primary btn-lg btn-block',
                'name' => PAYMENT_TYPE_ONLINE
            ));
            ?>
        </div>
    <?php } ?>
</div>
<div class="row">
    <div class="col-sm-6">
        <a class="btn btn-warning btn-lg btn-block hidden-xs hidden-sm" href="<?php echo $this->Step->getStepLink('order_menu'); ?>">Back to menu</a>
        <a class="btn btn-warning btn-lg btn-block hidden-md hidden-lg" href="<?php echo $this->Step->getStepLink('order_basket'); ?>">Back to basket</a>
    </div>
</div>
<?php echo $this->Form->end(); ?>
<?php echo $this->element('Modal/AllergyDisclaimer'); ?>
<?php echo $this->element('Modal/TermsAndConditions'); ?>
