//bind the click event for the address dropdown
function bindAddressClick(){
    $('#address').on('change', function(){
        //get this address key
        var key = $(this).val();

        //get the hidden values and populate into the manual address fields
        $('#address-line-1').val($('#AddressLine1_'+key).val());
        $('#address-line-2').val($('#AddressLine2_'+key).val());
        $('#address-town').val($('#AddressTown_'+key).val());
        $('#address-county').val($('#AddressCounty_'+key).val());

        //show the manual address fields
        $('#address-fields').show();
    });
}

$(document).ready(function() {
    //on click of the find address button
    $('#find-address').on('click', function(e) {
        e.preventDefault();

        //hide the address fields
        $('#address-fields').hide();

        //empty the postcode results div
        $('#postcode-results').empty();

        //blockUI
        startBlocking();

        var url = '/ajax/postcodeLookup';
        var postcode = $('#postcode').val();
        $.post(url, {postcode: postcode}, function(data) {
            //if no results found, show the manual address fields
            if (data.success===false){
                $('#address-fields').show();
            }
            //populate the page with the address dropdown
            $('#postcode-results').html(data.markup);

            //bind the click event for the address dropdown
            bindAddressClick();
        }, 'json').always(function() {
            //always stop blockUI
            stopBlocking();
        });
    });
});

