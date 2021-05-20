/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
/**
 * dosamigos is the root module for all dosamigos JavaScript modules.
 * It implements a mechanism of organizing JavaScript code in modules through the function "dosamigos.initModule()".
 *
 * Each module should be named as "x.y.z", where "x" stands for the root module (for the Yii core code, this is "yii").
 *
 * A module may be structured as follows:
 *
 * ~~~
 * dosamigos.sample = (function($) {
 *     var pub = {
 *         // whether this module is currently active. If false, init() will not be called for this module
 *         // it will also not be called for all its child modules. If this property is undefined, it means true.
 *         isActive: true,
 *         init: function() {
 *             // ... module initialization code go here ...
 *         },
 *
 *         // ... other public functions and properties go here ...
 *     };
 *
 *     // ... private functions and properties go here ...
 *
 *     return pub;
 * })(jQuery);
 * ~~~
 *
 * Using this structure, you can define public and private functions/properties for a module.
 * Private functions/properties are only visible within the module, while public functions/properties
 * may be accessed outside of the module. For example, you can access "dosamigos.sample.isActive".
 *
 * You must call "dosamigos.initModule()" once for the root module of all your modules.
 *
 * This module also implements some utility methods that are used throughout applications. Current helper methods are:
 *
 * - microtemplating
 * - ensures window.btoa and window.atob provides base64 encoding/decoding methods respectively
 * - Todo: declarative mappings
 */
var dosamigos = (function ($) {
    'use strict';

    var pub = {

        initModule: function (module) {
            if (module.isActive === undefined || module.isActive) {
                if ($.isFunction(module.init)) {
                    module.init();
                }
                $.each(module, function () {
                    if ($.isPlainObject(this)) {
                        pub.initModule(this);
                    }
                });
            }
        },

        init: function () {

        }
    };

    /**
     * Holds cache vars
     * @type {{}}
     */
    var cache = {};

    /**
     * Micro-templating engine
     * http://ejohn.org/blog/javascript-micro-templating/
     * @param str
     * @param data
     * @returns {*}
     */
    pub.tmpl = function (str, data) {
        // Figure out if we're getting a template, or if we need to
        // load the template - and be sure to cache the result.
        var fn = !/\W/.test(str) ?
            cache[str] = cache[str] ||
                tmpl(document.getElementById(str).innerHTML || str) :

            // Generate a reusable function that will serve as a template
            // generator (and which will be cached).
            new Function("obj",
                "var p=[],print=function(){p.push.apply(p,arguments);};" +

                    // Introduce the data as local variables using with(){}
                    "with(obj){p.push('" +

                    // Convert the template into pure JavaScript
                    str
                        .replace(/[\r\t\n]/g, " ")
                        .split("<%").join("\t")
                        .replace(/((^|%>)[^\t]*)'/g, "$1\r")
                        .replace(/\t=(.*?)%>/g, "',$1,'")
                        .split("\t").join("');")
                        .split("%>").join("p.push('")
                        .split("\r").join("\\'")
                    + "');}return p.join('');");

        // Provide some basic currying to the user
        return data ? fn( data ) : fn;
    }

    /**
     * base64 encode/decode compatible with window.btoa/atob. We require this on multiple dosamigos widgets/extensions
     * @type {{}}
     */
    var base64 = {};
    base64.PADCHAR = '=';
    base64.ALPHA = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';

    base64.makeDOMException = (function () {
        "use strict";
        // fabricate a suitable error object
        try {
            document.createElement('$');
        } catch (error) {
            return error;
        }
    }());

    base64.getbyte64 = function(s,i) {
        // This is oddly fast, except on Chrome/V8.
        //  Minimal or no improvement in performance by using a
        //   object with properties mapping chars to value (eg. 'A': 0)
        var idx = base64.ALPHA.indexOf(s.charAt(i));
        if (idx === -1) {
            throw base64.makeDOMException();
        }
        return idx;
    }

    base64.decode = function(s) {
        // convert to string
        s = '' + s;
        var getbyte64 = base64.getbyte64;
        var pads, i, b10;
        var imax = s.length;
        if (imax === 0) {
            return s;
        }

        if (imax % 4 !== 0) {
            throw base64.makeDOMException();
        }

        pads = 0
        if (s.charAt(imax - 1) === base64.PADCHAR) {
            pads = 1;
            if (s.charAt(imax - 2) === base64.PADCHAR) {
                pads = 2;
            }
            // either way, we want to ignore this last block
            imax -= 4;
        }

        var x = [];
        for (i = 0; i < imax; i += 4) {
            b10 = (getbyte64(s,i) << 18) | (getbyte64(s,i+1) << 12) |
                (getbyte64(s,i+2) << 6) | getbyte64(s,i+3);
            x.push(String.fromCharCode(b10 >> 16, (b10 >> 8) & 0xff, b10 & 0xff));
        }

        switch (pads) {
            case 1:
                b10 = (getbyte64(s,i) << 18) | (getbyte64(s,i+1) << 12) | (getbyte64(s,i+2) << 6);
                x.push(String.fromCharCode(b10 >> 16, (b10 >> 8) & 0xff));
                break;
            case 2:
                b10 = (getbyte64(s,i) << 18) | (getbyte64(s,i+1) << 12);
                x.push(String.fromCharCode(b10 >> 16));
                break;
        }
        return x.join('');
    }

    base64.getbyte = function(s,i) {
        var x = s.charCodeAt(i);
        if (x > 255) {
            throw base64.makeDOMException();
        }
        return x;
    }

    base64.encode = function(s) {
        if (arguments.length !== 1) {
            throw new SyntaxError("Not enough arguments");
        }
        var padchar = base64.PADCHAR;
        var alpha   = base64.ALPHA;
        var getbyte = base64.getbyte;

        var i, b10;
        var x = [];

        // convert to string
        s = '' + s;

        var imax = s.length - s.length % 3;

        if (s.length === 0) {
            return s;
        }
        for (i = 0; i < imax; i += 3) {
            b10 = (getbyte(s,i) << 16) | (getbyte(s,i+1) << 8) | getbyte(s,i+2);
            x.push(alpha.charAt(b10 >> 18));
            x.push(alpha.charAt((b10 >> 12) & 0x3F));
            x.push(alpha.charAt((b10 >> 6) & 0x3f));
            x.push(alpha.charAt(b10 & 0x3f));
        }
        switch (s.length - imax) {
            case 1:
                b10 = getbyte(s,i) << 16;
                x.push(alpha.charAt(b10 >> 18) + alpha.charAt((b10 >> 12) & 0x3F) +
                    padchar + padchar);
                break;
            case 2:
                b10 = (getbyte(s,i) << 16) | (getbyte(s,i+1) << 8);
                x.push(alpha.charAt(b10 >> 18) + alpha.charAt((b10 >> 12) & 0x3F) +
                    alpha.charAt((b10 >> 6) & 0x3f) + padchar);
                break;
        }
        return x.join('');
    }

    pub.base64Encode = base64.encode;
    pub.base64Decode = base64.decode;

    window.btoa = window.btoa || pub.base64Encode;
    window.atob = window.atob || pub.base64Decode;

    return pub;

})(jQuery);

jQuery(document).ready(function () {
    dosamigos.initModule(dosamigos);
});