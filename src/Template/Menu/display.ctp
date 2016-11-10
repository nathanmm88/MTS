<div class="row">
    <div class="col-sm-12">
        <h1 class="clearfix">Offline Menu <a class="btn btn-lg btn-primary pull-right hidden-xs" href="/menu/download.pdf">Download PDF</a></h1>
    </div>
</div>
<a class="btn btn-lg btn-primary hidden-sm hidden-md hidden-lg" href="/menu/download.pdf">Download PDF</a>
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <?php
    foreach ($this->Entity->get('Menu')->getSections() as $section) {
        if ($section->isActive()){
            echo $this->element('Menu/Section', get_defined_vars());
        }
    }
    ?>    
</div>