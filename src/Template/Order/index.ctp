<div class="row">
    <div class="col-sm-12">
        <?php if ($this->Takeaway->isOnline()) { ?>
            <h2>Order Options</h2>
            <?php if ($this->Takeaway->isDelivering()) { ?>
                <div class="row"><div class="col-xs-12 text-center"><a id="wantsDelivery" class="btn btn-primary" href="#">Delivery in approximately <?php echo $this->Takeaway->getDeliveryWaitingTime(); ?></a></div></div>
            <?php } ?>
            <?php if ($this->Takeaway->isDeliveryAndCollection()) { ?>
                <div class="row"><div class="col-xs-12 text-center or-txt">Or</div></div>
            <?php } ?>
            <?php if ($this->Takeaway->isCollection()) { ?>
                <div class="row"><div class="col-xs-12 text-center"><a id="wantsCollection" class="btn btn-primary" href="#">Collection in approximately <?php echo $this->Takeaway->getCollectionWaitingTime(); ?></a></div></div>
            <?php } ?>
        <?php } else { ?>
            <div class="alert alert-danger">Online orders are currently unavailable. <a href="#">Click here</a> to view our offline menu</div>
        <?php } ?>
    </div>
</div>
<hr/>
<div class="row">
    <div class="col-sm-6">
        <h2>Contact Details</h2>
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
        <h2>Opening Hours</h2>
        <?php echo $this->Takeaway->getOpeningHours(); ?>
    </div>
</div>