/**
 * Enable the add-item button if there are no more locked elements
 * i.e. all condiments have been selected
 * 
 * @returns {undefined}
 */
function toggleDisabledClass() {
    var lockedElements = $('.selected-condiment').filter(function() {
        return !$(this).val();
    }).length;

    if (lockedElements === 0) {
        $('#add-item').removeClass('disabled');
    } else {
        $('#add-item').addClass('disabled');
    }

    clearValidation();
}

/**
 * Clear all validation classes
 * 
 * @returns {undefined}
 */
function clearValidation() {
    //clear all validation classes
    $('.panel-danger').removeClass('panel-danger');

    //remove the error message
    $('.text-danger').remove();
}

/**
 * Events for when we refresh basket
 * 
 * @returns {undefined}
 */
function bindBasketEvents() {

    //remove any events we may have bound
    $('.remove-item, #changeToCollection, #add-item').unbind('click');

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
        //get the condiment type ID
        var type_id = $(this).parent().data('type');

        //set the description in the header
        $('#condiment-desc-' + type_id).html($(this).html());

        //clear the selection for this condiment type - remove all active classes
        $(this).parent().children('.condiment').removeClass('active');

        //set this as the new condiment - add active class
        $(this).addClass('active');

        //get the parent - we want to collapse this accordion
        var parent = $(this).closest('div.panel-collapse');
        parent.collapse('toggle');

        //now we need to open the next panel
        //get all panels
        var panels = $('#ItemOptions div.panel-collapse');

        //get the next panel
        var nextPanel = panels.eq(panels.index(parent) + 1);

        //remove the locked class from the panel heading link so the user can go back and amend their choice
        nextPanel.siblings('.panel-heading').find('a').removeClass('locked');

        //show the next panel
        nextPanel.collapse('show');

        //update the hidden element with the selected condiment
        $('#selected-condiment-' + type_id).val($(this).data('id'));

        //check whether we can enable the add-item button
        toggleDisabledClass();

        bindBasketEvents();
    });

    //when a section is opened
    $('#ItemOptions div.panel-collapse').on('show.bs.collapse', function(e) {
        //close all others
        $('#ItemOptions div.panel-collapse').not($(this))
                .collapse('hide');
    });

    //when the user attempts to open a locked section
    $('.panel-heading a').on('click', function(e) {
        //if it has a class of locked stop the accordion opening
        if ($(this).hasClass('locked')) {
            e.stopPropagation();
        }
    });

    /**
     * If the add-item button is disabled, show a validation error
     */
    $('#add-item.disabled').on('click', function(e) {
        clearValidation();
        
        var error = '<p class="text-danger">Please make a selection for each condiment type</p>';
        $('.modal-body').append(error);

        //for each unselected condiment, add the validation error class
        $('.selected-condiment').filter(function() {
            return !$(this).val();
        }).each(function(index) {
            $(this).closest('.panel').addClass('panel-danger');
        });
    });

    /**
     * When the user adds an item to the basket
     */
    $('#add-item').not(".disabled").on('click', function(e) {
        e.preventDefault();
        //close the modal
        $('#ItemOptions').modal('hide');

        var url = '/ajax/addItem';
        var data = $("#ItemOptionsForm").serialize();

        $.post(url, data, function(data) {
            if (data.success === true) {
                //update the sidebar with the latest sidebar content
                $('#sidebar-content').html(data.markup);

                //update the order total
                $('.order-total').html(data.order_total);

                //bind the dynamically added elements
                bindBasketEvents();
            }

        }, 'json').always(function() {
            stopBlocking();

        });
    });
}

$(document).ready(function() {   
    //when the user selects an item to add
    $('.get-item-options').on('click', function(e) {
        e.preventDefault();
        //startBlocking();

        var url = '/ajax/getItemOptions';
        $.post(url, {item: $(this).data('item-id'), variation: $(this).data('variation-id')}, function(data) {
            if (data.success === true) {
                //populate the modal body with the item options markup
                $('#ItemOptions div.modal-content div.modal-body').html(data.markup);

                toggleDisabledClass();

                //show the modal as it now has the content
                $('#ItemOptions').modal('show');
                //bind the dynamically added elements
                bindBasketEvents();
            }

        }, 'json').always(function() {

        });
    });

    //bind any events on load
    bindBasketEvents();
});

