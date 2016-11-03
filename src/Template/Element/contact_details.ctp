<div id="contactDetails" class="row" <?= isset($show) && $show == true ? 'style="display: block;"' : '' ?>>
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