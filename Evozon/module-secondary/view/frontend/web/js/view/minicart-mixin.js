define([], function () {
    'use strict';

    return function (Minicart) {
        return Minicart.extend({
            update: function (updatedCart) {
                console.log('Evozon -> Minicart Mixin for cart update');
                console.log(updatedCart);
                return this._super(updatedCart);
            }
        });
    }
});
