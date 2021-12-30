define(['jquery'], function($) {
    'use strict';
    return function() {
        console.log('validator added');
        $.validator.addMethod(
            'validate-custom-postcode-fr',
            function(value) {
                return $.mage.isEmptyNoTrim(value) || /^[0-9]{5,6}$/.test(value);
            },
            $.mage.__('Please enter a valid french postcode.')
        );
    }
});
