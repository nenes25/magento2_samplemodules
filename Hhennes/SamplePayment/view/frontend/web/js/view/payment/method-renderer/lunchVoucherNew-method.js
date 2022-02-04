define(
    [
        'Magento_Checkout/js/view/payment/default'
    ], function (Component) {
        'use strict';
        console.log('RENDERER NEW GET CALLED ?');
        return Component.extend({
            defaults: {
                template: 'Hhennes_SamplePayment/payment/lunchVoucherNew'
            },
        });
    });
