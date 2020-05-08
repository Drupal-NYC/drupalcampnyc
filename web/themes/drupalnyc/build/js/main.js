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
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
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
/******/ 	__webpack_require__.p = "/themes/drupalnyc/build/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./assets/js/main.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./assets/images/plussign.svg":
/*!************************************!*\
  !*** ./assets/images/plussign.svg ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "/themes/drupalnyc/build/images/plussign.93d567d7.svg";

/***/ }),

/***/ "./assets/js/main.js":
/*!***************************!*\
  !*** ./assets/js/main.js ***!
  \***************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
 // images are loaded here, so they get preprocessed by webpack.

var images = [__webpack_require__(/*! ../images/plussign.svg */ "./assets/images/plussign.svg")];

(function ($) {
  Drupal.behaviors.onLoad = {
    onLoad: function (context, settings) {
      // on scroll fade small logo in menu
      if ($('body').hasClass('path-frontpage')) {
        $(document).scroll(function () {
          var pageHeader = $(".page--header");
          var offsetTop = $('.js-content--header').offset().top;
          var pageHeaderFadedIn = pageHeader.hasClass("fade-in");

          if (offsetTop <= $(document).scrollTop() && !pageHeaderFadedIn) {
            pageHeader.addClass('fade-in');
          } else if (offsetTop > $(document).scrollTop() && pageHeaderFadedIn) {
            pageHeader.removeClass('fade-in');
          }
        });
      }

      $('.superhero--view-mode-volunteer-profile', context).find('.field--name-field-u-volunteer-about').before("<div class='expand'><span>" + Drupal.t('Read more') + "</span></div>");
      $('.expand').click(function (el) {
        var $parent = $($(el.target).parents('.superhero--prosa'));
        $parent.addClass('show-more');
        $(el.target).remove();
      }); // add wrapper on users data

      $('.people .field--name-field-u-first-name').parent().addClass('main-data-wrapper');
      var users = $('.superhero');
      users.each(function (index, item) {
        if ($(item).find('img').length === 0) {
          $(item).find('.superhero--profile').prepend('<img src="/themes/drupalnyc/user-placeholder.png"/>');
        }
      });
    }(),
    clickEvents: function () {
      var mainMenu = $('.menu--main');
      $(".hamburger").click(function () {
        if (mainMenu.hasClass('open')) {
          mainMenu.removeClass('open');
          $('main').removeClass('mobile-menu-opened');
        } else {
          mainMenu.addClass('open');
          $('main').addClass('mobile-menu-opened');
        }
      });
    }()
  };
  Drupal.behaviors.ticketing = {
    attach: function attach(context, settings) {
      // Set donation to checked once value is changed for donation amount.
      $('input[name="price_2"]').change(function () {
        $('input[name="item_2"]').prop('checked', true);
      });
    }
  };
})(jQuery);

/***/ })

/******/ });
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vd2VicGFjay9ib290c3RyYXAiLCJ3ZWJwYWNrOi8vLy4vYXNzZXRzL2ltYWdlcy9wbHVzc2lnbi5zdmciLCJ3ZWJwYWNrOi8vLy4vYXNzZXRzL2pzL21haW4uanMiXSwibmFtZXMiOlsiaW1hZ2VzIiwicmVxdWlyZSIsIiQiLCJEcnVwYWwiLCJiZWhhdmlvcnMiLCJvbkxvYWQiLCJjb250ZXh0Iiwic2V0dGluZ3MiLCJoYXNDbGFzcyIsImRvY3VtZW50Iiwic2Nyb2xsIiwicGFnZUhlYWRlciIsIm9mZnNldFRvcCIsIm9mZnNldCIsInRvcCIsInBhZ2VIZWFkZXJGYWRlZEluIiwic2Nyb2xsVG9wIiwiYWRkQ2xhc3MiLCJyZW1vdmVDbGFzcyIsImZpbmQiLCJiZWZvcmUiLCJ0IiwiY2xpY2siLCJlbCIsIiRwYXJlbnQiLCJ0YXJnZXQiLCJwYXJlbnRzIiwicmVtb3ZlIiwicGFyZW50IiwidXNlcnMiLCJlYWNoIiwiaW5kZXgiLCJpdGVtIiwibGVuZ3RoIiwicHJlcGVuZCIsImNsaWNrRXZlbnRzIiwibWFpbk1lbnUiLCJ0aWNrZXRpbmciLCJhdHRhY2giLCJjaGFuZ2UiLCJwcm9wIiwialF1ZXJ5Il0sIm1hcHBpbmdzIjoiO1FBQUE7UUFDQTs7UUFFQTtRQUNBOztRQUVBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBOztRQUVBO1FBQ0E7O1FBRUE7UUFDQTs7UUFFQTtRQUNBO1FBQ0E7OztRQUdBO1FBQ0E7O1FBRUE7UUFDQTs7UUFFQTtRQUNBO1FBQ0E7UUFDQSwwQ0FBMEMsZ0NBQWdDO1FBQzFFO1FBQ0E7O1FBRUE7UUFDQTtRQUNBO1FBQ0Esd0RBQXdELGtCQUFrQjtRQUMxRTtRQUNBLGlEQUFpRCxjQUFjO1FBQy9EOztRQUVBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQSx5Q0FBeUMsaUNBQWlDO1FBQzFFLGdIQUFnSCxtQkFBbUIsRUFBRTtR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LENBQUM1QixRQUFULENBQWtCLE1BQWxCLENBQUgsRUFBOEI7QUFDMUI0QixrQkFBUSxDQUFDbEIsV0FBVCxDQUFxQixNQUFyQjtBQUNBaEIsV0FBQyxDQUFDLE1BQUQsQ0FBRCxDQUFVZ0IsV0FBVixDQUFzQixvQkFBdEI7QUFDSCxTQUhELE1BSUs7QUFDRGtCLGtCQUFRLENBQUNuQixRQUFULENBQWtCLE1BQWxCO0FBQ0FmLFdBQUMsQ0FBQyxNQUFELENBQUQsQ0FBVWUsUUFBVixDQUFtQixvQkFBbkI7QUFDSDtBQUNKLE9BVEQ7QUFVSCxLQVpZO0FBekNTLEdBQTFCO0FBd0RBZCxRQUFNLENBQUNDLFNBQVAsQ0FBaUJpQyxTQUFqQixHQUE2QjtBQUMzQkMsVUFBTSxFQUFFLGdCQUFTaEMsT0FBVCxFQUFrQkMsUUFBbEIsRUFBNEI7QUFDbEM7QUFDQUwsT0FBQyxDQUFDLHVCQUFELENBQUQsQ0FBMkJxQyxNQUEzQixDQUFrQyxZQUFXO0FBQzNDckMsU0FBQyxDQUFDLHNCQUFELENBQUQsQ0FBMEJzQyxJQUExQixDQUErQixTQUEvQixFQUEwQyxJQUExQztBQUNELE9BRkQ7QUFHRDtBQU4wQixHQUE3QjtBQVFILENBakVELEVBaUVHQyxNQWpFSCxFIiwiZmlsZSI6ImpzL21haW4uanMiLCJzb3VyY2VzQ29udGVudCI6WyIgXHQvLyBUaGUgbW9kdWxlIGNhY2hlXG4gXHR2YXIgaW5zdGFsbGVkTW9kdWxlcyA9IHt9O1xuXG4gXHQvLyBUaGUgcmVxdWlyZSBmdW5jdGlvblxuIFx0ZnVuY3Rpb24gX193ZWJwYWNrX3JlcXVpcmVfXyhtb2R1bGVJZCkge1xuXG4gXHRcdC8vIENoZWNrIGlmIG1vZHVsZSBpcyBpbiBjYWNoZVxuIFx0XHRpZihpbnN0YWxsZWRNb2R1bGVzW21vZHVsZUlkXSkge1xuIFx0XHRcdHJldHVybiBpbnN0YWxsZWRNb2R1bGVzW21vZHVsZUlkXS5leHBvcnRzO1xuIFx0XHR9XG4gXHRcdC8vIENyZWF0ZSBhIG5ldyBtb2R1bGUgKGFuZCBwdXQgaXQgaW50byB0aGUgY2FjaGUpXG4gXHRcdHZhciBtb2R1bGUgPSBpbnN0YWxsZWRNb2R1bGVzW21vZHVsZUlkXSA9IHtcbiBcdFx0XHRpOiBtb2R1bGVJZCxcbiBcdFx0XHRsOiBmYWxzZSxcbiBcdFx0XHRleHBvcnRzOiB7fVxuIFx0XHR9O1xuXG4gXHRcdC8vIEV4ZWN1dGUgdGhlIG1vZHVsZSBmdW5jdGlvblxuIFx0XHRtb2R1bGVzW21vZHVsZUlkXS5jYWxsKG1vZHVsZS5leHBvcnRzLCBtb2R1bGUsIG1vZHVsZS5leHBvcnRzLCBfX3dlYnBhY2tfcmVxdWlyZV9fKTtcblxuIFx0XHQvLyBGbGFnIHRoZSBtb2R1bGUgYXMgbG9hZGVkXG4gXHRcdG1vZHVsZS5sID0gdHJ1ZTtcblxuIFx0XHQvLyBSZXR1cm4gdGhlIGV4cG9ydHMgb2YgdGhlIG1vZHVsZVxuIFx0XHRyZXR1cm4gbW9kdWxlLmV4cG9ydHM7XG4gXHR9XG5cblxuIFx0Ly8gZXhwb3NlIHRoZSBtb2R1bGVzIG9iamVjdCAoX193ZWJwYWNrX21vZHVsZXNfXylcbiBcdF9fd2VicGFja19yZXF1aXJlX18ubSA9IG1vZHVsZXM7XG5cbiBcdC8vIGV4cG9zZSB0aGUgbW9kdWxlIGNhY2hlXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLmMgPSBpbnN0YWxsZWRNb2R1bGVzO1xuXG4gXHQvLyBkZWZpbmUgZ2V0dGVyIGZ1bmN0aW9uIGZvciBoYXJtb255IGV4cG9ydHNcbiBcdF9fd2VicGFja19yZXF1aXJlX18uZCA9IGZ1bmN0aW9uKGV4cG9ydHMsIG5hbWUsIGdldHRlcikge1xuIFx0XHRpZighX193ZWJwYWNrX3JlcXVpcmVfXy5vKGV4cG9ydHMsIG5hbWUpKSB7XG4gXHRcdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsIG5hbWUsIHsgZW51bWVyYWJsZTogdHJ1ZSwgZ2V0OiBnZXR0ZXIgfSk7XG4gXHRcdH1cbiBcdH07XG5cbiBcdC8vIGRlZmluZSBfX2VzTW9kdWxlIG9uIGV4cG9ydHNcbiBcdF9fd2VicGFja19yZXF1aXJlX18uciA9IGZ1bmN0aW9uKGV4cG9ydHMpIHtcbiBcdFx0aWYodHlwZW9mIFN5bWJvbCAhPT0gJ3VuZGVmaW5lZCcgJiYgU3ltYm9sLnRvU3RyaW5nVGFnKSB7XG4gXHRcdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsIFN5bWJvbC50b1N0cmluZ1RhZywgeyB2YWx1ZTogJ01vZHVsZScgfSk7XG4gXHRcdH1cbiBcdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsICdfX2VzTW9kdWxlJywgeyB2YWx1ZTogdHJ1ZSB9KTtcbiBcdH07XG5cbiBcdC8vIGNyZWF0ZSBhIGZha2UgbmFtZXNwYWNlIG9iamVjdFxuIFx0Ly8gbW9kZSAmIDE6IHZhbHVlIGlzIGEgbW9kdWxlIGlkLCByZXF1aXJlIGl0XG4gXHQvLyBtb2RlICYgMjogbWVyZ2UgYWxsIHByb3BlcnRpZXMgb2YgdmFsdWUgaW50byB0aGUgbnNcbiBcdC8vIG1vZGUgJiA0OiByZXR1cm4gdmFsdWUgd2hlbiBhbHJlYWR5IG5zIG9iamVjdFxuIFx0Ly8gbW9kZSAmIDh8MTogYmVoYXZlIGxpa2UgcmVxdWlyZVxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy50ID0gZnVuY3Rpb24odmFsdWUsIG1vZGUpIHtcbiBcdFx0aWYobW9kZSAmIDEpIHZhbHVlID0gX193ZWJwYWNrX3JlcXVpcmVfXyh2YWx1ZSk7XG4gXHRcdGlmKG1vZGUgJiA4KSByZXR1cm4gdmFsdWU7XG4gXHRcdGlmKChtb2RlICYgNCkgJiYgdHlwZW9mIHZhbHVlID09PSAnb2JqZWN0JyAmJiB2YWx1ZSAmJiB2YWx1ZS5fX2VzTW9kdWxlKSByZXR1cm4gdmFsdWU7XG4gXHRcdHZhciBucyA9IE9iamVjdC5jcmVhdGUobnVsbCk7XG4gXHRcdF9fd2VicGFja19yZXF1aXJlX18ucihucyk7XG4gXHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShucywgJ2RlZmF1bHQnLCB7IGVudW1lcmFibGU6IHRydWUsIHZhbHVlOiB2YWx1ZSB9KTtcbiBcdFx0aWYobW9kZSAmIDIgJiYgdHlwZW9mIHZhbHVlICE9ICdzdHJpbmcnKSBmb3IodmFyIGtleSBpbiB2YWx1ZSkgX193ZWJwYWNrX3JlcXVpcmVfXy5kKG5zLCBrZXksIGZ1bmN0aW9uKGtleSkgeyByZXR1cm4gdmFsdWVba2V5XTsgfS5iaW5kKG51bGwsIGtleSkpO1xuIFx0XHRyZXR1cm4gbnM7XG4gXHR9O1xuXG4gXHQvLyBnZXREZWZhdWx0RXhwb3J0IGZ1bmN0aW9uIGZvciBjb21wYXRpYmlsaXR5IHdpdGggbm9uLWhhcm1vbnkgbW9kdWxlc1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5uID0gZnVuY3Rpb24obW9kdWxlKSB7XG4gXHRcdHZhciBnZXR0ZXIgPSBtb2R1bGUgJiYgbW9kdWxlLl9fZXNNb2R1bGUgP1xuIFx0XHRcdGZ1bmN0aW9uIGdldERlZmF1bHQoKSB7IHJldHVybiBtb2R1bGVbJ2RlZmF1bHQnXTsgfSA6XG4gXHRcdFx0ZnVuY3Rpb24gZ2V0TW9kdWxlRXhwb3J0cygpIHsgcmV0dXJuIG1vZHVsZTsgfTtcbiBcdFx0X193ZWJwYWNrX3JlcXVpcmVfXy5kKGdldHRlciwgJ2EnLCBnZXR0ZXIpO1xuIFx0XHRyZXR1cm4gZ2V0dGVyO1xuIFx0fTtcblxuIFx0Ly8gT2JqZWN0LnByb3RvdHlwZS5oYXNPd25Qcm9wZXJ0eS5jYWxsXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLm8gPSBmdW5jdGlvbihvYmplY3QsIHByb3BlcnR5KSB7IHJldHVybiBPYmplY3QucHJvdG90eXBlLmhhc093blByb3BlcnR5LmNhbGwob2JqZWN0LCBwcm9wZXJ0eSk7IH07XG5cbiBcdC8vIF9fd2VicGFja19wdWJsaWNfcGF0aF9fXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLnAgPSBcIi90aGVtZXMvZHJ1cGFsbnljL2J1aWxkL1wiO1xuXG5cbiBcdC8vIExvYWQgZW50cnkgbW9kdWxlIGFuZCByZXR1cm4gZXhwb3J0c1xuIFx0cmV0dXJuIF9fd2VicGFja19yZXF1aXJlX18oX193ZWJwYWNrX3JlcXVpcmVfXy5zID0gXCIuL2Fzc2V0cy9qcy9tYWluLmpzXCIpO1xuIiwibW9kdWxlLmV4cG9ydHMgPSBcIi90aGVtZXMvZHJ1cGFsbnljL2J1aWxkL2ltYWdlcy9wbHVzc2lnbi45M2Q1NjdkNy5zdmdcIjsiLCIndXNlIHN0cmljdCc7XG4vLyBpbWFnZXMgYXJlIGxvYWRlZCBoZXJlLCBzbyB0aGV5IGdldCBwcmVwcm9jZXNzZWQgYnkgd2VicGFjay5cbmNvbnN0IGltYWdlcyA9IFtcbiAgICByZXF1aXJlKCcuLi9pbWFnZXMvcGx1c3NpZ24uc3ZnJylcbl07XG5cbihmdW5jdGlvbigkKSB7XG4gICAgRHJ1cGFsLmJlaGF2aW9ycy5vbkxvYWQgPSB7XG4gICAgICAgIG9uTG9hZDogZnVuY3Rpb24gKGNvbnRleHQsIHNldHRpbmdzKSB7XG4gICAgICAgICAgICAvLyBvbiBzY3JvbGwgZmFkZSBzbWFsbCBsb2dvIGluIG1lbnVcbiAgICAgICAgICAgIGlmICgkKCdib2R5JykuaGFzQ2xhc3MoJ3BhdGgtZnJvbnRwYWdlJykpIHtcbiAgICAgICAgICAgICAgICAkKGRvY3VtZW50KS5zY3JvbGwoZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAgICAgICAgIGxldCBwYWdlSGVhZGVyID0gJChcIi5wYWdlLS1oZWFkZXJcIik7XG4gICAgICAgICAgICAgICAgICAgIGNvbnN0IG9mZnNldFRvcCA9ICQoJy5qcy1jb250ZW50LS1oZWFkZXInKS5vZmZzZXQoKS50b3A7XG4gICAgICAgICAgICAgICAgICAgIGNvbnN0IHBhZ2VIZWFkZXJGYWRlZEluID0gcGFnZUhlYWRlci5oYXNDbGFzcyhcImZhZGUtaW5cIik7XG4gICAgICAgICAgICAgICAgICAgIGlmIChvZmZzZXRUb3AgPD0gJChkb2N1bWVudCkuc2Nyb2xsVG9wKClcbiAgICAgICAgICAgICAgICAgICAgICAgICYmICFwYWdlSGVhZGVyRmFkZWRJbikge1xuICAgICAgICAgICAgICAgICAgICAgIHBhZ2VIZWFkZXIuYWRkQ2xhc3MoJ2ZhZGUtaW4nKTtcbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICBlbHNlIGlmIChvZmZzZXRUb3AgPiAkKGRvY3VtZW50KS5zY3JvbGxUb3AoKVxuICAgICAgICAgICAgICAgICAgICAgICAgJiYgcGFnZUhlYWRlckZhZGVkSW4pIHtcbiAgICAgICAgICAgICAgICAgICAgICBwYWdlSGVhZGVyLnJlbW92ZUNsYXNzKCdmYWRlLWluJyk7XG4gICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgJCgnLnN1cGVyaGVyby0tdmlldy1tb2RlLXZvbHVudGVlci1wcm9maWxlJywgY29udGV4dClcbiAgICAgICAgICAgICAgICAuZmluZCgnLmZpZWxkLS1uYW1lLWZpZWxkLXUtdm9sdW50ZWVyLWFib3V0JylcbiAgICAgICAgICAgICAgICAuYmVmb3JlKFwiPGRpdiBjbGFzcz0nZXhwYW5kJz48c3Bhbj5cIiArIERydXBhbC50KCdSZWFkIG1vcmUnKSArIFwiPC9zcGFuPjwvZGl2PlwiKTtcbiAgICAgICAgICAgICQoJy5leHBhbmQnKS5jbGljayhlbCA9PiB7XG4gICAgICAgICAgICAgICAgbGV0ICRwYXJlbnQgPSAkKCQoZWwudGFyZ2V0KS5wYXJlbnRzKCcuc3VwZXJoZXJvLS1wcm9zYScpKTtcblxuICAgICAgICAgICAgICAgICRwYXJlbnQuYWRkQ2xhc3MoJ3Nob3ctbW9yZScpO1xuICAgICAgICAgICAgICAgICQoZWwudGFyZ2V0KS5yZW1vdmUoKTtcbiAgICAgICAgICAgIH0pO1xuXG4gICAgICAgICAgICAvLyBhZGQgd3JhcHBlciBvbiB1c2VycyBkYXRhXG4gICAgICAgICAgICAkKCcucGVvcGxlIC5maWVsZC0tbmFtZS1maWVsZC11LWZpcnN0LW5hbWUnKS5wYXJlbnQoKS5hZGRDbGFzcygnbWFpbi1kYXRhLXdyYXBwZXInKTtcblxuICAgICAgICAgICAgbGV0IHVzZXJzID0gJCgnLnN1cGVyaGVybycpO1xuXG4gICAgICAgICAgICB1c2Vycy5lYWNoKGZ1bmN0aW9uKGluZGV4LCBpdGVtKSB7XG4gICAgICAgICAgICAgICAgaWYoJChpdGVtKS5maW5kKCdpbWcnKS5sZW5ndGggPT09IDApIHtcbiAgICAgICAgICAgICAgICAgICAgJChpdGVtKS5maW5kKCcuc3VwZXJoZXJvLS1wcm9maWxlJykucHJlcGVuZCgnPGltZyBzcmM9XCIvdGhlbWVzL2RydXBhbG55Yy91c2VyLXBsYWNlaG9sZGVyLnBuZ1wiLz4nKTtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9KTtcblxuICAgICAgICB9KCksXG4gICAgICAgIGNsaWNrRXZlbnRzOiBmdW5jdGlvbigpIHtcbiAgICAgICAgICAgIGxldCBtYWluTWVudSA9ICQoJy5tZW51LS1tYWluJyk7XG4gICAgICAgICAgICAkKFwiLmhhbWJ1cmdlclwiKS5jbGljayhmdW5jdGlvbigpIHtcbiAgICAgICAgICAgICAgICBpZihtYWluTWVudS5oYXNDbGFzcygnb3BlbicpKSB7XG4gICAgICAgICAgICAgICAgICAgIG1haW5NZW51LnJlbW92ZUNsYXNzKCdvcGVuJyk7XG4gICAgICAgICAgICAgICAgICAgICQoJ21haW4nKS5yZW1vdmVDbGFzcygnbW9iaWxlLW1lbnUtb3BlbmVkJyk7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIGVsc2Uge1xuICAgICAgICAgICAgICAgICAgICBtYWluTWVudS5hZGRDbGFzcygnb3BlbicpO1xuICAgICAgICAgICAgICAgICAgICAkKCdtYWluJykuYWRkQ2xhc3MoJ21vYmlsZS1tZW51LW9wZW5lZCcpO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9KClcbiAgICB9O1xuXG4gICAgRHJ1cGFsLmJlaGF2aW9ycy50aWNrZXRpbmcgPSB7XG4gICAgICBhdHRhY2g6IGZ1bmN0aW9uKGNvbnRleHQsIHNldHRpbmdzKSB7XG4gICAgICAgIC8vIFNldCBkb25hdGlvbiB0byBjaGVja2VkIG9uY2UgdmFsdWUgaXMgY2hhbmdlZCBmb3IgZG9uYXRpb24gYW1vdW50LlxuICAgICAgICAkKCdpbnB1dFtuYW1lPVwicHJpY2VfMlwiXScpLmNoYW5nZShmdW5jdGlvbigpIHtcbiAgICAgICAgICAkKCdpbnB1dFtuYW1lPVwiaXRlbV8yXCJdJykucHJvcCgnY2hlY2tlZCcsIHRydWUpO1xuICAgICAgICB9KTtcbiAgICAgIH1cbiAgfTtcbn0pKGpRdWVyeSk7XG4iXSwic291cmNlUm9vdCI6IiJ9