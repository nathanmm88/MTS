<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading<?php echo $section['id']; ?>">
        <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $section['id']; ?>" aria-expanded="true" aria-controls="collapse<?php echo $section['id']; ?>">
                <?php echo $section['name']; ?>
            </a>
        </h4>
    </div>
    <div id="collapse<?php echo $section['id']; ?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading<?php echo $section['id']; ?>">
        <div class="panel-body">
            <p><?php echo $section['description']; ?></p>
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
                    foreach ($this->Menu->getSectionItems($section['id']) as $item) {                        
                                             
                        echo $this->element('Menu/Row', array('item' => $item));

                        if ($item['has_variations']){                            
                            foreach ($this->Menu->getItemVariations($item['id']) as $variation) {
                                echo $this->element('Menu/Row', array('item' => $variation));
                            }
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>