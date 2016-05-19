<tr>
    <td>
        <h5><?php echo $item['name']; ?></h5>
        <p>
            <?php echo $item['description']; ?>
        </p>
    </td>
    <td>
        <strong><?php echo $this->Takeaway->formatMoney($item['price']); ?></strong>
    </td>
    <td >
        <a class="btn btn-default add-item" href="#" role="button" data-item-id="<?php echo $item['id']; ?>">Add</a>
    </td>
</tr>                   
