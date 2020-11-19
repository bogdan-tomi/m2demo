define(['uiComponent', 'jquery'], function (Component, $) {
    'use strict';

    return Component.extend({
        defaults: {
            title: $.mage.__('Component B'),
            value: 55
        }
    })
});
