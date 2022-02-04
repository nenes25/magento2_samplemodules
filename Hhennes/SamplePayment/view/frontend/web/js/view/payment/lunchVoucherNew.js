define([
    'uiComponent',
    'Magento_Checkout/js/model/payment/renderer-list'
], function (Component, rendererList) {
    'use strict';
    rendererList.push({
        type: 'lunchvouchernew', //Beware the type here must match the declared component name (case sensitive) in checkout_index_index.xml <item name="lunchvoucher" xsi:type="array">
        component: 'Hhennes_SamplePayment/js/view/payment/method-renderer/lunchVoucherNew-method'
    });
    console.log('Hhennes_SamplePayment/js/view/payment/method-renderer/lunchVoucherNew-method');
    console.log('COMPONENT NEW IS CALLED ?');
    console.log(Component,rendererList);
    return Component.extend({});
});
