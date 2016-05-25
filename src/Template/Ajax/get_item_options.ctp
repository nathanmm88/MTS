<?php

//load the markup we required - the sidebar
$data['markup'] = $this->element('/Modal/ItemOptionsList', ['condimentTypes' => $condimentTypes, 'itemId' => $itemId, 'variationId' => $variationId]);

//return the json encoded data
echo json_encode($data);
?>