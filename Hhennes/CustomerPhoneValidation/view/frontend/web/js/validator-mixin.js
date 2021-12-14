define([
    'jquery',
], function ($) {
    'use strict';
    return function (validator) {
        validator.addRule(
            'validate-custom-phone',
            function (value, params, additionalParams) {
                return $.mage.isEmptyNoTrim(value) || /^0[1-9][0-9]{8}$/.test(value);
            },
            $.mage.__('Please enter a valid french phone number.')
        );
        return validator;
    };
});
