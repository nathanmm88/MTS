<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading<?php echo $name; ?>">
        <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $name; ?>" aria-expanded="true" aria-controls="collapse<?php echo $name; ?>">
                <?php echo $name; ?>
            </a>
        </h4>
    </div>
    <div id="collapse<?php echo $name; ?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading<?php echo $name; ?>">
        <div class="panel-body">
            <p><?php echo $category['description']; ?></p>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="col-xs-8">Item</th>
                        <th class="col-xs-2">Price</th>
                        <th class="col-xs-2"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($category['items'] as $name => $item) { ?>
                    <tr>
                        <td>
                            <h5><?php echo $name; ?></h5>
                            <p>
                                <?php echo $item['description']; ?>
                            </p>
                        </td>
                        <td>
                            <strong><?php echo $this->Takeaway->formatMoney($item['price']); ?></strong>
                        </td>
                        <td class="add-item">
                            <a class="btn btn-default" href="#" role="button">Add</a>
                        </td>
                    </tr>                    
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>