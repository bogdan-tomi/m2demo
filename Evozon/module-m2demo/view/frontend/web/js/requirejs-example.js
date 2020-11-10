define(function(){
    'use strict';

    return function (config, element) {
        console.log('Evozon -> Loaded via RequireJS AMD module function', config);
        element.innerHTML = 'text added from AMD module with JS';
    }
})
