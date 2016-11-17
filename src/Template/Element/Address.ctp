<!-- This div contains the address dropdown -->
<div id="postcode-results"></div>

<!-- Hide the manual address fields on page load -->
<div id="address-fields" style="display:none;">
    <div class="row">
        <div class="col-md-12">
            <?php echo $this->Form->label('address_line_one', 'House name/number', ['class' => 'control-label']); ?>
            <?php echo $this->Form->text('address_line_one', ['id' => 'address-line-1', 'class' => 'form-control', 'default' => $this->Entity->get('Order')->getAddress()->getAddressLineOne()]); ?>
            <?php echo $this->Form->isFieldError('address_line_one') ? $this->Form->error('address_line_one') : ''; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php echo $this->Form->label('address_line_two', 'Street', ['class' => 'control-label']); ?>
            <?php echo $this->Form->text('address_line_two', ['id' => 'address-line-2', 'class' => 'form-control', 'default' => $this->Entity->get('Order')->getAddress()->getAddressLineTwo()]); ?>
            <?php echo $this->Form->isFieldError('address_line_two') ? $this->Form->error('address_line_two') : ''; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php echo $this->Form->label('address_line_three', 'Town', ['class' => 'control-label']); ?>
            <?php echo $this->Form->text('address_line_three', ['id' => 'address-town', 'class' => 'form-control', 'default' => $this->Entity->get('Order')->getAddress()->getAddressLineThree()]); ?>
            <?php echo $this->Form->isFieldError('address_line_three') ? $this->Form->error('address_line_three') : ''; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php echo $this->Form->label('address_line_four', 'County', ['class' => 'control-label']); ?>
            <?php echo $this->Form->text('address_line_four', ['id' => 'address-county', 'class' => 'form-control', 'default' => $this->Entity->get('Order')->getAddress()->getAddressLineFour()]); ?>
            <?php echo $this->Form->isFieldError('address_line_four') ? $this->Form->error('address_line_four') : ''; ?>
        </div>
    </div>
</div>