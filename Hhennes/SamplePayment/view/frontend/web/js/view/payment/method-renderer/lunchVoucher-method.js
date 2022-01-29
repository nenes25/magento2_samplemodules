define(
    [
        'Magento_Checkout/js/view/payment/default'
    ], function (Component) {
        'use strict';
        console.log('RENDERER GET CALLED');
        return Component.extend({
            defaults: {
                template: 'Hhennes_SamplePayment/payment/lunchVoucher'
            },
            /*getMailingAddress: function () {
                return window.checkoutConfig.payment.checkmo.mailingAddress;
            }, /!** Returns payable to info *!/
            getPayableTo: function () {
                return window.checkoutConfig.payment.checkmo.payableTo;
            },
            isActive: function (){
                console.log('LUNCH VOUCHER CALLED BUT NOT DISPLAYED');
                return true;
            }*/
        });
    });
