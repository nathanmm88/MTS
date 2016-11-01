<!--Maybe this should go in a new ItemHelper - to discuss-->
<?php
//initialise an array to hold the info
$itemInfo = array();

//if vegetarian
if ($item->isVegetarian()) {
    array_push($itemInfo, 'Vegetarian');
}

//if the item is gluten free
if ($item->isGlutenFree()) {
    array_push($itemInfo, 'Gluten Free');
}

//if the item is dairy free
if ($item->isDairyFree()) {
    array_push($itemInfo, 'Dairy Free');
}

//if the item may contain bones
if ($item->mayContainBones()) {
    array_push($itemInfo, 'May Contain Bones');
}

//implode the array into a string we can display to the user
$itemInfoString = implode('<br/>', $itemInfo);

?>
<p class="small">
    <?php echo $itemInfoString; ?>
</p>