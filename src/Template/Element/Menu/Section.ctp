<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading<?php echo $section->getId(); ?>">
        <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $section->getId(); ?>" aria-expanded="true" aria-controls="collapse<?php echo $section->getId(); ?>">
                <?php echo $section->getName(); ?>
            </a>
        </h4>
    </div>
    <div id="collapse<?php echo $section->getId(); ?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading<?php echo $section->getId(); ?>">
        <div class="panel-body">
            <p><?php echo $section->getDescription(); ?></p>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="col-xs-8">Item</th>
                        <th class="col-xs-2">Price</th>
                        <th class="col-xs-2"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->Entity->get('Menu')->getItems($section->getId()) as $item) {
                        if ($item->isActive()) {
                            if (!$item->hasVariations()) {
                                echo $this->element('Menu/Row', array('item' => $item, 'section' => $section));
                            } else {
                                echo $this->element('Menu/VariationTitle', array('item' => $item, 'section' => $section));
                                foreach ($this->Entity->get('Menu')->getVariations($item->getId()) as $variation) {
                                    echo $this->element('Menu/Row', array('item' => $variation, 'section' => $section));
                                }
                            }
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>