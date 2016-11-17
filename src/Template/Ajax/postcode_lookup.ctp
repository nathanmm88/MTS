<?php
//load the markup we required - the postcode lookup element
$data['markup'] = $this->element('PostcodeLookup', []);

//return the json encoded data
echo json_encode($data);
?>