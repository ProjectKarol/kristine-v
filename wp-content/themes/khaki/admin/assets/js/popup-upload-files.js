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
/******/ 	return __webpack_require__(__webpack_require__.s = 18);
/******/ })
/************************************************************************/
/******/ ({

/***/ 18:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(19);


/***/ }),

/***/ 19:
/***/ (function(module, exports) {

jQuery(function ($) {

  // Set all variables to be used in scope
  // ADD IMAGE LINK
  $(document).on('click', '.khaki-menu-bg-image .upload-custom-img', function (event) {
    event.preventDefault();
    var metaBox = $(this).parents('.khaki-menu-bg-image:eq(0)'); // Your meta box id here
    var addImgLink = metaBox.find('.upload-custom-img');
    var delImgLink = metaBox.find('.delete-custom-img');
    var imgContainer = metaBox.find('.custom-img-container');
    var imgIdInput = metaBox.find('.custom-img-id');

    // Create a new media frame
    var frame = wp.media({
      title: 'Select or Upload Media Of Your Chosen Persuasion',
      button: {
        text: 'Use this media'
      },
      multiple: false // Set to true to allow multiple files to be selected
    });

    // When an image is selected in the media frame...
    frame.on('select', function () {

      // Get media attachment details from the frame state
      var attachment = frame.state().get('selection').first().toJSON();

      // Send the attachment URL to our custom image input field.
      imgContainer.append('<img src="' + attachment.url + '" alt="" style="max-width:100%;"/>');

      // Send the attachment id to our hidden input
      imgIdInput.val(attachment.id);

      // Hide the add image link
      addImgLink.addClass('hidden');

      // Unhide the remove image link
      delImgLink.removeClass('hidden');
    });

    // Finally, open the modal on click
    frame.open();
  });

  // DELETE IMAGE LINK

  $(document).on('click', '.khaki-menu-bg-image .delete-custom-img', function (event) {

    event.preventDefault();
    var metaBox = $(this).parents('.khaki-menu-bg-image:eq(0)'); // Your meta box id here
    var addImgLink = metaBox.find('.upload-custom-img');
    var delImgLink = metaBox.find('.delete-custom-img');
    var imgContainer = metaBox.find('.custom-img-container');
    var imgIdInput = metaBox.find('.custom-img-id');

    // Clear out the preview image
    imgContainer.html('');

    // Un-hide the add image link
    addImgLink.removeClass('hidden');

    // Hide the delete image link
    delImgLink.addClass('hidden');

    // Delete the image id from the hidden input
    imgIdInput.val('');
  });
});

/***/ })

/******/ });