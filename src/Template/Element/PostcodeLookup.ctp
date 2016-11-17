<?php
//if at least one address has been found
if (count($addressList) > 0) {
    //create the formatted array to be used in the dropwdown - add the empty option
    $formattedAddresses = ['' => $this->Content->get('address.please_select')];
    //for each address
    foreach ($addressList as $key => $address) {
        //save the values as hidden elements
        echo $this->Form->hidden('AddressLine1_' . $key, ['id' => 'AddressLine1_' . $key, 'value' => $address['AddressLine1']]);
        echo $this->Form->hidden('AddressLine2_' . $key, ['id' => 'AddressLine2_' . $key, 'value' => $address['AddressLine2']]);
        echo $this->Form->hidden('AddressTown_' . $key, ['id' => 'AddressTown_' . $key, 'value' => $address['Town']]);
        echo $this->Form->hidden('AddressCounty_' . $key, ['id' => 'AddressCounty_' . $key, 'value' => $address['County']]);

        //create the string to display in the dropdown
        $thisAddress = $address['AddressLine1'];
        $thisAddress .= (empty($address['AddressLine2'])) ? '' : ', ' . $address['AddressLine2'];
        $thisAddress .= (empty($address['Town'])) ? '' : ', ' . $address['Town'];
        $thisAddress .= (empty($address['County'])) ? '' : ', ' . $address['County'];
        $formattedAddresses[] = $thisAddress;
    }
    //output the dropdown
    echo $this->Form->select('address', $formattedAddresses, ['id' => 'address']);
} else {
    //no results found - show an error message
    echo $this->Content->get('address.no_address_found');
}