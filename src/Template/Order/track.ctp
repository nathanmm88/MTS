<h1>Order Tracking</h1>
<p>Thanks for your order - please see below for the status of your order</p>

<p>Your order status: <?php echo $this->Entity->get('Order')->getStatusDesc(); ?></p>

<?php echo $this->Element('order_details'); ?>
<div id="viewContactDetailsContainer" class="row">
    <div class="col-xs-12 text-center">
        <a id="viewContactDetails" href="#"><?php echo $this->Content->get('label.show_contact_details'); ?></a>
    </div>
</div>
<?php echo $this->Element('contact_details'); ?>