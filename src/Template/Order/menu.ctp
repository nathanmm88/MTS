<h1>Menu</h1>

<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <?php
    foreach ($categories as $name => $category) {
        echo $this->element('Menu/Category', array('category' => $category, 'name' => $name));
    }
    ?>    
</div>
<div class="row">
    <div class="col-xs-12 hidden-sm hidden-md hidden-lg">
        <div id="view-basket-mobile">
            <a href="#">View Basket</a>
        </div>
    </div>
</div>