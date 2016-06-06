<?php echo $this->Form->create($article, ['id' => 'ItemOptionsForm']); ?>
<input type="hidden" name="item" id="item" value="<?php echo $itemId; ?>">
<input type="hidden" name="variation" id="variation" value="<?php echo $variationId; ?>">
<div class="panel-group" id="ItemOptionsAccordion" role="tablist" aria-multiselectable="true">
    <?php
    $count = 0;

    foreach ($condimentTypes as $condimentType) {
        ?>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="ItemOptionsHeading<?php echo $condimentType->getId(); ?>">
                <h4 class="panel-title">
                    <a class="<?php echo ($count == 0) ? '' : 'locked'; ?>" role="button" data-toggle="collapse" data-parent="#ItemOptionsAccordion" href="#ItemOptionsCollapse<?php echo $condimentType->getId(); ?>" aria-expanded="<?php echo ($count == 0) ? 'true' : 'false'; ?>" aria-controls="ItemOptionsCollapse<?php echo $condimentType->getId(); ?>">
                        Condiment: <?php echo $condimentType->getDescription(); ?><span id="condiment-desc-<?php echo $condimentType->getId(); ?>" class="small pull-right"></span>
                    </a>
                </h4>
            </div>
            <div id="ItemOptionsCollapse<?php echo $condimentType->getId(); ?>" class="panel-collapse collapse <?php echo ($count == 0) ? 'in' : ''; ?>" role="tabpanel" aria-labelledby="ItemOptionsHeading<?php echo $condimentType->getId(); ?>">
                <input type="hidden" class="selected-condiment" name="selected-condiment[<?php echo $condimentType->getId(); ?>]" id="selected-condiment-<?php echo $condimentType->getId(); ?>" value="">
                <div class="panel-body">
                    <ul class="list-group" data-type="<?php echo $condimentType->getId(); ?>">
                        <?php foreach ($condimentType->getCondiments() as $condiment) {
                            ?>                                                        
                            <li class="list-group-item condiment " data-id="<?php echo $condiment->getId(); ?>"><?php echo $condiment->getDescription(); ?></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php
        $count++;
    }
    ?> 
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="ItemNotesHeading">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#ItemOptionsAccordion" href="#ItemNotesCollapse" aria-expanded="true" aria-controls="ItemNotesCollapse">
                    Notes
                </a>
            </h4>
        </div>
        <div id="ItemNotesCollapse" class="panel-collapse collapse <?php echo ($count == 0) ? 'in' : ''; ?>" role="tabpanel" aria-labelledby="ItemNotesHeading">
            <div class="row">
                <div class="col-md-12">                    
                    <?php echo $this->Form->text('notes', ['class' => 'form-control']); ?>
                </div>

            </div>          
        </div>
    </div>
</div>
<?php
echo $this->Form->end();
