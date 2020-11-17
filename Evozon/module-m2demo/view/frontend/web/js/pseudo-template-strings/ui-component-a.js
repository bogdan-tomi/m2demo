define(['uiComponent'], function (Component) {
    'use strict';

    return Component.extend({
        defaults: {
            label: 'Component A',
            amount: 12,
            tracks: {
                amount: true // make amount observable
            },
            imports: {
                // template strings with template placeholders
                // amount: 'component-b:value'
                // amount: '${ $.provider }:value'
                amount: '${ $.provider }:${ $.providerProperty }'
            }
        }
    })
});
