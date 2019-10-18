'use strict';

/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 14);
/******/ })
/************************************************************************/
/******/ ({

/***/ 14:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(15);


/***/ }),

/***/ 15:
/***/ (function(module, exports) {

/**
 * attach_video VC control
 */
;(function ($) {
    $('#vc_ui-panel-edit-element').on('click', '.awb_attach_audio_btn', function (e) {
        e.preventDefault();
        var $this = $(this);
        var $input = $this.prev('.awb_attach_audio').children('input');
        var $label = $this.next('.awb_attach_audio_label');
        var frame = $this.data('wp-frame');

        // if selected - remove
        if ($this.hasClass('awb_attach_audio_btn_selected')) {
            $input.val('');
            $label.html('');
            $this.html($this.attr('data-select-title'));
            $this.removeClass('awb_attach_audio_btn_selected');
            return;
        }

        // If the media frame already exists, reopen it.
        if (frame) {
            frame.open();
            return;
        }

        if (!wp.media) {
            console.error('Can not access wp.media object.');
            return;
        }

        // Create a new media frame
        frame = wp.media({
            title: 'Select or Upload Audio',
            button: {
                text: 'Use this audio'
            },
            multiple: false,
            library: {
                type: 'audio'
            }
        });
        $this.data('wp-frame', frame);

        // When an video is selected in the media frame...
        frame.on('select', function () {
            // Get media attachment details from the frame state
            var attachment = frame.state().get('selection').first().toJSON();

            if (attachment) {
                console.log(attachment);
                $input.val(attachment.id);
                $label.html(attachment.filename);
                $this.html($this.attr('data-remove-title'));
                $this.addClass('awb_attach_audio_btn_selected');
            }
        });

        // Finally, open the modal on click
        frame.open();
    });
})(jQuery);

/***/ })

/******/ });