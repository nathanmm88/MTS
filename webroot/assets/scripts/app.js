$(document).ready(function(){
    /**
     * Showing contact details when a user clicks on the link
     */
    $('#viewContactDetails').on('click', function(e){
        e.preventDefault();
        $('#viewContactDetailsContainer').hide();
        $('#contactDetails').slideDown('fast');
    });
    
    /**
     * When the user wants to make a delivery order and we need to display the 
     * postcode inputs
     */
    $('#wantsDelivery').on('click', function(e){
        e.preventDefault();
        $(this).hide();
        $('#lookupPostcode').removeClass('hidden');
    });
});

