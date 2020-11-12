define(['jquery'], function ($) {
    'use strict';

    // RequireJS modules always return a function, which receives the return value of the target module,
    // in this case the password strength indicator constructor
    return function (passwordStrengthIndicator) {
        // redeclare the widget in order to override it, passing the original constructor function as the basis to extend from
        $.widget('mage.passwordStrengthIndicator', passwordStrengthIndicator, {
            _displayStrength: function (displayScore) {
                // alert the user for a very strong password
                if (displayScore === 4) {
                    alert('woah');
                }
                // this calls the original function (remember to pass any received parameters)
                return this._super(displayScore);
            }
        });

        // we cannot return the passwordStrengthIndicator, because that is a reference to the old constructor,
        // we need to return a reference to the new constructor function
        return $.mage.passwordStrengthIndicator;
    };
});
