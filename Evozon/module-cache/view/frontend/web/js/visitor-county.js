define(['jquery'], function ($) {
    'use strict';

    return function (config, element) {
        $.get({
            url: '/evozon-visitor-county/block',
            cache: true,
            success: function (result) {
                element.innerHTML = result;
            }
        });
    }
});
