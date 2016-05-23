<form>
    <div class="panel-group" id="ItemOptionsAccordion" role="tablist" aria-multiselectable="true">
        <?php foreach ($condimentTypes as $key => $condimentType) {
            ?>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="ItemOptionsHeading<?php echo $condimentType->getId(); ?>">
                    <h4 class="panel-title">
                        <a  role="button" data-toggle="collapse" data-parent="#ItemOptionsAccordion" href="#ItemOptionsCollapse<?php echo $condimentType->getId(); ?>" aria-expanded="<?php echo ($key == 0) ? 'true' : 'false'; ?>" aria-controls="ItemOptionsCollapse<?php echo $condimentType->getId(); ?>">
                            Condiment: <?php echo $condimentType->getDescription(); ?><span id="condiment-desc-<?php echo $condimentType->getId() ;?>" class="small pull-right"></span>
                        </a>
                    </h4>
                </div>
                <div id="ItemOptionsCollapse<?php echo $condimentType->getId(); ?>" class="<?php echo ($key == 0) ? '' : 'locked'; ?> panel-collapse collapse <?php echo ($key == 0) ? 'in' : ''; ?>" role="tabpanel" aria-labelledby="ItemOptionsHeading<?php echo $condimentType->getId(); ?>">
                    <input type="hidden" id="type-selection-<?php echo $condimentType->getId(); ?>" value="">
                    <div class="panel-body">
                        <ul class="list-group" data-type="<?php echo $condimentType->getId(); ?>">
                            <?php foreach ($condimentType->getCondiments() as $condiment) { ?>                                                        
                                <li class="list-group-item condiment " data-id="<?php echo $condiment->getId(); ?>"><?php echo $condiment->getDescription(); ?></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php } ?> 
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="ItemNotesHeading">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#ItemOptionsAccordion" href="#ItemNotesCollapse" aria-expanded="true" aria-controls="ItemNotesCollapse">
                        Notes
                    </a>
                </h4>
            </div>
            <div id="ItemNotesCollapse" class="locked panel-collapse collapse" role="tabpanel" aria-labelledby="ItemNotesHeading">
                <input type="text" id="item-notes" value="">              
            </div>
        </div>
    </div>
</form>