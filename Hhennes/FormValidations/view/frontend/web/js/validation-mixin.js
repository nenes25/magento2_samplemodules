define(['jquery'], function($) {
    'use strict';
    return function() {
        console.log('add rule 5 words');
        $.validator.addMethod(
            'validate-five-words',
            function(value, element) {
                return value.split(' ').length == 5;
            },
            $.mage.__('Please enter exactly five words')
        )
    }
});
