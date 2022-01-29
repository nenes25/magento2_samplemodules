define([
    'uiComponent',
    'Magento_Checkout/js/model/payment/renderer-list'
], function (Component, rendererList) {
    'use strict';
    rendererList.push({
        type: 'lunchvoucher', //Beware the type here must match the declared component name (case sensitive) in checkout_index_index.xml <item name="lunchvoucher" xsi:type="array">
        component: 'Hhennes_SamplePayment/js/view/payment/method-renderer/lunchVoucher-method'
    });
    console.log('Hhennes_SamplePayment/js/view/payment/method-renderer/lunchvoucher-method');
    return Component.extend({});
});
