// we can use jquery dependency, but variable name NEEDS to be $ or jQuery
// $.mage.__('string') jQuery.mage.__('string')

// or use mage/translate dependency, and just $t('string')

// also, the translated string cannot be used inside a variable, it HAS to be inline
define(['uiComponent', 'mage/translate'], function (Component, $t) {
    'use strict';

    return Component.extend({
        defaults: {
            label: $t('Component A'),
            amount: 12,
            tracks: {
                amount: true // make amount observable
            },
            imports: {
                // template strings with template placeholders (placeholders are not keywords, can be replaced)
                // amount: 'component-b:value'
                // amount: '${ $.provider }:value'
                amount: '${ $.provider }:${ $.providerProperty }'
            }
        }
    })
});
