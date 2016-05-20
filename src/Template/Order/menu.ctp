<h1>Menu</h1>

<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <?php
       
    foreach ($this->Entity->get('Menu')->getSections() as $section) {
        echo $this->element('Menu/Section', get_defined_vars());
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