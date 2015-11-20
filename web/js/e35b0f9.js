/*!
 * Bootstrap v4.0.0-alpha (http://getbootstrap.com)
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 */

if (typeof jQuery === 'undefined') {
  throw new Error('Bootstrap\'s JavaScript requires jQuery')
}

+function ($) {
  var version = $.fn.jquery.split(' ')[0].split('.')
  if ((version[0] < 2 && version[1] < 9) || (version[0] == 1 && version[1] == 9 && version[2] < 1)) {
    throw new Error('Bootstrap\'s JavaScript requires jQuery version 1.9.1 or higher')
  }
}(jQuery);


+function ($) {

/**
 * --------------------------------------------------------------------------
 * Bootstrap (v4.0.0): util.js
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * --------------------------------------------------------------------------
 */

'use strict';

var _get = function get(_x, _x2, _x3) { var _again = true; _function: while (_again) { var object = _x, property = _x2, receiver = _x3; desc = parent = getter = undefined; _again = false; if (object === null) object = Function.prototype; var desc = Object.getOwnPropertyDescriptor(object, property); if (desc === undefined) { var parent = Object.getPrototypeOf(object); if (parent === null) { return undefined; } else { _x = parent; _x2 = property; _x3 = receiver; _again = true; continue _function; } } else if ('value' in desc) { return desc.value; } else { var getter = desc.get; if (getter === undefined) { return undefined; } return getter.call(receiver); } } };

var _createClass = (function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ('value' in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; })();

function _inherits(subClass, superClass) { if (typeof superClass !== 'function' && superClass !== null) { throw new TypeError('Super expression must either be null or a function, not ' + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError('Cannot call a class as a function'); } }

var Util = (function ($) {

  /**
   * ------------------------------------------------------------------------
   * Private TransitionEnd Helpers
   * ------------------------------------------------------------------------
   */

  var transition = false;

  var TransitionEndEvent = {
    WebkitTransition: 'webkitTransitionEnd',
    MozTransition: 'transitionend',
    OTransition: 'oTransitionEnd otransitionend',
    transition: 'transitionend'
  };

  // shoutout AngusCroll (https://goo.gl/pxwQGp)
  function toType(obj) {
    return ({}).toString.call(obj).match(/\s([a-zA-Z]+)/)[1].toLowerCase();
  }

  function isElement(obj) {
    return (obj[0] || obj).nodeType;
  }

  function getSpecialTransitionEndEvent() {
    return {
      bindType: transition.end,
      delegateType: transition.end,
      handle: function handle(event) {
        if ($(event.target).is(this)) {
          return event.handleObj.handler.apply(this, arguments);
        }
      }
    };
  }

  function transitionEndTest() {
    if (window.QUnit) {
      return false;
    }

    var el = document.createElement('bootstrap');

    for (var _name in TransitionEndEvent) {
      if (el.style[_name] !== undefined) {
        return { end: TransitionEndEvent[_name] };
      }
    }

    return false;
  }

  function transitionEndEmulator(duration) {
    var _this = this;

    var called = false;

    $(this).one(Util.TRANSITION_END, function () {
      called = true;
    });

    setTimeout(function () {
      if (!called) {
        Util.triggerTransitionEnd(_this);
      }
    }, duration);

    return this;
  }

  function setTransitionEndSupport() {
    transition = transitionEndTest();

    $.fn.emulateTransitionEnd = transitionEndEmulator;

    if (Util.supportsTransitionEnd()) {
      $.event.special[Util.TRANSITION_END] = getSpecialTransitionEndEvent();
    }
  }

  /**
   * --------------------------------------------------------------------------
   * Public Util Api
   * --------------------------------------------------------------------------
   */

  var Util = {

    TRANSITION_END: 'bsTransitionEnd',

    getUID: function getUID(prefix) {
      do {
        prefix += ~ ~(Math.random() * 1000000);
      } while (document.getElementById(prefix));
      return prefix;
    },

    getSelectorFromElement: function getSelectorFromElement(element) {
      var selector = element.getAttribute('data-target');

      if (!selector) {
        selector = element.getAttribute('href') || '';
        selector = /^#[a-z]/i.test(selector) ? selector : null;
      }

      return selector;
    },

    reflow: function reflow(element) {
      new Function('bs', 'return bs')(element.offsetHeight);
    },

    triggerTransitionEnd: function triggerTransitionEnd(element) {
      $(element).trigger(transition.end);
    },

    supportsTransitionEnd: function supportsTransitionEnd() {
      return Boolean(transition);
    },

    typeCheckConfig: function typeCheckConfig(componentName, config, configTypes) {
      for (var property in configTypes) {
        if (configTypes.hasOwnProperty(property)) {
          var expectedTypes = configTypes[property];
          var value = config[property];
          var valueType = undefined;

          if (value && isElement(value)) {
            valueType = 'element';
          } else {
            valueType = toType(value);
          }

          if (!new RegExp(expectedTypes).test(valueType)) {
            throw new Error(componentName.toUpperCase() + ': ' + ('Option "' + property + '" provided type "' + valueType + '" ') + ('but expected type "' + expectedTypes + '".'));
          }
        }
      }
    }
  };

  setTransitionEndSupport();

  return Util;
})(jQuery);

/**
 * --------------------------------------------------------------------------
 * Bootstrap (v4.0.0): alert.js
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * --------------------------------------------------------------------------
 */

var Alert = (function ($) {

  /**
   * ------------------------------------------------------------------------
   * Constants
   * ------------------------------------------------------------------------
   */

  var NAME = 'alert';
  var VERSION = '4.0.0';
  var DATA_KEY = 'bs.alert';
  var EVENT_KEY = '.' + DATA_KEY;
  var DATA_API_KEY = '.data-api';
  var JQUERY_NO_CONFLICT = $.fn[NAME];
  var TRANSITION_DURATION = 150;

  var Selector = {
    DISMISS: '[data-dismiss="alert"]'
  };

  var Event = {
    CLOSE: 'close' + EVENT_KEY,
    CLOSED: 'closed' + EVENT_KEY,
    CLICK_DATA_API: 'click' + EVENT_KEY + DATA_API_KEY
  };

  var ClassName = {
    ALERT: 'alert',
    FADE: 'fade',
    IN: 'in'
  };

  /**
   * ------------------------------------------------------------------------
   * Class Definition
   * ------------------------------------------------------------------------
   */

  var Alert = (function () {
    function Alert(element) {
      _classCallCheck(this, Alert);

      this._element = element;
    }

    /**
     * ------------------------------------------------------------------------
     * Data Api implementation
     * ------------------------------------------------------------------------
     */

    // getters

    _createClass(Alert, [{
      key: 'close',

      // public

      value: function close(element) {
        element = element || this._element;

        var rootElement = this._getRootElement(element);
        var customEvent = this._triggerCloseEvent(rootElement);

        if (customEvent.isDefaultPrevented()) {
          return;
        }

        this._removeElement(rootElement);
      }
    }, {
      key: 'dispose',
      value: function dispose() {
        $.removeData(this._element, DATA_KEY);
        this._element = null;
      }

      // private

    }, {
      key: '_getRootElement',
      value: function _getRootElement(element) {
        var selector = Util.getSelectorFromElement(element);
        var parent = false;

        if (selector) {
          parent = $(selector)[0];
        }

        if (!parent) {
          parent = $(element).closest('.' + ClassName.ALERT)[0];
        }

        return parent;
      }
    }, {
      key: '_triggerCloseEvent',
      value: function _triggerCloseEvent(element) {
        var closeEvent = $.Event(Event.CLOSE);

        $(element).trigger(closeEvent);
        return closeEvent;
      }
    }, {
      key: '_removeElement',
      value: function _removeElement(element) {
        $(element).removeClass(ClassName.IN);

        if (!Util.supportsTransitionEnd() || !$(element).hasClass(ClassName.FADE)) {
          this._destroyElement(element);
          return;
        }

        $(element).one(Util.TRANSITION_END, $.proxy(this._destroyElement, this, element)).emulateTransitionEnd(TRANSITION_DURATION);
      }
    }, {
      key: '_destroyElement',
      value: function _destroyElement(element) {
        $(element).detach().trigger(Event.CLOSED).remove();
      }

      // static

    }], [{
      key: '_jQueryInterface',
      value: function _jQueryInterface(config) {
        return this.each(function () {
          var $element = $(this);
          var data = $element.data(DATA_KEY);

          if (!data) {
            data = new Alert(this);
            $element.data(DATA_KEY, data);
          }

          if (config === 'close') {
            data[config](this);
          }
        });
      }
    }, {
      key: '_handleDismiss',
      value: function _handleDismiss(alertInstance) {
        return function (event) {
          if (event) {
            event.preventDefault();
          }

          alertInstance.close(this);
        };
      }
    }, {
      key: 'VERSION',
      get: function get() {
        return VERSION;
      }
    }]);

    return Alert;
  })();

  $(document).on(Event.CLICK_DATA_API, Selector.DISMISS, Alert._handleDismiss(new Alert()));

  /**
   * ------------------------------------------------------------------------
   * jQuery
   * ------------------------------------------------------------------------
   */

  $.fn[NAME] = Alert._jQueryInterface;
  $.fn[NAME].Constructor = Alert;
  $.fn[NAME].noConflict = function () {
    $.fn[NAME] = JQUERY_NO_CONFLICT;
    return Alert._jQueryInterface;
  };

  return Alert;
})(jQuery);

/**
 * --------------------------------------------------------------------------
 * Bootstrap (v4.0.0): button.js
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * --------------------------------------------------------------------------
 */

var Button = (function ($) {

  /**
   * ------------------------------------------------------------------------
   * Constants
   * ------------------------------------------------------------------------
   */

  var NAME = 'button';
  var VERSION = '4.0.0';
  var DATA_KEY = 'bs.button';
  var EVENT_KEY = '.' + DATA_KEY;
  var DATA_API_KEY = '.data-api';
  var JQUERY_NO_CONFLICT = $.fn[NAME];

  var ClassName = {
    ACTIVE: 'active',
    BUTTON: 'btn',
    FOCUS: 'focus'
  };

  var Selector = {
    DATA_TOGGLE_CARROT: '[data-toggle^="button"]',
    DATA_TOGGLE: '[data-toggle="buttons"]',
    INPUT: 'input',
    ACTIVE: '.active',
    BUTTON: '.btn'
  };

  var Event = {
    CLICK_DATA_API: 'click' + EVENT_KEY + DATA_API_KEY,
    FOCUS_BLUR_DATA_API: 'focus' + EVENT_KEY + DATA_API_KEY + ' ' + ('blur' + EVENT_KEY + DATA_API_KEY)
  };

  /**
   * ------------------------------------------------------------------------
   * Class Definition
   * ------------------------------------------------------------------------
   */

  var Button = (function () {
    function Button(element) {
      _classCallCheck(this, Button);

      this._element = element;
    }

    /**
     * ------------------------------------------------------------------------
     * Data Api implementation
     * ------------------------------------------------------------------------
     */

    // getters

    _createClass(Button, [{
      key: 'toggle',

      // public

      value: function toggle() {
        var triggerChangeEvent = true;
        var rootElement = $(this._element).closest(Selector.DATA_TOGGLE)[0];

        if (rootElement) {
          var input = $(this._element).find(Selector.INPUT)[0];

          if (input) {
            if (input.type === 'radio') {
              if (input.checked && $(this._element).hasClass(ClassName.ACTIVE)) {
                triggerChangeEvent = false;
              } else {
                var activeElement = $(rootElement).find(Selector.ACTIVE)[0];

                if (activeElement) {
                  $(activeElement).removeClass(ClassName.ACTIVE);
                }
              }
            }

            if (triggerChangeEvent) {
              input.checked = !$(this._element).hasClass(ClassName.ACTIVE);
              $(this._element).trigger('change');
            }
          }
        } else {
          this._element.setAttribute('aria-pressed', !$(this._element).hasClass(ClassName.ACTIVE));
        }

        if (triggerChangeEvent) {
          $(this._element).toggleClass(ClassName.ACTIVE);
        }
      }
    }, {
      key: 'dispose',
      value: function dispose() {
        $.removeData(this._element, DATA_KEY);
        this._element = null;
      }

      // static

    }], [{
      key: '_jQueryInterface',
      value: function _jQueryInterface(config) {
        return this.each(function () {
          var data = $(this).data(DATA_KEY);

          if (!data) {
            data = new Button(this);
            $(this).data(DATA_KEY, data);
          }

          if (config === 'toggle') {
            data[config]();
          }
        });
      }
    }, {
      key: 'VERSION',
      get: function get() {
        return VERSION;
      }
    }]);

    return Button;
  })();

  $(document).on(Event.CLICK_DATA_API, Selector.DATA_TOGGLE_CARROT, function (event) {
    event.preventDefault();

    var button = event.target;

    if (!$(button).hasClass(ClassName.BUTTON)) {
      button = $(button).closest(Selector.BUTTON);
    }

    Button._jQueryInterface.call($(button), 'toggle');
  }).on(Event.FOCUS_BLUR_DATA_API, Selector.DATA_TOGGLE_CARROT, function (event) {
    var button = $(event.target).closest(Selector.BUTTON)[0];
    $(button).toggleClass(ClassName.FOCUS, /^focus(in)?$/.test(event.type));
  });

  /**
   * ------------------------------------------------------------------------
   * jQuery
   * ------------------------------------------------------------------------
   */

  $.fn[NAME] = Button._jQueryInterface;
  $.fn[NAME].Constructor = Button;
  $.fn[NAME].noConflict = function () {
    $.fn[NAME] = JQUERY_NO_CONFLICT;
    return Button._jQueryInterface;
  };

  return Button;
})(jQuery);

/**
 * --------------------------------------------------------------------------
 * Bootstrap (v4.0.0): carousel.js
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * --------------------------------------------------------------------------
 */

var Carousel = (function ($) {

  /**
   * ------------------------------------------------------------------------
   * Constants
   * ------------------------------------------------------------------------
   */

  var NAME = 'carousel';
  var VERSION = '4.0.0';
  var DATA_KEY = 'bs.carousel';
  var EVENT_KEY = '.' + DATA_KEY;
  var DATA_API_KEY = '.data-api';
  var JQUERY_NO_CONFLICT = $.fn[NAME];
  var TRANSITION_DURATION = 600;

  var Default = {
    interval: 5000,
    keyboard: true,
    slide: false,
    pause: 'hover',
    wrap: true
  };

  var DefaultType = {
    interval: '(number|boolean)',
    keyboard: 'boolean',
    slide: '(boolean|string)',
    pause: '(string|boolean)',
    wrap: 'boolean'
  };

  var Direction = {
    NEXT: 'next',
    PREVIOUS: 'prev'
  };

  var Event = {
    SLIDE: 'slide' + EVENT_KEY,
    SLID: 'slid' + EVENT_KEY,
    KEYDOWN: 'keydown' + EVENT_KEY,
    MOUSEENTER: 'mouseenter' + EVENT_KEY,
    MOUSELEAVE: 'mouseleave' + EVENT_KEY,
    LOAD_DATA_API: 'load' + EVENT_KEY + DATA_API_KEY,
    CLICK_DATA_API: 'click' + EVENT_KEY + DATA_API_KEY
  };

  var ClassName = {
    CAROUSEL: 'carousel',
    ACTIVE: 'active',
    SLIDE: 'slide',
    RIGHT: 'right',
    LEFT: 'left',
    ITEM: 'carousel-item'
  };

  var Selector = {
    ACTIVE: '.active',
    ACTIVE_ITEM: '.active.carousel-item',
    ITEM: '.carousel-item',
    NEXT_PREV: '.next, .prev',
    INDICATORS: '.carousel-indicators',
    DATA_SLIDE: '[data-slide], [data-slide-to]',
    DATA_RIDE: '[data-ride="carousel"]'
  };

  /**
   * ------------------------------------------------------------------------
   * Class Definition
   * ------------------------------------------------------------------------
   */

  var Carousel = (function () {
    function Carousel(element, config) {
      _classCallCheck(this, Carousel);

      this._items = null;
      this._interval = null;
      this._activeElement = null;

      this._isPaused = false;
      this._isSliding = false;

      this._config = this._getConfig(config);
      this._element = $(element)[0];
      this._indicatorsElement = $(this._element).find(Selector.INDICATORS)[0];

      this._addEventListeners();
    }

    /**
     * ------------------------------------------------------------------------
     * Data Api implementation
     * ------------------------------------------------------------------------
     */

    // getters

    _createClass(Carousel, [{
      key: 'next',

      // public

      value: function next() {
        if (!this._isSliding) {
          this._slide(Direction.NEXT);
        }
      }
    }, {
      key: 'prev',
      value: function prev() {
        if (!this._isSliding) {
          this._slide(Direction.PREVIOUS);
        }
      }
    }, {
      key: 'pause',
      value: function pause(event) {
        if (!event) {
          this._isPaused = true;
        }

        if ($(this._element).find(Selector.NEXT_PREV)[0] && Util.supportsTransitionEnd()) {
          Util.triggerTransitionEnd(this._element);
          this.cycle(true);
        }

        clearInterval(this._interval);
        this._interval = null;
      }
    }, {
      key: 'cycle',
      value: function cycle(event) {
        if (!event) {
          this._isPaused = false;
        }

        if (this._interval) {
          clearInterval(this._interval);
          this._interval = null;
        }

        if (this._config.interval && !this._isPaused) {
          this._interval = setInterval($.proxy(this.next, this), this._config.interval);
        }
      }
    }, {
      key: 'to',
      value: function to(index) {
        var _this2 = this;

        this._activeElement = $(this._element).find(Selector.ACTIVE_ITEM)[0];

        var activeIndex = this._getItemIndex(this._activeElement);

        if (index > this._items.length - 1 || index < 0) {
          return;
        }

        if (this._isSliding) {
          $(this._element).one(Event.SLID, function () {
            return _this2.to(index);
          });
          return;
        }

        if (activeIndex === index) {
          this.pause();
          this.cycle();
          return;
        }

        var direction = index > activeIndex ? Direction.NEXT : Direction.PREVIOUS;

        this._slide(direction, this._items[index]);
      }
    }, {
      key: 'dispose',
      value: function dispose() {
        $(this._element).off(EVENT_KEY);
        $.removeData(this._element, DATA_KEY);

        this._items = null;
        this._config = null;
        this._element = null;
        this._interval = null;
        this._isPaused = null;
        this._isSliding = null;
        this._activeElement = null;
        this._indicatorsElement = null;
      }

      // private

    }, {
      key: '_getConfig',
      value: function _getConfig(config) {
        config = $.extend({}, Default, config);
        Util.typeCheckConfig(NAME, config, DefaultType);
        return config;
      }
    }, {
      key: '_addEventListeners',
      value: function _addEventListeners() {
        if (this._config.keyboard) {
          $(this._element).on(Event.KEYDOWN, $.proxy(this._keydown, this));
        }

        if (this._config.pause === 'hover' && !('ontouchstart' in document.documentElement)) {
          $(this._element).on(Event.MOUSEENTER, $.proxy(this.pause, this)).on(Event.MOUSELEAVE, $.proxy(this.cycle, this));
        }
      }
    }, {
      key: '_keydown',
      value: function _keydown(event) {
        event.preventDefault();

        if (/input|textarea/i.test(event.target.tagName)) {
          return;
        }

        switch (event.which) {
          case 37:
            this.prev();break;
          case 39:
            this.next();break;
          default:
            return;
        }
      }
    }, {
      key: '_getItemIndex',
      value: function _getItemIndex(element) {
        this._items = $.makeArray($(element).parent().find(Selector.ITEM));
        return this._items.indexOf(element);
      }
    }, {
      key: '_getItemByDirection',
      value: function _getItemByDirection(direction, activeElement) {
        var isNextDirection = direction === Direction.NEXT;
        var isPrevDirection = direction === Direction.PREVIOUS;
        var activeIndex = this._getItemIndex(activeElement);
        var lastItemIndex = this._items.length - 1;
        var isGoingToWrap = isPrevDirection && activeIndex === 0 || isNextDirection && activeIndex === lastItemIndex;

        if (isGoingToWrap && !this._config.wrap) {
          return activeElement;
        }

        var delta = direction === Direction.PREVIOUS ? -1 : 1;
        var itemIndex = (activeIndex + delta) % this._items.length;

        return itemIndex === -1 ? this._items[this._items.length - 1] : this._items[itemIndex];
      }
    }, {
      key: '_triggerSlideEvent',
      value: function _triggerSlideEvent(relatedTarget, directionalClassname) {
        var slideEvent = $.Event(Event.SLIDE, {
          relatedTarget: relatedTarget,
          direction: directionalClassname
        });

        $(this._element).trigger(slideEvent);

        return slideEvent;
      }
    }, {
      key: '_setActiveIndicatorElement',
      value: function _setActiveIndicatorElement(element) {
        if (this._indicatorsElement) {
          $(this._indicatorsElement).find(Selector.ACTIVE).removeClass(ClassName.ACTIVE);

          var nextIndicator = this._indicatorsElement.children[this._getItemIndex(element)];

          if (nextIndicator) {
            $(nextIndicator).addClass(ClassName.ACTIVE);
          }
        }
      }
    }, {
      key: '_slide',
      value: function _slide(direction, element) {
        var _this3 = this;

        var activeElement = $(this._element).find(Selector.ACTIVE_ITEM)[0];
        var nextElement = element || activeElement && this._getItemByDirection(direction, activeElement);

        var isCycling = Boolean(this._interval);

        var directionalClassName = direction === Direction.NEXT ? ClassName.LEFT : ClassName.RIGHT;

        if (nextElement && $(nextElement).hasClass(ClassName.ACTIVE)) {
          this._isSliding = false;
          return;
        }

        var slideEvent = this._triggerSlideEvent(nextElement, directionalClassName);
        if (slideEvent.isDefaultPrevented()) {
          return;
        }

        if (!activeElement || !nextElement) {
          // some weirdness is happening, so we bail
          return;
        }

        this._isSliding = true;

        if (isCycling) {
          this.pause();
        }

        this._setActiveIndicatorElement(nextElement);

        var slidEvent = $.Event(Event.SLID, {
          relatedTarget: nextElement,
          direction: directionalClassName
        });

        if (Util.supportsTransitionEnd() && $(this._element).hasClass(ClassName.SLIDE)) {

          $(nextElement).addClass(direction);

          Util.reflow(nextElement);

          $(activeElement).addClass(directionalClassName);
          $(nextElement).addClass(directionalClassName);

          $(activeElement).one(Util.TRANSITION_END, function () {
            $(nextElement).removeClass(directionalClassName).removeClass(direction);

            $(nextElement).addClass(ClassName.ACTIVE);

            $(activeElement).removeClass(ClassName.ACTIVE).removeClass(direction).removeClass(directionalClassName);

            _this3._isSliding = false;

            setTimeout(function () {
              return $(_this3._element).trigger(slidEvent);
            }, 0);
          }).emulateTransitionEnd(TRANSITION_DURATION);
        } else {
          $(activeElement).removeClass(ClassName.ACTIVE);
          $(nextElement).addClass(ClassName.ACTIVE);

          this._isSliding = false;
          $(this._element).trigger(slidEvent);
        }

        if (isCycling) {
          this.cycle();
        }
      }

      // static

    }], [{
      key: '_jQueryInterface',
      value: function _jQueryInterface(config) {
        return this.each(function () {
          var data = $(this).data(DATA_KEY);
          var _config = $.extend({}, Default, $(this).data());

          if (typeof config === 'object') {
            $.extend(_config, config);
          }

          var action = typeof config === 'string' ? config : _config.slide;

          if (!data) {
            data = new Carousel(this, _config);
            $(this).data(DATA_KEY, data);
          }

          if (typeof config === 'number') {
            data.to(config);
          } else if (action) {
            data[action]();
          } else if (_config.interval) {
            data.pause();
            data.cycle();
          }
        });
      }
    }, {
      key: '_dataApiClickHandler',
      value: function _dataApiClickHandler(event) {
        var selector = Util.getSelectorFromElement(this);

        if (!selector) {
          return;
        }

        var target = $(selector)[0];

        if (!target || !$(target).hasClass(ClassName.CAROUSEL)) {
          return;
        }

        var config = $.extend({}, $(target).data(), $(this).data());
        var slideIndex = this.getAttribute('data-slide-to');

        if (slideIndex) {
          config.interval = false;
        }

        Carousel._jQueryInterface.call($(target), config);

        if (slideIndex) {
          $(target).data(DATA_KEY).to(slideIndex);
        }

        event.preventDefault();
      }
    }, {
      key: 'VERSION',
      get: function get() {
        return VERSION;
      }
    }, {
      key: 'Default',
      get: function get() {
        return Default;
      }
    }]);

    return Carousel;
  })();

  $(document).on(Event.CLICK_DATA_API, Selector.DATA_SLIDE, Carousel._dataApiClickHandler);

  $(window).on(Event.LOAD_DATA_API, function () {
    $(Selector.DATA_RIDE).each(function () {
      var $carousel = $(this);
      Carousel._jQueryInterface.call($carousel, $carousel.data());
    });
  });

  /**
   * ------------------------------------------------------------------------
   * jQuery
   * ------------------------------------------------------------------------
   */

  $.fn[NAME] = Carousel._jQueryInterface;
  $.fn[NAME].Constructor = Carousel;
  $.fn[NAME].noConflict = function () {
    $.fn[NAME] = JQUERY_NO_CONFLICT;
    return Carousel._jQueryInterface;
  };

  return Carousel;
})(jQuery);

/**
 * --------------------------------------------------------------------------
 * Bootstrap (v4.0.0): collapse.js
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * --------------------------------------------------------------------------
 */

var Collapse = (function ($) {

  /**
   * ------------------------------------------------------------------------
   * Constants
   * ------------------------------------------------------------------------
   */

  var NAME = 'collapse';
  var VERSION = '4.0.0';
  var DATA_KEY = 'bs.collapse';
  var EVENT_KEY = '.' + DATA_KEY;
  var DATA_API_KEY = '.data-api';
  var JQUERY_NO_CONFLICT = $.fn[NAME];
  var TRANSITION_DURATION = 600;

  var Default = {
    toggle: true,
    parent: ''
  };

  var DefaultType = {
    toggle: 'boolean',
    parent: 'string'
  };

  var Event = {
    SHOW: 'show' + EVENT_KEY,
    SHOWN: 'shown' + EVENT_KEY,
    HIDE: 'hide' + EVENT_KEY,
    HIDDEN: 'hidden' + EVENT_KEY,
    CLICK_DATA_API: 'click' + EVENT_KEY + DATA_API_KEY
  };

  var ClassName = {
    IN: 'in',
    COLLAPSE: 'collapse',
    COLLAPSING: 'collapsing',
    COLLAPSED: 'collapsed'
  };

  var Dimension = {
    WIDTH: 'width',
    HEIGHT: 'height'
  };

  var Selector = {
    ACTIVES: '.panel > .in, .panel > .collapsing',
    DATA_TOGGLE: '[data-toggle="collapse"]'
  };

  /**
   * ------------------------------------------------------------------------
   * Class Definition
   * ------------------------------------------------------------------------
   */

  var Collapse = (function () {
    function Collapse(element, config) {
      _classCallCheck(this, Collapse);

      this._isTransitioning = false;
      this._element = element;
      this._config = this._getConfig(config);
      this._triggerArray = $.makeArray($('[data-toggle="collapse"][href="#' + element.id + '"],' + ('[data-toggle="collapse"][data-target="#' + element.id + '"]')));

      this._parent = this._config.parent ? this._getParent() : null;

      if (!this._config.parent) {
        this._addAriaAndCollapsedClass(this._element, this._triggerArray);
      }

      if (this._config.toggle) {
        this.toggle();
      }
    }

    /**
     * ------------------------------------------------------------------------
     * Data Api implementation
     * ------------------------------------------------------------------------
     */

    // getters

    _createClass(Collapse, [{
      key: 'toggle',

      // public

      value: function toggle() {
        if ($(this._element).hasClass(ClassName.IN)) {
          this.hide();
        } else {
          this.show();
        }
      }
    }, {
      key: 'show',
      value: function show() {
        var _this4 = this;

        if (this._isTransitioning || $(this._element).hasClass(ClassName.IN)) {
          return;
        }

        var actives = undefined;
        var activesData = undefined;

        if (this._parent) {
          actives = $.makeArray($(Selector.ACTIVES));
          if (!actives.length) {
            actives = null;
          }
        }

        if (actives) {
          activesData = $(actives).data(DATA_KEY);
          if (activesData && activesData._isTransitioning) {
            return;
          }
        }

        var startEvent = $.Event(Event.SHOW);
        $(this._element).trigger(startEvent);
        if (startEvent.isDefaultPrevented()) {
          return;
        }

        if (actives) {
          Collapse._jQueryInterface.call($(actives), 'hide');
          if (!activesData) {
            $(actives).data(DATA_KEY, null);
          }
        }

        var dimension = this._getDimension();

        $(this._element).removeClass(ClassName.COLLAPSE).addClass(ClassName.COLLAPSING);

        this._element.style[dimension] = 0;
        this._element.setAttribute('aria-expanded', true);

        if (this._triggerArray.length) {
          $(this._triggerArray).removeClass(ClassName.COLLAPSED).attr('aria-expanded', true);
        }

        this.setTransitioning(true);

        var complete = function complete() {
          $(_this4._element).removeClass(ClassName.COLLAPSING).addClass(ClassName.COLLAPSE).addClass(ClassName.IN);

          _this4._element.style[dimension] = '';

          _this4.setTransitioning(false);

          $(_this4._element).trigger(Event.SHOWN);
        };

        if (!Util.supportsTransitionEnd()) {
          complete();
          return;
        }

        var capitalizedDimension = dimension[0].toUpperCase() + dimension.slice(1);
        var scrollSize = 'scroll' + capitalizedDimension;

        $(this._element).one(Util.TRANSITION_END, complete).emulateTransitionEnd(TRANSITION_DURATION);

        this._element.style[dimension] = this._element[scrollSize] + 'px';
      }
    }, {
      key: 'hide',
      value: function hide() {
        var _this5 = this;

        if (this._isTransitioning || !$(this._element).hasClass(ClassName.IN)) {
          return;
        }

        var startEvent = $.Event(Event.HIDE);
        $(this._element).trigger(startEvent);
        if (startEvent.isDefaultPrevented()) {
          return;
        }

        var dimension = this._getDimension();
        var offsetDimension = dimension === Dimension.WIDTH ? 'offsetWidth' : 'offsetHeight';

        this._element.style[dimension] = this._element[offsetDimension] + 'px';

        Util.reflow(this._element);

        $(this._element).addClass(ClassName.COLLAPSING).removeClass(ClassName.COLLAPSE).removeClass(ClassName.IN);

        this._element.setAttribute('aria-expanded', false);

        if (this._triggerArray.length) {
          $(this._triggerArray).addClass(ClassName.COLLAPSED).attr('aria-expanded', false);
        }

        this.setTransitioning(true);

        var complete = function complete() {
          _this5.setTransitioning(false);
          $(_this5._element).removeClass(ClassName.COLLAPSING).addClass(ClassName.COLLAPSE).trigger(Event.HIDDEN);
        };

        this._element.style[dimension] = 0;

        if (!Util.supportsTransitionEnd()) {
          complete();
          return;
        }

        $(this._element).one(Util.TRANSITION_END, complete).emulateTransitionEnd(TRANSITION_DURATION);
      }
    }, {
      key: 'setTransitioning',
      value: function setTransitioning(isTransitioning) {
        this._isTransitioning = isTransitioning;
      }
    }, {
      key: 'dispose',
      value: function dispose() {
        $.removeData(this._element, DATA_KEY);

        this._config = null;
        this._parent = null;
        this._element = null;
        this._triggerArray = null;
        this._isTransitioning = null;
      }

      // private

    }, {
      key: '_getConfig',
      value: function _getConfig(config) {
        config = $.extend({}, Default, config);
        config.toggle = Boolean(config.toggle); // coerce string values
        Util.typeCheckConfig(NAME, config, DefaultType);
        return config;
      }
    }, {
      key: '_getDimension',
      value: function _getDimension() {
        var hasWidth = $(this._element).hasClass(Dimension.WIDTH);
        return hasWidth ? Dimension.WIDTH : Dimension.HEIGHT;
      }
    }, {
      key: '_getParent',
      value: function _getParent() {
        var _this6 = this;

        var parent = $(this._config.parent)[0];
        var selector = '[data-toggle="collapse"][data-parent="' + this._config.parent + '"]';

        $(parent).find(selector).each(function (i, element) {
          _this6._addAriaAndCollapsedClass(Collapse._getTargetFromElement(element), [element]);
        });

        return parent;
      }
    }, {
      key: '_addAriaAndCollapsedClass',
      value: function _addAriaAndCollapsedClass(element, triggerArray) {
        if (element) {
          var isOpen = $(element).hasClass(ClassName.IN);
          element.setAttribute('aria-expanded', isOpen);

          if (triggerArray.length) {
            $(triggerArray).toggleClass(ClassName.COLLAPSED, !isOpen).attr('aria-expanded', isOpen);
          }
        }
      }

      // static

    }], [{
      key: '_getTargetFromElement',
      value: function _getTargetFromElement(element) {
        var selector = Util.getSelectorFromElement(element);
        return selector ? $(selector)[0] : null;
      }
    }, {
      key: '_jQueryInterface',
      value: function _jQueryInterface(config) {
        return this.each(function () {
          var $this = $(this);
          var data = $this.data(DATA_KEY);
          var _config = $.extend({}, Default, $this.data(), typeof config === 'object' && config);

          if (!data && _config.toggle && /show|hide/.test(config)) {
            _config.toggle = false;
          }

          if (!data) {
            data = new Collapse(this, _config);
            $this.data(DATA_KEY, data);
          }

          if (typeof config === 'string') {
            data[config]();
          }
        });
      }
    }, {
      key: 'VERSION',
      get: function get() {
        return VERSION;
      }
    }, {
      key: 'Default',
      get: function get() {
        return Default;
      }
    }]);

    return Collapse;
  })();

  $(document).on(Event.CLICK_DATA_API, Selector.DATA_TOGGLE, function (event) {
    event.preventDefault();

    var target = Collapse._getTargetFromElement(this);
    var data = $(target).data(DATA_KEY);
    var config = data ? 'toggle' : $(this).data();

    Collapse._jQueryInterface.call($(target), config);
  });

  /**
   * ------------------------------------------------------------------------
   * jQuery
   * ------------------------------------------------------------------------
   */

  $.fn[NAME] = Collapse._jQueryInterface;
  $.fn[NAME].Constructor = Collapse;
  $.fn[NAME].noConflict = function () {
    $.fn[NAME] = JQUERY_NO_CONFLICT;
    return Collapse._jQueryInterface;
  };

  return Collapse;
})(jQuery);

/**
 * --------------------------------------------------------------------------
 * Bootstrap (v4.0.0): dropdown.js
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * --------------------------------------------------------------------------
 */

var Dropdown = (function ($) {

  /**
   * ------------------------------------------------------------------------
   * Constants
   * ------------------------------------------------------------------------
   */

  var NAME = 'dropdown';
  var VERSION = '4.0.0';
  var DATA_KEY = 'bs.dropdown';
  var EVENT_KEY = '.' + DATA_KEY;
  var DATA_API_KEY = '.data-api';
  var JQUERY_NO_CONFLICT = $.fn[NAME];

  var Event = {
    HIDE: 'hide' + EVENT_KEY,
    HIDDEN: 'hidden' + EVENT_KEY,
    SHOW: 'show' + EVENT_KEY,
    SHOWN: 'shown' + EVENT_KEY,
    CLICK: 'click' + EVENT_KEY,
    CLICK_DATA_API: 'click' + EVENT_KEY + DATA_API_KEY,
    KEYDOWN_DATA_API: 'keydown' + EVENT_KEY + DATA_API_KEY
  };

  var ClassName = {
    BACKDROP: 'dropdown-backdrop',
    DISABLED: 'disabled',
    OPEN: 'open'
  };

  var Selector = {
    BACKDROP: '.dropdown-backdrop',
    DATA_TOGGLE: '[data-toggle="dropdown"]',
    FORM_CHILD: '.dropdown form',
    ROLE_MENU: '[role="menu"]',
    ROLE_LISTBOX: '[role="listbox"]',
    NAVBAR_NAV: '.navbar-nav',
    VISIBLE_ITEMS: '[role="menu"] li:not(.disabled) a, ' + '[role="listbox"] li:not(.disabled) a'
  };

  /**
   * ------------------------------------------------------------------------
   * Class Definition
   * ------------------------------------------------------------------------
   */

  var Dropdown = (function () {
    function Dropdown(element) {
      _classCallCheck(this, Dropdown);

      this._element = element;

      this._addEventListeners();
    }

    /**
     * ------------------------------------------------------------------------
     * Data Api implementation
     * ------------------------------------------------------------------------
     */

    // getters

    _createClass(Dropdown, [{
      key: 'toggle',

      // public

      value: function toggle() {
        if (this.disabled || $(this).hasClass(ClassName.DISABLED)) {
          return false;
        }

        var parent = Dropdown._getParentFromElement(this);
        var isActive = $(parent).hasClass(ClassName.OPEN);

        Dropdown._clearMenus();

        if (isActive) {
          return false;
        }

        if ('ontouchstart' in document.documentElement && !$(parent).closest(Selector.NAVBAR_NAV).length) {

          // if mobile we use a backdrop because click events don't delegate
          var dropdown = document.createElement('div');
          dropdown.className = ClassName.BACKDROP;
          $(dropdown).insertBefore(this);
          $(dropdown).on('click', Dropdown._clearMenus);
        }

        var relatedTarget = { relatedTarget: this };
        var showEvent = $.Event(Event.SHOW, relatedTarget);

        $(parent).trigger(showEvent);

        if (showEvent.isDefaultPrevented()) {
          return false;
        }

        this.focus();
        this.setAttribute('aria-expanded', 'true');

        $(parent).toggleClass(ClassName.OPEN);
        $(parent).trigger($.Event(Event.SHOWN, relatedTarget));

        return false;
      }
    }, {
      key: 'dispose',
      value: function dispose() {
        $.removeData(this._element, DATA_KEY);
        $(this._element).off(EVENT_KEY);
        this._element = null;
      }

      // private

    }, {
      key: '_addEventListeners',
      value: function _addEventListeners() {
        $(this._element).on(Event.CLICK, this.toggle);
      }

      // static

    }], [{
      key: '_jQueryInterface',
      value: function _jQueryInterface(config) {
        return this.each(function () {
          var data = $(this).data(DATA_KEY);

          if (!data) {
            $(this).data(DATA_KEY, data = new Dropdown(this));
          }

          if (typeof config === 'string') {
            data[config].call(this);
          }
        });
      }
    }, {
      key: '_clearMenus',
      value: function _clearMenus(event) {
        if (event && event.which === 3) {
          return;
        }

        var backdrop = $(Selector.BACKDROP)[0];
        if (backdrop) {
          backdrop.parentNode.removeChild(backdrop);
        }

        var toggles = $.makeArray($(Selector.DATA_TOGGLE));

        for (var i = 0; i < toggles.length; i++) {
          var _parent = Dropdown._getParentFromElement(toggles[i]);
          var relatedTarget = { relatedTarget: toggles[i] };

          if (!$(_parent).hasClass(ClassName.OPEN)) {
            continue;
          }

          if (event && event.type === 'click' && /input|textarea/i.test(event.target.tagName) && $.contains(_parent, event.target)) {
            continue;
          }

          var hideEvent = $.Event(Event.HIDE, relatedTarget);
          $(_parent).trigger(hideEvent);
          if (hideEvent.isDefaultPrevented()) {
            continue;
          }

          toggles[i].setAttribute('aria-expanded', 'false');

          $(_parent).removeClass(ClassName.OPEN).trigger($.Event(Event.HIDDEN, relatedTarget));
        }
      }
    }, {
      key: '_getParentFromElement',
      value: function _getParentFromElement(element) {
        var parent = undefined;
        var selector = Util.getSelectorFromElement(element);

        if (selector) {
          parent = $(selector)[0];
        }

        return parent || element.parentNode;
      }
    }, {
      key: '_dataApiKeydownHandler',
      value: function _dataApiKeydownHandler(event) {
        if (!/(38|40|27|32)/.test(event.which) || /input|textarea/i.test(event.target.tagName)) {
          return;
        }

        event.preventDefault();
        event.stopPropagation();

        if (this.disabled || $(this).hasClass(ClassName.DISABLED)) {
          return;
        }

        var parent = Dropdown._getParentFromElement(this);
        var isActive = $(parent).hasClass(ClassName.OPEN);

        if (!isActive && event.which !== 27 || isActive && event.which === 27) {

          if (event.which === 27) {
            var toggle = $(parent).find(Selector.DATA_TOGGLE)[0];
            $(toggle).trigger('focus');
          }

          $(this).trigger('click');
          return;
        }

        var items = $.makeArray($(Selector.VISIBLE_ITEMS));

        items = items.filter(function (item) {
          return item.offsetWidth || item.offsetHeight;
        });

        if (!items.length) {
          return;
        }

        var index = items.indexOf(event.target);

        if (event.which === 38 && index > 0) {
          // up
          index--;
        }

        if (event.which === 40 && index < items.length - 1) {
          // down
          index++;
        }

        if (! ~index) {
          index = 0;
        }

        items[index].focus();
      }
    }, {
      key: 'VERSION',
      get: function get() {
        return VERSION;
      }
    }]);

    return Dropdown;
  })();

  $(document).on(Event.KEYDOWN_DATA_API, Selector.DATA_TOGGLE, Dropdown._dataApiKeydownHandler).on(Event.KEYDOWN_DATA_API, Selector.ROLE_MENU, Dropdown._dataApiKeydownHandler).on(Event.KEYDOWN_DATA_API, Selector.ROLE_LISTBOX, Dropdown._dataApiKeydownHandler).on(Event.CLICK_DATA_API, Dropdown._clearMenus).on(Event.CLICK_DATA_API, Selector.DATA_TOGGLE, Dropdown.prototype.toggle).on(Event.CLICK_DATA_API, Selector.FORM_CHILD, function (e) {
    e.stopPropagation();
  });

  /**
   * ------------------------------------------------------------------------
   * jQuery
   * ------------------------------------------------------------------------
   */

  $.fn[NAME] = Dropdown._jQueryInterface;
  $.fn[NAME].Constructor = Dropdown;
  $.fn[NAME].noConflict = function () {
    $.fn[NAME] = JQUERY_NO_CONFLICT;
    return Dropdown._jQueryInterface;
  };

  return Dropdown;
})(jQuery);

/**
 * --------------------------------------------------------------------------
 * Bootstrap (v4.0.0): modal.js
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * --------------------------------------------------------------------------
 */

var Modal = (function ($) {

  /**
   * ------------------------------------------------------------------------
   * Constants
   * ------------------------------------------------------------------------
   */

  var NAME = 'modal';
  var VERSION = '4.0.0';
  var DATA_KEY = 'bs.modal';
  var EVENT_KEY = '.' + DATA_KEY;
  var DATA_API_KEY = '.data-api';
  var JQUERY_NO_CONFLICT = $.fn[NAME];
  var TRANSITION_DURATION = 300;
  var BACKDROP_TRANSITION_DURATION = 150;

  var Default = {
    backdrop: true,
    keyboard: true,
    focus: true,
    show: true
  };

  var DefaultType = {
    backdrop: '(boolean|string)',
    keyboard: 'boolean',
    focus: 'boolean',
    show: 'boolean'
  };

  var Event = {
    HIDE: 'hide' + EVENT_KEY,
    HIDDEN: 'hidden' + EVENT_KEY,
    SHOW: 'show' + EVENT_KEY,
    SHOWN: 'shown' + EVENT_KEY,
    FOCUSIN: 'focusin' + EVENT_KEY,
    RESIZE: 'resize' + EVENT_KEY,
    CLICK_DISMISS: 'click.dismiss' + EVENT_KEY,
    KEYDOWN_DISMISS: 'keydown.dismiss' + EVENT_KEY,
    MOUSEUP_DISMISS: 'mouseup.dismiss' + EVENT_KEY,
    MOUSEDOWN_DISMISS: 'mousedown.dismiss' + EVENT_KEY,
    CLICK_DATA_API: 'click' + EVENT_KEY + DATA_API_KEY
  };

  var ClassName = {
    SCROLLBAR_MEASURER: 'modal-scrollbar-measure',
    BACKDROP: 'modal-backdrop',
    OPEN: 'modal-open',
    FADE: 'fade',
    IN: 'in'
  };

  var Selector = {
    DIALOG: '.modal-dialog',
    DATA_TOGGLE: '[data-toggle="modal"]',
    DATA_DISMISS: '[data-dismiss="modal"]',
    FIXED_CONTENT: '.navbar-fixed-top, .navbar-fixed-bottom, .is-fixed'
  };

  /**
   * ------------------------------------------------------------------------
   * Class Definition
   * ------------------------------------------------------------------------
   */

  var Modal = (function () {
    function Modal(element, config) {
      _classCallCheck(this, Modal);

      this._config = this._getConfig(config);
      this._element = element;
      this._dialog = $(element).find(Selector.DIALOG)[0];
      this._backdrop = null;
      this._isShown = false;
      this._isBodyOverflowing = false;
      this._ignoreBackdropClick = false;
      this._originalBodyPadding = 0;
      this._scrollbarWidth = 0;
    }

    /**
     * ------------------------------------------------------------------------
     * Data Api implementation
     * ------------------------------------------------------------------------
     */

    // getters

    _createClass(Modal, [{
      key: 'toggle',

      // public

      value: function toggle(relatedTarget) {
        return this._isShown ? this.hide() : this.show(relatedTarget);
      }
    }, {
      key: 'show',
      value: function show(relatedTarget) {
        var _this7 = this;

        var showEvent = $.Event(Event.SHOW, {
          relatedTarget: relatedTarget
        });

        $(this._element).trigger(showEvent);

        if (this._isShown || showEvent.isDefaultPrevented()) {
          return;
        }

        this._isShown = true;

        this._checkScrollbar();
        this._setScrollbar();

        $(document.body).addClass(ClassName.OPEN);

        this._setEscapeEvent();
        this._setResizeEvent();

        $(this._element).on(Event.CLICK_DISMISS, Selector.DATA_DISMISS, $.proxy(this.hide, this));

        $(this._dialog).on(Event.MOUSEDOWN_DISMISS, function () {
          $(_this7._element).one(Event.MOUSEUP_DISMISS, function (event) {
            if ($(event.target).is(_this7._element)) {
              that._ignoreBackdropClick = true;
            }
          });
        });

        this._showBackdrop($.proxy(this._showElement, this, relatedTarget));
      }
    }, {
      key: 'hide',
      value: function hide(event) {
        if (event) {
          event.preventDefault();
        }

        var hideEvent = $.Event(Event.HIDE);

        $(this._element).trigger(hideEvent);

        if (!this._isShown || hideEvent.isDefaultPrevented()) {
          return;
        }

        this._isShown = false;

        this._setEscapeEvent();
        this._setResizeEvent();

        $(document).off(Event.FOCUSIN);

        $(this._element).removeClass(ClassName.IN);

        $(this._element).off(Event.CLICK_DISMISS);
        $(this._dialog).off(Event.MOUSEDOWN_DISMISS);

        if (Util.supportsTransitionEnd() && $(this._element).hasClass(ClassName.FADE)) {

          $(this._element).one(Util.TRANSITION_END, $.proxy(this._hideModal, this)).emulateTransitionEnd(TRANSITION_DURATION);
        } else {
          this._hideModal();
        }
      }
    }, {
      key: 'dispose',
      value: function dispose() {
        $.removeData(this._element, DATA_KEY);

        $(window).off(EVENT_KEY);
        $(document).off(EVENT_KEY);
        $(this._element).off(EVENT_KEY);
        $(this._backdrop).off(EVENT_KEY);

        this._config = null;
        this._element = null;
        this._dialog = null;
        this._backdrop = null;
        this._isShown = null;
        this._isBodyOverflowing = null;
        this._ignoreBackdropClick = null;
        this._originalBodyPadding = null;
        this._scrollbarWidth = null;
      }

      // private

    }, {
      key: '_getConfig',
      value: function _getConfig(config) {
        config = $.extend({}, Default, config);
        Util.typeCheckConfig(NAME, config, DefaultType);
        return config;
      }
    }, {
      key: '_showElement',
      value: function _showElement(relatedTarget) {
        var _this8 = this;

        var transition = Util.supportsTransitionEnd() && $(this._element).hasClass(ClassName.FADE);

        if (!this._element.parentNode || this._element.parentNode.nodeType !== Node.ELEMENT_NODE) {
          // don't move modals dom position
          document.body.appendChild(this._element);
        }

        this._element.style.display = 'block';
        this._element.scrollTop = 0;

        if (transition) {
          Util.reflow(this._element);
        }

        $(this._element).addClass(ClassName.IN);

        if (this._config.focus) {
          this._enforceFocus();
        }

        var shownEvent = $.Event(Event.SHOWN, {
          relatedTarget: relatedTarget
        });

        var transitionComplete = function transitionComplete() {
          if (_this8._config.focus) {
            _this8._element.focus();
          }
          $(_this8._element).trigger(shownEvent);
        };

        if (transition) {
          $(this._dialog).one(Util.TRANSITION_END, transitionComplete).emulateTransitionEnd(TRANSITION_DURATION);
        } else {
          transitionComplete();
        }
      }
    }, {
      key: '_enforceFocus',
      value: function _enforceFocus() {
        var _this9 = this;

        $(document).off(Event.FOCUSIN) // guard against infinite focus loop
        .on(Event.FOCUSIN, function (event) {
          if (_this9._element !== event.target && !$(_this9._element).has(event.target).length) {
            _this9._element.focus();
          }
        });
      }
    }, {
      key: '_setEscapeEvent',
      value: function _setEscapeEvent() {
        var _this10 = this;

        if (this._isShown && this._config.keyboard) {
          $(this._element).on(Event.KEYDOWN_DISMISS, function (event) {
            if (event.which === 27) {
              _this10.hide();
            }
          });
        } else if (!this._isShown) {
          $(this._element).off(Event.KEYDOWN_DISMISS);
        }
      }
    }, {
      key: '_setResizeEvent',
      value: function _setResizeEvent() {
        if (this._isShown) {
          $(window).on(Event.RESIZE, $.proxy(this._handleUpdate, this));
        } else {
          $(window).off(Event.RESIZE);
        }
      }
    }, {
      key: '_hideModal',
      value: function _hideModal() {
        var _this11 = this;

        this._element.style.display = 'none';
        this._showBackdrop(function () {
          $(document.body).removeClass(ClassName.OPEN);
          _this11._resetAdjustments();
          _this11._resetScrollbar();
          $(_this11._element).trigger(Event.HIDDEN);
        });
      }
    }, {
      key: '_removeBackdrop',
      value: function _removeBackdrop() {
        if (this._backdrop) {
          $(this._backdrop).remove();
          this._backdrop = null;
        }
      }
    }, {
      key: '_showBackdrop',
      value: function _showBackdrop(callback) {
        var _this12 = this;

        var animate = $(this._element).hasClass(ClassName.FADE) ? ClassName.FADE : '';

        if (this._isShown && this._config.backdrop) {
          var doAnimate = Util.supportsTransitionEnd() && animate;

          this._backdrop = document.createElement('div');
          this._backdrop.className = ClassName.BACKDROP;

          if (animate) {
            $(this._backdrop).addClass(animate);
          }

          $(this._backdrop).appendTo(document.body);

          $(this._element).on(Event.CLICK_DISMISS, function (event) {
            if (_this12._ignoreBackdropClick) {
              _this12._ignoreBackdropClick = false;
              return;
            }
            if (event.target !== event.currentTarget) {
              return;
            }
            if (_this12._config.backdrop === 'static') {
              _this12._element.focus();
            } else {
              _this12.hide();
            }
          });

          if (doAnimate) {
            Util.reflow(this._backdrop);
          }

          $(this._backdrop).addClass(ClassName.IN);

          if (!callback) {
            return;
          }

          if (!doAnimate) {
            callback();
            return;
          }

          $(this._backdrop).one(Util.TRANSITION_END, callback).emulateTransitionEnd(BACKDROP_TRANSITION_DURATION);
        } else if (!this._isShown && this._backdrop) {
          $(this._backdrop).removeClass(ClassName.IN);

          var callbackRemove = function callbackRemove() {
            _this12._removeBackdrop();
            if (callback) {
              callback();
            }
          };

          if (Util.supportsTransitionEnd() && $(this._element).hasClass(ClassName.FADE)) {
            $(this._backdrop).one(Util.TRANSITION_END, callbackRemove).emulateTransitionEnd(BACKDROP_TRANSITION_DURATION);
          } else {
            callbackRemove();
          }
        } else if (callback) {
          callback();
        }
      }

      // ----------------------------------------------------------------------
      // the following methods are used to handle overflowing modals
      // todo (fat): these should probably be refactored out of modal.js
      // ----------------------------------------------------------------------

    }, {
      key: '_handleUpdate',
      value: function _handleUpdate() {
        this._adjustDialog();
      }
    }, {
      key: '_adjustDialog',
      value: function _adjustDialog() {
        var isModalOverflowing = this._element.scrollHeight > document.documentElement.clientHeight;

        if (!this._isBodyOverflowing && isModalOverflowing) {
          this._element.style.paddingLeft = this._scrollbarWidth + 'px';
        }

        if (this._isBodyOverflowing && !isModalOverflowing) {
          this._element.style.paddingRight = this._scrollbarWidth + 'px~';
        }
      }
    }, {
      key: '_resetAdjustments',
      value: function _resetAdjustments() {
        this._element.style.paddingLeft = '';
        this._element.style.paddingRight = '';
      }
    }, {
      key: '_checkScrollbar',
      value: function _checkScrollbar() {
        var fullWindowWidth = window.innerWidth;
        if (!fullWindowWidth) {
          // workaround for missing window.innerWidth in IE8
          var documentElementRect = document.documentElement.getBoundingClientRect();
          fullWindowWidth = documentElementRect.right - Math.abs(documentElementRect.left);
        }
        this._isBodyOverflowing = document.body.clientWidth < fullWindowWidth;
        this._scrollbarWidth = this._getScrollbarWidth();
      }
    }, {
      key: '_setScrollbar',
      value: function _setScrollbar() {
        var bodyPadding = parseInt($(Selector.FIXED_CONTENT).css('padding-right') || 0, 10);

        this._originalBodyPadding = document.body.style.paddingRight || '';

        if (this._isBodyOverflowing) {
          document.body.style.paddingRight = bodyPadding + (this._scrollbarWidth + 'px');
        }
      }
    }, {
      key: '_resetScrollbar',
      value: function _resetScrollbar() {
        document.body.style.paddingRight = this._originalBodyPadding;
      }
    }, {
      key: '_getScrollbarWidth',
      value: function _getScrollbarWidth() {
        // thx d.walsh
        var scrollDiv = document.createElement('div');
        scrollDiv.className = ClassName.SCROLLBAR_MEASURER;
        document.body.appendChild(scrollDiv);
        var scrollbarWidth = scrollDiv.offsetWidth - scrollDiv.clientWidth;
        document.body.removeChild(scrollDiv);
        return scrollbarWidth;
      }

      // static

    }], [{
      key: '_jQueryInterface',
      value: function _jQueryInterface(config, relatedTarget) {
        return this.each(function () {
          var data = $(this).data(DATA_KEY);
          var _config = $.extend({}, Modal.Default, $(this).data(), typeof config === 'object' && config);

          if (!data) {
            data = new Modal(this, _config);
            $(this).data(DATA_KEY, data);
          }

          if (typeof config === 'string') {
            data[config](relatedTarget);
          } else if (_config.show) {
            data.show(relatedTarget);
          }
        });
      }
    }, {
      key: 'VERSION',
      get: function get() {
        return VERSION;
      }
    }, {
      key: 'Default',
      get: function get() {
        return Default;
      }
    }]);

    return Modal;
  })();

  $(document).on(Event.CLICK_DATA_API, Selector.DATA_TOGGLE, function (event) {
    var _this13 = this;

    var target = undefined;
    var selector = Util.getSelectorFromElement(this);

    if (selector) {
      target = $(selector)[0];
    }

    var config = $(target).data(DATA_KEY) ? 'toggle' : $.extend({}, $(target).data(), $(this).data());

    if (this.tagName === 'A') {
      event.preventDefault();
    }

    var $target = $(target).one(Event.SHOW, function (showEvent) {
      if (showEvent.isDefaultPrevented()) {
        // only register focus restorer if modal will actually get shown
        return;
      }

      $target.one(Event.HIDDEN, function () {
        if ($(_this13).is(':visible')) {
          _this13.focus();
        }
      });
    });

    Modal._jQueryInterface.call($(target), config, this);
  });

  /**
   * ------------------------------------------------------------------------
   * jQuery
   * ------------------------------------------------------------------------
   */

  $.fn[NAME] = Modal._jQueryInterface;
  $.fn[NAME].Constructor = Modal;
  $.fn[NAME].noConflict = function () {
    $.fn[NAME] = JQUERY_NO_CONFLICT;
    return Modal._jQueryInterface;
  };

  return Modal;
})(jQuery);

/**
 * --------------------------------------------------------------------------
 * Bootstrap (v4.0.0): scrollspy.js
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * --------------------------------------------------------------------------
 */

var ScrollSpy = (function ($) {

  /**
   * ------------------------------------------------------------------------
   * Constants
   * ------------------------------------------------------------------------
   */

  var NAME = 'scrollspy';
  var VERSION = '4.0.0';
  var DATA_KEY = 'bs.scrollspy';
  var EVENT_KEY = '.' + DATA_KEY;
  var DATA_API_KEY = '.data-api';
  var JQUERY_NO_CONFLICT = $.fn[NAME];

  var Default = {
    offset: 10,
    method: 'auto',
    target: ''
  };

  var DefaultType = {
    offset: 'number',
    method: 'string',
    target: '(string|element)'
  };

  var Event = {
    ACTIVATE: 'activate' + EVENT_KEY,
    SCROLL: 'scroll' + EVENT_KEY,
    LOAD_DATA_API: 'load' + EVENT_KEY + DATA_API_KEY
  };

  var ClassName = {
    DROPDOWN_ITEM: 'dropdown-item',
    DROPDOWN_MENU: 'dropdown-menu',
    NAV_LINK: 'nav-link',
    NAV: 'nav',
    ACTIVE: 'active'
  };

  var Selector = {
    DATA_SPY: '[data-spy="scroll"]',
    ACTIVE: '.active',
    LIST_ITEM: '.list-item',
    LI: 'li',
    LI_DROPDOWN: 'li.dropdown',
    NAV_LINKS: '.nav-link',
    DROPDOWN: '.dropdown',
    DROPDOWN_ITEMS: '.dropdown-item',
    DROPDOWN_TOGGLE: '.dropdown-toggle'
  };

  var OffsetMethod = {
    OFFSET: 'offset',
    POSITION: 'position'
  };

  /**
   * ------------------------------------------------------------------------
   * Class Definition
   * ------------------------------------------------------------------------
   */

  var ScrollSpy = (function () {
    function ScrollSpy(element, config) {
      _classCallCheck(this, ScrollSpy);

      this._element = element;
      this._scrollElement = element.tagName === 'BODY' ? window : element;
      this._config = this._getConfig(config);
      this._selector = this._config.target + ' ' + Selector.NAV_LINKS + ',' + (this._config.target + ' ' + Selector.DROPDOWN_ITEMS);
      this._offsets = [];
      this._targets = [];
      this._activeTarget = null;
      this._scrollHeight = 0;

      $(this._scrollElement).on(Event.SCROLL, $.proxy(this._process, this));

      this.refresh();
      this._process();
    }

    /**
     * ------------------------------------------------------------------------
     * Data Api implementation
     * ------------------------------------------------------------------------
     */

    // getters

    _createClass(ScrollSpy, [{
      key: 'refresh',

      // public

      value: function refresh() {
        var _this14 = this;

        var autoMethod = this._scrollElement !== this._scrollElement.window ? OffsetMethod.POSITION : OffsetMethod.OFFSET;

        var offsetMethod = this._config.method === 'auto' ? autoMethod : this._config.method;

        var offsetBase = offsetMethod === OffsetMethod.POSITION ? this._getScrollTop() : 0;

        this._offsets = [];
        this._targets = [];

        this._scrollHeight = this._getScrollHeight();

        var targets = $.makeArray($(this._selector));

        targets.map(function (element) {
          var target = undefined;
          var targetSelector = Util.getSelectorFromElement(element);

          if (targetSelector) {
            target = $(targetSelector)[0];
          }

          if (target && (target.offsetWidth || target.offsetHeight)) {
            // todo (fat): remove sketch reliance on jQuery position/offset
            return [$(target)[offsetMethod]().top + offsetBase, targetSelector];
          }
        }).filter(function (item) {
          return item;
        }).sort(function (a, b) {
          return a[0] - b[0];
        }).forEach(function (item) {
          _this14._offsets.push(item[0]);
          _this14._targets.push(item[1]);
        });
      }
    }, {
      key: 'dispose',
      value: function dispose() {
        $.removeData(this._element, DATA_KEY);
        $(this._scrollElement).off(EVENT_KEY);

        this._element = null;
        this._scrollElement = null;
        this._config = null;
        this._selector = null;
        this._offsets = null;
        this._targets = null;
        this._activeTarget = null;
        this._scrollHeight = null;
      }

      // private

    }, {
      key: '_getConfig',
      value: function _getConfig(config) {
        config = $.extend({}, Default, config);

        if (typeof config.target !== 'string') {
          var id = $(config.target).attr('id');
          if (!id) {
            id = Util.getUID(NAME);
            $(config.target).attr('id', id);
          }
          config.target = '#' + id;
        }

        Util.typeCheckConfig(NAME, config, DefaultType);

        return config;
      }
    }, {
      key: '_getScrollTop',
      value: function _getScrollTop() {
        return this._scrollElement === window ? this._scrollElement.scrollY : this._scrollElement.scrollTop;
      }
    }, {
      key: '_getScrollHeight',
      value: function _getScrollHeight() {
        return this._scrollElement.scrollHeight || Math.max(document.body.scrollHeight, document.documentElement.scrollHeight);
      }
    }, {
      key: '_process',
      value: function _process() {
        var scrollTop = this._getScrollTop() + this._config.offset;
        var scrollHeight = this._getScrollHeight();
        var maxScroll = this._config.offset + scrollHeight - this._scrollElement.offsetHeight;

        if (this._scrollHeight !== scrollHeight) {
          this.refresh();
        }

        if (scrollTop >= maxScroll) {
          var target = this._targets[this._targets.length - 1];

          if (this._activeTarget !== target) {
            this._activate(target);
          }
        }

        if (this._activeTarget && scrollTop < this._offsets[0]) {
          this._activeTarget = null;
          this._clear();
          return;
        }

        for (var i = this._offsets.length; i--;) {
          var isActiveTarget = this._activeTarget !== this._targets[i] && scrollTop >= this._offsets[i] && (this._offsets[i + 1] === undefined || scrollTop < this._offsets[i + 1]);

          if (isActiveTarget) {
            this._activate(this._targets[i]);
          }
        }
      }
    }, {
      key: '_activate',
      value: function _activate(target) {
        this._activeTarget = target;

        this._clear();

        var queries = this._selector.split(',');
        queries = queries.map(function (selector) {
          return selector + '[data-target="' + target + '"],' + (selector + '[href="' + target + '"]');
        });

        var $link = $(queries.join(','));

        if ($link.hasClass(ClassName.DROPDOWN_ITEM)) {
          $link.closest(Selector.DROPDOWN).find(Selector.DROPDOWN_TOGGLE).addClass(ClassName.ACTIVE);
          $link.addClass(ClassName.ACTIVE);
        } else {
          // todo (fat) this is kinda sus…
          // recursively add actives to tested nav-links
          $link.parents(Selector.LI).find(Selector.NAV_LINKS).addClass(ClassName.ACTIVE);
        }

        $(this._scrollElement).trigger(Event.ACTIVATE, {
          relatedTarget: target
        });
      }
    }, {
      key: '_clear',
      value: function _clear() {
        $(this._selector).filter(Selector.ACTIVE).removeClass(ClassName.ACTIVE);
      }

      // static

    }], [{
      key: '_jQueryInterface',
      value: function _jQueryInterface(config) {
        return this.each(function () {
          var data = $(this).data(DATA_KEY);
          var _config = typeof config === 'object' && config || null;

          if (!data) {
            data = new ScrollSpy(this, _config);
            $(this).data(DATA_KEY, data);
          }

          if (typeof config === 'string') {
            data[config]();
          }
        });
      }
    }, {
      key: 'VERSION',
      get: function get() {
        return VERSION;
      }
    }, {
      key: 'Default',
      get: function get() {
        return Default;
      }
    }]);

    return ScrollSpy;
  })();

  $(window).on(Event.LOAD_DATA_API, function () {
    var scrollSpys = $.makeArray($(Selector.DATA_SPY));

    for (var i = scrollSpys.length; i--;) {
      var $spy = $(scrollSpys[i]);
      ScrollSpy._jQueryInterface.call($spy, $spy.data());
    }
  });

  /**
   * ------------------------------------------------------------------------
   * jQuery
   * ------------------------------------------------------------------------
   */

  $.fn[NAME] = ScrollSpy._jQueryInterface;
  $.fn[NAME].Constructor = ScrollSpy;
  $.fn[NAME].noConflict = function () {
    $.fn[NAME] = JQUERY_NO_CONFLICT;
    return ScrollSpy._jQueryInterface;
  };

  return ScrollSpy;
})(jQuery);

/**
 * --------------------------------------------------------------------------
 * Bootstrap (v4.0.0): tab.js
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * --------------------------------------------------------------------------
 */

var Tab = (function ($) {

  /**
   * ------------------------------------------------------------------------
   * Constants
   * ------------------------------------------------------------------------
   */

  var NAME = 'tab';
  var VERSION = '4.0.0';
  var DATA_KEY = 'bs.tab';
  var EVENT_KEY = '.' + DATA_KEY;
  var DATA_API_KEY = '.data-api';
  var JQUERY_NO_CONFLICT = $.fn[NAME];
  var TRANSITION_DURATION = 150;

  var Event = {
    HIDE: 'hide' + EVENT_KEY,
    HIDDEN: 'hidden' + EVENT_KEY,
    SHOW: 'show' + EVENT_KEY,
    SHOWN: 'shown' + EVENT_KEY,
    CLICK_DATA_API: 'click' + EVENT_KEY + DATA_API_KEY
  };

  var ClassName = {
    DROPDOWN_MENU: 'dropdown-menu',
    ACTIVE: 'active',
    FADE: 'fade',
    IN: 'in'
  };

  var Selector = {
    A: 'a',
    LI: 'li',
    DROPDOWN: '.dropdown',
    UL: 'ul:not(.dropdown-menu)',
    FADE_CHILD: '> .nav-item .fade, > .fade',
    ACTIVE: '.active',
    ACTIVE_CHILD: '> .nav-item > .active, > .active',
    DATA_TOGGLE: '[data-toggle="tab"], [data-toggle="pill"]',
    DROPDOWN_TOGGLE: '.dropdown-toggle',
    DROPDOWN_ACTIVE_CHILD: '> .dropdown-menu .active'
  };

  /**
   * ------------------------------------------------------------------------
   * Class Definition
   * ------------------------------------------------------------------------
   */

  var Tab = (function () {
    function Tab(element) {
      _classCallCheck(this, Tab);

      this._element = element;
    }

    /**
     * ------------------------------------------------------------------------
     * Data Api implementation
     * ------------------------------------------------------------------------
     */

    // getters

    _createClass(Tab, [{
      key: 'show',

      // public

      value: function show() {
        var _this15 = this;

        if (this._element.parentNode && this._element.parentNode.nodeType === Node.ELEMENT_NODE && $(this._element).hasClass(ClassName.ACTIVE)) {
          return;
        }

        var target = undefined;
        var previous = undefined;
        var ulElement = $(this._element).closest(Selector.UL)[0];
        var selector = Util.getSelectorFromElement(this._element);

        if (ulElement) {
          previous = $.makeArray($(ulElement).find(Selector.ACTIVE));
          previous = previous[previous.length - 1];
        }

        var hideEvent = $.Event(Event.HIDE, {
          relatedTarget: this._element
        });

        var showEvent = $.Event(Event.SHOW, {
          relatedTarget: previous
        });

        if (previous) {
          $(previous).trigger(hideEvent);
        }

        $(this._element).trigger(showEvent);

        if (showEvent.isDefaultPrevented() || hideEvent.isDefaultPrevented()) {
          return;
        }

        if (selector) {
          target = $(selector)[0];
        }

        this._activate(this._element, ulElement);

        var complete = function complete() {
          var hiddenEvent = $.Event(Event.HIDDEN, {
            relatedTarget: _this15._element
          });

          var shownEvent = $.Event(Event.SHOWN, {
            relatedTarget: previous
          });

          $(previous).trigger(hiddenEvent);
          $(_this15._element).trigger(shownEvent);
        };

        if (target) {
          this._activate(target, target.parentNode, complete);
        } else {
          complete();
        }
      }
    }, {
      key: 'dispose',
      value: function dispose() {
        $.removeClass(this._element, DATA_KEY);
        this._element = null;
      }

      // private

    }, {
      key: '_activate',
      value: function _activate(element, container, callback) {
        var active = $(container).find(Selector.ACTIVE_CHILD)[0];
        var isTransitioning = callback && Util.supportsTransitionEnd() && (active && $(active).hasClass(ClassName.FADE) || Boolean($(container).find(Selector.FADE_CHILD)[0]));

        var complete = $.proxy(this._transitionComplete, this, element, active, isTransitioning, callback);

        if (active && isTransitioning) {
          $(active).one(Util.TRANSITION_END, complete).emulateTransitionEnd(TRANSITION_DURATION);
        } else {
          complete();
        }

        if (active) {
          $(active).removeClass(ClassName.IN);
        }
      }
    }, {
      key: '_transitionComplete',
      value: function _transitionComplete(element, active, isTransitioning, callback) {
        if (active) {
          $(active).removeClass(ClassName.ACTIVE);

          var dropdownChild = $(active).find(Selector.DROPDOWN_ACTIVE_CHILD)[0];

          if (dropdownChild) {
            $(dropdownChild).removeClass(ClassName.ACTIVE);
          }

          active.setAttribute('aria-expanded', false);
        }

        $(element).addClass(ClassName.ACTIVE);
        element.setAttribute('aria-expanded', true);

        if (isTransitioning) {
          Util.reflow(element);
          $(element).addClass(ClassName.IN);
        } else {
          $(element).removeClass(ClassName.FADE);
        }

        if (element.parentNode && $(element.parentNode).hasClass(ClassName.DROPDOWN_MENU)) {

          var dropdownElement = $(element).closest(Selector.DROPDOWN)[0];
          if (dropdownElement) {
            $(dropdownElement).find(Selector.DROPDOWN_TOGGLE).addClass(ClassName.ACTIVE);
          }

          element.setAttribute('aria-expanded', true);
        }

        if (callback) {
          callback();
        }
      }

      // static

    }], [{
      key: '_jQueryInterface',
      value: function _jQueryInterface(config) {
        return this.each(function () {
          var $this = $(this);
          var data = $this.data(DATA_KEY);

          if (!data) {
            data = data = new Tab(this);
            $this.data(DATA_KEY, data);
          }

          if (typeof config === 'string') {
            data[config]();
          }
        });
      }
    }, {
      key: 'VERSION',
      get: function get() {
        return VERSION;
      }
    }]);

    return Tab;
  })();

  $(document).on(Event.CLICK_DATA_API, Selector.DATA_TOGGLE, function (event) {
    event.preventDefault();
    Tab._jQueryInterface.call($(this), 'show');
  });

  /**
   * ------------------------------------------------------------------------
   * jQuery
   * ------------------------------------------------------------------------
   */

  $.fn[NAME] = Tab._jQueryInterface;
  $.fn[NAME].Constructor = Tab;
  $.fn[NAME].noConflict = function () {
    $.fn[NAME] = JQUERY_NO_CONFLICT;
    return Tab._jQueryInterface;
  };

  return Tab;
})(jQuery);

/**
 * --------------------------------------------------------------------------
 * Bootstrap (v4.0.0): tooltip.js
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * --------------------------------------------------------------------------
 */

var Tooltip = (function ($) {

  /**
   * ------------------------------------------------------------------------
   * Constants
   * ------------------------------------------------------------------------
   */

  var NAME = 'tooltip';
  var VERSION = '4.0.0';
  var DATA_KEY = 'bs.tooltip';
  var EVENT_KEY = '.' + DATA_KEY;
  var JQUERY_NO_CONFLICT = $.fn[NAME];
  var TRANSITION_DURATION = 150;
  var CLASS_PREFIX = 'bs-tether';

  var Default = {
    animation: true,
    template: '<div class="tooltip" role="tooltip">' + '<div class="tooltip-arrow"></div>' + '<div class="tooltip-inner"></div></div>',
    trigger: 'hover focus',
    title: '',
    delay: 0,
    html: false,
    selector: false,
    placement: 'top',
    offset: '0 0',
    constraints: []
  };

  var DefaultType = {
    animation: 'boolean',
    template: 'string',
    title: '(string|function)',
    trigger: 'string',
    delay: '(number|object)',
    html: 'boolean',
    selector: '(string|boolean)',
    placement: '(string|function)',
    offset: 'string',
    constraints: 'array'
  };

  var AttachmentMap = {
    TOP: 'bottom center',
    RIGHT: 'middle left',
    BOTTOM: 'top center',
    LEFT: 'middle right'
  };

  var HoverState = {
    IN: 'in',
    OUT: 'out'
  };

  var Event = {
    HIDE: 'hide' + EVENT_KEY,
    HIDDEN: 'hidden' + EVENT_KEY,
    SHOW: 'show' + EVENT_KEY,
    SHOWN: 'shown' + EVENT_KEY,
    INSERTED: 'inserted' + EVENT_KEY,
    CLICK: 'click' + EVENT_KEY,
    FOCUSIN: 'focusin' + EVENT_KEY,
    FOCUSOUT: 'focusout' + EVENT_KEY,
    MOUSEENTER: 'mouseenter' + EVENT_KEY,
    MOUSELEAVE: 'mouseleave' + EVENT_KEY
  };

  var ClassName = {
    FADE: 'fade',
    IN: 'in'
  };

  var Selector = {
    TOOLTIP: '.tooltip',
    TOOLTIP_INNER: '.tooltip-inner'
  };

  var TetherClass = {
    element: false,
    enabled: false
  };

  var Trigger = {
    HOVER: 'hover',
    FOCUS: 'focus',
    CLICK: 'click',
    MANUAL: 'manual'
  };

  /**
   * ------------------------------------------------------------------------
   * Class Definition
   * ------------------------------------------------------------------------
   */

  var Tooltip = (function () {
    function Tooltip(element, config) {
      _classCallCheck(this, Tooltip);

      // private
      this._isEnabled = true;
      this._timeout = 0;
      this._hoverState = '';
      this._activeTrigger = {};
      this._tether = null;

      // protected
      this.element = element;
      this.config = this._getConfig(config);
      this.tip = null;

      this._setListeners();
    }

    /**
     * ------------------------------------------------------------------------
     * jQuery
     * ------------------------------------------------------------------------
     */

    // getters

    _createClass(Tooltip, [{
      key: 'enable',

      // public

      value: function enable() {
        this._isEnabled = true;
      }
    }, {
      key: 'disable',
      value: function disable() {
        this._isEnabled = false;
      }
    }, {
      key: 'toggleEnabled',
      value: function toggleEnabled() {
        this._isEnabled = !this._isEnabled;
      }
    }, {
      key: 'toggle',
      value: function toggle(event) {
        if (event) {
          var dataKey = this.constructor.DATA_KEY;
          var context = $(event.currentTarget).data(dataKey);

          if (!context) {
            context = new this.constructor(event.currentTarget, this._getDelegateConfig());
            $(event.currentTarget).data(dataKey, context);
          }

          context._activeTrigger.click = !context._activeTrigger.click;

          if (context._isWithActiveTrigger()) {
            context._enter(null, context);
          } else {
            context._leave(null, context);
          }
        } else {

          if ($(this.getTipElement()).hasClass(ClassName.IN)) {
            this._leave(null, this);
            return;
          }

          this._enter(null, this);
        }
      }
    }, {
      key: 'dispose',
      value: function dispose() {
        clearTimeout(this._timeout);

        this.cleanupTether();

        $.removeData(this.element, this.constructor.DATA_KEY);

        $(this.element).off(this.constructor.EVENT_KEY);

        if (this.tip) {
          $(this.tip).remove();
        }

        this._isEnabled = null;
        this._timeout = null;
        this._hoverState = null;
        this._activeTrigger = null;
        this._tether = null;

        this.element = null;
        this.config = null;
        this.tip = null;
      }
    }, {
      key: 'show',
      value: function show() {
        var _this16 = this;

        var showEvent = $.Event(this.constructor.Event.SHOW);

        if (this.isWithContent() && this._isEnabled) {
          $(this.element).trigger(showEvent);

          var isInTheDom = $.contains(this.element.ownerDocument.documentElement, this.element);

          if (showEvent.isDefaultPrevented() || !isInTheDom) {
            return;
          }

          var tip = this.getTipElement();
          var tipId = Util.getUID(this.constructor.NAME);

          tip.setAttribute('id', tipId);
          this.element.setAttribute('aria-describedby', tipId);

          this.setContent();

          if (this.config.animation) {
            $(tip).addClass(ClassName.FADE);
          }

          var placement = typeof this.config.placement === 'function' ? this.config.placement.call(this, tip, this.element) : this.config.placement;

          var attachment = this._getAttachment(placement);

          $(tip).data(this.constructor.DATA_KEY, this).appendTo(document.body);

          $(this.element).trigger(this.constructor.Event.INSERTED);

          this._tether = new Tether({
            attachment: attachment,
            element: tip,
            target: this.element,
            classes: TetherClass,
            classPrefix: CLASS_PREFIX,
            offset: this.config.offset,
            constraints: this.config.constraints
          });

          Util.reflow(tip);
          this._tether.position();

          $(tip).addClass(ClassName.IN);

          var complete = function complete() {
            var prevHoverState = _this16._hoverState;
            _this16._hoverState = null;

            $(_this16.element).trigger(_this16.constructor.Event.SHOWN);

            if (prevHoverState === HoverState.OUT) {
              _this16._leave(null, _this16);
            }
          };

          if (Util.supportsTransitionEnd() && $(this.tip).hasClass(ClassName.FADE)) {
            $(this.tip).one(Util.TRANSITION_END, complete).emulateTransitionEnd(Tooltip._TRANSITION_DURATION);
            return;
          }

          complete();
        }
      }
    }, {
      key: 'hide',
      value: function hide(callback) {
        var _this17 = this;

        var tip = this.getTipElement();
        var hideEvent = $.Event(this.constructor.Event.HIDE);
        var complete = function complete() {
          if (_this17._hoverState !== HoverState.IN && tip.parentNode) {
            tip.parentNode.removeChild(tip);
          }

          _this17.element.removeAttribute('aria-describedby');
          $(_this17.element).trigger(_this17.constructor.Event.HIDDEN);
          _this17.cleanupTether();

          if (callback) {
            callback();
          }
        };

        $(this.element).trigger(hideEvent);

        if (hideEvent.isDefaultPrevented()) {
          return;
        }

        $(tip).removeClass(ClassName.IN);

        if (Util.supportsTransitionEnd() && $(this.tip).hasClass(ClassName.FADE)) {

          $(tip).one(Util.TRANSITION_END, complete).emulateTransitionEnd(TRANSITION_DURATION);
        } else {
          complete();
        }

        this._hoverState = '';
      }

      // protected

    }, {
      key: 'isWithContent',
      value: function isWithContent() {
        return Boolean(this.getTitle());
      }
    }, {
      key: 'getTipElement',
      value: function getTipElement() {
        return this.tip = this.tip || $(this.config.template)[0];
      }
    }, {
      key: 'setContent',
      value: function setContent() {
        var tip = this.getTipElement();
        var title = this.getTitle();
        var method = this.config.html ? 'innerHTML' : 'innerText';

        $(tip).find(Selector.TOOLTIP_INNER)[0][method] = title;

        $(tip).removeClass(ClassName.FADE).removeClass(ClassName.IN);

        this.cleanupTether();
      }
    }, {
      key: 'getTitle',
      value: function getTitle() {
        var title = this.element.getAttribute('data-original-title');

        if (!title) {
          title = typeof this.config.title === 'function' ? this.config.title.call(this.element) : this.config.title;
        }

        return title;
      }
    }, {
      key: 'cleanupTether',
      value: function cleanupTether() {
        if (this._tether) {
          this._tether.destroy();

          // clean up after tether's junk classes
          // remove after they fix issue
          // (https://github.com/HubSpot/tether/issues/36)
          $(this.element).removeClass(this._removeTetherClasses);
          $(this.tip).removeClass(this._removeTetherClasses);
        }
      }

      // private

    }, {
      key: '_getAttachment',
      value: function _getAttachment(placement) {
        return AttachmentMap[placement.toUpperCase()];
      }
    }, {
      key: '_setListeners',
      value: function _setListeners() {
        var _this18 = this;

        var triggers = this.config.trigger.split(' ');

        triggers.forEach(function (trigger) {
          if (trigger === 'click') {
            $(_this18.element).on(_this18.constructor.Event.CLICK, _this18.config.selector, $.proxy(_this18.toggle, _this18));
          } else if (trigger !== Trigger.MANUAL) {
            var eventIn = trigger === Trigger.HOVER ? _this18.constructor.Event.MOUSEENTER : _this18.constructor.Event.FOCUSIN;
            var eventOut = trigger === Trigger.HOVER ? _this18.constructor.Event.MOUSELEAVE : _this18.constructor.Event.FOCUSOUT;

            $(_this18.element).on(eventIn, _this18.config.selector, $.proxy(_this18._enter, _this18)).on(eventOut, _this18.config.selector, $.proxy(_this18._leave, _this18));
          }
        });

        if (this.config.selector) {
          this.config = $.extend({}, this.config, {
            trigger: 'manual',
            selector: ''
          });
        } else {
          this._fixTitle();
        }
      }
    }, {
      key: '_removeTetherClasses',
      value: function _removeTetherClasses(i, css) {
        return ((css.baseVal || css).match(new RegExp('(^|\\s)' + CLASS_PREFIX + '-\\S+', 'g')) || []).join(' ');
      }
    }, {
      key: '_fixTitle',
      value: function _fixTitle() {
        var titleType = typeof this.element.getAttribute('data-original-title');
        if (this.element.getAttribute('title') || titleType !== 'string') {
          this.element.setAttribute('data-original-title', this.element.getAttribute('title') || '');
          this.element.setAttribute('title', '');
        }
      }
    }, {
      key: '_enter',
      value: function _enter(event, context) {
        var dataKey = this.constructor.DATA_KEY;

        context = context || $(event.currentTarget).data(dataKey);

        if (!context) {
          context = new this.constructor(event.currentTarget, this._getDelegateConfig());
          $(event.currentTarget).data(dataKey, context);
        }

        if (event) {
          context._activeTrigger[event.type === 'focusin' ? Trigger.FOCUS : Trigger.HOVER] = true;
        }

        if ($(context.getTipElement()).hasClass(ClassName.IN) || context._hoverState === HoverState.IN) {
          context._hoverState = HoverState.IN;
          return;
        }

        clearTimeout(context._timeout);

        context._hoverState = HoverState.IN;

        if (!context.config.delay || !context.config.delay.show) {
          context.show();
          return;
        }

        context._timeout = setTimeout(function () {
          if (context._hoverState === HoverState.IN) {
            context.show();
          }
        }, context.config.delay.show);
      }
    }, {
      key: '_leave',
      value: function _leave(event, context) {
        var dataKey = this.constructor.DATA_KEY;

        context = context || $(event.currentTarget).data(dataKey);

        if (!context) {
          context = new this.constructor(event.currentTarget, this._getDelegateConfig());
          $(event.currentTarget).data(dataKey, context);
        }

        if (event) {
          context._activeTrigger[event.type === 'focusout' ? Trigger.FOCUS : Trigger.HOVER] = false;
        }

        if (context._isWithActiveTrigger()) {
          return;
        }

        clearTimeout(context._timeout);

        context._hoverState = HoverState.OUT;

        if (!context.config.delay || !context.config.delay.hide) {
          context.hide();
          return;
        }

        context._timeout = setTimeout(function () {
          if (context._hoverState === HoverState.OUT) {
            context.hide();
          }
        }, context.config.delay.hide);
      }
    }, {
      key: '_isWithActiveTrigger',
      value: function _isWithActiveTrigger() {
        for (var trigger in this._activeTrigger) {
          if (this._activeTrigger[trigger]) {
            return true;
          }
        }

        return false;
      }
    }, {
      key: '_getConfig',
      value: function _getConfig(config) {
        config = $.extend({}, this.constructor.Default, $(this.element).data(), config);

        if (config.delay && typeof config.delay === 'number') {
          config.delay = {
            show: config.delay,
            hide: config.delay
          };
        }

        Util.typeCheckConfig(NAME, config, this.constructor.DefaultType);

        return config;
      }
    }, {
      key: '_getDelegateConfig',
      value: function _getDelegateConfig() {
        var config = {};

        if (this.config) {
          for (var key in this.config) {
            if (this.constructor.Default[key] !== this.config[key]) {
              config[key] = this.config[key];
            }
          }
        }

        return config;
      }

      // static

    }], [{
      key: '_jQueryInterface',
      value: function _jQueryInterface(config) {
        return this.each(function () {
          var data = $(this).data(DATA_KEY);
          var _config = typeof config === 'object' ? config : null;

          if (!data && /destroy|hide/.test(config)) {
            return;
          }

          if (!data) {
            data = new Tooltip(this, _config);
            $(this).data(DATA_KEY, data);
          }

          if (typeof config === 'string') {
            data[config]();
          }
        });
      }
    }, {
      key: 'VERSION',
      get: function get() {
        return VERSION;
      }
    }, {
      key: 'Default',
      get: function get() {
        return Default;
      }
    }, {
      key: 'NAME',
      get: function get() {
        return NAME;
      }
    }, {
      key: 'DATA_KEY',
      get: function get() {
        return DATA_KEY;
      }
    }, {
      key: 'Event',
      get: function get() {
        return Event;
      }
    }, {
      key: 'EVENT_KEY',
      get: function get() {
        return EVENT_KEY;
      }
    }, {
      key: 'DefaultType',
      get: function get() {
        return DefaultType;
      }
    }]);

    return Tooltip;
  })();

  $.fn[NAME] = Tooltip._jQueryInterface;
  $.fn[NAME].Constructor = Tooltip;
  $.fn[NAME].noConflict = function () {
    $.fn[NAME] = JQUERY_NO_CONFLICT;
    return Tooltip._jQueryInterface;
  };

  return Tooltip;
})(jQuery);

/**
 * --------------------------------------------------------------------------
 * Bootstrap (v4.0.0): popover.js
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * --------------------------------------------------------------------------
 */

var Popover = (function ($) {

  /**
   * ------------------------------------------------------------------------
   * Constants
   * ------------------------------------------------------------------------
   */

  var NAME = 'popover';
  var VERSION = '4.0.0';
  var DATA_KEY = 'bs.popover';
  var EVENT_KEY = '.' + DATA_KEY;
  var JQUERY_NO_CONFLICT = $.fn[NAME];

  var Default = $.extend({}, Tooltip.Default, {
    placement: 'right',
    trigger: 'click',
    content: '',
    template: '<div class="popover" role="tooltip">' + '<div class="popover-arrow"></div>' + '<h3 class="popover-title"></h3>' + '<div class="popover-content"></div></div>'
  });

  var DefaultType = $.extend({}, Tooltip.DefaultType, {
    content: '(string|function)'
  });

  var ClassName = {
    FADE: 'fade',
    IN: 'in'
  };

  var Selector = {
    TITLE: '.popover-title',
    CONTENT: '.popover-content',
    ARROW: '.popover-arrow'
  };

  var Event = {
    HIDE: 'hide' + EVENT_KEY,
    HIDDEN: 'hidden' + EVENT_KEY,
    SHOW: 'show' + EVENT_KEY,
    SHOWN: 'shown' + EVENT_KEY,
    INSERTED: 'inserted' + EVENT_KEY,
    CLICK: 'click' + EVENT_KEY,
    FOCUSIN: 'focusin' + EVENT_KEY,
    FOCUSOUT: 'focusout' + EVENT_KEY,
    MOUSEENTER: 'mouseenter' + EVENT_KEY,
    MOUSELEAVE: 'mouseleave' + EVENT_KEY
  };

  /**
   * ------------------------------------------------------------------------
   * Class Definition
   * ------------------------------------------------------------------------
   */

  var Popover = (function (_Tooltip) {
    _inherits(Popover, _Tooltip);

    function Popover() {
      _classCallCheck(this, Popover);

      _get(Object.getPrototypeOf(Popover.prototype), 'constructor', this).apply(this, arguments);
    }

    /**
     * ------------------------------------------------------------------------
     * jQuery
     * ------------------------------------------------------------------------
     */

    _createClass(Popover, [{
      key: 'isWithContent',

      // overrides

      value: function isWithContent() {
        return this.getTitle() || this._getContent();
      }
    }, {
      key: 'getTipElement',
      value: function getTipElement() {
        return this.tip = this.tip || $(this.config.template)[0];
      }
    }, {
      key: 'setContent',
      value: function setContent() {
        var tip = this.getTipElement();
        var title = this.getTitle();
        var content = this._getContent();
        var titleElement = $(tip).find(Selector.TITLE)[0];

        if (titleElement) {
          titleElement[this.config.html ? 'innerHTML' : 'innerText'] = title;
        }

        // we use append for html objects to maintain js events
        $(tip).find(Selector.CONTENT).children().detach().end()[this.config.html ? typeof content === 'string' ? 'html' : 'append' : 'text'](content);

        $(tip).removeClass(ClassName.FADE).removeClass(ClassName.IN);

        this.cleanupTether();
      }

      // private

    }, {
      key: '_getContent',
      value: function _getContent() {
        return this.element.getAttribute('data-content') || (typeof this.config.content === 'function' ? this.config.content.call(this.element) : this.config.content);
      }

      // static

    }], [{
      key: '_jQueryInterface',
      value: function _jQueryInterface(config) {
        return this.each(function () {
          var data = $(this).data(DATA_KEY);
          var _config = typeof config === 'object' ? config : null;

          if (!data && /destroy|hide/.test(config)) {
            return;
          }

          if (!data) {
            data = new Popover(this, _config);
            $(this).data(DATA_KEY, data);
          }

          if (typeof config === 'string') {
            data[config]();
          }
        });
      }
    }, {
      key: 'VERSION',

      // getters

      get: function get() {
        return VERSION;
      }
    }, {
      key: 'Default',
      get: function get() {
        return Default;
      }
    }, {
      key: 'NAME',
      get: function get() {
        return NAME;
      }
    }, {
      key: 'DATA_KEY',
      get: function get() {
        return DATA_KEY;
      }
    }, {
      key: 'Event',
      get: function get() {
        return Event;
      }
    }, {
      key: 'EVENT_KEY',
      get: function get() {
        return EVENT_KEY;
      }
    }, {
      key: 'DefaultType',
      get: function get() {
        return DefaultType;
      }
    }]);

    return Popover;
  })(Tooltip);

  $.fn[NAME] = Popover._jQueryInterface;
  $.fn[NAME].Constructor = Popover;
  $.fn[NAME].noConflict = function () {
    $.fn[NAME] = JQUERY_NO_CONFLICT;
    return Popover._jQueryInterface;
  };

  return Popover;
})(jQuery);

}(jQuery);

/*!
 * Bootstrap v4.0.0-alpha (http://getbootstrap.com)
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 */
if("undefined"==typeof jQuery)throw new Error("Bootstrap's JavaScript requires jQuery");+function(a){var b=a.fn.jquery.split(" ")[0].split(".");if(b[0]<2&&b[1]<9||1==b[0]&&9==b[1]&&b[2]<1)throw new Error("Bootstrap's JavaScript requires jQuery version 1.9.1 or higher")}(jQuery),+function(){"use strict";function a(a,b){if("function"!=typeof b&&null!==b)throw new TypeError("Super expression must either be null or a function, not "+typeof b);a.prototype=Object.create(b&&b.prototype,{constructor:{value:a,enumerable:!1,writable:!0,configurable:!0}}),b&&(Object.setPrototypeOf?Object.setPrototypeOf(a,b):a.__proto__=b)}function b(a,b){if(!(a instanceof b))throw new TypeError("Cannot call a class as a function")}{var c=function(a,b,c){for(var d=!0;d;){var e=a,f=b,g=c;h=j=i=void 0,d=!1,null===e&&(e=Function.prototype);var h=Object.getOwnPropertyDescriptor(e,f);if(void 0!==h){if("value"in h)return h.value;var i=h.get;return void 0===i?void 0:i.call(g)}var j=Object.getPrototypeOf(e);if(null===j)return void 0;a=j,b=f,c=g,d=!0}},d=function(){function a(a,b){for(var c=0;c<b.length;c++){var d=b[c];d.enumerable=d.enumerable||!1,d.configurable=!0,"value"in d&&(d.writable=!0),Object.defineProperty(a,d.key,d)}}return function(b,c,d){return c&&a(b.prototype,c),d&&a(b,d),b}}(),e=function(a){function b(a){return{}.toString.call(a).match(/\s([a-zA-Z]+)/)[1].toLowerCase()}function c(a){return(a[0]||a).nodeType}function d(){return{bindType:h.end,delegateType:h.end,handle:function(b){return a(b.target).is(this)?b.handleObj.handler.apply(this,arguments):void 0}}}function e(){if(window.QUnit)return!1;var a=document.createElement("bootstrap");for(var b in i)if(void 0!==a.style[b])return{end:i[b]};return!1}function f(b){var c=this,d=!1;return a(this).one(j.TRANSITION_END,function(){d=!0}),setTimeout(function(){d||j.triggerTransitionEnd(c)},b),this}function g(){h=e(),a.fn.emulateTransitionEnd=f,j.supportsTransitionEnd()&&(a.event.special[j.TRANSITION_END]=d())}var h=!1,i={WebkitTransition:"webkitTransitionEnd",MozTransition:"transitionend",OTransition:"oTransitionEnd otransitionend",transition:"transitionend"},j={TRANSITION_END:"bsTransitionEnd",getUID:function(a){do a+=~~(1e6*Math.random());while(document.getElementById(a));return a},getSelectorFromElement:function(a){var b=a.getAttribute("data-target");return b||(b=a.getAttribute("href")||"",b=/^#[a-z]/i.test(b)?b:null),b},reflow:function(a){new Function("bs","return bs")(a.offsetHeight)},triggerTransitionEnd:function(b){a(b).trigger(h.end)},supportsTransitionEnd:function(){return Boolean(h)},typeCheckConfig:function(a,d,e){for(var f in e)if(e.hasOwnProperty(f)){var g=e[f],h=d[f],i=void 0;if(i=h&&c(h)?"element":b(h),!new RegExp(g).test(i))throw new Error(a.toUpperCase()+": "+('Option "'+f+'" provided type "'+i+'" ')+('but expected type "'+g+'".'))}}};return g(),j}(jQuery),f=(function(a){var c="alert",f="4.0.0",g="bs.alert",h="."+g,i=".data-api",j=a.fn[c],k=150,l={DISMISS:'[data-dismiss="alert"]'},m={CLOSE:"close"+h,CLOSED:"closed"+h,CLICK_DATA_API:"click"+h+i},n={ALERT:"alert",FADE:"fade",IN:"in"},o=function(){function c(a){b(this,c),this._element=a}return d(c,[{key:"close",value:function(a){a=a||this._element;var b=this._getRootElement(a),c=this._triggerCloseEvent(b);c.isDefaultPrevented()||this._removeElement(b)}},{key:"dispose",value:function(){a.removeData(this._element,g),this._element=null}},{key:"_getRootElement",value:function(b){var c=e.getSelectorFromElement(b),d=!1;return c&&(d=a(c)[0]),d||(d=a(b).closest("."+n.ALERT)[0]),d}},{key:"_triggerCloseEvent",value:function(b){var c=a.Event(m.CLOSE);return a(b).trigger(c),c}},{key:"_removeElement",value:function(b){return a(b).removeClass(n.IN),e.supportsTransitionEnd()&&a(b).hasClass(n.FADE)?void a(b).one(e.TRANSITION_END,a.proxy(this._destroyElement,this,b)).emulateTransitionEnd(k):void this._destroyElement(b)}},{key:"_destroyElement",value:function(b){a(b).detach().trigger(m.CLOSED).remove()}}],[{key:"_jQueryInterface",value:function(b){return this.each(function(){var d=a(this),e=d.data(g);e||(e=new c(this),d.data(g,e)),"close"===b&&e[b](this)})}},{key:"_handleDismiss",value:function(a){return function(b){b&&b.preventDefault(),a.close(this)}}},{key:"VERSION",get:function(){return f}}]),c}();return a(document).on(m.CLICK_DATA_API,l.DISMISS,o._handleDismiss(new o)),a.fn[c]=o._jQueryInterface,a.fn[c].Constructor=o,a.fn[c].noConflict=function(){return a.fn[c]=j,o._jQueryInterface},o}(jQuery),function(a){var c="button",e="4.0.0",f="bs.button",g="."+f,h=".data-api",i=a.fn[c],j={ACTIVE:"active",BUTTON:"btn",FOCUS:"focus"},k={DATA_TOGGLE_CARROT:'[data-toggle^="button"]',DATA_TOGGLE:'[data-toggle="buttons"]',INPUT:"input",ACTIVE:".active",BUTTON:".btn"},l={CLICK_DATA_API:"click"+g+h,FOCUS_BLUR_DATA_API:"focus"+g+h+" "+("blur"+g+h)},m=function(){function c(a){b(this,c),this._element=a}return d(c,[{key:"toggle",value:function(){var b=!0,c=a(this._element).closest(k.DATA_TOGGLE)[0];if(c){var d=a(this._element).find(k.INPUT)[0];if(d){if("radio"===d.type)if(d.checked&&a(this._element).hasClass(j.ACTIVE))b=!1;else{var e=a(c).find(k.ACTIVE)[0];e&&a(e).removeClass(j.ACTIVE)}b&&(d.checked=!a(this._element).hasClass(j.ACTIVE),a(this._element).trigger("change"))}}else this._element.setAttribute("aria-pressed",!a(this._element).hasClass(j.ACTIVE));b&&a(this._element).toggleClass(j.ACTIVE)}},{key:"dispose",value:function(){a.removeData(this._element,f),this._element=null}}],[{key:"_jQueryInterface",value:function(b){return this.each(function(){var d=a(this).data(f);d||(d=new c(this),a(this).data(f,d)),"toggle"===b&&d[b]()})}},{key:"VERSION",get:function(){return e}}]),c}();return a(document).on(l.CLICK_DATA_API,k.DATA_TOGGLE_CARROT,function(b){b.preventDefault();var c=b.target;a(c).hasClass(j.BUTTON)||(c=a(c).closest(k.BUTTON)),m._jQueryInterface.call(a(c),"toggle")}).on(l.FOCUS_BLUR_DATA_API,k.DATA_TOGGLE_CARROT,function(b){var c=a(b.target).closest(k.BUTTON)[0];a(c).toggleClass(j.FOCUS,/^focus(in)?$/.test(b.type))}),a.fn[c]=m._jQueryInterface,a.fn[c].Constructor=m,a.fn[c].noConflict=function(){return a.fn[c]=i,m._jQueryInterface},m}(jQuery),function(a){var c="carousel",f="4.0.0",g="bs.carousel",h="."+g,i=".data-api",j=a.fn[c],k=600,l={interval:5e3,keyboard:!0,slide:!1,pause:"hover",wrap:!0},m={interval:"(number|boolean)",keyboard:"boolean",slide:"(boolean|string)",pause:"(string|boolean)",wrap:"boolean"},n={NEXT:"next",PREVIOUS:"prev"},o={SLIDE:"slide"+h,SLID:"slid"+h,KEYDOWN:"keydown"+h,MOUSEENTER:"mouseenter"+h,MOUSELEAVE:"mouseleave"+h,LOAD_DATA_API:"load"+h+i,CLICK_DATA_API:"click"+h+i},p={CAROUSEL:"carousel",ACTIVE:"active",SLIDE:"slide",RIGHT:"right",LEFT:"left",ITEM:"carousel-item"},q={ACTIVE:".active",ACTIVE_ITEM:".active.carousel-item",ITEM:".carousel-item",NEXT_PREV:".next, .prev",INDICATORS:".carousel-indicators",DATA_SLIDE:"[data-slide], [data-slide-to]",DATA_RIDE:'[data-ride="carousel"]'},r=function(){function i(c,d){b(this,i),this._items=null,this._interval=null,this._activeElement=null,this._isPaused=!1,this._isSliding=!1,this._config=this._getConfig(d),this._element=a(c)[0],this._indicatorsElement=a(this._element).find(q.INDICATORS)[0],this._addEventListeners()}return d(i,[{key:"next",value:function(){this._isSliding||this._slide(n.NEXT)}},{key:"prev",value:function(){this._isSliding||this._slide(n.PREVIOUS)}},{key:"pause",value:function(b){b||(this._isPaused=!0),a(this._element).find(q.NEXT_PREV)[0]&&e.supportsTransitionEnd()&&(e.triggerTransitionEnd(this._element),this.cycle(!0)),clearInterval(this._interval),this._interval=null}},{key:"cycle",value:function(b){b||(this._isPaused=!1),this._interval&&(clearInterval(this._interval),this._interval=null),this._config.interval&&!this._isPaused&&(this._interval=setInterval(a.proxy(this.next,this),this._config.interval))}},{key:"to",value:function(b){var c=this;this._activeElement=a(this._element).find(q.ACTIVE_ITEM)[0];var d=this._getItemIndex(this._activeElement);if(!(b>this._items.length-1||0>b)){if(this._isSliding)return void a(this._element).one(o.SLID,function(){return c.to(b)});if(d===b)return this.pause(),void this.cycle();var e=b>d?n.NEXT:n.PREVIOUS;this._slide(e,this._items[b])}}},{key:"dispose",value:function(){a(this._element).off(h),a.removeData(this._element,g),this._items=null,this._config=null,this._element=null,this._interval=null,this._isPaused=null,this._isSliding=null,this._activeElement=null,this._indicatorsElement=null}},{key:"_getConfig",value:function(b){return b=a.extend({},l,b),e.typeCheckConfig(c,b,m),b}},{key:"_addEventListeners",value:function(){this._config.keyboard&&a(this._element).on(o.KEYDOWN,a.proxy(this._keydown,this)),"hover"!==this._config.pause||"ontouchstart"in document.documentElement||a(this._element).on(o.MOUSEENTER,a.proxy(this.pause,this)).on(o.MOUSELEAVE,a.proxy(this.cycle,this))}},{key:"_keydown",value:function(a){if(a.preventDefault(),!/input|textarea/i.test(a.target.tagName))switch(a.which){case 37:this.prev();break;case 39:this.next();break;default:return}}},{key:"_getItemIndex",value:function(b){return this._items=a.makeArray(a(b).parent().find(q.ITEM)),this._items.indexOf(b)}},{key:"_getItemByDirection",value:function(a,b){var c=a===n.NEXT,d=a===n.PREVIOUS,e=this._getItemIndex(b),f=this._items.length-1,g=d&&0===e||c&&e===f;if(g&&!this._config.wrap)return b;var h=a===n.PREVIOUS?-1:1,i=(e+h)%this._items.length;return-1===i?this._items[this._items.length-1]:this._items[i]}},{key:"_triggerSlideEvent",value:function(b,c){var d=a.Event(o.SLIDE,{relatedTarget:b,direction:c});return a(this._element).trigger(d),d}},{key:"_setActiveIndicatorElement",value:function(b){if(this._indicatorsElement){a(this._indicatorsElement).find(q.ACTIVE).removeClass(p.ACTIVE);var c=this._indicatorsElement.children[this._getItemIndex(b)];c&&a(c).addClass(p.ACTIVE)}}},{key:"_slide",value:function(b,c){var d=this,f=a(this._element).find(q.ACTIVE_ITEM)[0],g=c||f&&this._getItemByDirection(b,f),h=Boolean(this._interval),i=b===n.NEXT?p.LEFT:p.RIGHT;if(g&&a(g).hasClass(p.ACTIVE))return void(this._isSliding=!1);var j=this._triggerSlideEvent(g,i);if(!j.isDefaultPrevented()&&f&&g){this._isSliding=!0,h&&this.pause(),this._setActiveIndicatorElement(g);var l=a.Event(o.SLID,{relatedTarget:g,direction:i});e.supportsTransitionEnd()&&a(this._element).hasClass(p.SLIDE)?(a(g).addClass(b),e.reflow(g),a(f).addClass(i),a(g).addClass(i),a(f).one(e.TRANSITION_END,function(){a(g).removeClass(i).removeClass(b),a(g).addClass(p.ACTIVE),a(f).removeClass(p.ACTIVE).removeClass(b).removeClass(i),d._isSliding=!1,setTimeout(function(){return a(d._element).trigger(l)},0)}).emulateTransitionEnd(k)):(a(f).removeClass(p.ACTIVE),a(g).addClass(p.ACTIVE),this._isSliding=!1,a(this._element).trigger(l)),h&&this.cycle()}}}],[{key:"_jQueryInterface",value:function(b){return this.each(function(){var c=a(this).data(g),d=a.extend({},l,a(this).data());"object"==typeof b&&a.extend(d,b);var e="string"==typeof b?b:d.slide;c||(c=new i(this,d),a(this).data(g,c)),"number"==typeof b?c.to(b):e?c[e]():d.interval&&(c.pause(),c.cycle())})}},{key:"_dataApiClickHandler",value:function(b){var c=e.getSelectorFromElement(this);if(c){var d=a(c)[0];if(d&&a(d).hasClass(p.CAROUSEL)){var f=a.extend({},a(d).data(),a(this).data()),h=this.getAttribute("data-slide-to");h&&(f.interval=!1),i._jQueryInterface.call(a(d),f),h&&a(d).data(g).to(h),b.preventDefault()}}}},{key:"VERSION",get:function(){return f}},{key:"Default",get:function(){return l}}]),i}();return a(document).on(o.CLICK_DATA_API,q.DATA_SLIDE,r._dataApiClickHandler),a(window).on(o.LOAD_DATA_API,function(){a(q.DATA_RIDE).each(function(){var b=a(this);r._jQueryInterface.call(b,b.data())})}),a.fn[c]=r._jQueryInterface,a.fn[c].Constructor=r,a.fn[c].noConflict=function(){return a.fn[c]=j,r._jQueryInterface},r}(jQuery),function(a){var c="collapse",f="4.0.0",g="bs.collapse",h="."+g,i=".data-api",j=a.fn[c],k=600,l={toggle:!0,parent:""},m={toggle:"boolean",parent:"string"},n={SHOW:"show"+h,SHOWN:"shown"+h,HIDE:"hide"+h,HIDDEN:"hidden"+h,CLICK_DATA_API:"click"+h+i},o={IN:"in",COLLAPSE:"collapse",COLLAPSING:"collapsing",COLLAPSED:"collapsed"},p={WIDTH:"width",HEIGHT:"height"},q={ACTIVES:".panel > .in, .panel > .collapsing",DATA_TOGGLE:'[data-toggle="collapse"]'},r=function(){function h(c,d){b(this,h),this._isTransitioning=!1,this._element=c,this._config=this._getConfig(d),this._triggerArray=a.makeArray(a('[data-toggle="collapse"][href="#'+c.id+'"],'+('[data-toggle="collapse"][data-target="#'+c.id+'"]'))),this._parent=this._config.parent?this._getParent():null,this._config.parent||this._addAriaAndCollapsedClass(this._element,this._triggerArray),this._config.toggle&&this.toggle()}return d(h,[{key:"toggle",value:function(){a(this._element).hasClass(o.IN)?this.hide():this.show()}},{key:"show",value:function(){var b=this;if(!this._isTransitioning&&!a(this._element).hasClass(o.IN)){var c=void 0,d=void 0;if(this._parent&&(c=a.makeArray(a(q.ACTIVES)),c.length||(c=null)),!(c&&(d=a(c).data(g),d&&d._isTransitioning))){var f=a.Event(n.SHOW);if(a(this._element).trigger(f),!f.isDefaultPrevented()){c&&(h._jQueryInterface.call(a(c),"hide"),d||a(c).data(g,null));var i=this._getDimension();a(this._element).removeClass(o.COLLAPSE).addClass(o.COLLAPSING),this._element.style[i]=0,this._element.setAttribute("aria-expanded",!0),this._triggerArray.length&&a(this._triggerArray).removeClass(o.COLLAPSED).attr("aria-expanded",!0),this.setTransitioning(!0);var j=function(){a(b._element).removeClass(o.COLLAPSING).addClass(o.COLLAPSE).addClass(o.IN),b._element.style[i]="",b.setTransitioning(!1),a(b._element).trigger(n.SHOWN)};if(!e.supportsTransitionEnd())return void j();var l=i[0].toUpperCase()+i.slice(1),m="scroll"+l;a(this._element).one(e.TRANSITION_END,j).emulateTransitionEnd(k),this._element.style[i]=this._element[m]+"px"}}}}},{key:"hide",value:function(){var b=this;if(!this._isTransitioning&&a(this._element).hasClass(o.IN)){var c=a.Event(n.HIDE);if(a(this._element).trigger(c),!c.isDefaultPrevented()){var d=this._getDimension(),f=d===p.WIDTH?"offsetWidth":"offsetHeight";this._element.style[d]=this._element[f]+"px",e.reflow(this._element),a(this._element).addClass(o.COLLAPSING).removeClass(o.COLLAPSE).removeClass(o.IN),this._element.setAttribute("aria-expanded",!1),this._triggerArray.length&&a(this._triggerArray).addClass(o.COLLAPSED).attr("aria-expanded",!1),this.setTransitioning(!0);var g=function(){b.setTransitioning(!1),a(b._element).removeClass(o.COLLAPSING).addClass(o.COLLAPSE).trigger(n.HIDDEN)};return this._element.style[d]=0,e.supportsTransitionEnd()?void a(this._element).one(e.TRANSITION_END,g).emulateTransitionEnd(k):void g()}}}},{key:"setTransitioning",value:function(a){this._isTransitioning=a}},{key:"dispose",value:function(){a.removeData(this._element,g),this._config=null,this._parent=null,this._element=null,this._triggerArray=null,this._isTransitioning=null}},{key:"_getConfig",value:function(b){return b=a.extend({},l,b),b.toggle=Boolean(b.toggle),e.typeCheckConfig(c,b,m),b}},{key:"_getDimension",value:function(){var b=a(this._element).hasClass(p.WIDTH);return b?p.WIDTH:p.HEIGHT}},{key:"_getParent",value:function(){var b=this,c=a(this._config.parent)[0],d='[data-toggle="collapse"][data-parent="'+this._config.parent+'"]';return a(c).find(d).each(function(a,c){b._addAriaAndCollapsedClass(h._getTargetFromElement(c),[c])}),c}},{key:"_addAriaAndCollapsedClass",value:function(b,c){if(b){var d=a(b).hasClass(o.IN);b.setAttribute("aria-expanded",d),c.length&&a(c).toggleClass(o.COLLAPSED,!d).attr("aria-expanded",d)}}}],[{key:"_getTargetFromElement",value:function(b){var c=e.getSelectorFromElement(b);return c?a(c)[0]:null}},{key:"_jQueryInterface",value:function(b){return this.each(function(){var c=a(this),d=c.data(g),e=a.extend({},l,c.data(),"object"==typeof b&&b);!d&&e.toggle&&/show|hide/.test(b)&&(e.toggle=!1),d||(d=new h(this,e),c.data(g,d)),"string"==typeof b&&d[b]()})}},{key:"VERSION",get:function(){return f}},{key:"Default",get:function(){return l}}]),h}();return a(document).on(n.CLICK_DATA_API,q.DATA_TOGGLE,function(b){b.preventDefault();var c=r._getTargetFromElement(this),d=a(c).data(g),e=d?"toggle":a(this).data();r._jQueryInterface.call(a(c),e)}),a.fn[c]=r._jQueryInterface,a.fn[c].Constructor=r,a.fn[c].noConflict=function(){return a.fn[c]=j,r._jQueryInterface},r}(jQuery),function(a){var c="dropdown",f="4.0.0",g="bs.dropdown",h="."+g,i=".data-api",j=a.fn[c],k={HIDE:"hide"+h,HIDDEN:"hidden"+h,SHOW:"show"+h,SHOWN:"shown"+h,CLICK:"click"+h,CLICK_DATA_API:"click"+h+i,KEYDOWN_DATA_API:"keydown"+h+i},l={BACKDROP:"dropdown-backdrop",DISABLED:"disabled",OPEN:"open"},m={BACKDROP:".dropdown-backdrop",DATA_TOGGLE:'[data-toggle="dropdown"]',FORM_CHILD:".dropdown form",ROLE_MENU:'[role="menu"]',ROLE_LISTBOX:'[role="listbox"]',NAVBAR_NAV:".navbar-nav",VISIBLE_ITEMS:'[role="menu"] li:not(.disabled) a, [role="listbox"] li:not(.disabled) a'},n=function(){function c(a){b(this,c),this._element=a,this._addEventListeners()}return d(c,[{key:"toggle",value:function(){if(this.disabled||a(this).hasClass(l.DISABLED))return!1;var b=c._getParentFromElement(this),d=a(b).hasClass(l.OPEN);if(c._clearMenus(),d)return!1;if("ontouchstart"in document.documentElement&&!a(b).closest(m.NAVBAR_NAV).length){var e=document.createElement("div");e.className=l.BACKDROP,a(e).insertBefore(this),a(e).on("click",c._clearMenus)}var f={relatedTarget:this},g=a.Event(k.SHOW,f);return a(b).trigger(g),g.isDefaultPrevented()?!1:(this.focus(),this.setAttribute("aria-expanded","true"),a(b).toggleClass(l.OPEN),a(b).trigger(a.Event(k.SHOWN,f)),!1)}},{key:"dispose",value:function(){a.removeData(this._element,g),a(this._element).off(h),this._element=null}},{key:"_addEventListeners",value:function(){a(this._element).on(k.CLICK,this.toggle)}}],[{key:"_jQueryInterface",value:function(b){return this.each(function(){var d=a(this).data(g);d||a(this).data(g,d=new c(this)),"string"==typeof b&&d[b].call(this)})}},{key:"_clearMenus",value:function(b){if(!b||3!==b.which){var d=a(m.BACKDROP)[0];d&&d.parentNode.removeChild(d);for(var e=a.makeArray(a(m.DATA_TOGGLE)),f=0;f<e.length;f++){var g=c._getParentFromElement(e[f]),h={relatedTarget:e[f]};if(a(g).hasClass(l.OPEN)&&!(b&&"click"===b.type&&/input|textarea/i.test(b.target.tagName)&&a.contains(g,b.target))){var i=a.Event(k.HIDE,h);a(g).trigger(i),i.isDefaultPrevented()||(e[f].setAttribute("aria-expanded","false"),a(g).removeClass(l.OPEN).trigger(a.Event(k.HIDDEN,h)))}}}}},{key:"_getParentFromElement",value:function(b){var c=void 0,d=e.getSelectorFromElement(b);return d&&(c=a(d)[0]),c||b.parentNode}},{key:"_dataApiKeydownHandler",value:function(b){if(/(38|40|27|32)/.test(b.which)&&!/input|textarea/i.test(b.target.tagName)&&(b.preventDefault(),b.stopPropagation(),!this.disabled&&!a(this).hasClass(l.DISABLED))){var d=c._getParentFromElement(this),e=a(d).hasClass(l.OPEN);if(!e&&27!==b.which||e&&27===b.which){if(27===b.which){var f=a(d).find(m.DATA_TOGGLE)[0];a(f).trigger("focus")}return void a(this).trigger("click")}var g=a.makeArray(a(m.VISIBLE_ITEMS));if(g=g.filter(function(a){return a.offsetWidth||a.offsetHeight}),g.length){var h=g.indexOf(b.target);38===b.which&&h>0&&h--,40===b.which&&h<g.length-1&&h++,~h||(h=0),g[h].focus()}}}},{key:"VERSION",get:function(){return f}}]),c}();return a(document).on(k.KEYDOWN_DATA_API,m.DATA_TOGGLE,n._dataApiKeydownHandler).on(k.KEYDOWN_DATA_API,m.ROLE_MENU,n._dataApiKeydownHandler).on(k.KEYDOWN_DATA_API,m.ROLE_LISTBOX,n._dataApiKeydownHandler).on(k.CLICK_DATA_API,n._clearMenus).on(k.CLICK_DATA_API,m.DATA_TOGGLE,n.prototype.toggle).on(k.CLICK_DATA_API,m.FORM_CHILD,function(a){a.stopPropagation()}),a.fn[c]=n._jQueryInterface,a.fn[c].Constructor=n,a.fn[c].noConflict=function(){return a.fn[c]=j,n._jQueryInterface},n}(jQuery),function(a){var c="modal",f="4.0.0",g="bs.modal",h="."+g,i=".data-api",j=a.fn[c],k=300,l=150,m={backdrop:!0,keyboard:!0,focus:!0,show:!0},n={backdrop:"(boolean|string)",keyboard:"boolean",focus:"boolean",show:"boolean"},o={HIDE:"hide"+h,HIDDEN:"hidden"+h,SHOW:"show"+h,SHOWN:"shown"+h,FOCUSIN:"focusin"+h,RESIZE:"resize"+h,CLICK_DISMISS:"click.dismiss"+h,KEYDOWN_DISMISS:"keydown.dismiss"+h,MOUSEUP_DISMISS:"mouseup.dismiss"+h,MOUSEDOWN_DISMISS:"mousedown.dismiss"+h,CLICK_DATA_API:"click"+h+i},p={SCROLLBAR_MEASURER:"modal-scrollbar-measure",BACKDROP:"modal-backdrop",OPEN:"modal-open",FADE:"fade",IN:"in"},q={DIALOG:".modal-dialog",DATA_TOGGLE:'[data-toggle="modal"]',DATA_DISMISS:'[data-dismiss="modal"]',FIXED_CONTENT:".navbar-fixed-top, .navbar-fixed-bottom, .is-fixed"},r=function(){function i(c,d){b(this,i),this._config=this._getConfig(d),this._element=c,this._dialog=a(c).find(q.DIALOG)[0],this._backdrop=null,this._isShown=!1,this._isBodyOverflowing=!1,this._ignoreBackdropClick=!1,this._originalBodyPadding=0,this._scrollbarWidth=0}return d(i,[{key:"toggle",value:function(a){return this._isShown?this.hide():this.show(a)}},{key:"show",value:function(b){var c=this,d=a.Event(o.SHOW,{relatedTarget:b});a(this._element).trigger(d),this._isShown||d.isDefaultPrevented()||(this._isShown=!0,this._checkScrollbar(),this._setScrollbar(),a(document.body).addClass(p.OPEN),this._setEscapeEvent(),this._setResizeEvent(),a(this._element).on(o.CLICK_DISMISS,q.DATA_DISMISS,a.proxy(this.hide,this)),a(this._dialog).on(o.MOUSEDOWN_DISMISS,function(){a(c._element).one(o.MOUSEUP_DISMISS,function(b){a(b.target).is(c._element)&&(that._ignoreBackdropClick=!0)})}),this._showBackdrop(a.proxy(this._showElement,this,b)))}},{key:"hide",value:function(b){b&&b.preventDefault();var c=a.Event(o.HIDE);a(this._element).trigger(c),this._isShown&&!c.isDefaultPrevented()&&(this._isShown=!1,this._setEscapeEvent(),this._setResizeEvent(),a(document).off(o.FOCUSIN),a(this._element).removeClass(p.IN),a(this._element).off(o.CLICK_DISMISS),a(this._dialog).off(o.MOUSEDOWN_DISMISS),e.supportsTransitionEnd()&&a(this._element).hasClass(p.FADE)?a(this._element).one(e.TRANSITION_END,a.proxy(this._hideModal,this)).emulateTransitionEnd(k):this._hideModal())}},{key:"dispose",value:function(){a.removeData(this._element,g),a(window).off(h),a(document).off(h),a(this._element).off(h),a(this._backdrop).off(h),this._config=null,this._element=null,this._dialog=null,this._backdrop=null,this._isShown=null,this._isBodyOverflowing=null,this._ignoreBackdropClick=null,this._originalBodyPadding=null,this._scrollbarWidth=null}},{key:"_getConfig",value:function(b){return b=a.extend({},m,b),e.typeCheckConfig(c,b,n),b}},{key:"_showElement",value:function(b){var c=this,d=e.supportsTransitionEnd()&&a(this._element).hasClass(p.FADE);this._element.parentNode&&this._element.parentNode.nodeType===Node.ELEMENT_NODE||document.body.appendChild(this._element),this._element.style.display="block",this._element.scrollTop=0,d&&e.reflow(this._element),a(this._element).addClass(p.IN),this._config.focus&&this._enforceFocus();var f=a.Event(o.SHOWN,{relatedTarget:b}),g=function(){c._config.focus&&c._element.focus(),a(c._element).trigger(f)};d?a(this._dialog).one(e.TRANSITION_END,g).emulateTransitionEnd(k):g()}},{key:"_enforceFocus",value:function(){var b=this;a(document).off(o.FOCUSIN).on(o.FOCUSIN,function(c){b._element===c.target||a(b._element).has(c.target).length||b._element.focus()})}},{key:"_setEscapeEvent",value:function(){var b=this;this._isShown&&this._config.keyboard?a(this._element).on(o.KEYDOWN_DISMISS,function(a){27===a.which&&b.hide()}):this._isShown||a(this._element).off(o.KEYDOWN_DISMISS)}},{key:"_setResizeEvent",value:function(){this._isShown?a(window).on(o.RESIZE,a.proxy(this._handleUpdate,this)):a(window).off(o.RESIZE)}},{key:"_hideModal",value:function(){var b=this;this._element.style.display="none",this._showBackdrop(function(){a(document.body).removeClass(p.OPEN),b._resetAdjustments(),b._resetScrollbar(),a(b._element).trigger(o.HIDDEN)})}},{key:"_removeBackdrop",value:function(){this._backdrop&&(a(this._backdrop).remove(),this._backdrop=null)}},{key:"_showBackdrop",value:function(b){var c=this,d=a(this._element).hasClass(p.FADE)?p.FADE:"";if(this._isShown&&this._config.backdrop){var f=e.supportsTransitionEnd()&&d;if(this._backdrop=document.createElement("div"),this._backdrop.className=p.BACKDROP,d&&a(this._backdrop).addClass(d),a(this._backdrop).appendTo(document.body),a(this._element).on(o.CLICK_DISMISS,function(a){return c._ignoreBackdropClick?void(c._ignoreBackdropClick=!1):void(a.target===a.currentTarget&&("static"===c._config.backdrop?c._element.focus():c.hide()))}),f&&e.reflow(this._backdrop),a(this._backdrop).addClass(p.IN),!b)return;if(!f)return void b();a(this._backdrop).one(e.TRANSITION_END,b).emulateTransitionEnd(l)}else if(!this._isShown&&this._backdrop){a(this._backdrop).removeClass(p.IN);var g=function(){c._removeBackdrop(),b&&b()};e.supportsTransitionEnd()&&a(this._element).hasClass(p.FADE)?a(this._backdrop).one(e.TRANSITION_END,g).emulateTransitionEnd(l):g()}else b&&b()}},{key:"_handleUpdate",value:function(){this._adjustDialog()}},{key:"_adjustDialog",value:function(){var a=this._element.scrollHeight>document.documentElement.clientHeight;!this._isBodyOverflowing&&a&&(this._element.style.paddingLeft=this._scrollbarWidth+"px"),this._isBodyOverflowing&&!a&&(this._element.style.paddingRight=this._scrollbarWidth+"px~")}},{key:"_resetAdjustments",value:function(){this._element.style.paddingLeft="",this._element.style.paddingRight=""}},{key:"_checkScrollbar",value:function(){var a=window.innerWidth;if(!a){var b=document.documentElement.getBoundingClientRect();a=b.right-Math.abs(b.left)}this._isBodyOverflowing=document.body.clientWidth<a,this._scrollbarWidth=this._getScrollbarWidth()}},{key:"_setScrollbar",value:function(){var b=parseInt(a(q.FIXED_CONTENT).css("padding-right")||0,10);this._originalBodyPadding=document.body.style.paddingRight||"",this._isBodyOverflowing&&(document.body.style.paddingRight=b+(this._scrollbarWidth+"px"))}},{key:"_resetScrollbar",value:function(){document.body.style.paddingRight=this._originalBodyPadding}},{key:"_getScrollbarWidth",value:function(){var a=document.createElement("div");a.className=p.SCROLLBAR_MEASURER,document.body.appendChild(a);var b=a.offsetWidth-a.clientWidth;return document.body.removeChild(a),b}}],[{key:"_jQueryInterface",value:function(b,c){return this.each(function(){var d=a(this).data(g),e=a.extend({},i.Default,a(this).data(),"object"==typeof b&&b);d||(d=new i(this,e),a(this).data(g,d)),"string"==typeof b?d[b](c):e.show&&d.show(c)})}},{key:"VERSION",get:function(){return f}},{key:"Default",get:function(){return m}}]),i}();return a(document).on(o.CLICK_DATA_API,q.DATA_TOGGLE,function(b){var c=this,d=void 0,f=e.getSelectorFromElement(this);f&&(d=a(f)[0]);var h=a(d).data(g)?"toggle":a.extend({},a(d).data(),a(this).data());"A"===this.tagName&&b.preventDefault();var i=a(d).one(o.SHOW,function(b){b.isDefaultPrevented()||i.one(o.HIDDEN,function(){a(c).is(":visible")&&c.focus()})});r._jQueryInterface.call(a(d),h,this)}),a.fn[c]=r._jQueryInterface,a.fn[c].Constructor=r,a.fn[c].noConflict=function(){return a.fn[c]=j,r._jQueryInterface},r}(jQuery),function(a){var c="scrollspy",f="4.0.0",g="bs.scrollspy",h="."+g,i=".data-api",j=a.fn[c],k={offset:10,method:"auto",target:""},l={offset:"number",method:"string",target:"(string|element)"},m={ACTIVATE:"activate"+h,SCROLL:"scroll"+h,LOAD_DATA_API:"load"+h+i},n={DROPDOWN_ITEM:"dropdown-item",DROPDOWN_MENU:"dropdown-menu",NAV_LINK:"nav-link",NAV:"nav",ACTIVE:"active"},o={DATA_SPY:'[data-spy="scroll"]',ACTIVE:".active",LIST_ITEM:".list-item",LI:"li",LI_DROPDOWN:"li.dropdown",NAV_LINKS:".nav-link",DROPDOWN:".dropdown",DROPDOWN_ITEMS:".dropdown-item",DROPDOWN_TOGGLE:".dropdown-toggle"},p={OFFSET:"offset",POSITION:"position"},q=function(){function i(c,d){b(this,i),this._element=c,this._scrollElement="BODY"===c.tagName?window:c,this._config=this._getConfig(d),this._selector=this._config.target+" "+o.NAV_LINKS+","+(this._config.target+" "+o.DROPDOWN_ITEMS),this._offsets=[],this._targets=[],this._activeTarget=null,this._scrollHeight=0,a(this._scrollElement).on(m.SCROLL,a.proxy(this._process,this)),this.refresh(),this._process()}return d(i,[{key:"refresh",value:function(){var b=this,c=this._scrollElement!==this._scrollElement.window?p.POSITION:p.OFFSET,d="auto"===this._config.method?c:this._config.method,f=d===p.POSITION?this._getScrollTop():0;this._offsets=[],this._targets=[],this._scrollHeight=this._getScrollHeight();var g=a.makeArray(a(this._selector));g.map(function(b){var c=void 0,g=e.getSelectorFromElement(b);return g&&(c=a(g)[0]),c&&(c.offsetWidth||c.offsetHeight)?[a(c)[d]().top+f,g]:void 0}).filter(function(a){return a}).sort(function(a,b){return a[0]-b[0]}).forEach(function(a){b._offsets.push(a[0]),b._targets.push(a[1])})}},{key:"dispose",value:function(){a.removeData(this._element,g),a(this._scrollElement).off(h),this._element=null,this._scrollElement=null,this._config=null,this._selector=null,this._offsets=null,this._targets=null,this._activeTarget=null,this._scrollHeight=null}},{key:"_getConfig",value:function(b){if(b=a.extend({},k,b),"string"!=typeof b.target){var d=a(b.target).attr("id");d||(d=e.getUID(c),a(b.target).attr("id",d)),b.target="#"+d}return e.typeCheckConfig(c,b,l),b}},{key:"_getScrollTop",value:function(){return this._scrollElement===window?this._scrollElement.scrollY:this._scrollElement.scrollTop}},{key:"_getScrollHeight",value:function(){return this._scrollElement.scrollHeight||Math.max(document.body.scrollHeight,document.documentElement.scrollHeight)}},{key:"_process",value:function(){var a=this._getScrollTop()+this._config.offset,b=this._getScrollHeight(),c=this._config.offset+b-this._scrollElement.offsetHeight;if(this._scrollHeight!==b&&this.refresh(),a>=c){var d=this._targets[this._targets.length-1];this._activeTarget!==d&&this._activate(d)}if(this._activeTarget&&a<this._offsets[0])return this._activeTarget=null,void this._clear();for(var e=this._offsets.length;e--;){var f=this._activeTarget!==this._targets[e]&&a>=this._offsets[e]&&(void 0===this._offsets[e+1]||a<this._offsets[e+1]);f&&this._activate(this._targets[e])}}},{key:"_activate",value:function(b){this._activeTarget=b,this._clear();var c=this._selector.split(",");c=c.map(function(a){return a+'[data-target="'+b+'"],'+(a+'[href="'+b+'"]')});var d=a(c.join(","));d.hasClass(n.DROPDOWN_ITEM)?(d.closest(o.DROPDOWN).find(o.DROPDOWN_TOGGLE).addClass(n.ACTIVE),d.addClass(n.ACTIVE)):d.parents(o.LI).find(o.NAV_LINKS).addClass(n.ACTIVE),a(this._scrollElement).trigger(m.ACTIVATE,{relatedTarget:b})}},{key:"_clear",value:function(){a(this._selector).filter(o.ACTIVE).removeClass(n.ACTIVE)}}],[{key:"_jQueryInterface",value:function(b){return this.each(function(){var c=a(this).data(g),d="object"==typeof b&&b||null;c||(c=new i(this,d),a(this).data(g,c)),"string"==typeof b&&c[b]()})}},{key:"VERSION",get:function(){return f}},{key:"Default",get:function(){return k}}]),i}();return a(window).on(m.LOAD_DATA_API,function(){for(var b=a.makeArray(a(o.DATA_SPY)),c=b.length;c--;){var d=a(b[c]);q._jQueryInterface.call(d,d.data())}}),a.fn[c]=q._jQueryInterface,a.fn[c].Constructor=q,a.fn[c].noConflict=function(){return a.fn[c]=j,q._jQueryInterface},q}(jQuery),function(a){var c="tab",f="4.0.0",g="bs.tab",h="."+g,i=".data-api",j=a.fn[c],k=150,l={HIDE:"hide"+h,HIDDEN:"hidden"+h,SHOW:"show"+h,SHOWN:"shown"+h,CLICK_DATA_API:"click"+h+i},m={DROPDOWN_MENU:"dropdown-menu",ACTIVE:"active",FADE:"fade",IN:"in"},n={A:"a",LI:"li",DROPDOWN:".dropdown",UL:"ul:not(.dropdown-menu)",FADE_CHILD:"> .nav-item .fade, > .fade",ACTIVE:".active",ACTIVE_CHILD:"> .nav-item > .active, > .active",DATA_TOGGLE:'[data-toggle="tab"], [data-toggle="pill"]',DROPDOWN_TOGGLE:".dropdown-toggle",DROPDOWN_ACTIVE_CHILD:"> .dropdown-menu .active"},o=function(){function c(a){b(this,c),this._element=a}return d(c,[{key:"show",value:function(){var b=this;if(!this._element.parentNode||this._element.parentNode.nodeType!==Node.ELEMENT_NODE||!a(this._element).hasClass(m.ACTIVE)){var c=void 0,d=void 0,f=a(this._element).closest(n.UL)[0],g=e.getSelectorFromElement(this._element);f&&(d=a.makeArray(a(f).find(n.ACTIVE)),d=d[d.length-1]);var h=a.Event(l.HIDE,{
relatedTarget:this._element}),i=a.Event(l.SHOW,{relatedTarget:d});if(d&&a(d).trigger(h),a(this._element).trigger(i),!i.isDefaultPrevented()&&!h.isDefaultPrevented()){g&&(c=a(g)[0]),this._activate(this._element,f);var j=function(){var c=a.Event(l.HIDDEN,{relatedTarget:b._element}),e=a.Event(l.SHOWN,{relatedTarget:d});a(d).trigger(c),a(b._element).trigger(e)};c?this._activate(c,c.parentNode,j):j()}}}},{key:"dispose",value:function(){a.removeClass(this._element,g),this._element=null}},{key:"_activate",value:function(b,c,d){var f=a(c).find(n.ACTIVE_CHILD)[0],g=d&&e.supportsTransitionEnd()&&(f&&a(f).hasClass(m.FADE)||Boolean(a(c).find(n.FADE_CHILD)[0])),h=a.proxy(this._transitionComplete,this,b,f,g,d);f&&g?a(f).one(e.TRANSITION_END,h).emulateTransitionEnd(k):h(),f&&a(f).removeClass(m.IN)}},{key:"_transitionComplete",value:function(b,c,d,f){if(c){a(c).removeClass(m.ACTIVE);var g=a(c).find(n.DROPDOWN_ACTIVE_CHILD)[0];g&&a(g).removeClass(m.ACTIVE),c.setAttribute("aria-expanded",!1)}if(a(b).addClass(m.ACTIVE),b.setAttribute("aria-expanded",!0),d?(e.reflow(b),a(b).addClass(m.IN)):a(b).removeClass(m.FADE),b.parentNode&&a(b.parentNode).hasClass(m.DROPDOWN_MENU)){var h=a(b).closest(n.DROPDOWN)[0];h&&a(h).find(n.DROPDOWN_TOGGLE).addClass(m.ACTIVE),b.setAttribute("aria-expanded",!0)}f&&f()}}],[{key:"_jQueryInterface",value:function(b){return this.each(function(){var d=a(this),e=d.data(g);e||(e=e=new c(this),d.data(g,e)),"string"==typeof b&&e[b]()})}},{key:"VERSION",get:function(){return f}}]),c}();return a(document).on(l.CLICK_DATA_API,n.DATA_TOGGLE,function(b){b.preventDefault(),o._jQueryInterface.call(a(this),"show")}),a.fn[c]=o._jQueryInterface,a.fn[c].Constructor=o,a.fn[c].noConflict=function(){return a.fn[c]=j,o._jQueryInterface},o}(jQuery),function(a){var c="tooltip",f="4.0.0",g="bs.tooltip",h="."+g,i=a.fn[c],j=150,k="bs-tether",l={animation:!0,template:'<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',trigger:"hover focus",title:"",delay:0,html:!1,selector:!1,placement:"top",offset:"0 0",constraints:[]},m={animation:"boolean",template:"string",title:"(string|function)",trigger:"string",delay:"(number|object)",html:"boolean",selector:"(string|boolean)",placement:"(string|function)",offset:"string",constraints:"array"},n={TOP:"bottom center",RIGHT:"middle left",BOTTOM:"top center",LEFT:"middle right"},o={IN:"in",OUT:"out"},p={HIDE:"hide"+h,HIDDEN:"hidden"+h,SHOW:"show"+h,SHOWN:"shown"+h,INSERTED:"inserted"+h,CLICK:"click"+h,FOCUSIN:"focusin"+h,FOCUSOUT:"focusout"+h,MOUSEENTER:"mouseenter"+h,MOUSELEAVE:"mouseleave"+h},q={FADE:"fade",IN:"in"},r={TOOLTIP:".tooltip",TOOLTIP_INNER:".tooltip-inner"},s={element:!1,enabled:!1},t={HOVER:"hover",FOCUS:"focus",CLICK:"click",MANUAL:"manual"},u=function(){function i(a,c){b(this,i),this._isEnabled=!0,this._timeout=0,this._hoverState="",this._activeTrigger={},this._tether=null,this.element=a,this.config=this._getConfig(c),this.tip=null,this._setListeners()}return d(i,[{key:"enable",value:function(){this._isEnabled=!0}},{key:"disable",value:function(){this._isEnabled=!1}},{key:"toggleEnabled",value:function(){this._isEnabled=!this._isEnabled}},{key:"toggle",value:function(b){if(b){var c=this.constructor.DATA_KEY,d=a(b.currentTarget).data(c);d||(d=new this.constructor(b.currentTarget,this._getDelegateConfig()),a(b.currentTarget).data(c,d)),d._activeTrigger.click=!d._activeTrigger.click,d._isWithActiveTrigger()?d._enter(null,d):d._leave(null,d)}else{if(a(this.getTipElement()).hasClass(q.IN))return void this._leave(null,this);this._enter(null,this)}}},{key:"dispose",value:function(){clearTimeout(this._timeout),this.cleanupTether(),a.removeData(this.element,this.constructor.DATA_KEY),a(this.element).off(this.constructor.EVENT_KEY),this.tip&&a(this.tip).remove(),this._isEnabled=null,this._timeout=null,this._hoverState=null,this._activeTrigger=null,this._tether=null,this.element=null,this.config=null,this.tip=null}},{key:"show",value:function(){var b=this,c=a.Event(this.constructor.Event.SHOW);if(this.isWithContent()&&this._isEnabled){a(this.element).trigger(c);var d=a.contains(this.element.ownerDocument.documentElement,this.element);if(c.isDefaultPrevented()||!d)return;var f=this.getTipElement(),g=e.getUID(this.constructor.NAME);f.setAttribute("id",g),this.element.setAttribute("aria-describedby",g),this.setContent(),this.config.animation&&a(f).addClass(q.FADE);var h="function"==typeof this.config.placement?this.config.placement.call(this,f,this.element):this.config.placement,j=this._getAttachment(h);a(f).data(this.constructor.DATA_KEY,this).appendTo(document.body),a(this.element).trigger(this.constructor.Event.INSERTED),this._tether=new Tether({attachment:j,element:f,target:this.element,classes:s,classPrefix:k,offset:this.config.offset,constraints:this.config.constraints}),e.reflow(f),this._tether.position(),a(f).addClass(q.IN);var l=function(){var c=b._hoverState;b._hoverState=null,a(b.element).trigger(b.constructor.Event.SHOWN),c===o.OUT&&b._leave(null,b)};if(e.supportsTransitionEnd()&&a(this.tip).hasClass(q.FADE))return void a(this.tip).one(e.TRANSITION_END,l).emulateTransitionEnd(i._TRANSITION_DURATION);l()}}},{key:"hide",value:function(b){var c=this,d=this.getTipElement(),f=a.Event(this.constructor.Event.HIDE),g=function(){c._hoverState!==o.IN&&d.parentNode&&d.parentNode.removeChild(d),c.element.removeAttribute("aria-describedby"),a(c.element).trigger(c.constructor.Event.HIDDEN),c.cleanupTether(),b&&b()};a(this.element).trigger(f),f.isDefaultPrevented()||(a(d).removeClass(q.IN),e.supportsTransitionEnd()&&a(this.tip).hasClass(q.FADE)?a(d).one(e.TRANSITION_END,g).emulateTransitionEnd(j):g(),this._hoverState="")}},{key:"isWithContent",value:function(){return Boolean(this.getTitle())}},{key:"getTipElement",value:function(){return this.tip=this.tip||a(this.config.template)[0]}},{key:"setContent",value:function(){var b=this.getTipElement(),c=this.getTitle(),d=this.config.html?"innerHTML":"innerText";a(b).find(r.TOOLTIP_INNER)[0][d]=c,a(b).removeClass(q.FADE).removeClass(q.IN),this.cleanupTether()}},{key:"getTitle",value:function(){var a=this.element.getAttribute("data-original-title");return a||(a="function"==typeof this.config.title?this.config.title.call(this.element):this.config.title),a}},{key:"cleanupTether",value:function(){this._tether&&(this._tether.destroy(),a(this.element).removeClass(this._removeTetherClasses),a(this.tip).removeClass(this._removeTetherClasses))}},{key:"_getAttachment",value:function(a){return n[a.toUpperCase()]}},{key:"_setListeners",value:function(){var b=this,c=this.config.trigger.split(" ");c.forEach(function(c){if("click"===c)a(b.element).on(b.constructor.Event.CLICK,b.config.selector,a.proxy(b.toggle,b));else if(c!==t.MANUAL){var d=c===t.HOVER?b.constructor.Event.MOUSEENTER:b.constructor.Event.FOCUSIN,e=c===t.HOVER?b.constructor.Event.MOUSELEAVE:b.constructor.Event.FOCUSOUT;a(b.element).on(d,b.config.selector,a.proxy(b._enter,b)).on(e,b.config.selector,a.proxy(b._leave,b))}}),this.config.selector?this.config=a.extend({},this.config,{trigger:"manual",selector:""}):this._fixTitle()}},{key:"_removeTetherClasses",value:function(a,b){return((b.baseVal||b).match(new RegExp("(^|\\s)"+k+"-\\S+","g"))||[]).join(" ")}},{key:"_fixTitle",value:function(){var a=typeof this.element.getAttribute("data-original-title");(this.element.getAttribute("title")||"string"!==a)&&(this.element.setAttribute("data-original-title",this.element.getAttribute("title")||""),this.element.setAttribute("title",""))}},{key:"_enter",value:function(b,c){var d=this.constructor.DATA_KEY;return c=c||a(b.currentTarget).data(d),c||(c=new this.constructor(b.currentTarget,this._getDelegateConfig()),a(b.currentTarget).data(d,c)),b&&(c._activeTrigger["focusin"===b.type?t.FOCUS:t.HOVER]=!0),a(c.getTipElement()).hasClass(q.IN)||c._hoverState===o.IN?void(c._hoverState=o.IN):(clearTimeout(c._timeout),c._hoverState=o.IN,c.config.delay&&c.config.delay.show?void(c._timeout=setTimeout(function(){c._hoverState===o.IN&&c.show()},c.config.delay.show)):void c.show())}},{key:"_leave",value:function(b,c){var d=this.constructor.DATA_KEY;return c=c||a(b.currentTarget).data(d),c||(c=new this.constructor(b.currentTarget,this._getDelegateConfig()),a(b.currentTarget).data(d,c)),b&&(c._activeTrigger["focusout"===b.type?t.FOCUS:t.HOVER]=!1),c._isWithActiveTrigger()?void 0:(clearTimeout(c._timeout),c._hoverState=o.OUT,c.config.delay&&c.config.delay.hide?void(c._timeout=setTimeout(function(){c._hoverState===o.OUT&&c.hide()},c.config.delay.hide)):void c.hide())}},{key:"_isWithActiveTrigger",value:function(){for(var a in this._activeTrigger)if(this._activeTrigger[a])return!0;return!1}},{key:"_getConfig",value:function(b){return b=a.extend({},this.constructor.Default,a(this.element).data(),b),b.delay&&"number"==typeof b.delay&&(b.delay={show:b.delay,hide:b.delay}),e.typeCheckConfig(c,b,this.constructor.DefaultType),b}},{key:"_getDelegateConfig",value:function(){var a={};if(this.config)for(var b in this.config)this.constructor.Default[b]!==this.config[b]&&(a[b]=this.config[b]);return a}}],[{key:"_jQueryInterface",value:function(b){return this.each(function(){var c=a(this).data(g),d="object"==typeof b?b:null;(c||!/destroy|hide/.test(b))&&(c||(c=new i(this,d),a(this).data(g,c)),"string"==typeof b&&c[b]())})}},{key:"VERSION",get:function(){return f}},{key:"Default",get:function(){return l}},{key:"NAME",get:function(){return c}},{key:"DATA_KEY",get:function(){return g}},{key:"Event",get:function(){return p}},{key:"EVENT_KEY",get:function(){return h}},{key:"DefaultType",get:function(){return m}}]),i}();return a.fn[c]=u._jQueryInterface,a.fn[c].Constructor=u,a.fn[c].noConflict=function(){return a.fn[c]=i,u._jQueryInterface},u}(jQuery));!function(e){var g="popover",h="4.0.0",i="bs.popover",j="."+i,k=e.fn[g],l=e.extend({},f.Default,{placement:"right",trigger:"click",content:"",template:'<div class="popover" role="tooltip"><div class="popover-arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'}),m=e.extend({},f.DefaultType,{content:"(string|function)"}),n={FADE:"fade",IN:"in"},o={TITLE:".popover-title",CONTENT:".popover-content",ARROW:".popover-arrow"},p={HIDE:"hide"+j,HIDDEN:"hidden"+j,SHOW:"show"+j,SHOWN:"shown"+j,INSERTED:"inserted"+j,CLICK:"click"+j,FOCUSIN:"focusin"+j,FOCUSOUT:"focusout"+j,MOUSEENTER:"mouseenter"+j,MOUSELEAVE:"mouseleave"+j},q=function(f){function k(){b(this,k),c(Object.getPrototypeOf(k.prototype),"constructor",this).apply(this,arguments)}return a(k,f),d(k,[{key:"isWithContent",value:function(){return this.getTitle()||this._getContent()}},{key:"getTipElement",value:function(){return this.tip=this.tip||e(this.config.template)[0]}},{key:"setContent",value:function(){var a=this.getTipElement(),b=this.getTitle(),c=this._getContent(),d=e(a).find(o.TITLE)[0];d&&(d[this.config.html?"innerHTML":"innerText"]=b),e(a).find(o.CONTENT).children().detach().end()[this.config.html?"string"==typeof c?"html":"append":"text"](c),e(a).removeClass(n.FADE).removeClass(n.IN),this.cleanupTether()}},{key:"_getContent",value:function(){return this.element.getAttribute("data-content")||("function"==typeof this.config.content?this.config.content.call(this.element):this.config.content)}}],[{key:"_jQueryInterface",value:function(a){return this.each(function(){var b=e(this).data(i),c="object"==typeof a?a:null;(b||!/destroy|hide/.test(a))&&(b||(b=new k(this,c),e(this).data(i,b)),"string"==typeof a&&b[a]())})}},{key:"VERSION",get:function(){return h}},{key:"Default",get:function(){return l}},{key:"NAME",get:function(){return g}},{key:"DATA_KEY",get:function(){return i}},{key:"Event",get:function(){return p}},{key:"EVENT_KEY",get:function(){return j}},{key:"DefaultType",get:function(){return m}}]),k}(f);return e.fn[g]=q._jQueryInterface,e.fn[g].Constructor=q,e.fn[g].noConflict=function(){return e.fn[g]=k,q._jQueryInterface},q}(jQuery)}}(jQuery);
// This file is autogenerated via the `commonjs` Grunt task. You can require() this file in a CommonJS environment.
require('./umd/util.js')
require('./umd/alert.js')
require('./umd/button.js')
require('./umd/carousel.js')
require('./umd/collapse.js')
require('./umd/dropdown.js')
require('./umd/modal.js')
require('./umd/scrollspy.js')
require('./umd/tab.js')
require('./umd/tooltip.js')
require('./umd/popover.js')
/* ============================================================
 * Bootstrap: rowlink.js v3.1.3
 * http://jasny.github.io/bootstrap/javascript/#rowlink
 * ============================================================
 * Copyright 2012-2014 Arnold Daniels
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ============================================================ */

+function ($) { "use strict";

  var Rowlink = function (element, options) {
    this.$element = $(element)
    this.options = $.extend({}, Rowlink.DEFAULTS, options)
    
    this.$element.on('click.bs.rowlink', 'td:not(.rowlink-skip)', $.proxy(this.click, this))
  }

  Rowlink.DEFAULTS = {
    target: "a"
  }

  Rowlink.prototype.click = function(e) {
    var target = $(e.currentTarget).closest('tr').find(this.options.target)[0]
    if ($(e.target)[0] === target) return
    
    e.preventDefault();
    
    if (target.click) {
      target.click()
    } else if (document.createEvent) {
      var evt = document.createEvent("MouseEvents"); 
      evt.initMouseEvent("click", true, true, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null); 
      target.dispatchEvent(evt);
    }
  }

  
  // ROWLINK PLUGIN DEFINITION
  // ===========================

  var old = $.fn.rowlink

  $.fn.rowlink = function (options) {
    return this.each(function () {
      var $this = $(this)
      var data = $this.data('bs.rowlink')
      if (!data) $this.data('bs.rowlink', (data = new Rowlink(this, options)))
    })
  }

  $.fn.rowlink.Constructor = Rowlink


  // ROWLINK NO CONFLICT
  // ====================

  $.fn.rowlink.noConflict = function () {
    $.fn.rowlink = old
    return this
  }


  // ROWLINK DATA-API
  // ==================

  $(document).on('click.bs.rowlink.data-api', '[data-link="row"]', function (e) {
    if ($(e.target).closest('.rowlink-skip').length !== 0) return
    
    var $this = $(this)
    if ($this.data('bs.rowlink')) return
    $this.rowlink($this.data())
    $(e.target).trigger('click.bs.rowlink')
  })
  
}(window.jQuery);

/* ===========================================================
 * Bootstrap: inputmask.js v3.1.0
 * http://jasny.github.io/bootstrap/javascript/#inputmask
 * 
 * Based on Masked Input plugin by Josh Bush (digitalbush.com)
 * ===========================================================
 * Copyright 2012-2014 Arnold Daniels
 *
 * Licensed under the Apache License, Version 2.0 (the "License")
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================== */

+function ($) { "use strict";

  var isIphone = (window.orientation !== undefined)
  var isAndroid = navigator.userAgent.toLowerCase().indexOf("android") > -1
  var isIE = window.navigator.appName == 'Microsoft Internet Explorer'

  // INPUTMASK PUBLIC CLASS DEFINITION
  // =================================

  var Inputmask = function (element, options) {
    if (isAndroid) return // No support because caret positioning doesn't work on Android
    
    this.$element = $(element)
    this.options = $.extend({}, Inputmask.DEFAULTS, options)
    this.mask = String(this.options.mask)
    
    this.init()
    this.listen()
        
    this.checkVal() //Perform initial check for existing values
  }

  Inputmask.DEFAULTS = {
    mask: "",
    placeholder: "_",
    definitions: {
      '9': "[0-9]",
      'a': "[A-Za-z]",
      'w': "[A-Za-z0-9]",
      '*': "."
    }
  }

  Inputmask.prototype.init = function() {
    var defs = this.options.definitions
    var len = this.mask.length

    this.tests = [] 
    this.partialPosition = this.mask.length
    this.firstNonMaskPos = null

    $.each(this.mask.split(""), $.proxy(function(i, c) {
      if (c == '?') {
        len--
        this.partialPosition = i
      } else if (defs[c]) {
        this.tests.push(new RegExp(defs[c]))
        if (this.firstNonMaskPos === null)
          this.firstNonMaskPos =  this.tests.length - 1
      } else {
        this.tests.push(null)
      }
    }, this))

    this.buffer = $.map(this.mask.split(""), $.proxy(function(c, i) {
      if (c != '?') return defs[c] ? this.options.placeholder : c
    }, this))

    this.focusText = this.$element.val()

    this.$element.data("rawMaskFn", $.proxy(function() {
      return $.map(this.buffer, function(c, i) {
        return this.tests[i] && c != this.options.placeholder ? c : null
      }).join('')
    }, this))
  }
    
  Inputmask.prototype.listen = function() {
    if (this.$element.attr("readonly")) return

    var pasteEventName = (isIE ? 'paste' : 'input') + ".bs.inputmask"

    this.$element
      .on("unmask.bs.inputmask", $.proxy(this.unmask, this))

      .on("focus.bs.inputmask", $.proxy(this.focusEvent, this))
      .on("blur.bs.inputmask", $.proxy(this.blurEvent, this))

      .on("keydown.bs.inputmask", $.proxy(this.keydownEvent, this))
      .on("keypress.bs.inputmask", $.proxy(this.keypressEvent, this))

      .on(pasteEventName, $.proxy(this.pasteEvent, this))
  }

  //Helper Function for Caret positioning
  Inputmask.prototype.caret = function(begin, end) {
    if (this.$element.length === 0) return
    if (typeof begin == 'number') {
      end = (typeof end == 'number') ? end : begin
      return this.$element.each(function() {
        if (this.setSelectionRange) {
          this.setSelectionRange(begin, end)
        } else if (this.createTextRange) {
          var range = this.createTextRange()
          range.collapse(true)
          range.moveEnd('character', end)
          range.moveStart('character', begin)
          range.select()
        }
      })
    } else {
      if (this.$element[0].setSelectionRange) {
        begin = this.$element[0].selectionStart
        end = this.$element[0].selectionEnd
      } else if (document.selection && document.selection.createRange) {
        var range = document.selection.createRange()
        begin = 0 - range.duplicate().moveStart('character', -100000)
        end = begin + range.text.length
      }
      return {
        begin: begin, 
        end: end
      }
    }
  }
  
  Inputmask.prototype.seekNext = function(pos) {
    var len = this.mask.length
    while (++pos <= len && !this.tests[pos]);

    return pos
  }
  
  Inputmask.prototype.seekPrev = function(pos) {
    while (--pos >= 0 && !this.tests[pos]);

    return pos
  }

  Inputmask.prototype.shiftL = function(begin,end) {
    var len = this.mask.length

    if (begin < 0) return

    for (var i = begin, j = this.seekNext(end); i < len; i++) {
      if (this.tests[i]) {
        if (j < len && this.tests[i].test(this.buffer[j])) {
          this.buffer[i] = this.buffer[j]
          this.buffer[j] = this.options.placeholder
        } else
          break
        j = this.seekNext(j)
      }
    }
    this.writeBuffer()
    this.caret(Math.max(this.firstNonMaskPos, begin))
  }

  Inputmask.prototype.shiftR = function(pos) {
    var len = this.mask.length

    for (var i = pos, c = this.options.placeholder; i < len; i++) {
      if (this.tests[i]) {
        var j = this.seekNext(i)
        var t = this.buffer[i]
        this.buffer[i] = c
        if (j < len && this.tests[j].test(t))
          c = t
        else
          break
      }
    }
  },

  Inputmask.prototype.unmask = function() {
    this.$element
      .unbind(".bs.inputmask")
      .removeData("bs.inputmask")
  }

  Inputmask.prototype.focusEvent = function() {
    this.focusText = this.$element.val()
    var len = this.mask.length 
    var pos = this.checkVal()
    this.writeBuffer()

    var that = this
    var moveCaret = function() {
      if (pos == len)
        that.caret(0, pos)
      else
        that.caret(pos)
    }

    moveCaret()
    setTimeout(moveCaret, 50)
  }

  Inputmask.prototype.blurEvent = function() {
    this.checkVal()
    if (this.$element.val() !== this.focusText) {
      this.$element.trigger('change')
      this.$element.trigger('input')
    }
  }

  Inputmask.prototype.keydownEvent = function(e) {
    var k = e.which

    //backspace, delete, and escape get special treatment
    if (k == 8 || k == 46 || (isIphone && k == 127)) {
      var pos = this.caret(),
      begin = pos.begin,
      end = pos.end

      if (end - begin === 0) {
        begin = k != 46 ? this.seekPrev(begin) : (end = this.seekNext(begin - 1))
        end = k == 46 ? this.seekNext(end) : end
      }
      this.clearBuffer(begin, end)
      this.shiftL(begin, end - 1)

      return false
    } else if (k == 27) {//escape
      this.$element.val(this.focusText)
      this.caret(0, this.checkVal())
      return false
    }
  }

  Inputmask.prototype.keypressEvent = function(e) {
    var len = this.mask.length

    var k = e.which,
    pos = this.caret()

    if (e.ctrlKey || e.altKey || e.metaKey || k < 32)  {//Ignore
      return true
    } else if (k) {
      if (pos.end - pos.begin !== 0) {
        this.clearBuffer(pos.begin, pos.end)
        this.shiftL(pos.begin, pos.end - 1)
      }

      var p = this.seekNext(pos.begin - 1)
      if (p < len) {
        var c = String.fromCharCode(k)
        if (this.tests[p].test(c)) {
          this.shiftR(p)
          this.buffer[p] = c
          this.writeBuffer()
          var next = this.seekNext(p)
          this.caret(next)
        }
      }
      return false
    }
  }

  Inputmask.prototype.pasteEvent = function() {
    var that = this

    setTimeout(function() {
      that.caret(that.checkVal(true))
    }, 0)
  }

  Inputmask.prototype.clearBuffer = function(start, end) {
    var len = this.mask.length

    for (var i = start; i < end && i < len; i++) {
      if (this.tests[i])
        this.buffer[i] = this.options.placeholder
    }
  }

  Inputmask.prototype.writeBuffer = function() {
    return this.$element.val(this.buffer.join('')).val()
  }

  Inputmask.prototype.checkVal = function(allow) {
    var len = this.mask.length
    //try to place characters where they belong
    var test = this.$element.val()
    var lastMatch = -1

    for (var i = 0, pos = 0; i < len; i++) {
      if (this.tests[i]) {
        this.buffer[i] = this.options.placeholder
        while (pos++ < test.length) {
          var c = test.charAt(pos - 1)
          if (this.tests[i].test(c)) {
            this.buffer[i] = c
            lastMatch = i
            break
          }
        }
        if (pos > test.length)
          break
      } else if (this.buffer[i] == test.charAt(pos) && i != this.partialPosition) {
        pos++
        lastMatch = i
      }
    }
    if (!allow && lastMatch + 1 < this.partialPosition) {
      this.$element.val("")
      this.clearBuffer(0, len)
    } else if (allow || lastMatch + 1 >= this.partialPosition) {
      this.writeBuffer()
      if (!allow) this.$element.val(this.$element.val().substring(0, lastMatch + 1))
    }
    return (this.partialPosition ? i : this.firstNonMaskPos)
  }

  
  // INPUTMASK PLUGIN DEFINITION
  // ===========================

  var old = $.fn.inputmask
  
  $.fn.inputmask = function (options) {
    return this.each(function () {
      var $this = $(this)
      var data = $this.data('bs.inputmask')
      
      if (!data) $this.data('bs.inputmask', (data = new Inputmask(this, options)))
    })
  }

  $.fn.inputmask.Constructor = Inputmask


  // INPUTMASK NO CONFLICT
  // ====================

  $.fn.inputmask.noConflict = function () {
    $.fn.inputmask = old
    return this
  }


  // INPUTMASK DATA-API
  // ==================

  $(document).on('focus.bs.inputmask.data-api', '[data-mask]', function (e) {
    var $this = $(this)
    if ($this.data('bs.inputmask')) return
    $this.inputmask($this.data())
  })

}(window.jQuery);

/* ===========================================================
 * Bootstrap: fileinput.js v3.1.3
 * http://jasny.github.com/bootstrap/javascript/#fileinput
 * ===========================================================
 * Copyright 2012-2014 Arnold Daniels
 *
 * Licensed under the Apache License, Version 2.0 (the "License")
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================== */

+function ($) { "use strict";

  var isIE = window.navigator.appName == 'Microsoft Internet Explorer'

  // FILEUPLOAD PUBLIC CLASS DEFINITION
  // =================================

  var Fileinput = function (element, options) {
    this.$element = $(element)
    
    this.$input = this.$element.find(':file')
    if (this.$input.length === 0) return

    this.name = this.$input.attr('name') || options.name

    this.$hidden = this.$element.find('input[type=hidden][name="' + this.name + '"]')
    if (this.$hidden.length === 0) {
      this.$hidden = $('<input type="hidden">').insertBefore(this.$input)
    }

    this.$preview = this.$element.find('.fileinput-preview')
    var height = this.$preview.css('height')
    if (this.$preview.css('display') !== 'inline' && height !== '0px' && height !== 'none') {
      this.$preview.css('line-height', height)
    }
        
    this.original = {
      exists: this.$element.hasClass('fileinput-exists'),
      preview: this.$preview.html(),
      hiddenVal: this.$hidden.val()
    }
    
    this.listen()
  }
  
  Fileinput.prototype.listen = function() {
    this.$input.on('change.bs.fileinput', $.proxy(this.change, this))
    $(this.$input[0].form).on('reset.bs.fileinput', $.proxy(this.reset, this))
    
    this.$element.find('[data-trigger="fileinput"]').on('click.bs.fileinput', $.proxy(this.trigger, this))
    this.$element.find('[data-dismiss="fileinput"]').on('click.bs.fileinput', $.proxy(this.clear, this))
  },

  Fileinput.prototype.change = function(e) {
    var files = e.target.files === undefined ? (e.target && e.target.value ? [{ name: e.target.value.replace(/^.+\\/, '')}] : []) : e.target.files
    
    e.stopPropagation()

    if (files.length === 0) {
      this.clear()
      return
    }

    this.$hidden.val('')
    this.$hidden.attr('name', '')
    this.$input.attr('name', this.name)

    var file = files[0]

    if (this.$preview.length > 0 && (typeof file.type !== "undefined" ? file.type.match(/^image\/(gif|png|jpeg)$/) : file.name.match(/\.(gif|png|jpe?g)$/i)) && typeof FileReader !== "undefined") {
      var reader = new FileReader()
      var preview = this.$preview
      var element = this.$element

      reader.onload = function(re) {
        var $img = $('<img>')
        $img[0].src = re.target.result
        files[0].result = re.target.result
        
        element.find('.fileinput-filename').text(file.name)
        
        // if parent has max-height, using `(max-)height: 100%` on child doesn't take padding and border into account
        if (preview.css('max-height') != 'none') $img.css('max-height', parseInt(preview.css('max-height'), 10) - parseInt(preview.css('padding-top'), 10) - parseInt(preview.css('padding-bottom'), 10)  - parseInt(preview.css('border-top'), 10) - parseInt(preview.css('border-bottom'), 10))
        
        preview.html($img)
        element.addClass('fileinput-exists').removeClass('fileinput-new')

        element.trigger('change.bs.fileinput', files)
      }

      reader.readAsDataURL(file)
    } else {
      this.$element.find('.fileinput-filename').text(file.name)
      this.$preview.text(file.name)
      
      this.$element.addClass('fileinput-exists').removeClass('fileinput-new')
      
      this.$element.trigger('change.bs.fileinput')
    }
  },

  Fileinput.prototype.clear = function(e) {
    if (e) e.preventDefault()
    
    this.$hidden.val('')
    this.$hidden.attr('name', this.name)
    this.$input.attr('name', '')

    //ie8+ doesn't support changing the value of input with type=file so clone instead
    if (isIE) { 
      var inputClone = this.$input.clone(true);
      this.$input.after(inputClone);
      this.$input.remove();
      this.$input = inputClone;
    } else {
      this.$input.val('')
    }

    this.$preview.html('')
    this.$element.find('.fileinput-filename').text('')
    this.$element.addClass('fileinput-new').removeClass('fileinput-exists')
    
    if (e !== undefined) {
      this.$input.trigger('change')
      this.$element.trigger('clear.bs.fileinput')
    }
  },

  Fileinput.prototype.reset = function() {
    this.clear()

    this.$hidden.val(this.original.hiddenVal)
    this.$preview.html(this.original.preview)
    this.$element.find('.fileinput-filename').text('')

    if (this.original.exists) this.$element.addClass('fileinput-exists').removeClass('fileinput-new')
     else this.$element.addClass('fileinput-new').removeClass('fileinput-exists')
    
    this.$element.trigger('reset.bs.fileinput')
  },

  Fileinput.prototype.trigger = function(e) {
    this.$input.trigger('click')
    e.preventDefault()
  }

  
  // FILEUPLOAD PLUGIN DEFINITION
  // ===========================

  var old = $.fn.fileinput
  
  $.fn.fileinput = function (options) {
    return this.each(function () {
      var $this = $(this),
          data = $this.data('bs.fileinput')
      if (!data) $this.data('bs.fileinput', (data = new Fileinput(this, options)))
      if (typeof options == 'string') data[options]()
    })
  }

  $.fn.fileinput.Constructor = Fileinput


  // FILEINPUT NO CONFLICT
  // ====================

  $.fn.fileinput.noConflict = function () {
    $.fn.fileinput = old
    return this
  }


  // FILEUPLOAD DATA-API
  // ==================

  $(document).on('click.fileinput.data-api', '[data-provides="fileinput"]', function (e) {
    var $this = $(this)
    if ($this.data('bs.fileinput')) return
    $this.fileinput($this.data())
      
    var $target = $(e.target).closest('[data-dismiss="fileinput"],[data-trigger="fileinput"]');
    if ($target.length > 0) {
      e.preventDefault()
      $target.trigger('click.bs.fileinput')
    }
  })

}(window.jQuery);

/* ========================================================================
 * Bootstrap: offcanvas.js v3.1.3
 * http://jasny.github.io/bootstrap/javascript/#offcanvas
 * ========================================================================
 * Copyright 2013-2014 Arnold Daniels
 *
 * Licensed under the Apache License, Version 2.0 (the "License")
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ======================================================================== */

+function ($) { "use strict";

  // OFFCANVAS PUBLIC CLASS DEFINITION
  // =================================

  var OffCanvas = function (element, options) {
    this.$element = $(element)
    this.options  = $.extend({}, OffCanvas.DEFAULTS, options)
    this.state    = null
    this.placement = null
    
    if (this.options.recalc) {
      this.calcClone()
      $(window).on('resize', $.proxy(this.recalc, this))
    }
    
    if (this.options.autohide)
      $(document).on('click', $.proxy(this.autohide, this))

    if (this.options.toggle) this.toggle()
    
    if (this.options.disablescrolling) {
        this.options.disableScrolling = this.options.disablescrolling
        delete this.options.disablescrolling
    }
  }

  OffCanvas.DEFAULTS = {
    toggle: true,
    placement: 'auto',
    autohide: true,
    recalc: true,
    disableScrolling: true,
    modal: false
  }

  OffCanvas.prototype.offset = function () {
    switch (this.placement) {
      case 'left':
      case 'right':  return this.$element.outerWidth()
      case 'top':
      case 'bottom': return this.$element.outerHeight()
    }
  }
  
  OffCanvas.prototype.calcPlacement = function () {
    if (this.options.placement !== 'auto') {
        this.placement = this.options.placement
        return
    }
    
    if (!this.$element.hasClass('in')) {
      this.$element.css('visiblity', 'hidden !important').addClass('in')
    } 
    
    var horizontal = $(window).width() / this.$element.width()
    var vertical = $(window).height() / this.$element.height()
        
    var element = this.$element
    function ab(a, b) {
      if (element.css(b) === 'auto') return a
      if (element.css(a) === 'auto') return b
      
      var size_a = parseInt(element.css(a), 10)
      var size_b = parseInt(element.css(b), 10)
  
      return size_a > size_b ? b : a
    }
    
    this.placement = horizontal >= vertical ? ab('left', 'right') : ab('top', 'bottom')
      
    if (this.$element.css('visibility') === 'hidden !important') {
      this.$element.removeClass('in').css('visiblity', '')
    }
  }
  
  OffCanvas.prototype.opposite = function (placement) {
    switch (placement) {
      case 'top':    return 'bottom'
      case 'left':   return 'right'
      case 'bottom': return 'top'
      case 'right':  return 'left'
    }
  }
  
  OffCanvas.prototype.getCanvasElements = function() {
    // Return a set containing the canvas plus all fixed elements
    var canvas = this.options.canvas ? $(this.options.canvas) : this.$element
    
    var fixed_elements = canvas.find('*').filter(function() {
      return $(this).css('position') === 'fixed'
    }).not(this.options.exclude)
    
    return canvas.add(fixed_elements)
  }
  
  OffCanvas.prototype.slide = function (elements, offset, callback) {
    // Use jQuery animation if CSS transitions aren't supported
    if (!$.support.transition) {
      var anim = {}
      anim[this.placement] = "+=" + offset
      return elements.animate(anim, 350, callback)
    }

    var placement = this.placement
    var opposite = this.opposite(placement)
    
    elements.each(function() {
      if ($(this).css(placement) !== 'auto')
        $(this).css(placement, (parseInt($(this).css(placement), 10) || 0) + offset)
      
      if ($(this).css(opposite) !== 'auto')
        $(this).css(opposite, (parseInt($(this).css(opposite), 10) || 0) - offset)
    })
    
    this.$element
      .one($.support.transition.end, callback)
      .emulateTransitionEnd(350)
  }

  OffCanvas.prototype.disableScrolling = function() {
    var bodyWidth = $('body').width()
    var prop = 'padding-' + this.opposite(this.placement)

    if ($('body').data('offcanvas-style') === undefined) {
      $('body').data('offcanvas-style', $('body').attr('style') || '')
    }
      
    $('body').css('overflow', 'hidden')

    if ($('body').width() > bodyWidth) {
      var padding = parseInt($('body').css(prop), 10) + $('body').width() - bodyWidth
      
      setTimeout(function() {
        $('body').css(prop, padding)
      }, 1)
    }
    //disable scrolling on mobiles (they ignore overflow:hidden)
    $('body').on('touchmove.bs', function(e) {
      e.preventDefault();
    });
  }

  OffCanvas.prototype.enableScrolling = function() {
    $('body').off('touchmove.bs');
  }

  OffCanvas.prototype.show = function () {
    if (this.state) return
    
    var startEvent = $.Event('show.bs.offcanvas')
    this.$element.trigger(startEvent)
    if (startEvent.isDefaultPrevented()) return

    this.state = 'slide-in'
    this.calcPlacement();
    
    var elements = this.getCanvasElements()
    var placement = this.placement
    var opposite = this.opposite(placement)
    var offset = this.offset()

    if (elements.index(this.$element) !== -1) {
      $(this.$element).data('offcanvas-style', $(this.$element).attr('style') || '')
      this.$element.css(placement, -1 * offset)
      this.$element.css(placement); // Workaround: Need to get the CSS property for it to be applied before the next line of code
    }

    elements.addClass('canvas-sliding').each(function() {
      if ($(this).data('offcanvas-style') === undefined) $(this).data('offcanvas-style', $(this).attr('style') || '')
      if ($(this).css('position') === 'static') $(this).css('position', 'relative')
      if (($(this).css(placement) === 'auto' || $(this).css(placement) === '0px') &&
          ($(this).css(opposite) === 'auto' || $(this).css(opposite) === '0px')) {
        $(this).css(placement, 0)
      }
    })
    
    if (this.options.disableScrolling) this.disableScrolling()
    if (this.options.modal) this.toggleBackdrop()
    
    var complete = function () {
      if (this.state != 'slide-in') return
      
      this.state = 'slid'

      elements.removeClass('canvas-sliding').addClass('canvas-slid')
      this.$element.trigger('shown.bs.offcanvas')
    }

    setTimeout($.proxy(function() {
      this.$element.addClass('in')
      this.slide(elements, offset, $.proxy(complete, this))
    }, this), 1)
  }

  OffCanvas.prototype.hide = function (fast) {
    if (this.state !== 'slid') return

    var startEvent = $.Event('hide.bs.offcanvas')
    this.$element.trigger(startEvent)
    if (startEvent.isDefaultPrevented()) return

    this.state = 'slide-out'

    var elements = $('.canvas-slid')
    var placement = this.placement
    var offset = -1 * this.offset()

    var complete = function () {
      if (this.state != 'slide-out') return
      
      this.state = null
      this.placement = null
      
      this.$element.removeClass('in')
      
      elements.removeClass('canvas-sliding')
      elements.add(this.$element).add('body').each(function() {
        $(this).attr('style', $(this).data('offcanvas-style')).removeData('offcanvas-style')
      })

      this.$element.trigger('hidden.bs.offcanvas')
    }

    if (this.options.disableScrolling) this.enableScrolling()
    if (this.options.modal) this.toggleBackdrop()

    elements.removeClass('canvas-slid').addClass('canvas-sliding')
    
    setTimeout($.proxy(function() {
      this.slide(elements, offset, $.proxy(complete, this))
    }, this), 1)
  }

  OffCanvas.prototype.toggle = function () {
    if (this.state === 'slide-in' || this.state === 'slide-out') return
    this[this.state === 'slid' ? 'hide' : 'show']()
  }

  OffCanvas.prototype.toggleBackdrop = function (callback) {
    callback = callback || $.noop;
    if (this.state == 'slide-in') {
      var doAnimate = $.support.transition;

      this.$backdrop = $('<div class="modal-backdrop fade" />')
      .insertAfter(this.$element);

      if (doAnimate) this.$backdrop[0].offsetWidth // force reflow

      this.$backdrop.addClass('in')

      doAnimate ?
        this.$backdrop
        .one($.support.transition.end, callback)
        .emulateTransitionEnd(150) :
        callback()
    } else if (this.state == 'slide-out' && this.$backdrop) {
      this.$backdrop.removeClass('in');
      $('body').off('touchmove.bs');
      var self = this;
      if ($.support.transition) {
        this.$backdrop
          .one($.support.transition.end, function() {
            self.$backdrop.remove();
            callback()
            self.$backdrop = null;
          })
        .emulateTransitionEnd(150);
      } else {
        this.$backdrop.remove();
        this.$backdrop = null;
        callback();
      }
    } else if (callback) {
      callback()
    }
  }

  OffCanvas.prototype.calcClone = function() {
    this.$calcClone = this.$element.clone()
      .html('')
      .addClass('offcanvas-clone').removeClass('in')
      .appendTo($('body'))
  }

  OffCanvas.prototype.recalc = function () {
    if (this.$calcClone.css('display') === 'none' || (this.state !== 'slid' && this.state !== 'slide-in')) return
    
    this.state = null
    this.placement = null
    var elements = this.getCanvasElements()
    
    this.$element.removeClass('in')
    
    elements.removeClass('canvas-slid')
    elements.add(this.$element).add('body').each(function() {
      $(this).attr('style', $(this).data('offcanvas-style')).removeData('offcanvas-style')
    })
  }
  
  OffCanvas.prototype.autohide = function (e) {
    if ($(e.target).closest(this.$element).length === 0) this.hide()
  }

  // OFFCANVAS PLUGIN DEFINITION
  // ==========================

  var old = $.fn.offcanvas

  $.fn.offcanvas = function (option) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('bs.offcanvas')
      var options = $.extend({}, OffCanvas.DEFAULTS, $this.data(), typeof option === 'object' && option)

      if (!data) $this.data('bs.offcanvas', (data = new OffCanvas(this, options)))
      if (typeof option === 'string') data[option]()
    })
  }

  $.fn.offcanvas.Constructor = OffCanvas


  // OFFCANVAS NO CONFLICT
  // ====================

  $.fn.offcanvas.noConflict = function () {
    $.fn.offcanvas = old
    return this
  }


  // OFFCANVAS DATA-API
  // =================

  $(document).on('click.bs.offcanvas.data-api', '[data-toggle=offcanvas]', function (e) {
    var $this   = $(this), href
    var target  = $this.attr('data-target')
        || e.preventDefault()
        || (href = $this.attr('href')) && href.replace(/.*(?=#[^\s]+$)/, '') //strip for ie7
    var $canvas = $(target)
    var data    = $canvas.data('bs.offcanvas')
    var option  = data ? 'toggle' : $this.data()

    e.stopPropagation()

    if (data) data.toggle()
      else $canvas.offcanvas(option)
  })

}(window.jQuery);

/* ========================================================================
 * Bootstrap: transition.js v3.1.3
 * http://getbootstrap.com/javascript/#transitions
 * ========================================================================
 * Copyright 2011-2014 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // CSS TRANSITION SUPPORT (Shoutout: http://www.modernizr.com/)
  // ============================================================

  function transitionEnd() {
    var el = document.createElement('bootstrap')

    var transEndEventNames = {
      WebkitTransition : 'webkitTransitionEnd',
      MozTransition    : 'transitionend',
      OTransition      : 'oTransitionEnd otransitionend',
      transition       : 'transitionend'
    }

    for (var name in transEndEventNames) {
      if (el.style[name] !== undefined) {
        return { end: transEndEventNames[name] }
      }
    }

    return false // explicit for ie8 (  ._.)
  }

  if ($.support.transition !== undefined) return  // Prevent conflict with Twitter Bootstrap

  // http://blog.alexmaccaw.com/css-transitions
  $.fn.emulateTransitionEnd = function (duration) {
    var called = false, $el = this
    $(this).one($.support.transition.end, function () { called = true })
    var callback = function () { if (!called) $($el).trigger($.support.transition.end) }
    setTimeout(callback, duration)
    return this
  }

  $(function () {
    $.support.transition = transitionEnd()
  })

}(window.jQuery);

/*!
 * Jasny Bootstrap v3.1.0 (http://jasny.github.com/bootstrap)
 * Copyright 2011-2014 Arnold Daniels.
 * Licensed under Apache-2.0 (https://github.com/jasny/bootstrap/blob/master/LICENSE)
 */

+function(a){"use strict";var b=function(c,d){this.$element=a(c),this.options=a.extend({},b.DEFAULTS,d),this.$element.on("click.bs.rowlink","td:not(.rowlink-skip)",a.proxy(this.click,this))};b.DEFAULTS={target:"a"},b.prototype.click=function(b){var c=a(b.currentTarget).closest("tr").find(this.options.target)[0];if(a(b.target)[0]===c)return;b.preventDefault();if(c.click)c.click();else if(document.createEvent){var d=document.createEvent("MouseEvents");d.initMouseEvent("click",!0,!0,window,0,0,0,0,0,!1,!1,!1,!1,0,null),c.dispatchEvent(d)}};var c=a.fn.rowlink;a.fn.rowlink=function(c){return this.each(function(){var d=a(this),e=d.data("bs.rowlink");e||d.data("bs.rowlink",e=new b(this,c))})},a.fn.rowlink.Constructor=b,a.fn.rowlink.noConflict=function(){return a.fn.rowlink=c,this},a(document).on("click.bs.rowlink.data-api",'[data-link="row"]',function(b){if(a(b.target).closest(".rowlink-skip").length!==0)return;var c=a(this);if(c.data("bs.rowlink"))return;c.rowlink(c.data()),a(b.target).trigger("click.bs.rowlink")})}(window.jQuery),+function(a){"use strict";var b=window.orientation!==undefined,c=navigator.userAgent.toLowerCase().indexOf("android")>-1,d=window.navigator.appName=="Microsoft Internet Explorer",e=function(b,d){if(c)return;this.$element=a(b),this.options=a.extend({},e.DEFAULTS,d),this.mask=String(this.options.mask),this.init(),this.listen(),this.checkVal()};e.DEFAULTS={mask:"",placeholder:"_",definitions:{9:"[0-9]",a:"[A-Za-z]",w:"[A-Za-z0-9]","*":"."}},e.prototype.init=function(){var b=this.options.definitions,c=this.mask.length;this.tests=[],this.partialPosition=this.mask.length,this.firstNonMaskPos=null,a.each(this.mask.split(""),a.proxy(function(a,d){d=="?"?(c--,this.partialPosition=a):b[d]?(this.tests.push(new RegExp(b[d])),this.firstNonMaskPos===null&&(this.firstNonMaskPos=this.tests.length-1)):this.tests.push(null)},this)),this.buffer=a.map(this.mask.split(""),a.proxy(function(a,c){if(a!="?")return b[a]?this.options.placeholder:a},this)),this.focusText=this.$element.val(),this.$element.data("rawMaskFn",a.proxy(function(){return a.map(this.buffer,function(a,b){return this.tests[b]&&a!=this.options.placeholder?a:null}).join("")},this))},e.prototype.listen=function(){if(this.$element.attr("readonly"))return;var b=(d?"paste":"input")+".bs.inputmask";this.$element.on("unmask.bs.inputmask",a.proxy(this.unmask,this)).on("focus.bs.inputmask",a.proxy(this.focusEvent,this)).on("blur.bs.inputmask",a.proxy(this.blurEvent,this)).on("keydown.bs.inputmask",a.proxy(this.keydownEvent,this)).on("keypress.bs.inputmask",a.proxy(this.keypressEvent,this)).on(b,a.proxy(this.pasteEvent,this))},e.prototype.caret=function(a,b){if(this.$element.length===0)return;if(typeof a=="number")return b=typeof b=="number"?b:a,this.$element.each(function(){if(this.setSelectionRange)this.setSelectionRange(a,b);else if(this.createTextRange){var c=this.createTextRange();c.collapse(!0),c.moveEnd("character",b),c.moveStart("character",a),c.select()}});if(this.$element[0].setSelectionRange)a=this.$element[0].selectionStart,b=this.$element[0].selectionEnd;else if(document.selection&&document.selection.createRange){var c=document.selection.createRange();a=0-c.duplicate().moveStart("character",-1e5),b=a+c.text.length}return{begin:a,end:b}},e.prototype.seekNext=function(a){var b=this.mask.length;while(++a<=b&&!this.tests[a]);return a},e.prototype.seekPrev=function(a){while(--a>=0&&!this.tests[a]);return a},e.prototype.shiftL=function(a,b){var c=this.mask.length;if(a<0)return;for(var d=a,e=this.seekNext(b);d<c;d++)if(this.tests[d]){if(e<c&&this.tests[d].test(this.buffer[e]))this.buffer[d]=this.buffer[e],this.buffer[e]=this.options.placeholder;else break;e=this.seekNext(e)}this.writeBuffer(),this.caret(Math.max(this.firstNonMaskPos,a))},e.prototype.shiftR=function(a){var b=this.mask.length;for(var c=a,d=this.options.placeholder;c<b;c++)if(this.tests[c]){var e=this.seekNext(c),f=this.buffer[c];this.buffer[c]=d;if(e<b&&this.tests[e].test(f))d=f;else break}},e.prototype.unmask=function(){this.$element.unbind(".bs.inputmask").removeData("bs.inputmask")},e.prototype.focusEvent=function(){this.focusText=this.$element.val();var a=this.mask.length,b=this.checkVal();this.writeBuffer();var c=this,d=function(){b==a?c.caret(0,b):c.caret(b)};d(),setTimeout(d,50)},e.prototype.blurEvent=function(){this.checkVal(),this.$element.val()!==this.focusText&&(this.$element.trigger("change"),this.$element.trigger("input"))},e.prototype.keydownEvent=function(a){var c=a.which;if(c==8||c==46||b&&c==127){var d=this.caret(),e=d.begin,f=d.end;return f-e===0&&(e=c!=46?this.seekPrev(e):f=this.seekNext(e-1),f=c==46?this.seekNext(f):f),this.clearBuffer(e,f),this.shiftL(e,f-1),!1}if(c==27)return this.$element.val(this.focusText),this.caret(0,this.checkVal()),!1},e.prototype.keypressEvent=function(a){var b=this.mask.length,c=a.which,d=this.caret();if(a.ctrlKey||a.altKey||a.metaKey||c<32)return!0;if(c){d.end-d.begin!==0&&(this.clearBuffer(d.begin,d.end),this.shiftL(d.begin,d.end-1));var e=this.seekNext(d.begin-1);if(e<b){var f=String.fromCharCode(c);if(this.tests[e].test(f)){this.shiftR(e),this.buffer[e]=f,this.writeBuffer();var g=this.seekNext(e);this.caret(g)}}return!1}},e.prototype.pasteEvent=function(){var a=this;setTimeout(function(){a.caret(a.checkVal(!0))},0)},e.prototype.clearBuffer=function(a,b){var c=this.mask.length;for(var d=a;d<b&&d<c;d++)this.tests[d]&&(this.buffer[d]=this.options.placeholder)},e.prototype.writeBuffer=function(){return this.$element.val(this.buffer.join("")).val()},e.prototype.checkVal=function(a){var b=this.mask.length,c=this.$element.val(),d=-1;for(var e=0,f=0;e<b;e++)if(this.tests[e]){this.buffer[e]=this.options.placeholder;while(f++<c.length){var g=c.charAt(f-1);if(this.tests[e].test(g)){this.buffer[e]=g,d=e;break}}if(f>c.length)break}else this.buffer[e]==c.charAt(f)&&e!=this.partialPosition&&(f++,d=e);if(!a&&d+1<this.partialPosition)this.$element.val(""),this.clearBuffer(0,b);else if(a||d+1>=this.partialPosition)this.writeBuffer(),a||this.$element.val(this.$element.val().substring(0,d+1));return this.partialPosition?e:this.firstNonMaskPos};var f=a.fn.inputmask;a.fn.inputmask=function(b){return this.each(function(){var c=a(this),d=c.data("bs.inputmask");d||c.data("bs.inputmask",d=new e(this,b))})},a.fn.inputmask.Constructor=e,a.fn.inputmask.noConflict=function(){return a.fn.inputmask=f,this},a(document).on("focus.bs.inputmask.data-api","[data-mask]",function(b){var c=a(this);if(c.data("bs.inputmask"))return;c.inputmask(c.data())})}(window.jQuery),+function(a){"use strict";var b=window.navigator.appName=="Microsoft Internet Explorer",c=function(b,c){this.$element=a(b),this.$input=this.$element.find(":file");if(this.$input.length===0)return;this.name=this.$input.attr("name")||c.name,this.$hidden=this.$element.find('input[type=hidden][name="'+this.name+'"]'),this.$hidden.length===0&&(this.$hidden=a('<input type="hidden">').insertBefore(this.$input)),this.$preview=this.$element.find(".fileinput-preview");var d=this.$preview.css("height");this.$preview.css("display")!=="inline"&&d!=="0px"&&d!=="none"&&this.$preview.css("line-height",d),this.original={exists:this.$element.hasClass("fileinput-exists"),preview:this.$preview.html(),hiddenVal:this.$hidden.val()},this.listen()};c.prototype.listen=function(){this.$input.on("change.bs.fileinput",a.proxy(this.change,this)),a(this.$input[0].form).on("reset.bs.fileinput",a.proxy(this.reset,this)),this.$element.find('[data-trigger="fileinput"]').on("click.bs.fileinput",a.proxy(this.trigger,this)),this.$element.find('[data-dismiss="fileinput"]').on("click.bs.fileinput",a.proxy(this.clear,this))},c.prototype.change=function(b){var c=b.target.files===undefined?b.target&&b.target.value?[{name:b.target.value.replace(/^.+\\/,"")}]:[]:b.target.files;b.stopPropagation();if(c.length===0){this.clear();return}this.$hidden.val(""),this.$hidden.attr("name",""),this.$input.attr("name",this.name);var d=c[0];if(this.$preview.length>0&&(typeof d.type!="undefined"?d.type.match(/^image\/(gif|png|jpeg)$/):d.name.match(/\.(gif|png|jpe?g)$/i))&&typeof FileReader!="undefined"){var e=new FileReader,f=this.$preview,g=this.$element;e.onload=function(b){var e=a("<img>");e[0].src=b.target.result,c[0].result=b.target.result,g.find(".fileinput-filename").text(d.name),f.css("max-height")!="none"&&e.css("max-height",parseInt(f.css("max-height"),10)-parseInt(f.css("padding-top"),10)-parseInt(f.css("padding-bottom"),10)-parseInt(f.css("border-top"),10)-parseInt(f.css("border-bottom"),10)),f.html(e),g.addClass("fileinput-exists").removeClass("fileinput-new"),g.trigger("change.bs.fileinput",c)},e.readAsDataURL(d)}else this.$element.find(".fileinput-filename").text(d.name),this.$preview.text(d.name),this.$element.addClass("fileinput-exists").removeClass("fileinput-new"),this.$element.trigger("change.bs.fileinput")},c.prototype.clear=function(a){a&&a.preventDefault(),this.$hidden.val(""),this.$hidden.attr("name",this.name),this.$input.attr("name","");if(b){var c=this.$input.clone(!0);this.$input.after(c),this.$input.remove(),this.$input=c}else this.$input.val("");this.$preview.html(""),this.$element.find(".fileinput-filename").text(""),this.$element.addClass("fileinput-new").removeClass("fileinput-exists"),a!==undefined&&(this.$input.trigger("change"),this.$element.trigger("clear.bs.fileinput"))},c.prototype.reset=function(){this.clear(),this.$hidden.val(this.original.hiddenVal),this.$preview.html(this.original.preview),this.$element.find(".fileinput-filename").text(""),this.original.exists?this.$element.addClass("fileinput-exists").removeClass("fileinput-new"):this.$element.addClass("fileinput-new").removeClass("fileinput-exists"),this.$element.trigger("reset.bs.fileinput")},c.prototype.trigger=function(a){this.$input.trigger("click"),a.preventDefault()};var d=a.fn.fileinput;a.fn.fileinput=function(b){return this.each(function(){var d=a(this),e=d.data("bs.fileinput");e||d.data("bs.fileinput",e=new c(this,b)),typeof b=="string"&&e[b]()})},a.fn.fileinput.Constructor=c,a.fn.fileinput.noConflict=function(){return a.fn.fileinput=d,this},a(document).on("click.fileinput.data-api",'[data-provides="fileinput"]',function(b){var c=a(this);if(c.data("bs.fileinput"))return;c.fileinput(c.data());var d=a(b.target).closest('[data-dismiss="fileinput"],[data-trigger="fileinput"]');d.length>0&&(b.preventDefault(),d.trigger("click.bs.fileinput"))})}(window.jQuery),+function(a){"use strict";var b=function(c,d){this.$element=a(c),this.options=a.extend({},b.DEFAULTS,d),this.state=null,this.placement=null,this.options.recalc&&(this.calcClone(),a(window).on("resize",a.proxy(this.recalc,this))),this.options.autohide&&a(document).on("click",a.proxy(this.autohide,this)),this.options.toggle&&this.toggle(),this.options.disablescrolling&&(this.options.disableScrolling=this.options.disablescrolling,delete this.options.disablescrolling)};b.DEFAULTS={toggle:!0,placement:"auto",autohide:!0,recalc:!0,disableScrolling:!0,modal:!1},b.prototype.offset=function(){switch(this.placement){case"left":case"right":return this.$element.outerWidth();case"top":case"bottom":return this.$element.outerHeight()}},b.prototype.calcPlacement=function(){function e(a,b){if(d.css(b)==="auto")return a;if(d.css(a)==="auto")return b;var c=parseInt(d.css(a),10),e=parseInt(d.css(b),10);return c>e?b:a}if(this.options.placement!=="auto"){this.placement=this.options.placement;return}this.$element.hasClass("in")||this.$element.css("visiblity","hidden !important").addClass("in");var b=a(window).width()/this.$element.width(),c=a(window).height()/this.$element.height(),d=this.$element;this.placement=b>=c?e("left","right"):e("top","bottom"),this.$element.css("visibility")==="hidden !important"&&this.$element.removeClass("in").css("visiblity","")},b.prototype.opposite=function(a){switch(a){case"top":return"bottom";case"left":return"right";case"bottom":return"top";case"right":return"left"}},b.prototype.getCanvasElements=function(){var b=this.options.canvas?a(this.options.canvas):this.$element,c=b.find("*").filter(function(){return a(this).css("position")==="fixed"}).not(this.options.exclude);return b.add(c)},b.prototype.slide=function(b,c,d){if(!a.support.transition){var e={};return e[this.placement]="+="+c,b.animate(e,350,d)}var f=this.placement,g=this.opposite(f);b.each(function(){a(this).css(f)!=="auto"&&a(this).css(f,(parseInt(a(this).css(f),10)||0)+c),a(this).css(g)!=="auto"&&a(this).css(g,(parseInt(a(this).css(g),10)||0)-c)}),this.$element.one(a.support.transition.end,d).emulateTransitionEnd(350)},b.prototype.disableScrolling=function(){var b=a("body").width(),c="padding-"+this.opposite(this.placement);a("body").data("offcanvas-style")===undefined&&a("body").data("offcanvas-style",a("body").attr("style")||""),a("body").css("overflow","hidden");if(a("body").width()>b){var d=parseInt(a("body").css(c),10)+a("body").width()-b;setTimeout(function(){a("body").css(c,d)},1)}a("body").on("touchmove.bs",function(a){a.preventDefault()})},b.prototype.enableScrolling=function(){a("body").off("touchmove.bs")},b.prototype.show=function(){if(this.state)return;var b=a.Event("show.bs.offcanvas");this.$element.trigger(b);if(b.isDefaultPrevented())return;this.state="slide-in",this.calcPlacement();var c=this.getCanvasElements(),d=this.placement,e=this.opposite(d),f=this.offset();c.index(this.$element)!==-1&&(a(this.$element).data("offcanvas-style",a(this.$element).attr("style")||""),this.$element.css(d,-1*f),this.$element.css(d)),c.addClass("canvas-sliding").each(function(){a(this).data("offcanvas-style")===undefined&&a(this).data("offcanvas-style",a(this).attr("style")||""),a(this).css("position")==="static"&&a(this).css("position","relative"),(a(this).css(d)==="auto"||a(this).css(d)==="0px")&&(a(this).css(e)==="auto"||a(this).css(e)==="0px")&&a(this).css(d,0)}),this.options.disableScrolling&&this.disableScrolling(),this.options.modal&&this.toggleBackdrop();var g=function(){if(this.state!="slide-in")return;this.state="slid",c.removeClass("canvas-sliding").addClass("canvas-slid"),this.$element.trigger("shown.bs.offcanvas")};setTimeout(a.proxy(function(){this.$element.addClass("in"),this.slide(c,f,a.proxy(g,this))},this),1)},b.prototype.hide=function(b){if(this.state!=="slid")return;var c=a.Event("hide.bs.offcanvas");this.$element.trigger(c);if(c.isDefaultPrevented())return;this.state="slide-out";var d=a(".canvas-slid"),e=this.placement,f=-1*this.offset(),g=function(){if(this.state!="slide-out")return;this.state=null,this.placement=null,this.$element.removeClass("in"),d.removeClass("canvas-sliding"),d.add(this.$element).add("body").each(function(){a(this).attr("style",a(this).data("offcanvas-style")).removeData("offcanvas-style")}),this.$element.trigger("hidden.bs.offcanvas")};this.options.disableScrolling&&this.enableScrolling(),this.options.modal&&this.toggleBackdrop(),d.removeClass("canvas-slid").addClass("canvas-sliding"),setTimeout(a.proxy(function(){this.slide(d,f,a.proxy(g,this))},this),1)},b.prototype.toggle=function(){if(this.state==="slide-in"||this.state==="slide-out")return;this[this.state==="slid"?"hide":"show"]()},b.prototype.toggleBackdrop=function(b){b=b||a.noop;if(this.state=="slide-in"){var c=a.support.transition;this.$backdrop=a('<div class="modal-backdrop fade" />').insertAfter(this.$element),c&&this.$backdrop[0].offsetWidth,this.$backdrop.addClass("in"),c?this.$backdrop.one(a.support.transition.end,b).emulateTransitionEnd(150):b()}else if(this.state=="slide-out"&&this.$backdrop){this.$backdrop.removeClass("in"),a("body").off("touchmove.bs");var d=this;a.support.transition?this.$backdrop.one(a.support.transition.end,function(){d.$backdrop.remove(),b(),d.$backdrop=null}).emulateTransitionEnd(150):(this.$backdrop.remove(),this.$backdrop=null,b())}else b&&b()},b.prototype.calcClone=function(){this.$calcClone=this.$element.clone().html("").addClass("offcanvas-clone").removeClass("in").appendTo(a("body"))},b.prototype.recalc=function(){if(this.$calcClone.css("display")==="none"||this.state!=="slid"&&this.state!=="slide-in")return;this.state=null,this.placement=null;var b=this.getCanvasElements();this.$element.removeClass("in"),b.removeClass("canvas-slid"),b.add(this.$element).add("body").each(function(){a(this).attr("style",a(this).data("offcanvas-style")).removeData("offcanvas-style")})},b.prototype.autohide=function(b){a(b.target).closest(this.$element).length===0&&this.hide()};var c=a.fn.offcanvas;a.fn.offcanvas=function(c){return this.each(function(){var d=a(this),e=d.data("bs.offcanvas"),f=a.extend({},b.DEFAULTS,d.data(),typeof c=="object"&&c);e||d.data("bs.offcanvas",e=new b(this,f)),typeof c=="string"&&e[c]()})},a.fn.offcanvas.Constructor=b,a.fn.offcanvas.noConflict=function(){return a.fn.offcanvas=c,this},a(document).on("click.bs.offcanvas.data-api","[data-toggle=offcanvas]",function(b){var c=a(this),d,e=c.attr("data-target")||b.preventDefault()||(d=c.attr("href"))&&d.replace(/.*(?=#[^\s]+$)/,""),f=a(e),g=f.data("bs.offcanvas"),h=g?"toggle":c.data();b.stopPropagation(),g?g.toggle():f.offcanvas(h)})}(window.jQuery),+function(a){function b(){var a=document.createElement("bootstrap"),b={WebkitTransition:"webkitTransitionEnd",MozTransition:"transitionend",OTransition:"oTransitionEnd otransitionend",transition:"transitionend"};for(var c in b)if(a.style[c]!==undefined)return{end:b[c]};return!1}"use strict";if(a.support.transition!==undefined)return;a.fn.emulateTransitionEnd=function(b){var c=!1,d=this;a(this).one(a.support.transition.end,function(){c=!0});var e=function(){c||a(d).trigger(a.support.transition.end)};return setTimeout(e,b),this},a(function(){a.support.transition=b()})}(window.jQuery)