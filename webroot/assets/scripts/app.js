/**
 * Add a validation error to an element
 * 
 * @param Object element
 * @param string message
 * @returns void
 */
function addValidationError(element, message) {
    var parent = element.parent();
    if (!parent.hasClass('validate')) {
        parent = element.parentsUntil('.validate').parent();
    }
    parent.children('.error').remove();
    parent.append('<div class="col-xs-12 error alert alert-danger">' + message + '</div>');
}

/**
 * Removes a validation error
 * 
 * @param {type} element
 * @returns {undefined}
 */
function removeValidationError(element) {
    var parent = element.parent();
    if (!parent.hasClass('validate')) {
        parent = element.parentsUntil('.validate').parent();
    }
    parent.children('.error').remove();
}

/**
 * Block the screen
 * 
 * @returns {undefined}
 */
function startBlocking() {
    $.blockUI.defaults.css = {
        padding: 0,
        margin: 0,
        width: '30%',
        top: '40%',
        left: '35%',
        textAlign: 'center',
        cursor: 'wait'
    };
    $.blockUI({message: '<img alt="Loading" src="/dist/img/ajax-loader.gif"/>'});
}

/**
 * Unblock the screen
 * 
 * @returns {undefined}
 */
function stopBlocking() {
    $.unblockUI();
}

/**
 * Events for when we refresh basket
 * 
 * @returns {undefined}
 */
function bindBasketEvents() {

    //remove any events we may have bound
    $('.remove-item, #changeToCollection').unbind('click');

    /**
     * When the user clicks the remove item we want to remove it from the order
     */
    $('.remove-item').on('click', function(e) {
        e.preventDefault();
        startBlocking();

        var url = '/ajax/removeItem';

        $.post(url, {item: $(this).data('order-item')}, function(data) {
            if (data.success === true) {
                $('#sidebar-content').html(data.markup);
                $('.order-total').html(data.order_total);
                bindBasketEvents();
            }

        }, 'json').always(function() {
            stopBlocking();
        });
    });

    /**
     * When the user clicks to change to a collection order
     * 
     */
    $('#changeToCollection').on('click', function(e) {
        e.preventDefault();

        //start blocking while we do this
        startBlocking();

        var url = '/ajax/changeToCollection';

        $.post(url, {}, function(data) {
            if (data.success === true) {
                $('#sidebar-content').html(data.markup);
                bindBasketEvents();
            }

        }, 'json').always(function() {
            stopBlocking();
        });
    });

    /**
     * If the user selects a condiment
     */
    $('.condiment').on('click', function(e) {
        e.preventDefault();
        var description = $(this).html();
        var type_id = $(this).parent().data('type');

        //set the description in the header
        $('#condiment-desc-' + type_id).html(description);

        //clear the selection for this condiment type
        $(this).parent().children('.condiment').removeClass('active');

        //set this as the new condiment
        $(this).addClass('active');

        //get the parent - we want to collapse this
        var parent = $(this).closest('div.panel-collapse');
        parent.collapse('toggle');
      //  parent.removeClass('locked');

        //get all panels
        var panels = $('#ItemOptions div.panel-collapse');

        //get the next panel
        var $next = panels.eq(panels.index(parent) + 1);
       $next.removeClass('locked');
        //show the next panel
        $next.collapse('show');

        $(this).closest('.condiment-desc').html('dbjksab');


        $('#type-selection-' + type_id).val($(this).data('id'));
    });

    //when a section is opened
    $('#ItemOptions div.panel-collapse').on('show.bs.collapse', function() {
        //close all others
        $('.panel-collapse').not($(this))
                .collapse('hide');
    });
    
    //when a section is opened
    $('#ItemOptions div.panel-collapse').on('shown.bs.collapse', function() {
        
        if ($(this).hasClass('locked')){
                
                    $(this).collapse('hide');
           
                    
        }
    })
}

$(document).ready(function() {
    /**
     * Showing contact details when a user clicks on the link
     */
    $('#viewContactDetails').on('click', function(e) {
        e.preventDefault();
        $('#viewContactDetailsContainer').hide();
        $('#contactDetails').slideDown('fast');
    });

    /**
     * When the user wants to make a delivery order and we need to display the 
     * postcode inputs
     */
    $('#wantsDelivery').on('click', function(e) {
        e.preventDefault();
        $(this).hide();
        $('#lookupPostcode').removeClass('hidden');
    });

    /**
     * Now we have bound the click event check if we need to click it based on
     * it having a postcode already
     */
    if($('[name="postcode"]').val() != '' && $('#wantsDelivery').length > 0){
        $('#wantsDelivery').click();
    }

    /**
     * When the user searches for a postcode
     */
    $('#searchPostcode').on('click', function(e) {
        e.preventDefault();

        var postcode = $('input[name="postcode"]');

        if (postcode.val().length == 0) {
            addValidationError(postcode, 'Please enter a valid UK postcode');
        } else {
            removeValidationError(postcode);
            startBlocking();
            var data = {'postcode': postcode.val()};
            $.post("/ajax/getDeliveryDetailsForPostcode", data, function(response) {

                if (response.data.success == false) {
                    addValidationError(postcode, response.data.error);
                } else if (response.data.can_deliver == true) {
                    $('#lookupPostcode').addClass('hidden');
                    $('.postcodeContainer').html(response.data.details.postcode);
                    $('.delivery-cost').html(response.data.details.format_cost);
                    $('#postcodeDeliveryDetails').removeClass('hidden');
                    $('#deliveryBtn').removeClass('hidden');
                    $('input[name="delivery_postcode"]').val(response.data.details.postcode);
                } else if (response.data.can_deliver == false) {
                    $('#lookupPostcode').addClass('hidden');
                    $('#unableToDeliver').removeClass('hidden');
                    $('#deliveryDetails').addClass('hidden');
                    $('.postcodeContainer').html(response.data.details.postcode);
                }
            }, 'json').always(function() {
                stopBlocking();
            });
        }
    });

    /**
     * When the user wants to change the postcode they have already entered
     */
    $('.change-postcode').on('click', function(e) {
        e.preventDefault();
        $('#unableToDeliver').addClass('hidden');
        $('#postcodeDeliveryDetails').addClass('hidden');
        $('#deliveryBtn').addClass('hidden');
        $('#lookupPostcode').removeClass('hidden');
        $('#deliveryDetails').removeClass('hidden');
        $('input[name="postcode"]').val('');
    });

    /**
     * When the user adds an item to the basket
     */
    $('.add-item').on('click', function(e) {
        e.preventDefault();
        startBlocking();
        var url = '/ajax/addItem';

        $.post(url, {item: $(this).data('item-id'), section: $(this).data('section'), variation: $(this).data('variation-id')}, function(data) {
            if (data.success === true) {
                $('#sidebar-content').html(data.markup);

                bindBasketEvents();
            }

        }, 'json').always(function() {
            stopBlocking();
        });
    });

    $('.get-item-options').on('click', function(e) {
        e.preventDefault();
        $('#ItemOptions').modal('show');
        startBlocking();

        var url = '/ajax/getItemOptions';
        $.post(url, {item: $(this).data('item-id'), variation: $(this).data('variation-id')}, function(data) {
            if (data.success === true) {
                $('#ItemOptions div.modal-content div.modal-body').html(data.markup);
                $('.order-total').html(data.order_total);
                bindBasketEvents();
            }

        }, 'json').always(function() {
            stopBlocking();
        });


    });





    //bind any events on load
    bindBasketEvents();
});

