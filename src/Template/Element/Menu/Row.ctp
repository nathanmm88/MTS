<tr>
    <td>
        <h5><?php echo $item->getReference(); ?> <?php echo $item->getName(); ?></h5>
        <p>
            <?php echo $item->getDescription(); ?>
        </p>
    </td>
    <td>
        <strong><?php echo $this->Takeaway->formatMoney($item->getPrice()); ?></strong>
    </td>
    <td>
        <?php 
        $itemId = $item->getId();
        $variationId = '';
        if($item instanceof App\Entity\Menu\MenuItemVariationEntity){
            $itemId = $item->getParentId();
            $variationId = $item->getId();
        }
        
        $condimentTypes = $this->Entity->get('Menu')->getCondimentTypes($item->getId());
        $dataAttrib = '';
        if (count($condimentTypes)>0){
            $dataAttrib = 'data-condiments = "'.$item->getId().'"';
        }
        ?>
        <a class="btn btn-default add-item" href="#" <?php echo $dataAttrib; ?> data-item-id="<?php echo $itemId; ?>" data-variation-id="<?php echo $variationId; ?>" data-section="<?php echo $section->getId(); ?>">Add</a>
    </td>
</tr>                   
