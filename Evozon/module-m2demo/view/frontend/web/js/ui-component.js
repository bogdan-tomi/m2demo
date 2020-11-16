define(['uiElement'], function (UiElement) {
    'use strict';

    return UiElement.extend({
        // defaults can be used to set specific default values
        defaults: {
            label: "My first defaults UiComponent! (1)"
        },
        label: "My first UiComponent!"
    })
});
