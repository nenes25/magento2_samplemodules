define(['jquery'], function($) {
    'use strict';
    return function() {
        $.validator.addMethod(
            'validate-five-words',
            function(value, element) {
                return value.split(' ').length == 5;
            },
            $.mage.__('Please enter exactly five words')
        );
        $.validator.addMethod(
            'validate-herve',
            function(value, element) {
                return value == 'herve';
            },
            $.mage.__('Please enter exactly herve')
        );
    }
});
