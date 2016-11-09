<h1>Thanks</h1>
<p>Thanks for your order - please see below for the status of your order</p>

<h2>CONTENT HERE!!</h2>
<p><?php echo $this->Entity->get('Order')->getStatusId(); ?> : <?php echo $this->Entity->get('Order')->getStatusDesc(); ?></p>