<div class="row">
    <div class="col-sm-12">
        <h1 class="clearfix">Offline Menu</h1>
    </div>
</div>
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <?php
    foreach ($this->Entity->get('Menu')->getSections() as $section) {
        if ($section->isActive()){
            echo $this->element('Menu/Section', array_merge(get_defined_vars(), array('isPdf' => true)));
        }
    }
    ?>    
</div>