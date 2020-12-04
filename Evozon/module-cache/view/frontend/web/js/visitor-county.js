define(['jquery'], function ($) {
    'use strict';

    return function (config, element) {
        $.get('/evozon-visitor-county/block', function (result) {
            element.innerHTML = result;
        })
    }
});
