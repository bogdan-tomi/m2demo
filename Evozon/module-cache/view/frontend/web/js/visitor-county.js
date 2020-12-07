define(['jquery'], function ($) {
    'use strict';

    const key = 'evozon-cache-visitor-county';

    return function (config, element) {
        if (window.sessionStorage.getItem(key)) {
            element.innerHTML = window.sessionStorage.getItem(key);
        } else {
            $.get({
                url: '/evozon-visitor-county/block',
                cache: true,
                success: function (result) {
                    window.sessionStorage.setItem(key, result);
                    element.innerHTML = result;
                }
            });
        }
    }
});
