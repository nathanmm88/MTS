<?php echo $this->Form->create($confirmation, array('novalidate' => true)); ?>
First Name
    <?php echo $this->Form->text('first_name'); ?>
    <?php echo $this->Form->isFieldError('first_name') ? $this->Form->error('first_name') : ''; ?>
Surname
    <?php echo $this->Form->text('surname'); ?>
    <?php echo $this->Form->isFieldError('surname') ? $this->Form->error('surname') : ''; ?>
Email
    <?php echo $this->Form->text('email'); ?>
    <?php echo $this->Form->isFieldError('email') ? $this->Form->error('email') : ''; ?>
Telephone
    <?php echo $this->Form->text('telephone'); ?>
    <?php echo $this->Form->isFieldError('telephone') ? $this->Form->error('telephone') : ''; ?>
Address line one
    <?php echo $this->Form->text('address_line_one'); ?>
    <?php echo $this->Form->isFieldError('address_line_one') ? $this->Form->error('address_line_one') : ''; ?>
Address line two
    <?php echo $this->Form->text('address_line_two'); ?>
    <?php echo $this->Form->isFieldError('address_line_two') ? $this->Form->error('address_line_two') : ''; ?>
Town
    <?php echo $this->Form->text('address_line_three'); ?>
    <?php echo $this->Form->isFieldError('address_line_three') ? $this->Form->error('address_line_three') : ''; ?>
County
    <?php echo $this->Form->text('address_line_four'); ?>
    <?php echo $this->Form->isFieldError('address_line_four') ? $this->Form->error('address_line_four') : ''; ?>
Postcode
    <?php echo $this->Form->text('postcode'); ?>
    <?php echo $this->Form->isFieldError('postcode') ? $this->Form->error('postcode') : ''; ?>
    <div class="row">
        <div  class="col-sm-6">
            <?php
            echo $this->Form->button('Cash on delivery', array(
                'div' => false,
                'class' => 'btn btn-primary',
                'name' => PAYMENT_TYPE_CASH
            ));
            ?>
        </div>
        <div class="col-sm-6">
            <?php
            echo $this->Form->button('Pay by PayPal', array(
                'div' => false,
                'class' => 'btn btn-primary',
                'name' => PAYMENT_TYPE_ONLINE
            ));
            ?>
        </div>
    </div>
<?php echo $this->Form->end(); ?>