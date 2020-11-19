define(['uiComponent', 'Evozon_Secondary/js/ko-binding/pixelbg'], function (Component, pixelbackground) {
    'use strict';

    return Component.extend({
        defaults: {
            pixelGivenSize: 30,
            tracks: {
                pixelGivenSize: true
            }
        }
    })
});
