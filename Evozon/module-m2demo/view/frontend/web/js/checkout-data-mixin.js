define([], function () {
    'use strict';

    // the received parameter is the returned object from the RequireJS module we are customizing
    return function (checkoutData) {
        const orig = checkoutData.getSelectedShippingRate;
        checkoutData.getSelectedShippingRate = function () {
            // call the original method and keep the original object context intact by using bind()
            const shippingRate = orig.bind(checkoutData)();
            alert('that is a nice shipping rate!');
            return shippingRate;
        };
        return checkoutData;
    };
});
