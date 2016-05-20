<?php 
//load the markup we required - the sidebar
$data['markup'] = $this->element('/sidebar');

//return the json encoded data
echo json_encode($data); 
?>