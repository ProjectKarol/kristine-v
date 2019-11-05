jQuery(function() {

    jQuery('#pwgc-balance-search-form').on('submit', function(e) {
        pwgcAdminBalanceSearch();

        e.preventDefault();
        return false;
    });

    if (jQuery('#pwgc-balance-search').val()) {
        pwgcAdminBalanceSearch();
    }

    jQuery('#pwgc-save-settings-form').on('submit', function(e) {
        var messageContainer = jQuery('#pwgc-save-settings-message');
        var saveButton = jQuery('#pwgc-save-settings-button');
        var form = jQuery('#pwgc-save-settings-form').serialize();

        saveButton.hide();
        messageContainer.html('<i class="fas fa-cog fa-spin fa-3x"></i>');

        jQuery.post(ajaxurl, {'action': 'pw-gift-cards-save_settings', 'form': form, 'security': pwgc.nonces.save_settings }, function(result) {
            saveButton.show();
            messageContainer.html(result.data.html);
        }).fail(function(xhr, textStatus, errorThrown) {
            saveButton.show();
            if (errorThrown) {
                messageContainer.html(errorThrown);
            } else {
                messageContainer.text('Unknown ajax error');
            }
        });

        e.preventDefault();
        return false;
    });

    jQuery('#pwgc-setup-create-product').click(function(e) {
        var button = jQuery(this);
        button.html('<i class="fas fa-cog fa-spin"></i>');

        jQuery.post(ajaxurl, {'action': 'pw-gift-cards-create_product', 'security': pwgc.nonces.create_product }, function(result) {
            if (result.success) {
                button.hide();
                jQuery('#pwgc-setup-create-product-success').show();
            } else {
                button.text(button.attr('data-text'));
                jQuery('#pwgc-setup-error').text('Unknown error');
            }
        }).fail(function(xhr, textStatus, errorThrown) {
            button.text(button.attr('data-text'));
            if (errorThrown) {
                jQuery('#pwgc-setup-error').text(errorThrown);
            } else {
                jQuery('#pwgc-setup-error').text('Unknown ajax error');
            }
        });

        e.preventDefault();
        return false;
    });

    jQuery('.pwgc-dashboard-item').click(function(e) {
        jQuery('.pwgc-dashboard-item').removeClass('pwgc-dashboard-item-selected');
        jQuery(this).addClass('pwgc-dashboard-item-selected');
        var section = jQuery(this).attr('data-section');
        jQuery('.pwgc-section').hide();
        jQuery('#pwgc-section-' + section).show();
    });
});

function pwgcAdminLoadBalanceSummary() {
    var balanceSummary = jQuery('#pwgc-balance-summary-container');

    jQuery.post(ajaxurl, {'action': 'pw-gift-cards-balance_summary', 'security': pwgc.nonces.balance_summary}, function(result) {
        balanceSummary.html(result);
    }).fail(function(xhr, textStatus, errorThrown) {
        if (errorThrown) {
            balanceSummary.html(errorThrown);
        } else {
            balanceSummary.html('Unknown Error');
        }
    });
}

function pwgcAdminBalanceSearch() {
    jQuery('#pwgc-balance-search-results,#pwgc-balance-card-activity').text('');
    jQuery('#pwgc-balance-search-results').html('<i class="fas fa-cog fa-spin fa-3x"></i>');

    var searchTerms = jQuery('#pwgc-balance-search');

    jQuery.post(ajaxurl, {'action': 'pw-gift-cards-search', 'search_terms': searchTerms.val(), 'security': pwgc.nonces.search}, function(result) {
        jQuery('#pwgc-balance-search-results').html(result.html);
        searchTerms.focus();
    }).fail(function(xhr, textStatus, errorThrown) {
        if (errorThrown) {
            alert(errorThrown);
        } else {
            alert('Unknown Error');
        }
        searchTerms.focus();
    });
}

function pwgcAdminGiftCardActivityLoadStart(row) {
    var buttonCell = row.find('.pwgc-search-result-buttons').first();
    var activity = buttonCell.find('.pwgc-balance-activity-container');
    if (activity.length == 0) {
        activity = jQuery('<div class="pwgc-balance-activity-container"></div>').appendTo(buttonCell);
    }
    activity.html('<i class="fas fa-cog fa-spin fa-2x"></i>');
}

function pwgcAdminGiftCardActivity(row) {
    pwgcAdminGiftCardActivityLoadStart(row);

    var cardNumber = row.attr('data-gift-card-number');
    var buttonCell = row.find('.pwgc-search-result-buttons').first();
    var activity = buttonCell.find('.pwgc-balance-activity-container');

    jQuery.post(ajaxurl, {'action': 'pw-gift-cards-view_activity', 'card_number': cardNumber, 'security': pwgc.nonces.view_activity}, function(result) {
        activity.html(result.html);

        jQuery('.pwgc-balance-activity-hide-button').off('click').on('click', function(e) {
            jQuery(this).closest('.pwgc-balance-activity-container').remove();
            e.preventDefault();
            return false;
        });
    }).fail(function(xhr, textStatus, errorThrown) {
        if (errorThrown) {
            alert(errorThrown);
        } else {
            alert('Unknown Error');
        }
    });
}

function pwgcDelete(row) {
    var cardNumber = row.attr('data-gift-card-number');

    jQuery.post(ajaxurl, {'action': 'pw-gift-cards-delete', 'card_number': cardNumber, 'security': pwgc.nonces.delete}, function(result) {
        row.find('.pwgc-buttons-inactive, .pwgc-inactive-card').removeClass('pwgc-hidden');
        row.find('.pwgc-buttons-active').addClass('pwgc-hidden');
        pwgcAdminLoadBalanceSummary();
    }).fail(function(xhr, textStatus, errorThrown) {
        if (errorThrown) {
            alert(errorThrown);
        } else {
            alert('Unknown ajax error');
        }
    });
}

function pwgcRestore(row) {
    var cardNumber = row.attr('data-gift-card-number');

    jQuery.post(ajaxurl, {'action': 'pw-gift-cards-restore', 'card_number': cardNumber, 'security': pwgc.nonces.restore}, function(result) {
        row.find('.pwgc-buttons-inactive, .pwgc-inactive-card').addClass('pwgc-hidden');
        row.find('.pwgc-buttons-active').removeClass('pwgc-hidden');
        pwgcAdminLoadBalanceSummary();
    }).fail(function(xhr, textStatus, errorThrown) {
        if (errorThrown) {
            alert(errorThrown);
        } else {
            alert('Unknown ajax error');
        }
    });
}
