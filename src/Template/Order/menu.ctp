<h1>Menu</h1>

<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <?php
       
    foreach ($this->Entity->get('Menu')->getSections() as $section) {
        if ($section->isActive()){
            echo $this->element('Menu/Section', get_defined_vars());
        }
    }
    ?>    
</div>
<div class="row">
    <div class="col-xs-12 hidden-md hidden-lg">
        <div id="view-basket-mobile">
            <a href="<?php echo $this->Step->getStepLink('order_basket'); ?>"><i class="fa fa-shopping-bag" aria-hidden="true"></i> <span class="order-total"><?php echo $this->Takeaway->formatMoney($this->Entity->get('Order')->getTotal()); ?></span></a>
        </div>
    </div>
</div>
<?php echo $this->element('Modal/ItemOptions'); ?>