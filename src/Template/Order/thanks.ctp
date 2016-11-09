<h1>Thanks</h1>
<p>Thanks for your order - please see below for the status of your order</p>

<h2>CONTENT HERE!!</h2>
<p>Order Status : <?php echo $this->Entity->get('Order')->getStatusDesc(); ?></p>
<p>Payment Status : <?php echo $this->Entity->get('Order')->getPaymentStatusDesc(); ?></p>