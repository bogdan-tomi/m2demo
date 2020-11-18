define(['uiElement'], function (UiElement) {
    'use strict';

    return UiElement.extend({
        defaults: {
            imports: {
                value: "root.sharedState:value"
            },
            value: 0,
            tracks: {
                value: true
            }
        }
    })
});
