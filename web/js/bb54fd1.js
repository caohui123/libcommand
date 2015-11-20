/* ========================================================================
 * bootstrap-switch - v3.3.2
 * http://www.bootstrap-switch.org
 * ========================================================================
 * Copyright 2012-2013 Mattia Larentis
 *
 * ========================================================================
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================================
 */

(function(){var t=[].slice;!function(e,i){"use strict";var n;return n=function(){function t(t,i){null==i&&(i={}),this.$element=e(t),this.options=e.extend({},e.fn.bootstrapSwitch.defaults,{state:this.$element.is(":checked"),size:this.$element.data("size"),animate:this.$element.data("animate"),disabled:this.$element.is(":disabled"),readonly:this.$element.is("[readonly]"),indeterminate:this.$element.data("indeterminate"),inverse:this.$element.data("inverse"),radioAllOff:this.$element.data("radio-all-off"),onColor:this.$element.data("on-color"),offColor:this.$element.data("off-color"),onText:this.$element.data("on-text"),offText:this.$element.data("off-text"),labelText:this.$element.data("label-text"),handleWidth:this.$element.data("handle-width"),labelWidth:this.$element.data("label-width"),baseClass:this.$element.data("base-class"),wrapperClass:this.$element.data("wrapper-class")},i),this.prevOptions={},this.$wrapper=e("<div>",{"class":function(t){return function(){var e;return e=[""+t.options.baseClass].concat(t._getClasses(t.options.wrapperClass)),e.push(t.options.state?t.options.baseClass+"-on":t.options.baseClass+"-off"),null!=t.options.size&&e.push(t.options.baseClass+"-"+t.options.size),t.options.disabled&&e.push(t.options.baseClass+"-disabled"),t.options.readonly&&e.push(t.options.baseClass+"-readonly"),t.options.indeterminate&&e.push(t.options.baseClass+"-indeterminate"),t.options.inverse&&e.push(t.options.baseClass+"-inverse"),t.$element.attr("id")&&e.push(t.options.baseClass+"-id-"+t.$element.attr("id")),e.join(" ")}}(this)()}),this.$container=e("<div>",{"class":this.options.baseClass+"-container"}),this.$on=e("<span>",{html:this.options.onText,"class":this.options.baseClass+"-handle-on "+this.options.baseClass+"-"+this.options.onColor}),this.$off=e("<span>",{html:this.options.offText,"class":this.options.baseClass+"-handle-off "+this.options.baseClass+"-"+this.options.offColor}),this.$label=e("<span>",{html:this.options.labelText,"class":this.options.baseClass+"-label"}),this.$element.on("init.bootstrapSwitch",function(e){return function(){return e.options.onInit.apply(t,arguments)}}(this)),this.$element.on("switchChange.bootstrapSwitch",function(i){return function(n){return!1===i.options.onSwitchChange.apply(t,arguments)?i.$element.is(":radio")?e("[name='"+i.$element.attr("name")+"']").trigger("previousState.bootstrapSwitch",!0):i.$element.trigger("previousState.bootstrapSwitch",!0):void 0}}(this)),this.$container=this.$element.wrap(this.$container).parent(),this.$wrapper=this.$container.wrap(this.$wrapper).parent(),this.$element.before(this.options.inverse?this.$off:this.$on).before(this.$label).before(this.options.inverse?this.$on:this.$off),this.options.indeterminate&&this.$element.prop("indeterminate",!0),this._init(),this._elementHandlers(),this._handleHandlers(),this._labelHandlers(),this._formHandler(),this._externalLabelHandler(),this.$element.trigger("init.bootstrapSwitch",this.options.state)}return t.prototype._constructor=t,t.prototype.setPrevOptions=function(){return this.prevOptions=e.extend(!0,{},this.options)},t.prototype.state=function(t,i){return"undefined"==typeof t?this.options.state:this.options.disabled||this.options.readonly?this.$element:this.options.state&&!this.options.radioAllOff&&this.$element.is(":radio")?this.$element:(this.$element.is(":radio")?e("[name='"+this.$element.attr("name")+"']").trigger("setPreviousOptions.bootstrapSwitch"):this.$element.trigger("setPreviousOptions.bootstrapSwitch"),this.options.indeterminate&&this.indeterminate(!1),t=!!t,this.$element.prop("checked",t).trigger("change.bootstrapSwitch",i),this.$element)},t.prototype.toggleState=function(t){return this.options.disabled||this.options.readonly?this.$element:this.options.indeterminate?(this.indeterminate(!1),this.state(!0)):this.$element.prop("checked",!this.options.state).trigger("change.bootstrapSwitch",t)},t.prototype.size=function(t){return"undefined"==typeof t?this.options.size:(null!=this.options.size&&this.$wrapper.removeClass(this.options.baseClass+"-"+this.options.size),t&&this.$wrapper.addClass(this.options.baseClass+"-"+t),this._width(),this._containerPosition(),this.options.size=t,this.$element)},t.prototype.animate=function(t){return"undefined"==typeof t?this.options.animate:(t=!!t,t===this.options.animate?this.$element:this.toggleAnimate())},t.prototype.toggleAnimate=function(){return this.options.animate=!this.options.animate,this.$wrapper.toggleClass(this.options.baseClass+"-animate"),this.$element},t.prototype.disabled=function(t){return"undefined"==typeof t?this.options.disabled:(t=!!t,t===this.options.disabled?this.$element:this.toggleDisabled())},t.prototype.toggleDisabled=function(){return this.options.disabled=!this.options.disabled,this.$element.prop("disabled",this.options.disabled),this.$wrapper.toggleClass(this.options.baseClass+"-disabled"),this.$element},t.prototype.readonly=function(t){return"undefined"==typeof t?this.options.readonly:(t=!!t,t===this.options.readonly?this.$element:this.toggleReadonly())},t.prototype.toggleReadonly=function(){return this.options.readonly=!this.options.readonly,this.$element.prop("readonly",this.options.readonly),this.$wrapper.toggleClass(this.options.baseClass+"-readonly"),this.$element},t.prototype.indeterminate=function(t){return"undefined"==typeof t?this.options.indeterminate:(t=!!t,t===this.options.indeterminate?this.$element:this.toggleIndeterminate())},t.prototype.toggleIndeterminate=function(){return this.options.indeterminate=!this.options.indeterminate,this.$element.prop("indeterminate",this.options.indeterminate),this.$wrapper.toggleClass(this.options.baseClass+"-indeterminate"),this._containerPosition(),this.$element},t.prototype.inverse=function(t){return"undefined"==typeof t?this.options.inverse:(t=!!t,t===this.options.inverse?this.$element:this.toggleInverse())},t.prototype.toggleInverse=function(){var t,e;return this.$wrapper.toggleClass(this.options.baseClass+"-inverse"),e=this.$on.clone(!0),t=this.$off.clone(!0),this.$on.replaceWith(t),this.$off.replaceWith(e),this.$on=t,this.$off=e,this.options.inverse=!this.options.inverse,this.$element},t.prototype.onColor=function(t){var e;return e=this.options.onColor,"undefined"==typeof t?e:(null!=e&&this.$on.removeClass(this.options.baseClass+"-"+e),this.$on.addClass(this.options.baseClass+"-"+t),this.options.onColor=t,this.$element)},t.prototype.offColor=function(t){var e;return e=this.options.offColor,"undefined"==typeof t?e:(null!=e&&this.$off.removeClass(this.options.baseClass+"-"+e),this.$off.addClass(this.options.baseClass+"-"+t),this.options.offColor=t,this.$element)},t.prototype.onText=function(t){return"undefined"==typeof t?this.options.onText:(this.$on.html(t),this._width(),this._containerPosition(),this.options.onText=t,this.$element)},t.prototype.offText=function(t){return"undefined"==typeof t?this.options.offText:(this.$off.html(t),this._width(),this._containerPosition(),this.options.offText=t,this.$element)},t.prototype.labelText=function(t){return"undefined"==typeof t?this.options.labelText:(this.$label.html(t),this._width(),this.options.labelText=t,this.$element)},t.prototype.handleWidth=function(t){return"undefined"==typeof t?this.options.handleWidth:(this.options.handleWidth=t,this._width(),this._containerPosition(),this.$element)},t.prototype.labelWidth=function(t){return"undefined"==typeof t?this.options.labelWidth:(this.options.labelWidth=t,this._width(),this._containerPosition(),this.$element)},t.prototype.baseClass=function(t){return this.options.baseClass},t.prototype.wrapperClass=function(t){return"undefined"==typeof t?this.options.wrapperClass:(t||(t=e.fn.bootstrapSwitch.defaults.wrapperClass),this.$wrapper.removeClass(this._getClasses(this.options.wrapperClass).join(" ")),this.$wrapper.addClass(this._getClasses(t).join(" ")),this.options.wrapperClass=t,this.$element)},t.prototype.radioAllOff=function(t){return"undefined"==typeof t?this.options.radioAllOff:(t=!!t,t===this.options.radioAllOff?this.$element:(this.options.radioAllOff=t,this.$element))},t.prototype.onInit=function(t){return"undefined"==typeof t?this.options.onInit:(t||(t=e.fn.bootstrapSwitch.defaults.onInit),this.options.onInit=t,this.$element)},t.prototype.onSwitchChange=function(t){return"undefined"==typeof t?this.options.onSwitchChange:(t||(t=e.fn.bootstrapSwitch.defaults.onSwitchChange),this.options.onSwitchChange=t,this.$element)},t.prototype.destroy=function(){var t;return t=this.$element.closest("form"),t.length&&t.off("reset.bootstrapSwitch").removeData("bootstrap-switch"),this.$container.children().not(this.$element).remove(),this.$element.unwrap().unwrap().off(".bootstrapSwitch").removeData("bootstrap-switch"),this.$element},t.prototype._width=function(){var t,e;return t=this.$on.add(this.$off),t.add(this.$label).css("width",""),e="auto"===this.options.handleWidth?Math.max(this.$on.width(),this.$off.width()):this.options.handleWidth,t.width(e),this.$label.width(function(t){return function(i,n){return"auto"!==t.options.labelWidth?t.options.labelWidth:e>n?e:n}}(this)),this._handleWidth=this.$on.outerWidth(),this._labelWidth=this.$label.outerWidth(),this.$container.width(2*this._handleWidth+this._labelWidth),this.$wrapper.width(this._handleWidth+this._labelWidth)},t.prototype._containerPosition=function(t,e){return null==t&&(t=this.options.state),this.$container.css("margin-left",function(e){return function(){var i;return i=[0,"-"+e._handleWidth+"px"],e.options.indeterminate?"-"+e._handleWidth/2+"px":t?e.options.inverse?i[1]:i[0]:e.options.inverse?i[0]:i[1]}}(this)),e?setTimeout(function(){return e()},50):void 0},t.prototype._init=function(){var t,e;return t=function(t){return function(){return t.setPrevOptions(),t._width(),t._containerPosition(null,function(){return t.options.animate?t.$wrapper.addClass(t.options.baseClass+"-animate"):void 0})}}(this),this.$wrapper.is(":visible")?t():e=i.setInterval(function(n){return function(){return n.$wrapper.is(":visible")?(t(),i.clearInterval(e)):void 0}}(this),50)},t.prototype._elementHandlers=function(){return this.$element.on({"setPreviousOptions.bootstrapSwitch":function(t){return function(e){return t.setPrevOptions()}}(this),"previousState.bootstrapSwitch":function(t){return function(e){return t.options=t.prevOptions,t.options.indeterminate&&t.$wrapper.addClass(t.options.baseClass+"-indeterminate"),t.$element.prop("checked",t.options.state).trigger("change.bootstrapSwitch",!0)}}(this),"change.bootstrapSwitch":function(t){return function(i,n){var o;return i.preventDefault(),i.stopImmediatePropagation(),o=t.$element.is(":checked"),t._containerPosition(o),o!==t.options.state?(t.options.state=o,t.$wrapper.toggleClass(t.options.baseClass+"-off").toggleClass(t.options.baseClass+"-on"),n?void 0:(t.$element.is(":radio")&&e("[name='"+t.$element.attr("name")+"']").not(t.$element).prop("checked",!1).trigger("change.bootstrapSwitch",!0),t.$element.trigger("switchChange.bootstrapSwitch",[o]))):void 0}}(this),"focus.bootstrapSwitch":function(t){return function(e){return e.preventDefault(),t.$wrapper.addClass(t.options.baseClass+"-focused")}}(this),"blur.bootstrapSwitch":function(t){return function(e){return e.preventDefault(),t.$wrapper.removeClass(t.options.baseClass+"-focused")}}(this),"keydown.bootstrapSwitch":function(t){return function(e){if(e.which&&!t.options.disabled&&!t.options.readonly)switch(e.which){case 37:return e.preventDefault(),e.stopImmediatePropagation(),t.state(!1);case 39:return e.preventDefault(),e.stopImmediatePropagation(),t.state(!0)}}}(this)})},t.prototype._handleHandlers=function(){return this.$on.on("click.bootstrapSwitch",function(t){return function(e){return e.preventDefault(),e.stopPropagation(),t.state(!1),t.$element.trigger("focus.bootstrapSwitch")}}(this)),this.$off.on("click.bootstrapSwitch",function(t){return function(e){return e.preventDefault(),e.stopPropagation(),t.state(!0),t.$element.trigger("focus.bootstrapSwitch")}}(this))},t.prototype._labelHandlers=function(){return this.$label.on({click:function(t){return t.stopPropagation()},"mousedown.bootstrapSwitch touchstart.bootstrapSwitch":function(t){return function(e){return t._dragStart||t.options.disabled||t.options.readonly?void 0:(e.preventDefault(),e.stopPropagation(),t._dragStart=(e.pageX||e.originalEvent.touches[0].pageX)-parseInt(t.$container.css("margin-left"),10),t.options.animate&&t.$wrapper.removeClass(t.options.baseClass+"-animate"),t.$element.trigger("focus.bootstrapSwitch"))}}(this),"mousemove.bootstrapSwitch touchmove.bootstrapSwitch":function(t){return function(e){var i;if(null!=t._dragStart&&(e.preventDefault(),i=(e.pageX||e.originalEvent.touches[0].pageX)-t._dragStart,!(i<-t._handleWidth||i>0)))return t._dragEnd=i,t.$container.css("margin-left",t._dragEnd+"px")}}(this),"mouseup.bootstrapSwitch touchend.bootstrapSwitch":function(t){return function(e){var i;if(t._dragStart)return e.preventDefault(),t.options.animate&&t.$wrapper.addClass(t.options.baseClass+"-animate"),t._dragEnd?(i=t._dragEnd>-(t._handleWidth/2),t._dragEnd=!1,t.state(t.options.inverse?!i:i)):t.state(!t.options.state),t._dragStart=!1}}(this),"mouseleave.bootstrapSwitch":function(t){return function(e){return t.$label.trigger("mouseup.bootstrapSwitch")}}(this)})},t.prototype._externalLabelHandler=function(){var t;return t=this.$element.closest("label"),t.on("click",function(e){return function(i){return i.preventDefault(),i.stopImmediatePropagation(),i.target===t[0]?e.toggleState():void 0}}(this))},t.prototype._formHandler=function(){var t;return t=this.$element.closest("form"),t.data("bootstrap-switch")?void 0:t.on("reset.bootstrapSwitch",function(){return i.setTimeout(function(){return t.find("input").filter(function(){return e(this).data("bootstrap-switch")}).each(function(){return e(this).bootstrapSwitch("state",this.checked)})},1)}).data("bootstrap-switch",!0)},t.prototype._getClasses=function(t){var i,n,o,s;if(!e.isArray(t))return[this.options.baseClass+"-"+t];for(n=[],o=0,s=t.length;s>o;o++)i=t[o],n.push(this.options.baseClass+"-"+i);return n},t}(),e.fn.bootstrapSwitch=function(){var i,o,s;return o=arguments[0],i=2<=arguments.length?t.call(arguments,1):[],s=this,this.each(function(){var t,a;return t=e(this),a=t.data("bootstrap-switch"),a||t.data("bootstrap-switch",a=new n(this,o)),"string"==typeof o?s=a[o].apply(a,i):void 0}),s},e.fn.bootstrapSwitch.Constructor=n,e.fn.bootstrapSwitch.defaults={state:!0,size:null,animate:!0,disabled:!1,readonly:!1,indeterminate:!1,inverse:!1,radioAllOff:!1,onColor:"primary",offColor:"default",onText:"ON",offText:"OFF",labelText:"&nbsp;",handleWidth:"auto",labelWidth:"auto",baseClass:"bootstrap-switch",wrapperClass:"wrapper",onInit:function(){},onSwitchChange:function(){}}}(window.jQuery,window)}).call(this);
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