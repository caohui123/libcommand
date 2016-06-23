$(document).ready(function(){    
    /******
     * Tenured Staff 
     ******/
    var $tenuredCollectionHolder;
    var $addTenuredLink = $('<a href="#" class="add_stafftenured_link">+ Add Tenure-Track Staff</a>');
    var $newTenuredLi = $('<li></li>').append($addTenuredLink);

    // Get the ul that holds the collection of tags
    $tenuredCollectionHolder = $('ul.stafftenured_collection');
    
    // add the "add a tag" anchor and li to the tags ul
    $tenuredCollectionHolder.append($newTenuredLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $tenuredCollectionHolder.data('index', $tenuredCollectionHolder.find(':input').length);

    //Add an initial staffTenured form.
    //addTagForm($tenuredCollectionHolder, $newTenuredLi);

    //Add an additional staffTenured form each time a user clicks the $addTenuredLink
    $addTenuredLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new tag form
        addTagForm($tenuredCollectionHolder, $newTenuredLi);
    });

    /******
     * Clerical Staff 
     ******/
    var $clericalCollectionHolder;
    var $addClericalLink = $('<a href="#" class="add_staffclerical_link">+ Add Clerical Staff</a>');
    var $newClericalLi = $('<li></li>').append($addClericalLink);

    $clericalCollectionHolder = $('ul.staffclerical_collection');

    $clericalCollectionHolder.append($newClericalLi);

    $clericalCollectionHolder.data('index', $clericalCollectionHolder.find(':input').length);

    //Add an initial staffClerical form.
    //addTagForm($clericalCollectionHolder, $newClericalLi);

    //Add an additional staffClerical form each time a user clicks the $addClericalLink
    $addClericalLink.on('click', function(e) {
        e.preventDefault();
        addTagForm($clericalCollectionHolder, $newClericalLi);
    });

    /******
     * Lecturer Staff 
     ******/
    var $lecturerCollectionHolder;
    var $addLecturerLink = $('<a href="#" class="add_stafflecturers_link">+ Add Lecturers</a>');
    var $newLecturerLi = $('<li></li>').append($addLecturerLink);

    $lecturerCollectionHolder = $('ul.stafflecturers_collection');

    $lecturerCollectionHolder.append($newLecturerLi);

    $lecturerCollectionHolder.data('index', $lecturerCollectionHolder.find(':input').length);

    //Add an initial staffLecturer form.
    //addTagForm($lecturerCollectionHolder, $newLecturerLi);

    //Add an additional staffLecturer form each time a user clicks the $addLecturerLink
    $addLecturerLink.on('click', function(e) {
        e.preventDefault();
        addTagForm($lecturerCollectionHolder, $newLecturerLi);
    });

    /******
     * Other Staff 
     ******/
    var $otherCollectionHolder;
    var $addOtherLink = $('<a href="#" class="add_staffother_link">+ Add Other Staff</a>');
    var $newOtherLi = $('<li></li>').append($addOtherLink);

    $otherCollectionHolder = $('ul.staffother_collection');

    $otherCollectionHolder.append($newOtherLi);

    $otherCollectionHolder.data('index', $otherCollectionHolder.find(':input').length);

    //Add an initial staffOther form.
    //addTagForm($otherCollectionHolder, $newOtherLi);

    //Add an additional staffOther form each time a user clicks the $addOtherLink
    $addOtherLink.on('click', function(e) {
        e.preventDefault();
        addTagForm($otherCollectionHolder, $newOtherLi);
    });

    /******
     * Core Responsibilities 
     ******/
    var $detailCoreCollectionHolder;
    var $addDetailCoreLink = $('<a href="#" class="add_detailcore_link">+ Add Detail</a>');
    var $newDetailCoreLi = $('<li></li>').append($addDetailCoreLink);

    $detailCoreCollectionHolder = $('ul.detailcore_collection');

    $detailCoreCollectionHolder.append($newDetailCoreLi);

    $detailCoreCollectionHolder.data('index', $detailCoreCollectionHolder.find(':input').length);

    //Add an initial detailCore form.
    //addTagForm($detailCoreCollectionHolder, $newDetailCoreLi);

    //Add an additional detailCore form each time a user clicks the $addDetailCoreLink
    $addDetailCoreLink.on('click', function(e) {
        e.preventDefault();
        addTagForm($detailCoreCollectionHolder, $newDetailCoreLi);
    });

    /******
     * Progress 
     ******/
    var $detailProgressCollectionHolder;
    var $addDetailProgressLink = $('<a href="#" class="add_detailprogress_link">+ Add Detail</a>');
    var $newDetailProgressLi = $('<li></li>').append($addDetailProgressLink);

    $detailProgressCollectionHolder = $('ul.detailprogress_collection');

    $detailProgressCollectionHolder.append($newDetailProgressLi);

    $detailProgressCollectionHolder.data('index', $detailProgressCollectionHolder.find(':input').length);

    //Add an initial detailProgress form.
    //addTagForm($detailProgressCollectionHolder, $newDetailProgressLi);

    //Add an additional detailProgress form each time a user clicks the $addDetailProgressLink
    $addDetailProgressLink.on('click', function(e) {
        e.preventDefault();
        addTagForm($detailProgressCollectionHolder, $newDetailProgressLi);
    });

    /******
     * Initiatives
     ******/
    var $detailInitiativesCollectionHolder;
    var $addDetailInitiativesLink = $('<a href="#" class="add_detailinitiatives_link">+ Add Detail</a>');
    var $newDetailInitiativesLi = $('<li></li>').append($addDetailInitiativesLink);

    $detailInitiativesCollectionHolder = $('ul.detailinitiatives_collection');

    $detailInitiativesCollectionHolder.append($newDetailInitiativesLi);

    $detailInitiativesCollectionHolder.data('index', $detailInitiativesCollectionHolder.find(':input').length);

    //Add an initial detailInitiatives form.
    //addTagForm($detailInitiativesCollectionHolder, $newDetailInitiativesLi);

    //Add an additional detailInitiatives form each time a user clicks the $addDetailInitiativesLink
    $addDetailInitiativesLink.on('click', function(e) {
        e.preventDefault();
        addTagForm($detailInitiativesCollectionHolder, $newDetailInitiativesLi);
    });

    /******
     * Accomplishments 
     ******/
    var $detailAccomplishmentsCollectionHolder;
    var $addDetailAccomplishmentsLink = $('<a href="#" class="add_detailaccomplishments_link">+ Add Detail</a>');
    var $newDetailAccomplishmentsLi = $('<li></li>').append($addDetailAccomplishmentsLink);

    $detailAccomplishmentsCollectionHolder = $('ul.detailaccomplishments_collection');

    $detailAccomplishmentsCollectionHolder.append($newDetailAccomplishmentsLi);

    $detailAccomplishmentsCollectionHolder.data('index', $detailAccomplishmentsCollectionHolder.find(':input').length);

    //Add an initial detailAccomplishments form.
    //addTagForm($detailAccomplishmentsCollectionHolder, $newDetailAccomplishmentsLi);

    //Add an additional detailAccomplishments form each time a user clicks the $addDetailAccomplishmentsLink
    $addDetailAccomplishmentsLink.on('click', function(e) {
        e.preventDefault();
        addTagForm($detailAccomplishmentsCollectionHolder, $newDetailAccomplishmentsLi);
    });

    /******
     * Changes 
     ******/
    var $detailChangesCollectionHolder;
    var $addDetailChangesLink = $('<a href="#" class="add_detailchanges_link">+ Add Detail</a>');
    var $newDetailChangesLi = $('<li></li>').append($addDetailChangesLink);

    $detailChangesCollectionHolder = $('ul.detailchanges_collection');

    $detailChangesCollectionHolder.append($newDetailChangesLi);

    $detailChangesCollectionHolder.data('index', $detailChangesCollectionHolder.find(':input').length);

    //Add an initial detailChanges form.
    //addTagForm($detailChangesCollectionHolder, $newDetailChangesLi);

    //Add an additional detailChanges form each time a user clicks the $addDetailChangesLink
    $addDetailChangesLink.on('click', function(e) {
        e.preventDefault();
        addTagForm($detailChangesCollectionHolder, $newDetailChangesLi);
    });

    /******
     * Objectives 
     ******/
    var $detailObjectivesCollectionHolder;
    var $addDetailObjectivesLink = $('<a href="#" class="add_detailobjectives_link">+ Add Detail</a>');
    var $newDetailObjectivesLi = $('<li></li>').append($addDetailObjectivesLink);

    $detailObjectivesCollectionHolder = $('ul.detailobjectives_collection');

    $detailObjectivesCollectionHolder.append($newDetailObjectivesLi);

    $detailObjectivesCollectionHolder.data('index', $detailObjectivesCollectionHolder.find(':input').length);

    //Add an initial detailObjectives form.
    //addTagForm($detailObjectivesCollectionHolder, $newDetailObjectivesLi);

    //Add an additional detailObjectives form each time a user clicks the $addDetailObjectivesLink
    $addDetailObjectivesLink.on('click', function(e) {
        e.preventDefault();
        addTagForm($detailObjectivesCollectionHolder, $newDetailObjectivesLi);
    });
    
    /******
     * Documents
     ******/
    var $documentsCollectionHolder;
    var $addDocumentsLink = $('<a href="#" class="add_documents_link">+ Add Document</a>');
    var $newDocumentsLi = $('<li></li>').append($addDocumentsLink);

    $documentsCollectionHolder = $('ul.documents_collection');

    $documentsCollectionHolder.append($newDocumentsLi);

    $documentsCollectionHolder.data('index', $documentsCollectionHolder.find(':input').length);

    //Add an initial documents form.
    //addTagForm($documentsCollectionHolder, $newDocumentsLi);

    //Add an additional documents form each time a user clicks the $addDocumentsLink
    $addDocumentsLink.on('click', function(e) {
        e.preventDefault();
        addTagForm($documentsCollectionHolder, $newDocumentsLi, true);
    });

    /**
     * Uses Symfony's prototype code to generate a new list item for a form collection
     */
    function addTagForm($collectionHolder, $newLinkLi, bootstrapListStyle) {
        // Get the data-prototype explained earlier
        var prototype = $collectionHolder.data('prototype');

        // get the new index
        var index = $collectionHolder.data('index');

        // Replace '__name__' in the prototype's HTML to
        // instead be a number based on how many items we have
        var newForm = prototype.replace(/__name__/g, index);

        // increase the index with one for the next item
        $collectionHolder.data('index', index + 1);

        // Display the form in the page in an li, before the "Add a tag" link li
        if(bootstrapListStyle === true){
            var $newFormLi = $('<li class="list-group-item annualreport-item-container"></li>').append(newForm);
        } else {
            var $newFormLi = $('<li class="annualreport-item-container"></li>').append(newForm);
        }    
        $newLinkLi.before($newFormLi);
    }

    $(document).on('click', '.delete-staff, .delete-detail', function(event){
        event.preventDefault();
        $(this).parents('.annualreport-item-container').remove();
    });

    $(document).on('click', '.delete-document', function(e){
        e.preventDefault();
        var result = confirm("Please confirm you want to remove this item.")
        if(result){
            $(this).parents('.annualreport-item-container').remove();
        }
    });
});
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
$(document).ready(function(){
    var now = new Date(); //the current date (useful for datetimepickers)
    
    /**
     * Checkboxes using Bootstrap Switch library
    */
    var options = {   
        size: 'mini',
        onText: 'I',
        offText: 'O'
    };
    $(".user-status-ckbx").bootstrapSwitch(options);
    $(".user-status-ckbx-noajax").bootstrapSwitch(options); //use when you don't want ajax, just the switch button

    //ajax to activate/deactivate user
    $('.user-status-ckbx').on('switchChange.bootstrapSwitch', function(event, state){
        var currentDiv = $("#" + event.currentTarget.id).bootstrapSwitch('state');
        if( currentDiv == false ){
            var confirmed = confirm("Are you sure you wish to deactivate this user? They will no longer be able to access any forms.");
            if(confirmed == true){
                changeActivationStatus($(this).val());
            } else {
                $("#" + event.currentTarget.id).bootstrapSwitch('toggleState', true);
            }
        } else {
            var confirmed = confirm("Are you sure you wish to activate this user? Deactivated users which were previously active will have the same permissions prior to their de-activation unless changed manually.");
            if(confirmed == true){
                changeActivationStatus($(this).val());
            } else {
                $("#" + event.currentTarget.id).bootstrapSwitch('toggleState', true);
            }
       }
    });
    
    /**
        * Toggle chevron on list groups such as admin/staffareas/
        * 
        * ...seemed like a good idea at the time. Keeping this code for now in case it becomes needed...1/25/16
    */
    /*
    $('.list-group-item').on('click', function() {
        $('.glyphicon', this)
            .toggleClass('glyphicon-chevron-right')
            .toggleClass('glyphicon-chevron-down');
    });
    */
   
   /**
    * Creates a blue box around the currently selected thumbnail photo (example: News/edit.html.twig)
    */
   $(document).on('click', 'img.thumbnail-photo-select', function(e){
        $(this).toggleClass('blue-thumbnail-select-border');
        $('.thumbnail-photo-select').not($(this)).each(function(){
          $(this).removeClass('blue-thumbnail-select-border');
        })
   });
   
   /**
    * Search Instruction sessions (i.e. "AppBundle:Instruction:snippets/search.html.twig")
    */
    $('.instruction-search-container').on('click', function(e){
        e.stopPropagation();
    });
    
    $('#instruction-filter-tabs a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
    });
    
    $('#date-criteria-tabs a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
    });
    
    /**
     * Handle insturction search submission
     */
     $('#preliminary-instruction-criteria-form').on('submit', function(e){
        e.preventDefault();
        
        loadSearchForm($(this)); 
     });
     
    /**
     * Handle clicking of back button on instruction search form to return to the preliminary search form
     */
     function goBackToPreliminaryForm(){
        ajaxObject = {
            url: '/internalapi/instructionpreliminaryform',
            type: 'GET',
        };

        $.ajax(ajaxObject)
            .success(function(data,status,xhr) {
                $('#instruction-search-container').html(data);
            })
            .fail(function(data,status,xhr) {
                console.log("Failed to load preliminary form!");
            })
            .always(function(data,status,xhr) {
                $('#preliminary-instruction-criteria-form').on('submit', function(e){
                    e.preventDefault();

                    loadSearchForm($(this)); 
                });
            });
     }
     
     /**
      * Handle loading of instruction search form
      */
     function loadSearchForm(form){
        ajaxObject = {
            url: '/internalapi/instructionsearchform',
            data: form.serialize(),
            type: 'GET',
        };

        $.ajax(ajaxObject)
            .success(function(data,status,xhr) {
                $('#instruction-search-container').html(data);
                
                //initialize datetimepicker plugins for start and end date 
                $('#instrsearch_startDate').datetimepicker({
                    format: 'm/d/Y',
                    timepicker: false,
                    onShow:function( ct ){
                        this.setOptions({
                            maxDate:$('#instrsearch_endDate').val()?$('#instrsearch_endDate').val():false
                        })
                    },
                });
                $('#instrsearch_endDate').datetimepicker({
                    format: 'm/d/Y',
                    timepicker: false,
                    onShow:function( ct ){
                        this.setOptions({
                            minDate:$('#instrsearch_startDate').val()?$('#instrsearch_startDate').val():false
                        })
                    },
                });
                
                // Back button pressed
                $('#instrsearch_back').on('click', function(e){
                    goBackToPreliminaryForm();
                });
            })
            .fail(function(data,status,xhr) {
                console.log("Failed to load filtered form!");
            })
            .always(function(data,status,xhr) {});
     }
     
    //Add a custom parser for JQuery tablesorter to properly sort 12-hour time
    // add parser through the tablesorter addParser method 
    // NOT FUNCTIONING AS OF 5/16/16
    $.tablesorter.addParser({ 
        // set a unique id 
        id: 'twelvehourtime', 
        is: function(s) { 
            // return false so this parser is not auto detected 
            return false; 
        }, 
        format: function(s) { 
            // format your data for normalization 
            return s.toLowerCase().replace(/am/,0).replace(/pm/,1); 
        }, 
        // set type, either numeric or text 
        type: 'numeric' 
    });
    
       /**
        * Set 'active' CSS class on current sidebar li
        */
       /*
        var currentRoute = "{# app.request.get('_route') #}";
        var $sidebarItems = $('.main-sidebar-nav-menu li');
        $($sidebarItems).each(function(index){
            var itemPaths = $("a", this).data("paths");
            var currentItem = $(this);
            if(typeof itemPaths !== undefined){
                var pathsArr = itemPaths.split(",");
                $.each(pathsArr, function(i, value){
                    if(value == currentRoute){
                        $(currentItem).addClass("active");
                    }
                });
            }

        });
        */
});



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
var DateFormatter;!function(){"use strict";var e,t,a,r,n,o;n=864e5,o=3600,e=function(e,t){return"string"==typeof e&&"string"==typeof t&&e.toLowerCase()===t.toLowerCase()},t=function(e,a,r){var n=r||"0",o=e.toString();return o.length<a?t(n+o,a):o},a=function(e){var t,r;for(e=e||{},t=1;t<arguments.length;t++)if(r=arguments[t])for(var n in r)r.hasOwnProperty(n)&&("object"==typeof r[n]?a(e[n],r[n]):e[n]=r[n]);return e},r={dateSettings:{days:["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],daysShort:["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],months:["January","February","March","April","May","June","July","August","September","October","November","December"],monthsShort:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],meridiem:["AM","PM"],ordinal:function(e){var t=e%10,a={1:"st",2:"nd",3:"rd"};return 1!==Math.floor(e%100/10)&&a[t]?a[t]:"th"}},separators:/[ \-+\/\.T:@]/g,validParts:/[dDjlNSwzWFmMntLoYyaABgGhHisueTIOPZcrU]/g,intParts:/[djwNzmnyYhHgGis]/g,tzParts:/\b(?:[PMCEA][SDP]T|(?:Pacific|Mountain|Central|Eastern|Atlantic) (?:Standard|Daylight|Prevailing) Time|(?:GMT|UTC)(?:[-+]\d{4})?)\b/g,tzClip:/[^-+\dA-Z]/g},DateFormatter=function(e){var t=this,n=a(r,e);t.dateSettings=n.dateSettings,t.separators=n.separators,t.validParts=n.validParts,t.intParts=n.intParts,t.tzParts=n.tzParts,t.tzClip=n.tzClip},DateFormatter.prototype={constructor:DateFormatter,parseDate:function(t,a){var r,n,o,i,s,d,u,l,f,c,m=this,h=!1,g=!1,p=m.dateSettings,y={date:null,year:null,month:null,day:null,hour:0,min:0,sec:0};if(!t)return void 0;if(t instanceof Date)return t;if("number"==typeof t)return new Date(t);if("U"===a)return o=parseInt(t),o?new Date(1e3*o):t;if("string"!=typeof t)return"";if(r=a.match(m.validParts),!r||0===r.length)throw new Error("Invalid date format definition.");for(n=t.replace(m.separators,"\x00").split("\x00"),o=0;o<n.length;o++)switch(i=n[o],s=parseInt(i),r[o]){case"y":case"Y":f=i.length,2===f?y.year=parseInt((70>s?"20":"19")+i):4===f&&(y.year=s),h=!0;break;case"m":case"n":case"M":case"F":isNaN(i)?(d=p.monthsShort.indexOf(i),d>-1&&(y.month=d+1),d=p.months.indexOf(i),d>-1&&(y.month=d+1)):s>=1&&12>=s&&(y.month=s),h=!0;break;case"d":case"j":s>=1&&31>=s&&(y.day=s),h=!0;break;case"g":case"h":u=r.indexOf("a")>-1?r.indexOf("a"):r.indexOf("A")>-1?r.indexOf("A"):-1,c=n[u],u>-1?(l=e(c,p.meridiem[0])?0:e(c,p.meridiem[1])?12:-1,s>=1&&12>=s&&l>-1?y.hour=s+l-1:s>=0&&23>=s&&(y.hour=s)):s>=0&&23>=s&&(y.hour=s),g=!0;break;case"G":case"H":s>=0&&23>=s&&(y.hour=s),g=!0;break;case"i":s>=0&&59>=s&&(y.min=s),g=!0;break;case"s":s>=0&&59>=s&&(y.sec=s),g=!0}if(h===!0&&y.year&&y.month&&y.day)y.date=new Date(y.year,y.month-1,y.day,y.hour,y.min,y.sec,0);else{if(g!==!0)return!1;y.date=new Date(0,0,0,y.hour,y.min,y.sec,0)}return y.date},guessDate:function(e,t){if("string"!=typeof e)return e;var a,r,n,o,i=this,s=e.replace(i.separators,"\x00").split("\x00"),d=/^[djmn]/g,u=t.match(i.validParts),l=new Date,f=0;if(!d.test(u[0]))return e;for(r=0;r<s.length;r++){switch(f=2,n=s[r],o=parseInt(n.substr(0,2)),r){case 0:"m"===u[0]||"n"===u[0]?l.setMonth(o-1):l.setDate(o);break;case 1:"m"===u[0]||"n"===u[0]?l.setDate(o):l.setMonth(o-1);break;case 2:a=l.getFullYear(),n.length<4?(l.setFullYear(parseInt(a.toString().substr(0,4-n.length)+n)),f=n.length):(l.setFullYear=parseInt(n.substr(0,4)),f=4);break;case 3:l.setHours(o);break;case 4:l.setMinutes(o);break;case 5:l.setSeconds(o)}n.substr(f).length>0&&s.splice(r+1,0,n.substr(f))}return l},parseFormat:function(e,a){var r,i=this,s=i.dateSettings,d=/\\?(.?)/gi,u=function(e,t){return r[e]?r[e]():t};return r={d:function(){return t(r.j(),2)},D:function(){return s.daysShort[r.w()]},j:function(){return a.getDate()},l:function(){return s.days[r.w()]},N:function(){return r.w()||7},w:function(){return a.getDay()},z:function(){var e=new Date(r.Y(),r.n()-1,r.j()),t=new Date(r.Y(),0,1);return Math.round((e-t)/n)},W:function(){var e=new Date(r.Y(),r.n()-1,r.j()-r.N()+3),a=new Date(e.getFullYear(),0,4);return t(1+Math.round((e-a)/n/7),2)},F:function(){return s.months[a.getMonth()]},m:function(){return t(r.n(),2)},M:function(){return s.monthsShort[a.getMonth()]},n:function(){return a.getMonth()+1},t:function(){return new Date(r.Y(),r.n(),0).getDate()},L:function(){var e=r.Y();return e%4===0&&e%100!==0||e%400===0?1:0},o:function(){var e=r.n(),t=r.W(),a=r.Y();return a+(12===e&&9>t?1:1===e&&t>9?-1:0)},Y:function(){return a.getFullYear()},y:function(){return r.Y().toString().slice(-2)},a:function(){return r.A().toLowerCase()},A:function(){var e=r.G()<12?0:1;return s.meridiem[e]},B:function(){var e=a.getUTCHours()*o,r=60*a.getUTCMinutes(),n=a.getUTCSeconds();return t(Math.floor((e+r+n+o)/86.4)%1e3,3)},g:function(){return r.G()%12||12},G:function(){return a.getHours()},h:function(){return t(r.g(),2)},H:function(){return t(r.G(),2)},i:function(){return t(a.getMinutes(),2)},s:function(){return t(a.getSeconds(),2)},u:function(){return t(1e3*a.getMilliseconds(),6)},e:function(){var e=/\((.*)\)/.exec(String(a))[1];return e||"Coordinated Universal Time"},T:function(){var e=(String(a).match(i.tzParts)||[""]).pop().replace(i.tzClip,"");return e||"UTC"},I:function(){var e=new Date(r.Y(),0),t=Date.UTC(r.Y(),0),a=new Date(r.Y(),6),n=Date.UTC(r.Y(),6);return e-t!==a-n?1:0},O:function(){var e=a.getTimezoneOffset(),r=Math.abs(e);return(e>0?"-":"+")+t(100*Math.floor(r/60)+r%60,4)},P:function(){var e=r.O();return e.substr(0,3)+":"+e.substr(3,2)},Z:function(){return 60*-a.getTimezoneOffset()},c:function(){return"Y-m-d\\TH:i:sP".replace(d,u)},r:function(){return"D, d M Y H:i:s O".replace(d,u)},U:function(){return a.getTime()/1e3||0}},u(e,e)},formatDate:function(e,t){var a,r,n,o,i,s=this,d="";if("string"==typeof e&&(e=s.parseDate(e,t),e===!1))return!1;if(e instanceof Date){for(n=t.length,a=0;n>a;a++)i=t.charAt(a),"S"!==i&&(o=s.parseFormat(i,e),a!==n-1&&s.intParts.test(i)&&"S"===t.charAt(a+1)&&(r=parseInt(o),o+=s.dateSettings.ordinal(r)),d+=o);return d}return""}}}(),function(e){"function"==typeof define&&define.amd?define(["jquery","jquery-mousewheel"],e):"object"==typeof exports?module.exports=e:e(jQuery)}(function(e){"use strict";function t(e,t,a){this.date=e,this.desc=t,this.style=a}var a={i18n:{ar:{months:["كانون الثاني","شباط","آذار","نيسان","مايو","حزيران","تموز","آب","أيلول","تشرين الأول","تشرين الثاني","كانون الأول"],dayOfWeekShort:["ن","ث","ع","خ","ج","س","ح"],dayOfWeek:["الأحد","الاثنين","الثلاثاء","الأربعاء","الخميس","الجمعة","السبت","الأحد"]},ro:{months:["Ianuarie","Februarie","Martie","Aprilie","Mai","Iunie","Iulie","August","Septembrie","Octombrie","Noiembrie","Decembrie"],dayOfWeekShort:["Du","Lu","Ma","Mi","Jo","Vi","Sâ"],dayOfWeek:["Duminică","Luni","Marţi","Miercuri","Joi","Vineri","Sâmbătă"]},id:{months:["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"],dayOfWeekShort:["Min","Sen","Sel","Rab","Kam","Jum","Sab"],dayOfWeek:["Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu"]},is:{months:["Janúar","Febrúar","Mars","Apríl","Maí","Júní","Júlí","Ágúst","September","Október","Nóvember","Desember"],dayOfWeekShort:["Sun","Mán","Þrið","Mið","Fim","Fös","Lau"],dayOfWeek:["Sunnudagur","Mánudagur","Þriðjudagur","Miðvikudagur","Fimmtudagur","Föstudagur","Laugardagur"]},bg:{months:["Януари","Февруари","Март","Април","Май","Юни","Юли","Август","Септември","Октомври","Ноември","Декември"],dayOfWeekShort:["Нд","Пн","Вт","Ср","Чт","Пт","Сб"],dayOfWeek:["Неделя","Понеделник","Вторник","Сряда","Четвъртък","Петък","Събота"]},fa:{months:["فروردین","اردیبهشت","خرداد","تیر","مرداد","شهریور","مهر","آبان","آذر","دی","بهمن","اسفند"],dayOfWeekShort:["یکشنبه","دوشنبه","سه شنبه","چهارشنبه","پنجشنبه","جمعه","شنبه"],dayOfWeek:["یک‌شنبه","دوشنبه","سه‌شنبه","چهارشنبه","پنج‌شنبه","جمعه","شنبه","یک‌شنبه"]},ru:{months:["Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь"],dayOfWeekShort:["Вс","Пн","Вт","Ср","Чт","Пт","Сб"],dayOfWeek:["Воскресенье","Понедельник","Вторник","Среда","Четверг","Пятница","Суббота"]},uk:{months:["Січень","Лютий","Березень","Квітень","Травень","Червень","Липень","Серпень","Вересень","Жовтень","Листопад","Грудень"],dayOfWeekShort:["Ндл","Пнд","Втр","Срд","Чтв","Птн","Сбт"],dayOfWeek:["Неділя","Понеділок","Вівторок","Середа","Четвер","П'ятниця","Субота"]},en:{months:["January","February","March","April","May","June","July","August","September","October","November","December"],dayOfWeekShort:["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],dayOfWeek:["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"]},el:{months:["Ιανουάριος","Φεβρουάριος","Μάρτιος","Απρίλιος","Μάιος","Ιούνιος","Ιούλιος","Αύγουστος","Σεπτέμβριος","Οκτώβριος","Νοέμβριος","Δεκέμβριος"],dayOfWeekShort:["Κυρ","Δευ","Τρι","Τετ","Πεμ","Παρ","Σαβ"],dayOfWeek:["Κυριακή","Δευτέρα","Τρίτη","Τετάρτη","Πέμπτη","Παρασκευή","Σάββατο"]},de:{months:["Januar","Februar","März","April","Mai","Juni","Juli","August","September","Oktober","November","Dezember"],dayOfWeekShort:["So","Mo","Di","Mi","Do","Fr","Sa"],dayOfWeek:["Sonntag","Montag","Dienstag","Mittwoch","Donnerstag","Freitag","Samstag"]},nl:{months:["januari","februari","maart","april","mei","juni","juli","augustus","september","oktober","november","december"],dayOfWeekShort:["zo","ma","di","wo","do","vr","za"],dayOfWeek:["zondag","maandag","dinsdag","woensdag","donderdag","vrijdag","zaterdag"]},tr:{months:["Ocak","Şubat","Mart","Nisan","Mayıs","Haziran","Temmuz","Ağustos","Eylül","Ekim","Kasım","Aralık"],dayOfWeekShort:["Paz","Pts","Sal","Çar","Per","Cum","Cts"],dayOfWeek:["Pazar","Pazartesi","Salı","Çarşamba","Perşembe","Cuma","Cumartesi"]},fr:{months:["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre"],dayOfWeekShort:["Dim","Lun","Mar","Mer","Jeu","Ven","Sam"],dayOfWeek:["dimanche","lundi","mardi","mercredi","jeudi","vendredi","samedi"]},es:{months:["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"],dayOfWeekShort:["Dom","Lun","Mar","Mié","Jue","Vie","Sáb"],dayOfWeek:["Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado"]},th:{months:["มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม"],dayOfWeekShort:["อา.","จ.","อ.","พ.","พฤ.","ศ.","ส."],dayOfWeek:["อาทิตย์","จันทร์","อังคาร","พุธ","พฤหัส","ศุกร์","เสาร์","อาทิตย์"]},pl:{months:["styczeń","luty","marzec","kwiecień","maj","czerwiec","lipiec","sierpień","wrzesień","październik","listopad","grudzień"],dayOfWeekShort:["nd","pn","wt","śr","cz","pt","sb"],dayOfWeek:["niedziela","poniedziałek","wtorek","środa","czwartek","piątek","sobota"]},pt:{months:["Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro"],dayOfWeekShort:["Dom","Seg","Ter","Qua","Qui","Sex","Sab"],dayOfWeek:["Domingo","Segunda","Terça","Quarta","Quinta","Sexta","Sábado"]},ch:{months:["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],dayOfWeekShort:["日","一","二","三","四","五","六"]},se:{months:["Januari","Februari","Mars","April","Maj","Juni","Juli","Augusti","September","Oktober","November","December"],dayOfWeekShort:["Sön","Mån","Tis","Ons","Tor","Fre","Lör"]},kr:{months:["1월","2월","3월","4월","5월","6월","7월","8월","9월","10월","11월","12월"],dayOfWeekShort:["일","월","화","수","목","금","토"],dayOfWeek:["일요일","월요일","화요일","수요일","목요일","금요일","토요일"]},it:{months:["Gennaio","Febbraio","Marzo","Aprile","Maggio","Giugno","Luglio","Agosto","Settembre","Ottobre","Novembre","Dicembre"],dayOfWeekShort:["Dom","Lun","Mar","Mer","Gio","Ven","Sab"],dayOfWeek:["Domenica","Lunedì","Martedì","Mercoledì","Giovedì","Venerdì","Sabato"]},da:{months:["January","Februar","Marts","April","Maj","Juni","July","August","September","Oktober","November","December"],dayOfWeekShort:["Søn","Man","Tir","Ons","Tor","Fre","Lør"],dayOfWeek:["søndag","mandag","tirsdag","onsdag","torsdag","fredag","lørdag"]},no:{months:["Januar","Februar","Mars","April","Mai","Juni","Juli","August","September","Oktober","November","Desember"],dayOfWeekShort:["Søn","Man","Tir","Ons","Tor","Fre","Lør"],dayOfWeek:["Søndag","Mandag","Tirsdag","Onsdag","Torsdag","Fredag","Lørdag"]},ja:{months:["1月","2月","3月","4月","5月","6月","7月","8月","9月","10月","11月","12月"],dayOfWeekShort:["日","月","火","水","木","金","土"],dayOfWeek:["日曜","月曜","火曜","水曜","木曜","金曜","土曜"]},vi:{months:["Tháng 1","Tháng 2","Tháng 3","Tháng 4","Tháng 5","Tháng 6","Tháng 7","Tháng 8","Tháng 9","Tháng 10","Tháng 11","Tháng 12"],dayOfWeekShort:["CN","T2","T3","T4","T5","T6","T7"],dayOfWeek:["Chủ nhật","Thứ hai","Thứ ba","Thứ tư","Thứ năm","Thứ sáu","Thứ bảy"]},sl:{months:["Januar","Februar","Marec","April","Maj","Junij","Julij","Avgust","September","Oktober","November","December"],dayOfWeekShort:["Ned","Pon","Tor","Sre","Čet","Pet","Sob"],dayOfWeek:["Nedelja","Ponedeljek","Torek","Sreda","Četrtek","Petek","Sobota"]},cs:{months:["Leden","Únor","Březen","Duben","Květen","Červen","Červenec","Srpen","Září","Říjen","Listopad","Prosinec"],dayOfWeekShort:["Ne","Po","Út","St","Čt","Pá","So"]},hu:{months:["Január","Február","Március","Április","Május","Június","Július","Augusztus","Szeptember","Október","November","December"],dayOfWeekShort:["Va","Hé","Ke","Sze","Cs","Pé","Szo"],dayOfWeek:["vasárnap","hétfő","kedd","szerda","csütörtök","péntek","szombat"]},az:{months:["Yanvar","Fevral","Mart","Aprel","May","Iyun","Iyul","Avqust","Sentyabr","Oktyabr","Noyabr","Dekabr"],dayOfWeekShort:["B","Be","Ça","Ç","Ca","C","Ş"],dayOfWeek:["Bazar","Bazar ertəsi","Çərşənbə axşamı","Çərşənbə","Cümə axşamı","Cümə","Şənbə"]},bs:{months:["Januar","Februar","Mart","April","Maj","Jun","Jul","Avgust","Septembar","Oktobar","Novembar","Decembar"],dayOfWeekShort:["Ned","Pon","Uto","Sri","Čet","Pet","Sub"],dayOfWeek:["Nedjelja","Ponedjeljak","Utorak","Srijeda","Četvrtak","Petak","Subota"]},ca:{months:["Gener","Febrer","Març","Abril","Maig","Juny","Juliol","Agost","Setembre","Octubre","Novembre","Desembre"],dayOfWeekShort:["Dg","Dl","Dt","Dc","Dj","Dv","Ds"],dayOfWeek:["Diumenge","Dilluns","Dimarts","Dimecres","Dijous","Divendres","Dissabte"]},"en-GB":{months:["January","February","March","April","May","June","July","August","September","October","November","December"],dayOfWeekShort:["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],dayOfWeek:["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"]},et:{months:["Jaanuar","Veebruar","Märts","Aprill","Mai","Juuni","Juuli","August","September","Oktoober","November","Detsember"],dayOfWeekShort:["P","E","T","K","N","R","L"],dayOfWeek:["Pühapäev","Esmaspäev","Teisipäev","Kolmapäev","Neljapäev","Reede","Laupäev"]},eu:{months:["Urtarrila","Otsaila","Martxoa","Apirila","Maiatza","Ekaina","Uztaila","Abuztua","Iraila","Urria","Azaroa","Abendua"],dayOfWeekShort:["Ig.","Al.","Ar.","Az.","Og.","Or.","La."],dayOfWeek:["Igandea","Astelehena","Asteartea","Asteazkena","Osteguna","Ostirala","Larunbata"]},fi:{months:["Tammikuu","Helmikuu","Maaliskuu","Huhtikuu","Toukokuu","Kesäkuu","Heinäkuu","Elokuu","Syyskuu","Lokakuu","Marraskuu","Joulukuu"],dayOfWeekShort:["Su","Ma","Ti","Ke","To","Pe","La"],dayOfWeek:["sunnuntai","maanantai","tiistai","keskiviikko","torstai","perjantai","lauantai"]},gl:{months:["Xan","Feb","Maz","Abr","Mai","Xun","Xul","Ago","Set","Out","Nov","Dec"],dayOfWeekShort:["Dom","Lun","Mar","Mer","Xov","Ven","Sab"],dayOfWeek:["Domingo","Luns","Martes","Mércores","Xoves","Venres","Sábado"]},hr:{months:["Siječanj","Veljača","Ožujak","Travanj","Svibanj","Lipanj","Srpanj","Kolovoz","Rujan","Listopad","Studeni","Prosinac"],dayOfWeekShort:["Ned","Pon","Uto","Sri","Čet","Pet","Sub"],dayOfWeek:["Nedjelja","Ponedjeljak","Utorak","Srijeda","Četvrtak","Petak","Subota"]},ko:{months:["1월","2월","3월","4월","5월","6월","7월","8월","9월","10월","11월","12월"],dayOfWeekShort:["일","월","화","수","목","금","토"],dayOfWeek:["일요일","월요일","화요일","수요일","목요일","금요일","토요일"]},lt:{months:["Sausio","Vasario","Kovo","Balandžio","Gegužės","Birželio","Liepos","Rugpjūčio","Rugsėjo","Spalio","Lapkričio","Gruodžio"],dayOfWeekShort:["Sek","Pir","Ant","Tre","Ket","Pen","Šeš"],dayOfWeek:["Sekmadienis","Pirmadienis","Antradienis","Trečiadienis","Ketvirtadienis","Penktadienis","Šeštadienis"]},lv:{months:["Janvāris","Februāris","Marts","Aprīlis ","Maijs","Jūnijs","Jūlijs","Augusts","Septembris","Oktobris","Novembris","Decembris"],dayOfWeekShort:["Sv","Pr","Ot","Tr","Ct","Pk","St"],dayOfWeek:["Svētdiena","Pirmdiena","Otrdiena","Trešdiena","Ceturtdiena","Piektdiena","Sestdiena"]},mk:{months:["јануари","февруари","март","април","мај","јуни","јули","август","септември","октомври","ноември","декември"],dayOfWeekShort:["нед","пон","вто","сре","чет","пет","саб"],dayOfWeek:["Недела","Понеделник","Вторник","Среда","Четврток","Петок","Сабота"]},mn:{months:["1-р сар","2-р сар","3-р сар","4-р сар","5-р сар","6-р сар","7-р сар","8-р сар","9-р сар","10-р сар","11-р сар","12-р сар"],dayOfWeekShort:["Дав","Мяг","Лха","Пүр","Бсн","Бям","Ням"],dayOfWeek:["Даваа","Мягмар","Лхагва","Пүрэв","Баасан","Бямба","Ням"]},"pt-BR":{months:["Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro"],dayOfWeekShort:["Dom","Seg","Ter","Qua","Qui","Sex","Sáb"],dayOfWeek:["Domingo","Segunda","Terça","Quarta","Quinta","Sexta","Sábado"]},sk:{months:["Január","Február","Marec","Apríl","Máj","Jún","Júl","August","September","Október","November","December"],dayOfWeekShort:["Ne","Po","Ut","St","Št","Pi","So"],dayOfWeek:["Nedeľa","Pondelok","Utorok","Streda","Štvrtok","Piatok","Sobota"]},sq:{months:["Janar","Shkurt","Mars","Prill","Maj","Qershor","Korrik","Gusht","Shtator","Tetor","Nëntor","Dhjetor"],dayOfWeekShort:["Die","Hën","Mar","Mër","Enj","Pre","Shtu"],dayOfWeek:["E Diel","E Hënë","E Martē","E Mërkurë","E Enjte","E Premte","E Shtunë"]},"sr-YU":{months:["Januar","Februar","Mart","April","Maj","Jun","Jul","Avgust","Septembar","Oktobar","Novembar","Decembar"],dayOfWeekShort:["Ned","Pon","Uto","Sre","čet","Pet","Sub"],dayOfWeek:["Nedelja","Ponedeljak","Utorak","Sreda","Četvrtak","Petak","Subota"]},sr:{months:["јануар","фебруар","март","април","мај","јун","јул","август","септембар","октобар","новембар","децембар"],dayOfWeekShort:["нед","пон","уто","сре","чет","пет","суб"],dayOfWeek:["Недеља","Понедељак","Уторак","Среда","Четвртак","Петак","Субота"]},sv:{months:["Januari","Februari","Mars","April","Maj","Juni","Juli","Augusti","September","Oktober","November","December"],dayOfWeekShort:["Sön","Mån","Tis","Ons","Tor","Fre","Lör"],dayOfWeek:["Söndag","Måndag","Tisdag","Onsdag","Torsdag","Fredag","Lördag"]},"zh-TW":{months:["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],dayOfWeekShort:["日","一","二","三","四","五","六"],dayOfWeek:["星期日","星期一","星期二","星期三","星期四","星期五","星期六"]},zh:{months:["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],dayOfWeekShort:["日","一","二","三","四","五","六"],dayOfWeek:["星期日","星期一","星期二","星期三","星期四","星期五","星期六"]},he:{months:["ינואר","פברואר","מרץ","אפריל","מאי","יוני","יולי","אוגוסט","ספטמבר","אוקטובר","נובמבר","דצמבר"],dayOfWeekShort:["א'","ב'","ג'","ד'","ה'","ו'","שבת"],dayOfWeek:["ראשון","שני","שלישי","רביעי","חמישי","שישי","שבת","ראשון"]},hy:{months:["Հունվար","Փետրվար","Մարտ","Ապրիլ","Մայիս","Հունիս","Հուլիս","Օգոստոս","Սեպտեմբեր","Հոկտեմբեր","Նոյեմբեր","Դեկտեմբեր"],dayOfWeekShort:["Կի","Երկ","Երք","Չոր","Հնգ","Ուրբ","Շբթ"],dayOfWeek:["Կիրակի","Երկուշաբթի","Երեքշաբթի","Չորեքշաբթի","Հինգշաբթի","Ուրբաթ","Շաբաթ"]},kg:{months:["Үчтүн айы","Бирдин айы","Жалган Куран","Чын Куран","Бугу","Кулжа","Теке","Баш Оона","Аяк Оона","Тогуздун айы","Жетинин айы","Бештин айы"],dayOfWeekShort:["Жек","Дүй","Шей","Шар","Бей","Жум","Ише"],dayOfWeek:["Жекшемб","Дүйшөмб","Шейшемб","Шаршемб","Бейшемби","Жума","Ишенб"]},rm:{months:["Schaner","Favrer","Mars","Avrigl","Matg","Zercladur","Fanadur","Avust","Settember","October","November","December"],dayOfWeekShort:["Du","Gli","Ma","Me","Gie","Ve","So"],dayOfWeek:["Dumengia","Glindesdi","Mardi","Mesemna","Gievgia","Venderdi","Sonda"]}},value:"",rtl:!1,format:"Y/m/d H:i",formatTime:"H:i",formatDate:"Y/m/d",startDate:!1,step:60,monthChangeSpinner:!0,closeOnDateSelect:!1,closeOnTimeSelect:!0,closeOnWithoutClick:!0,closeOnInputClick:!0,timepicker:!0,datepicker:!0,weeks:!1,defaultTime:!1,defaultDate:!1,minDate:!1,maxDate:!1,minTime:!1,maxTime:!1,disabledMinTime:!1,disabledMaxTime:!1,allowTimes:[],opened:!1,initTime:!0,inline:!1,theme:"",onSelectDate:function(){},onSelectTime:function(){},onChangeMonth:function(){},onGetWeekOfYear:function(){},onChangeYear:function(){},onChangeDateTime:function(){},onShow:function(){},onClose:function(){},onGenerate:function(){},withoutCopyright:!0,inverseButton:!1,hours12:!1,next:"xdsoft_next",prev:"xdsoft_prev",dayOfWeekStart:0,parentID:"body",timeHeightInTimePicker:25,timepickerScrollbar:!0,todayButton:!0,prevButton:!0,nextButton:!0,defaultSelect:!0,scrollMonth:!0,scrollTime:!0,scrollInput:!0,lazyInit:!1,mask:!1,validateOnBlur:!0,allowBlank:!0,yearStart:1950,yearEnd:2050,monthStart:0,monthEnd:11,style:"",id:"",fixed:!1,roundTime:"round",className:"",weekends:[],highlightedDates:[],highlightedPeriods:[],allowDates:[],allowDateRe:null,disabledDates:[],disabledWeekDays:[],yearOffset:0,beforeShowDay:null,enterLikeTab:!0,showApplyButton:!1},r=null,n="en",o="en",i={meridiem:["AM","PM"]},s=function(){var t=a.i18n[o],n={days:t.dayOfWeek,daysShort:t.dayOfWeekShort,months:t.months,monthsShort:e.map(t.months,function(e){return e.substring(0,3)})};r=new DateFormatter({dateSettings:e.extend({},i,n)})};e.datetimepicker={setLocale:function(e){var t=a.i18n[e]?e:n;o!=t&&(o=t,s())},RFC_2822:"D, d M Y H:i:s O",ATOM:"Y-m-dTH:i:sP",ISO_8601:"Y-m-dTH:i:sO",RFC_822:"D, d M y H:i:s O",RFC_850:"l, d-M-y H:i:s T",RFC_1036:"D, d M y H:i:s O",RFC_1123:"D, d M Y H:i:s O",RSS:"D, d M Y H:i:s O",W3C:"Y-m-dTH:i:sP"},s(),window.getComputedStyle||(window.getComputedStyle=function(e){return this.el=e,this.getPropertyValue=function(t){var a=/(\-([a-z]){1})/g;return"float"===t&&(t="styleFloat"),a.test(t)&&(t=t.replace(a,function(e,t,a){return a.toUpperCase()})),e.currentStyle[t]||null},this}),Array.prototype.indexOf||(Array.prototype.indexOf=function(e,t){var a,r;for(a=t||0,r=this.length;r>a;a+=1)if(this[a]===e)return a;return-1}),Date.prototype.countDaysInMonth=function(){return new Date(this.getFullYear(),this.getMonth()+1,0).getDate()},e.fn.xdsoftScroller=function(t){return this.each(function(){var a,r,n,o,i,s=e(this),d=function(e){var t,a={x:0,y:0};return"touchstart"===e.type||"touchmove"===e.type||"touchend"===e.type||"touchcancel"===e.type?(t=e.originalEvent.touches[0]||e.originalEvent.changedTouches[0],a.x=t.clientX,a.y=t.clientY):("mousedown"===e.type||"mouseup"===e.type||"mousemove"===e.type||"mouseover"===e.type||"mouseout"===e.type||"mouseenter"===e.type||"mouseleave"===e.type)&&(a.x=e.clientX,a.y=e.clientY),a},u=100,l=!1,f=0,c=0,m=0,h=!1,g=0,p=function(){};return"hide"===t?void s.find(".xdsoft_scrollbar").hide():(e(this).hasClass("xdsoft_scroller_box")||(a=s.children().eq(0),r=s[0].clientHeight,n=a[0].offsetHeight,o=e('<div class="xdsoft_scrollbar"></div>'),i=e('<div class="xdsoft_scroller"></div>'),o.append(i),s.addClass("xdsoft_scroller_box").append(o),p=function(e){var t=d(e).y-f+g;0>t&&(t=0),t+i[0].offsetHeight>m&&(t=m-i[0].offsetHeight),s.trigger("scroll_element.xdsoft_scroller",[u?t/u:0])},i.on("touchstart.xdsoft_scroller mousedown.xdsoft_scroller",function(a){r||s.trigger("resize_scroll.xdsoft_scroller",[t]),f=d(a).y,g=parseInt(i.css("margin-top"),10),m=o[0].offsetHeight,"mousedown"===a.type||"touchstart"===a.type?(document&&e(document.body).addClass("xdsoft_noselect"),e([document.body,window]).on("touchend mouseup.xdsoft_scroller",function n(){e([document.body,window]).off("touchend mouseup.xdsoft_scroller",n).off("mousemove.xdsoft_scroller",p).removeClass("xdsoft_noselect")}),e(document.body).on("mousemove.xdsoft_scroller",p)):(h=!0,a.stopPropagation(),a.preventDefault())}).on("touchmove",function(e){h&&(e.preventDefault(),p(e))}).on("touchend touchcancel",function(){h=!1,g=0}),s.on("scroll_element.xdsoft_scroller",function(e,t){r||s.trigger("resize_scroll.xdsoft_scroller",[t,!0]),t=t>1?1:0>t||isNaN(t)?0:t,i.css("margin-top",u*t),setTimeout(function(){a.css("marginTop",-parseInt((a[0].offsetHeight-r)*t,10))},10)}).on("resize_scroll.xdsoft_scroller",function(e,t,d){var l,f;r=s[0].clientHeight,n=a[0].offsetHeight,l=r/n,f=l*o[0].offsetHeight,l>1?i.hide():(i.show(),i.css("height",parseInt(f>10?f:10,10)),u=o[0].offsetHeight-i[0].offsetHeight,d!==!0&&s.trigger("scroll_element.xdsoft_scroller",[t||Math.abs(parseInt(a.css("marginTop"),10))/(n-r)]))}),s.on("mousewheel",function(e){var t=Math.abs(parseInt(a.css("marginTop"),10));return t-=20*e.deltaY,0>t&&(t=0),s.trigger("scroll_element.xdsoft_scroller",[t/(n-r)]),e.stopPropagation(),!1}),s.on("touchstart",function(e){l=d(e),c=Math.abs(parseInt(a.css("marginTop"),10))}),s.on("touchmove",function(e){if(l){e.preventDefault();var t=d(e);s.trigger("scroll_element.xdsoft_scroller",[(c-(t.y-l.y))/(n-r)])}}),s.on("touchend touchcancel",function(){l=!1,c=0})),void s.trigger("resize_scroll.xdsoft_scroller",[t]))})},e.fn.datetimepicker=function(n,i){var s,d,u=this,l=48,f=57,c=96,m=105,h=17,g=46,p=13,y=27,v=8,b=37,x=38,D=39,k=40,T=9,S=116,w=65,O=67,M=86,_=90,W=89,C=!1,F=e.isPlainObject(n)||!n?e.extend(!0,{},a,n):e.extend(!0,{},a),P=0,A=function(e){e.on("open.xdsoft focusin.xdsoft mousedown.xdsoft touchstart",function t(){e.is(":disabled")||e.data("xdsoft_datetimepicker")||(clearTimeout(P),P=setTimeout(function(){e.data("xdsoft_datetimepicker")||s(e),e.off("open.xdsoft focusin.xdsoft mousedown.xdsoft touchstart",t).trigger("open.xdsoft")},100))})};return s=function(a){function i(){var e,t=!1;return F.startDate?t=j.strToDate(F.startDate):(t=F.value||(a&&a.val&&a.val()?a.val():""),t?t=j.strToDateTime(t):F.defaultDate&&(t=j.strToDateTime(F.defaultDate),F.defaultTime&&(e=j.strtotime(F.defaultTime),t.setHours(e.getHours()),t.setMinutes(e.getMinutes())))),t&&j.isValidDate(t)?J.data("changed",!0):t="",t||0}function s(t){var r=function(e,t){var a=e.replace(/([\[\]\/\{\}\(\)\-\.\+]{1})/g,"\\$1").replace(/_/g,"{digit+}").replace(/([0-9]{1})/g,"{digit$1}").replace(/\{digit([0-9]{1})\}/g,"[0-$1_]{1}").replace(/\{digit[\+]\}/g,"[0-9_]{1}");return new RegExp(a).test(t)},n=function(e){try{if(document.selection&&document.selection.createRange){var t=document.selection.createRange();return t.getBookmark().charCodeAt(2)-2}if(e.setSelectionRange)return e.selectionStart}catch(a){return 0}},o=function(e,t){if(e="string"==typeof e||e instanceof String?document.getElementById(e):e,!e)return!1;if(e.createTextRange){var a=e.createTextRange();return a.collapse(!0),a.moveEnd("character",t),a.moveStart("character",t),a.select(),!0}return e.setSelectionRange?(e.setSelectionRange(t,t),!0):!1};t.mask&&a.off("keydown.xdsoft"),t.mask===!0&&(t.mask="undefined"!=typeof moment?t.format.replace(/Y{4}/g,"9999").replace(/Y{2}/g,"99").replace(/M{2}/g,"19").replace(/D{2}/g,"39").replace(/H{2}/g,"29").replace(/m{2}/g,"59").replace(/s{2}/g,"59"):t.format.replace(/Y/g,"9999").replace(/F/g,"9999").replace(/m/g,"19").replace(/d/g,"39").replace(/H/g,"29").replace(/i/g,"59").replace(/s/g,"59")),"string"===e.type(t.mask)&&(r(t.mask,a.val())||(a.val(t.mask.replace(/[0-9]/g,"_")),o(a[0],0)),a.on("keydown.xdsoft",function(i){var s,d,u=this.value,F=i.which;if(F>=l&&f>=F||F>=c&&m>=F||F===v||F===g){for(s=n(this),d=F!==v&&F!==g?String.fromCharCode(F>=c&&m>=F?F-l:F):"_",F!==v&&F!==g||!s||(s-=1,d="_");/[^0-9_]/.test(t.mask.substr(s,1))&&s<t.mask.length&&s>0;)s+=F===v||F===g?-1:1;if(u=u.substr(0,s)+d+u.substr(s+1),""===e.trim(u))u=t.mask.replace(/[0-9]/g,"_");else if(s===t.mask.length)return i.preventDefault(),!1;for(s+=F===v||F===g?0:1;/[^0-9_]/.test(t.mask.substr(s,1))&&s<t.mask.length&&s>0;)s+=F===v||F===g?-1:1;r(t.mask,u)?(this.value=u,o(this,s)):""===e.trim(u)?this.value=t.mask.replace(/[0-9]/g,"_"):a.trigger("error_input.xdsoft")}else if(-1!==[w,O,M,_,W].indexOf(F)&&C||-1!==[y,x,k,b,D,S,h,T,p].indexOf(F))return!0;return i.preventDefault(),!1}))}var d,u,P,A,Y,j,H,J=e('<div class="xdsoft_datetimepicker xdsoft_noselect"></div>'),z=e('<div class="xdsoft_copyright"><a target="_blank" href="http://xdsoft.net/jqplugins/datetimepicker/">xdsoft.net</a></div>'),I=e('<div class="xdsoft_datepicker active"></div>'),N=e('<div class="xdsoft_mounthpicker"><button type="button" class="xdsoft_prev"></button><button type="button" class="xdsoft_today_button"></button><div class="xdsoft_label xdsoft_month"><span></span><i></i></div><div class="xdsoft_label xdsoft_year"><span></span><i></i></div><button type="button" class="xdsoft_next"></button></div>'),L=e('<div class="xdsoft_calendar"></div>'),E=e('<div class="xdsoft_timepicker active"><button type="button" class="xdsoft_prev"></button><div class="xdsoft_time_box"></div><button type="button" class="xdsoft_next"></button></div>'),R=E.find(".xdsoft_time_box").eq(0),V=e('<div class="xdsoft_time_variant"></div>'),B=e('<button type="button" class="xdsoft_save_selected blue-gradient-button">Save Selected</button>'),G=e('<div class="xdsoft_select xdsoft_monthselect"><div></div></div>'),U=e('<div class="xdsoft_select xdsoft_yearselect"><div></div></div>'),q=!1,X=0;F.id&&J.attr("id",F.id),F.style&&J.attr("style",F.style),F.weeks&&J.addClass("xdsoft_showweeks"),F.rtl&&J.addClass("xdsoft_rtl"),J.addClass("xdsoft_"+F.theme),J.addClass(F.className),N.find(".xdsoft_month span").after(G),N.find(".xdsoft_year span").after(U),N.find(".xdsoft_month,.xdsoft_year").on("touchstart mousedown.xdsoft",function(t){var a,r,n=e(this).find(".xdsoft_select").eq(0),o=0,i=0,s=n.is(":visible");for(N.find(".xdsoft_select").hide(),j.currentTime&&(o=j.currentTime[e(this).hasClass("xdsoft_month")?"getMonth":"getFullYear"]()),n[s?"hide":"show"](),a=n.find("div.xdsoft_option"),r=0;r<a.length&&a.eq(r).data("value")!==o;r+=1)i+=a[0].offsetHeight;return n.xdsoftScroller(i/(n.children()[0].offsetHeight-n[0].clientHeight)),t.stopPropagation(),!1}),N.find(".xdsoft_select").xdsoftScroller().on("touchstart mousedown.xdsoft",function(e){e.stopPropagation(),e.preventDefault()}).on("touchstart mousedown.xdsoft",".xdsoft_option",function(){(void 0===j.currentTime||null===j.currentTime)&&(j.currentTime=j.now());var t=j.currentTime.getFullYear();j&&j.currentTime&&j.currentTime[e(this).parent().parent().hasClass("xdsoft_monthselect")?"setMonth":"setFullYear"](e(this).data("value")),e(this).parent().parent().hide(),J.trigger("xchange.xdsoft"),F.onChangeMonth&&e.isFunction(F.onChangeMonth)&&F.onChangeMonth.call(J,j.currentTime,J.data("input")),t!==j.currentTime.getFullYear()&&e.isFunction(F.onChangeYear)&&F.onChangeYear.call(J,j.currentTime,J.data("input"))}),J.getValue=function(){return j.getCurrentTime()},J.setOptions=function(n){var o={};F=e.extend(!0,{},F,n),n.allowTimes&&e.isArray(n.allowTimes)&&n.allowTimes.length&&(F.allowTimes=e.extend(!0,[],n.allowTimes)),n.weekends&&e.isArray(n.weekends)&&n.weekends.length&&(F.weekends=e.extend(!0,[],n.weekends)),n.allowDates&&e.isArray(n.allowDates)&&n.allowDates.length&&(F.allowDates=e.extend(!0,[],n.allowDates)),n.allowDateRe&&"[object String]"===Object.prototype.toString.call(n.allowDateRe)&&(F.allowDateRe=new RegExp(n.allowDateRe)),n.highlightedDates&&e.isArray(n.highlightedDates)&&n.highlightedDates.length&&(e.each(n.highlightedDates,function(a,n){var i,s=e.map(n.split(","),e.trim),d=new t(r.parseDate(s[0],F.formatDate),s[1],s[2]),u=r.formatDate(d.date,F.formatDate);void 0!==o[u]?(i=o[u].desc,i&&i.length&&d.desc&&d.desc.length&&(o[u].desc=i+"\n"+d.desc)):o[u]=d}),F.highlightedDates=e.extend(!0,[],o)),n.highlightedPeriods&&e.isArray(n.highlightedPeriods)&&n.highlightedPeriods.length&&(o=e.extend(!0,[],F.highlightedDates),e.each(n.highlightedPeriods,function(a,n){var i,s,d,u,l,f,c;if(e.isArray(n))i=n[0],s=n[1],d=n[2],c=n[3];else{var m=e.map(n.split(","),e.trim);i=r.parseDate(m[0],F.formatDate),s=r.parseDate(m[1],F.formatDate),
d=m[2],c=m[3]}for(;s>=i;)u=new t(i,d,c),l=r.formatDate(i,F.formatDate),i.setDate(i.getDate()+1),void 0!==o[l]?(f=o[l].desc,f&&f.length&&u.desc&&u.desc.length&&(o[l].desc=f+"\n"+u.desc)):o[l]=u}),F.highlightedDates=e.extend(!0,[],o)),n.disabledDates&&e.isArray(n.disabledDates)&&n.disabledDates.length&&(F.disabledDates=e.extend(!0,[],n.disabledDates)),n.disabledWeekDays&&e.isArray(n.disabledWeekDays)&&n.disabledWeekDays.length&&(F.disabledWeekDays=e.extend(!0,[],n.disabledWeekDays)),!F.open&&!F.opened||F.inline||a.trigger("open.xdsoft"),F.inline&&(q=!0,J.addClass("xdsoft_inline"),a.after(J).hide()),F.inverseButton&&(F.next="xdsoft_prev",F.prev="xdsoft_next"),F.datepicker?I.addClass("active"):I.removeClass("active"),F.timepicker?E.addClass("active"):E.removeClass("active"),F.value&&(j.setCurrentTime(F.value),a&&a.val&&a.val(j.str)),F.dayOfWeekStart=isNaN(F.dayOfWeekStart)?0:parseInt(F.dayOfWeekStart,10)%7,F.timepickerScrollbar||R.xdsoftScroller("hide"),F.minDate&&/^[\+\-](.*)$/.test(F.minDate)&&(F.minDate=r.formatDate(j.strToDateTime(F.minDate),F.formatDate)),F.maxDate&&/^[\+\-](.*)$/.test(F.maxDate)&&(F.maxDate=r.formatDate(j.strToDateTime(F.maxDate),F.formatDate)),B.toggle(F.showApplyButton),N.find(".xdsoft_today_button").css("visibility",F.todayButton?"visible":"hidden"),N.find("."+F.prev).css("visibility",F.prevButton?"visible":"hidden"),N.find("."+F.next).css("visibility",F.nextButton?"visible":"hidden"),s(F),F.validateOnBlur&&a.off("blur.xdsoft").on("blur.xdsoft",function(){if(!F.allowBlank||e.trim(e(this).val()).length&&e.trim(e(this).val())!==F.mask.replace(/[0-9]/g,"_"))if(r.parseDate(e(this).val(),F.format))J.data("xdsoft_datetime").setCurrentTime(e(this).val());else{var t=+[e(this).val()[0],e(this).val()[1]].join(""),a=+[e(this).val()[2],e(this).val()[3]].join("");e(this).val(!F.datepicker&&F.timepicker&&t>=0&&24>t&&a>=0&&60>a?[t,a].map(function(e){return e>9?e:"0"+e}).join(":"):r.formatDate(j.now(),F.format)),J.data("xdsoft_datetime").setCurrentTime(e(this).val())}else e(this).val(null),J.data("xdsoft_datetime").empty();J.trigger("changedatetime.xdsoft"),J.trigger("close.xdsoft")}),F.dayOfWeekStartPrev=0===F.dayOfWeekStart?6:F.dayOfWeekStart-1,J.trigger("xchange.xdsoft").trigger("afterOpen.xdsoft")},J.data("options",F).on("touchstart mousedown.xdsoft",function(e){return e.stopPropagation(),e.preventDefault(),U.hide(),G.hide(),!1}),R.append(V),R.xdsoftScroller(),J.on("afterOpen.xdsoft",function(){R.xdsoftScroller()}),J.append(I).append(E),F.withoutCopyright!==!0&&J.append(z),I.append(N).append(L).append(B),e(F.parentID).append(J),d=function(){var t=this;t.now=function(e){var a,r,n=new Date;return!e&&F.defaultDate&&(a=t.strToDateTime(F.defaultDate),n.setFullYear(a.getFullYear()),n.setMonth(a.getMonth()),n.setDate(a.getDate())),F.yearOffset&&n.setFullYear(n.getFullYear()+F.yearOffset),!e&&F.defaultTime&&(r=t.strtotime(F.defaultTime),n.setHours(r.getHours()),n.setMinutes(r.getMinutes())),n},t.isValidDate=function(e){return"[object Date]"!==Object.prototype.toString.call(e)?!1:!isNaN(e.getTime())},t.setCurrentTime=function(e){t.currentTime="string"==typeof e?t.strToDateTime(e):t.isValidDate(e)?e:t.now(),J.trigger("xchange.xdsoft")},t.empty=function(){t.currentTime=null},t.getCurrentTime=function(){return t.currentTime},t.nextMonth=function(){(void 0===t.currentTime||null===t.currentTime)&&(t.currentTime=t.now());var a,r=t.currentTime.getMonth()+1;return 12===r&&(t.currentTime.setFullYear(t.currentTime.getFullYear()+1),r=0),a=t.currentTime.getFullYear(),t.currentTime.setDate(Math.min(new Date(t.currentTime.getFullYear(),r+1,0).getDate(),t.currentTime.getDate())),t.currentTime.setMonth(r),F.onChangeMonth&&e.isFunction(F.onChangeMonth)&&F.onChangeMonth.call(J,j.currentTime,J.data("input")),a!==t.currentTime.getFullYear()&&e.isFunction(F.onChangeYear)&&F.onChangeYear.call(J,j.currentTime,J.data("input")),J.trigger("xchange.xdsoft"),r},t.prevMonth=function(){(void 0===t.currentTime||null===t.currentTime)&&(t.currentTime=t.now());var a=t.currentTime.getMonth()-1;return-1===a&&(t.currentTime.setFullYear(t.currentTime.getFullYear()-1),a=11),t.currentTime.setDate(Math.min(new Date(t.currentTime.getFullYear(),a+1,0).getDate(),t.currentTime.getDate())),t.currentTime.setMonth(a),F.onChangeMonth&&e.isFunction(F.onChangeMonth)&&F.onChangeMonth.call(J,j.currentTime,J.data("input")),J.trigger("xchange.xdsoft"),a},t.getWeekOfYear=function(t){if(F.onGetWeekOfYear&&e.isFunction(F.onGetWeekOfYear)){var a=F.onGetWeekOfYear.call(J,t);if("undefined"!=typeof a)return a}var r=new Date(t.getFullYear(),0,1);return 4!=r.getDay()&&r.setMonth(0,1+(4-r.getDay()+7)%7),Math.ceil(((t-r)/864e5+r.getDay()+1)/7)},t.strToDateTime=function(e){var a,n,o=[];return e&&e instanceof Date&&t.isValidDate(e)?e:(o=/^(\+|\-)(.*)$/.exec(e),o&&(o[2]=r.parseDate(o[2],F.formatDate)),o&&o[2]?(a=o[2].getTime()-6e4*o[2].getTimezoneOffset(),n=new Date(t.now(!0).getTime()+parseInt(o[1]+"1",10)*a)):n=e?r.parseDate(e,F.format):t.now(),t.isValidDate(n)||(n=t.now()),n)},t.strToDate=function(e){if(e&&e instanceof Date&&t.isValidDate(e))return e;var a=e?r.parseDate(e,F.formatDate):t.now(!0);return t.isValidDate(a)||(a=t.now(!0)),a},t.strtotime=function(e){if(e&&e instanceof Date&&t.isValidDate(e))return e;var a=e?r.parseDate(e,F.formatTime):t.now(!0);return t.isValidDate(a)||(a=t.now(!0)),a},t.str=function(){return r.formatDate(t.currentTime,F.format)},t.currentTime=this.now()},j=new d,B.on("touchend click",function(e){e.preventDefault(),J.data("changed",!0),j.setCurrentTime(i()),a.val(j.str()),J.trigger("close.xdsoft")}),N.find(".xdsoft_today_button").on("touchend mousedown.xdsoft",function(){J.data("changed",!0),j.setCurrentTime(0),J.trigger("afterOpen.xdsoft")}).on("dblclick.xdsoft",function(){var e,t,r=j.getCurrentTime();r=new Date(r.getFullYear(),r.getMonth(),r.getDate()),e=j.strToDate(F.minDate),e=new Date(e.getFullYear(),e.getMonth(),e.getDate()),e>r||(t=j.strToDate(F.maxDate),t=new Date(t.getFullYear(),t.getMonth(),t.getDate()),r>t||(a.val(j.str()),a.trigger("change"),J.trigger("close.xdsoft")))}),N.find(".xdsoft_prev,.xdsoft_next").on("touchend mousedown.xdsoft",function(){var t=e(this),a=0,r=!1;!function n(e){t.hasClass(F.next)?j.nextMonth():t.hasClass(F.prev)&&j.prevMonth(),F.monthChangeSpinner&&(r||(a=setTimeout(n,e||100)))}(500),e([document.body,window]).on("touchend mouseup.xdsoft",function o(){clearTimeout(a),r=!0,e([document.body,window]).off("touchend mouseup.xdsoft",o)})}),E.find(".xdsoft_prev,.xdsoft_next").on("touchend mousedown.xdsoft",function(){var t=e(this),a=0,r=!1,n=110;!function o(e){var i=R[0].clientHeight,s=V[0].offsetHeight,d=Math.abs(parseInt(V.css("marginTop"),10));t.hasClass(F.next)&&s-i-F.timeHeightInTimePicker>=d?V.css("marginTop","-"+(d+F.timeHeightInTimePicker)+"px"):t.hasClass(F.prev)&&d-F.timeHeightInTimePicker>=0&&V.css("marginTop","-"+(d-F.timeHeightInTimePicker)+"px"),R.trigger("scroll_element.xdsoft_scroller",[Math.abs(parseInt(V.css("marginTop"),10)/(s-i))]),n=n>10?10:n-10,r||(a=setTimeout(o,e||n))}(500),e([document.body,window]).on("touchend mouseup.xdsoft",function i(){clearTimeout(a),r=!0,e([document.body,window]).off("touchend mouseup.xdsoft",i)})}),u=0,J.on("xchange.xdsoft",function(t){clearTimeout(u),u=setTimeout(function(){(void 0===j.currentTime||null===j.currentTime)&&(j.currentTime=j.now());for(var t,i,s,d,u,l,f,c,m,h,g="",p=new Date(j.currentTime.getFullYear(),j.currentTime.getMonth(),1,12,0,0),y=0,v=j.now(),b=!1,x=!1,D=[],k=!0,T="",S="";p.getDay()!==F.dayOfWeekStart;)p.setDate(p.getDate()-1);for(g+="<table><thead><tr>",F.weeks&&(g+="<th></th>"),t=0;7>t;t+=1)g+="<th>"+F.i18n[o].dayOfWeekShort[(t+F.dayOfWeekStart)%7]+"</th>";for(g+="</tr></thead>",g+="<tbody>",F.maxDate!==!1&&(b=j.strToDate(F.maxDate),b=new Date(b.getFullYear(),b.getMonth(),b.getDate(),23,59,59,999)),F.minDate!==!1&&(x=j.strToDate(F.minDate),x=new Date(x.getFullYear(),x.getMonth(),x.getDate()));y<j.currentTime.countDaysInMonth()||p.getDay()!==F.dayOfWeekStart||j.currentTime.getMonth()===p.getMonth();)D=[],y+=1,s=p.getDay(),d=p.getDate(),u=p.getFullYear(),l=p.getMonth(),f=j.getWeekOfYear(p),h="",D.push("xdsoft_date"),c=F.beforeShowDay&&e.isFunction(F.beforeShowDay.call)?F.beforeShowDay.call(J,p):null,F.allowDateRe&&"[object RegExp]"===Object.prototype.toString.call(F.allowDateRe)?F.allowDateRe.test(r.formatDate(p,F.formatDate))||D.push("xdsoft_disabled"):F.allowDates&&F.allowDates.length>0?-1===F.allowDates.indexOf(r.formatDate(p,F.formatDate))&&D.push("xdsoft_disabled"):b!==!1&&p>b||x!==!1&&x>p||c&&c[0]===!1?D.push("xdsoft_disabled"):-1!==F.disabledDates.indexOf(r.formatDate(p,F.formatDate))?D.push("xdsoft_disabled"):-1!==F.disabledWeekDays.indexOf(s)?D.push("xdsoft_disabled"):a.is("[readonly]")&&D.push("xdsoft_disabled"),c&&""!==c[1]&&D.push(c[1]),j.currentTime.getMonth()!==l&&D.push("xdsoft_other_month"),(F.defaultSelect||J.data("changed"))&&r.formatDate(j.currentTime,F.formatDate)===r.formatDate(p,F.formatDate)&&D.push("xdsoft_current"),r.formatDate(v,F.formatDate)===r.formatDate(p,F.formatDate)&&D.push("xdsoft_today"),(0===p.getDay()||6===p.getDay()||-1!==F.weekends.indexOf(r.formatDate(p,F.formatDate)))&&D.push("xdsoft_weekend"),void 0!==F.highlightedDates[r.formatDate(p,F.formatDate)]&&(i=F.highlightedDates[r.formatDate(p,F.formatDate)],D.push(void 0===i.style?"xdsoft_highlighted_default":i.style),h=void 0===i.desc?"":i.desc),F.beforeShowDay&&e.isFunction(F.beforeShowDay)&&D.push(F.beforeShowDay(p)),k&&(g+="<tr>",k=!1,F.weeks&&(g+="<th>"+f+"</th>")),g+='<td data-date="'+d+'" data-month="'+l+'" data-year="'+u+'" class="xdsoft_date xdsoft_day_of_week'+p.getDay()+" "+D.join(" ")+'" title="'+h+'"><div>'+d+"</div></td>",p.getDay()===F.dayOfWeekStartPrev&&(g+="</tr>",k=!0),p.setDate(d+1);if(g+="</tbody></table>",L.html(g),N.find(".xdsoft_label span").eq(0).text(F.i18n[o].months[j.currentTime.getMonth()]),N.find(".xdsoft_label span").eq(1).text(j.currentTime.getFullYear()),T="",S="",l="",m=function(t,n){var o,i,s=j.now(),d=F.allowTimes&&e.isArray(F.allowTimes)&&F.allowTimes.length;s.setHours(t),t=parseInt(s.getHours(),10),s.setMinutes(n),n=parseInt(s.getMinutes(),10),o=new Date(j.currentTime),o.setHours(t),o.setMinutes(n),D=[],F.minDateTime!==!1&&F.minDateTime>o||F.maxTime!==!1&&j.strtotime(F.maxTime).getTime()<s.getTime()||F.minTime!==!1&&j.strtotime(F.minTime).getTime()>s.getTime()?D.push("xdsoft_disabled"):F.minDateTime!==!1&&F.minDateTime>o||F.disabledMinTime!==!1&&s.getTime()>j.strtotime(F.disabledMinTime).getTime()&&F.disabledMaxTime!==!1&&s.getTime()<j.strtotime(F.disabledMaxTime).getTime()?D.push("xdsoft_disabled"):a.is("[readonly]")&&D.push("xdsoft_disabled"),i=new Date(j.currentTime),i.setHours(parseInt(j.currentTime.getHours(),10)),d||i.setMinutes(Math[F.roundTime](j.currentTime.getMinutes()/F.step)*F.step),(F.initTime||F.defaultSelect||J.data("changed"))&&i.getHours()===parseInt(t,10)&&(!d&&F.step>59||i.getMinutes()===parseInt(n,10))&&(F.defaultSelect||J.data("changed")?D.push("xdsoft_current"):F.initTime&&D.push("xdsoft_init_time")),parseInt(v.getHours(),10)===parseInt(t,10)&&parseInt(v.getMinutes(),10)===parseInt(n,10)&&D.push("xdsoft_today"),T+='<div class="xdsoft_time '+D.join(" ")+'" data-hour="'+t+'" data-minute="'+n+'">'+r.formatDate(s,F.formatTime)+"</div>"},F.allowTimes&&e.isArray(F.allowTimes)&&F.allowTimes.length)for(y=0;y<F.allowTimes.length;y+=1)S=j.strtotime(F.allowTimes[y]).getHours(),l=j.strtotime(F.allowTimes[y]).getMinutes(),m(S,l);else for(y=0,t=0;y<(F.hours12?12:24);y+=1)for(t=0;60>t;t+=F.step)S=(10>y?"0":"")+y,l=(10>t?"0":"")+t,m(S,l);for(V.html(T),n="",y=0,y=parseInt(F.yearStart,10)+F.yearOffset;y<=parseInt(F.yearEnd,10)+F.yearOffset;y+=1)n+='<div class="xdsoft_option '+(j.currentTime.getFullYear()===y?"xdsoft_current":"")+'" data-value="'+y+'">'+y+"</div>";for(U.children().eq(0).html(n),y=parseInt(F.monthStart,10),n="";y<=parseInt(F.monthEnd,10);y+=1)n+='<div class="xdsoft_option '+(j.currentTime.getMonth()===y?"xdsoft_current":"")+'" data-value="'+y+'">'+F.i18n[o].months[y]+"</div>";G.children().eq(0).html(n),e(J).trigger("generate.xdsoft")},10),t.stopPropagation()}).on("afterOpen.xdsoft",function(){if(F.timepicker){var e,t,a,r;V.find(".xdsoft_current").length?e=".xdsoft_current":V.find(".xdsoft_init_time").length&&(e=".xdsoft_init_time"),e?(t=R[0].clientHeight,a=V[0].offsetHeight,r=V.find(e).index()*F.timeHeightInTimePicker+1,r>a-t&&(r=a-t),R.trigger("scroll_element.xdsoft_scroller",[parseInt(r,10)/(a-t)])):R.trigger("scroll_element.xdsoft_scroller",[0])}}),P=0,L.on("touchend click.xdsoft","td",function(t){t.stopPropagation(),P+=1;var r=e(this),n=j.currentTime;return(void 0===n||null===n)&&(j.currentTime=j.now(),n=j.currentTime),r.hasClass("xdsoft_disabled")?!1:(n.setDate(1),n.setFullYear(r.data("year")),n.setMonth(r.data("month")),n.setDate(r.data("date")),J.trigger("select.xdsoft",[n]),a.val(j.str()),F.onSelectDate&&e.isFunction(F.onSelectDate)&&F.onSelectDate.call(J,j.currentTime,J.data("input"),t),J.data("changed",!0),J.trigger("xchange.xdsoft"),J.trigger("changedatetime.xdsoft"),(P>1||F.closeOnDateSelect===!0||F.closeOnDateSelect===!1&&!F.timepicker)&&!F.inline&&J.trigger("close.xdsoft"),void setTimeout(function(){P=0},200))}),V.on("touchend click.xdsoft","div",function(t){t.stopPropagation();var a=e(this),r=j.currentTime;return(void 0===r||null===r)&&(j.currentTime=j.now(),r=j.currentTime),a.hasClass("xdsoft_disabled")?!1:(r.setHours(a.data("hour")),r.setMinutes(a.data("minute")),J.trigger("select.xdsoft",[r]),J.data("input").val(j.str()),F.onSelectTime&&e.isFunction(F.onSelectTime)&&F.onSelectTime.call(J,j.currentTime,J.data("input"),t),J.data("changed",!0),J.trigger("xchange.xdsoft"),J.trigger("changedatetime.xdsoft"),void(F.inline!==!0&&F.closeOnTimeSelect===!0&&J.trigger("close.xdsoft")))}),I.on("mousewheel.xdsoft",function(e){return F.scrollMonth?(e.deltaY<0?j.nextMonth():j.prevMonth(),!1):!0}),a.on("mousewheel.xdsoft",function(e){return F.scrollInput?!F.datepicker&&F.timepicker?(A=V.find(".xdsoft_current").length?V.find(".xdsoft_current").eq(0).index():0,A+e.deltaY>=0&&A+e.deltaY<V.children().length&&(A+=e.deltaY),V.children().eq(A).length&&V.children().eq(A).trigger("mousedown"),!1):F.datepicker&&!F.timepicker?(I.trigger(e,[e.deltaY,e.deltaX,e.deltaY]),a.val&&a.val(j.str()),J.trigger("changedatetime.xdsoft"),!1):void 0:!0}),J.on("changedatetime.xdsoft",function(t){if(F.onChangeDateTime&&e.isFunction(F.onChangeDateTime)){var a=J.data("input");F.onChangeDateTime.call(J,j.currentTime,a,t),delete F.value,a.trigger("change")}}).on("generate.xdsoft",function(){F.onGenerate&&e.isFunction(F.onGenerate)&&F.onGenerate.call(J,j.currentTime,J.data("input")),q&&(J.trigger("afterOpen.xdsoft"),q=!1)}).on("click.xdsoft",function(e){e.stopPropagation()}),A=0,H=function(e,t){do if(e=e.parentNode,t(e)===!1)break;while("HTML"!==e.nodeName)},Y=function(){var t,a,r,n,o,i,s,d,u,l,f,c,m;if(d=J.data("input"),t=d.offset(),a=d[0],l="top",r=t.top+a.offsetHeight-1,n=t.left,o="absolute",u=e(window).width(),c=e(window).height(),m=e(window).scrollTop(),document.documentElement.clientWidth-t.left<I.parent().outerWidth(!0)){var h=I.parent().outerWidth(!0)-a.offsetWidth;n-=h}"rtl"===d.parent().css("direction")&&(n-=J.outerWidth()-d.outerWidth()),F.fixed?(r-=m,n-=e(window).scrollLeft(),o="fixed"):(s=!1,H(a,function(e){return"fixed"===window.getComputedStyle(e).getPropertyValue("position")?(s=!0,!1):void 0}),s?(o="fixed",r+J.outerHeight()>c+m?(l="bottom",r=c+m-t.top):r-=m):r+a.offsetHeight>c+m&&(r=t.top-a.offsetHeight+1),0>r&&(r=0),n+a.offsetWidth>u&&(n=u-a.offsetWidth)),i=J[0],H(i,function(e){var t;return t=window.getComputedStyle(e).getPropertyValue("position"),"relative"===t&&u>=e.offsetWidth?(n-=(u-e.offsetWidth)/2,!1):void 0}),f={position:o,left:n,top:"",bottom:""},f[l]=r,J.css(f)},J.on("open.xdsoft",function(t){var a=!0;F.onShow&&e.isFunction(F.onShow)&&(a=F.onShow.call(J,j.currentTime,J.data("input"),t)),a!==!1&&(J.show(),Y(),e(window).off("resize.xdsoft",Y).on("resize.xdsoft",Y),F.closeOnWithoutClick&&e([document.body,window]).on("touchstart mousedown.xdsoft",function r(){J.trigger("close.xdsoft"),e([document.body,window]).off("touchstart mousedown.xdsoft",r)}))}).on("close.xdsoft",function(t){var a=!0;N.find(".xdsoft_month,.xdsoft_year").find(".xdsoft_select").hide(),F.onClose&&e.isFunction(F.onClose)&&(a=F.onClose.call(J,j.currentTime,J.data("input"),t)),a===!1||F.opened||F.inline||J.hide(),t.stopPropagation()}).on("toggle.xdsoft",function(){J.trigger(J.is(":visible")?"close.xdsoft":"open.xdsoft")}).data("input",a),X=0,J.data("xdsoft_datetime",j),J.setOptions(F),j.setCurrentTime(i()),a.data("xdsoft_datetimepicker",J).on("open.xdsoft focusin.xdsoft mousedown.xdsoft touchstart",function(){a.is(":disabled")||a.data("xdsoft_datetimepicker").is(":visible")&&F.closeOnInputClick||(clearTimeout(X),X=setTimeout(function(){a.is(":disabled")||(q=!0,j.setCurrentTime(i()),F.mask&&s(F),J.trigger("open.xdsoft"))},100))}).on("keydown.xdsoft",function(t){var a,r=t.which;return-1!==[p].indexOf(r)&&F.enterLikeTab?(a=e("input:visible,textarea:visible,button:visible,a:visible"),J.trigger("close.xdsoft"),a.eq(a.index(this)+1).focus(),!1):-1!==[T].indexOf(r)?(J.trigger("close.xdsoft"),!0):void 0}).on("blur.xdsoft",function(){J.trigger("close.xdsoft")})},d=function(t){var a=t.data("xdsoft_datetimepicker");a&&(a.data("xdsoft_datetime",null),a.remove(),t.data("xdsoft_datetimepicker",null).off(".xdsoft"),e(window).off("resize.xdsoft"),e([window,document.body]).off("mousedown.xdsoft touchstart"),t.unmousewheel&&t.unmousewheel())},e(document).off("keydown.xdsoftctrl keyup.xdsoftctrl").on("keydown.xdsoftctrl",function(e){e.keyCode===h&&(C=!0)}).on("keyup.xdsoftctrl",function(e){e.keyCode===h&&(C=!1)}),this.each(function(){var t,a=e(this).data("xdsoft_datetimepicker");if(a){if("string"===e.type(n))switch(n){case"show":e(this).select().focus(),a.trigger("open.xdsoft");break;case"hide":a.trigger("close.xdsoft");break;case"toggle":a.trigger("toggle.xdsoft");break;case"destroy":d(e(this));break;case"reset":this.value=this.defaultValue,this.value&&a.data("xdsoft_datetime").isValidDate(r.parseDate(this.value,F.format))||a.data("changed",!1),a.data("xdsoft_datetime").setCurrentTime(this.value);break;case"validate":t=a.data("input"),t.trigger("blur.xdsoft");break;default:a[n]&&e.isFunction(a[n])&&(u=a[n](i))}else a.setOptions(n);return 0}"string"!==e.type(n)&&(!F.lazyInit||F.open||F.inline?s(e(this)):A(e(this)))}),u},e.fn.datetimepicker.defaults=a}),function(e){"function"==typeof define&&define.amd?define(["jquery"],e):"object"==typeof exports?module.exports=e:e(jQuery)}(function(e){function t(t){var i=t||window.event,s=d.call(arguments,1),u=0,f=0,c=0,m=0,h=0,g=0;if(t=e.event.fix(i),t.type="mousewheel","detail"in i&&(c=-1*i.detail),"wheelDelta"in i&&(c=i.wheelDelta),"wheelDeltaY"in i&&(c=i.wheelDeltaY),"wheelDeltaX"in i&&(f=-1*i.wheelDeltaX),"axis"in i&&i.axis===i.HORIZONTAL_AXIS&&(f=-1*c,c=0),u=0===c?f:c,"deltaY"in i&&(c=-1*i.deltaY,u=c),"deltaX"in i&&(f=i.deltaX,0===c&&(u=-1*f)),0!==c||0!==f){if(1===i.deltaMode){var p=e.data(this,"mousewheel-line-height");u*=p,c*=p,f*=p}else if(2===i.deltaMode){var y=e.data(this,"mousewheel-page-height");u*=y,c*=y,f*=y}if(m=Math.max(Math.abs(c),Math.abs(f)),(!o||o>m)&&(o=m,r(i,m)&&(o/=40)),r(i,m)&&(u/=40,f/=40,c/=40),u=Math[u>=1?"floor":"ceil"](u/o),f=Math[f>=1?"floor":"ceil"](f/o),c=Math[c>=1?"floor":"ceil"](c/o),l.settings.normalizeOffset&&this.getBoundingClientRect){var v=this.getBoundingClientRect();h=t.clientX-v.left,g=t.clientY-v.top}return t.deltaX=f,t.deltaY=c,t.deltaFactor=o,t.offsetX=h,t.offsetY=g,t.deltaMode=0,s.unshift(t,u,f,c),n&&clearTimeout(n),n=setTimeout(a,200),(e.event.dispatch||e.event.handle).apply(this,s)}}function a(){o=null}function r(e,t){return l.settings.adjustOldDeltas&&"mousewheel"===e.type&&t%120===0}var n,o,i=["wheel","mousewheel","DOMMouseScroll","MozMousePixelScroll"],s="onwheel"in document||document.documentMode>=9?["wheel"]:["mousewheel","DomMouseScroll","MozMousePixelScroll"],d=Array.prototype.slice;if(e.event.fixHooks)for(var u=i.length;u;)e.event.fixHooks[i[--u]]=e.event.mouseHooks;var l=e.event.special.mousewheel={version:"3.1.12",setup:function(){if(this.addEventListener)for(var a=s.length;a;)this.addEventListener(s[--a],t,!1);else this.onmousewheel=t;e.data(this,"mousewheel-line-height",l.getLineHeight(this)),e.data(this,"mousewheel-page-height",l.getPageHeight(this))},teardown:function(){if(this.removeEventListener)for(var a=s.length;a;)this.removeEventListener(s[--a],t,!1);else this.onmousewheel=null;e.removeData(this,"mousewheel-line-height"),e.removeData(this,"mousewheel-page-height")},getLineHeight:function(t){var a=e(t),r=a["offsetParent"in e.fn?"offsetParent":"parent"]();return r.length||(r=e("body")),parseInt(r.css("fontSize"),10)||parseInt(a.css("fontSize"),10)||16},getPageHeight:function(t){return e(t).height()},settings:{adjustOldDeltas:!0,normalizeOffset:!0}};e.fn.extend({mousewheel:function(e){return e?this.bind("mousewheel",e):this.trigger("mousewheel")},unmousewheel:function(e){return this.unbind("mousewheel",e)}})});
/*
== malihu jquery thumbnail scroller plugin == 
Version: 2.0.3 
Plugin URI: http://manos.malihu.gr/jquery-thumbnail-scroller 
Author: malihu
Author URI: http://manos.malihu.gr
License: MIT License (MIT)
*/

/*
Copyright 2010 Manos Malihutsakis (email: manos@malihu.gr)

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/

/*
The code below is fairly long, fully commented and should be normally used in development. 
For production, use the minified jquery.mThumbnailScroller.min.js script. 
*/

;(function($,window,document){
	
	/* 
	----------------------------------------
	PLUGIN NAMESPACE, PREFIX, DEFAULT SELECTOR(S) 
	----------------------------------------
	*/
	
	var pluginNS="mThumbnailScroller",
		pluginPfx="mTS",
		defaultSelector=".mThumbnailScroller",
	
	
		
	
	
	/* 
	----------------------------------------
	DEFAULT OPTIONS 
	----------------------------------------
	*/
	
		defaults={
			/*
			set element/content width/height programmatically 
			values: boolean, pixels, percentage 
				option						default
				-------------------------------------
				setWidth					false
				setHeight					false
			*/
			/*
			set the initial css top property of content  
			values: string (e.g. "-100px", "10%" etc.)
			*/
			setTop:0,
			/*
			set the initial css left property of content  
			values: string (e.g. "-100px", "10%" etc.)
			*/
			setLeft:0,
			/* 
			set the scrolling type 
			values (string): "hover-0"/"hover-100" (number indicating percentage), "hover-precise", "click-0"/"click-100" (number indicating percentage), "click-thumb"
			*/
			type:"hover-50",
			/* 
			scroller axis (vertical and/or horizontal) 
			values (string): "y", "x", "yx"
			*/
			axis:"x",
			/*
			scrolling speed
			values: integer (higher=faster)
			*/
			speed:15,
			/*
			enable content touch-swipe scrolling 
			values: boolean, integer, string (number)
			integer values define the axis-specific minimum amount required for scrolling momentum
			*/
			contentTouchScroll:25,
			/*
			markup option parameters
			*/
			markup:{
				/*
				thumbnailsContainer sets the element containing your thumbnails. By default this is an unordered list ("ul") 
				thumbnailContainer sets the element containing each thumbnail. By default this is a list-item ("li") 
				thumbnailElement sets the actual thumbnail element. By default this is an image tag ("img") 
				values: boolean, string
					option						default
					-------------------------------------
					thumbnailsContainer			null
					thumbnailContainer			null
					thumbnailElement			null
					
				*/
				/*
				set the placeholder element of the buttons 
				values: boolean, string
				*/
				buttonsPlaceholder:false,
				/*
				set buttons HTML
				*/
				buttonsHTML:{
					up:"SVG set 1",
					down:"SVG set 1",
					left:"SVG set 1",
					right:"SVG set 1"
				}
			},
			/*
			advanced option parameters
			*/
			advanced:{
				/*
				auto-expand content horizontally (for "x" or "yx" axis) 
				values: boolean
				*/
				autoExpandHorizontalScroll:true,
				/*
				auto-update scrollers on content, element or viewport resize 
				should be true for fluid layouts/elements, adding/removing content dynamically, hiding/showing elements, content with images etc. 
				values: boolean
				*/
				updateOnContentResize:true,
				/*
				auto-update scrollers each time each image inside the element is fully loaded 
				values: boolean
				*/
				updateOnImageLoad:true
				/*
				auto-update scrollers based on the amount and size changes of specific selectors 
				useful when you need to update the scroller(s) automatically, each time a type of element is added, removed or changes its size 
				values: boolean, string (e.g. "ul li" will auto-update the scroller each time list-items inside the element are changed) 
				a value of true (boolean) will auto-update the scroller each time any element is changed
					option						default
					-------------------------------------
					updateOnSelectorChange		null
				*/
			},
			/* 
			scroller theme 
			values: string 
			*/
			theme:"none",
			/*
			user defined callback functions
			*/
			callbacks:{
				/*
				Available callbacks: 
					callback					default
					-------------------------------------
					onInit						null
					onScrollStart				null
					onScroll					null
					onTotalScroll				null
					onTotalScrollBack			null
					whileScrolling				null
				*/
				onTotalScrollOffset:0,
				onTotalScrollBackOffset:0,
				alwaysTriggerOffsets:true
			}
			/*
			add scroller(s) on all elements matching the current selector, now and in the future 
			values: boolean, string 
			string values: "on" (enable), "once" (disable after first invocation), "off" (disable)
			liveSelector values: string (selector)
				option						default
				-------------------------------------
				live						false
				liveSelector				null
			*/
		},
	
	
	
	
	
	/* 
	----------------------------------------
	VARS, CONSTANTS 
	----------------------------------------
	*/
	
		totalInstances=0, /* plugin instances amount */
		liveTimers={}, /* live option timers */
		oldIE=(window.attachEvent && !window.addEventListener) ? 1 : 0, /* detect IE < 9 */
		touchActive=false, /* global touch state (for touch and pointer events) */
		touchi, /* touch interface */
		/* general plugin classes */
		classes=["mTS_disabled","mTS_destroyed","mTS_no_scroll"],
		
	
	
	
	
	/* 
	----------------------------------------
	METHODS 
	----------------------------------------
	*/
	
		methods={
			
			/* 
			plugin initialization method 
			creates the scroller(s), plugin data object and options
			----------------------------------------
			*/
			
			init:function(options){
				
				var options=$.extend(true,{},defaults,options),
					selector=_selector.call(this); /* validate selector */
				
				/* 
				if live option is enabled, monitor for elements matching the current selector and 
				apply scroller(s) when found (now and in the future) 
				*/
				if(options.live){
					var liveSelector=options.liveSelector || this.selector || defaultSelector, /* live selector(s) */
						$liveSelector=$(liveSelector); /* live selector(s) as jquery object */
					if(options.live==="off"){
						/* 
						disable live if requested 
						usage: $(selector).mThumbnailScroller({live:"off"}); 
						*/
						removeLiveTimers(liveSelector);
						return;
					}
					liveTimers[liveSelector]=setTimeout(function(){
						/* call mThumbnailScroller fn on live selector(s) every half-second */
						$liveSelector.mThumbnailScroller(options);
						if(options.live==="once" && $liveSelector.length){
							/* disable live after first invocation */
							removeLiveTimers(liveSelector);
						}
					},500);
				}else{
					removeLiveTimers(liveSelector);
				}
				
				/* options  normalization */
				options.speed=options.speed===0 ? 100 : options.speed;
				
				_theme(options); /* theme-specific options */
				
				/* plugin constructor */
				return $(selector).each(function(){
					
					var $this=$(this);
					
					if(!$this.data(pluginPfx)){ /* prevent multiple instantiations */
					
						/* store options and create objects in jquery data */
						$this.data(pluginPfx,{
							idx:++totalInstances, /* instance index */
							opt:options, /* options */
							html:null, /* element original html */
							overflowed:null, /* overflowed axis */
							bindEvents:false, /* object to check if events are bound */
							tweenRunning:false, /* object to check if tween is running */
							langDir:$this.css("direction"), /* detect/store direction (ltr or rtl) */
							cbOffsets:null, /* object to check whether callback offsets always trigger */
							/* 
							object to check how scrolling events where last triggered 
							"internal" (default - triggered by this script), "external" (triggered by other scripts, e.g. via scrollTo method) 
							usage: object.data("mTS").trigger
							*/
							trigger:null
						});
						
						/* HTML data attributes */
						var o=$this.data(pluginPfx).opt,
							htmlDataAxis=$this.data("mts-axis"),htmlDataType=$this.data("mts-type"),htmlDataTheme=$this.data("mts-theme");
						if(htmlDataAxis){o.axis=htmlDataAxis;} /* usage example: data-mts-axis="y" */
						if(htmlDataType){o.type=htmlDataType;} /* usage example: data-mts-type="hover-50" */
						if(htmlDataTheme){ /* usage example: data-mts-theme="theme-name" */
							o.theme=htmlDataTheme;
							_theme(o); /* theme-specific options */
						}
						
						_pluginMarkup.call(this); /* add plugin markup */
						
						methods.update.call(null,$this); /* call the update method */
					
					}
					
				});
				
			},
			/* ---------------------------------------- */
			
			
			
			/* 
			plugin update method 
			updates content and scroller values, events and status 
			----------------------------------------
			usage: $(selector).mThumbnailScroller("update");
			*/
			
			update:function(el){
				
				var selector=el || _selector.call(this); /* validate selector */
				
				return $(selector).each(function(){
					
					var $this=$(this);
					
					if($this.data(pluginPfx)){ /* check if plugin has initialized */
						
						var d=$this.data(pluginPfx),o=d.opt,
							mTS_container=$("#mTS_"+d.idx+"_container");
						
						if(!mTS_container.length){return;}
						
						if(d.tweenRunning){_stop($this);} /* stop any running tweens while updating */
						
						/* if element was disabled or destroyed, remove class(es) */
						if($this.hasClass(classes[0])){$this.removeClass(classes[0]);}
						if($this.hasClass(classes[1])){$this.removeClass(classes[1]);}
						
						_maxHeight.call(this); /* detect/set css max-height value */
						
						_expandContentHorizontally.call(this); /* expand content horizontally */
						
						d.overflowed=_overflowed.call(this); /* determine if scrolling is required */
						
						_buttonsVisibility.call(this); /* show/hide buttons */
						
						_bindEvents.call(this); /* bind scroller events */
						
						/* reset scrolling position and/or events */
						var to=[(mTS_container[0].offsetTop),(mTS_container[0].offsetLeft)];
						if(o.axis!=="x"){ /* y/yx axis */
							if(!d.overflowed[0]){ /* y scrolling is not required */
								_resetContentPosition.call(this); /* reset content position */
								if(o.axis==="y"){
									_scrollTo($this,"0",{dir:"y",dur:0,overwrite:"none"});
									_unbindEvents.call(this);
								}else if(o.axis==="yx" && d.overflowed[1]){
									_scrollTo($this,to[1].toString(),{dir:"x",dur:0,overwrite:"none"});
								}
							}else{ /* y scrolling is required */
								_scrollTo($this,to[0].toString(),{dir:"y",dur:0,overwrite:"none"});
							}
						}
						if(o.axis!=="y"){ /* x/yx axis */
							if(!d.overflowed[1]){ /* x scrolling is not required */
								_resetContentPosition.call(this); /* reset content position */
								if(o.axis==="x"){
									_scrollTo($this,"0",{dir:"x",dur:0,overwrite:"none"});
									_unbindEvents.call(this);
								}else if(o.axis==="yx" && d.overflowed[0]){
									_scrollTo($this,to[0].toString(),{dir:"y",dur:0,overwrite:"none"});
								}
							}else{ /* x scrolling is required */
								_scrollTo($this,to[1].toString(),{dir:"x",dur:0,overwrite:"none"});
							}
						}
						
						/* no scroll class */
						if(!d.overflowed[0] && !d.overflowed[1]){
							$this.addClass(classes[2]);
						}else{
							$this.removeClass(classes[2]);
						}
						
						_autoUpdate.call(this); /* initialize automatic updating (for dynamic content, fluid layouts etc.) */
						
					}
					
				});
				
			},
			/* ---------------------------------------- */
			
			
			
			/* 
			plugin scrollTo method 
			triggers a scrolling event to a specific value
			----------------------------------------
			usage: $(selector).mThumbnailScroller("scrollTo",value,options);
			*/
		
			scrollTo:function(val,options){
				
				/* prevent silly things like $(selector).mThumbnailScroller("scrollTo",undefined); */
				if(typeof val=="undefined" || val==null){return;}
				
				var selector=_selector.call(this); /* validate selector */
				
				return $(selector).each(function(){
					
					var $this=$(this);
					
					if($this.data(pluginPfx)){ /* check if plugin has initialized */
					
						var d=$this.data(pluginPfx),o=d.opt,
							/* method default options */
							methodDefaults={
								trigger:"external", /* method is by default triggered externally (e.g. from other scripts) */
								speed:o.speed, /* scrolling speed */
								duration:1000, /* animation duration */
								easing:"easeInOut", /* animation easing */
								timeout:60, /* scroll-to delay */
								callbacks:true, /* enable/disable callbacks */
								onStart:true,
								onUpdate:true,
								onComplete:true
							},
							methodOptions=$.extend(true,{},methodDefaults,options),
							to=_arr.call(this,val),dur=methodOptions.duration ? methodOptions.duration : 7000/(methodOptions.speed || 1);
						
						/* translate yx values to actual scroll-to positions */
						to[0]=_to.call(this,to[0],"y");
						to[1]=_to.call(this,to[1],"x");
						
						methodOptions.dur=dur>0 && dur<17 ? 17 : dur;
						
						setTimeout(function(){ 
							/* do the scrolling */
							if(to[0]!==null && typeof to[0]!=="undefined" && o.axis!=="x" && d.overflowed[0]){ /* scroll y */
								methodOptions.dir="y";
								methodOptions.overwrite="all";
								_scrollTo($this,-to[0].toString(),methodOptions);
							}
							if(to[1]!==null && typeof to[1]!=="undefined" && o.axis!=="y" && d.overflowed[1]){ /* scroll x */
								methodOptions.dir="x";
								methodOptions.overwrite="none";
								_scrollTo($this,-to[1].toString(),methodOptions);
							}
						},methodOptions.timeout);
						
					}
					
				});
				
			},
			/* ---------------------------------------- */
			
			
			
			/*
			plugin stop method 
			stops scrolling animation
			----------------------------------------
			usage: $(selector).mThumbnailScroller("stop");
			*/
			stop:function(){
				
				var selector=_selector.call(this); /* validate selector */
				
				return $(selector).each(function(){
					
					var $this=$(this);
					
					if($this.data(pluginPfx)){ /* check if plugin has initialized */
										
						_stop($this);
					
					}
					
				});
				
			},
			/* ---------------------------------------- */
			
			
			
			/*
			plugin disable method 
			temporarily disables the scroller 
			----------------------------------------
			usage: $(selector).mThumbnailScroller("disable",reset); 
			reset (boolean): resets content position to 0 
			*/
			disable:function(r){
				
				var selector=_selector.call(this); /* validate selector */
				
				return $(selector).each(function(){
					
					var $this=$(this);
					
					if($this.data(pluginPfx)){ /* check if plugin has initialized */
						
						var d=$this.data(pluginPfx),o=d.opt;
						
						_autoUpdate.call(this,"remove"); /* remove automatic updating */
						
						_unbindEvents.call(this); /* unbind events */
						
						if(r){_resetContentPosition.call(this);} /* reset content position */
						
						_buttonsVisibility.call(this,true); /* show/hide buttons */
						
						$this.addClass(classes[0]); /* add disable class */
					
					}
					
				});
				
			},
			/* ---------------------------------------- */
			
			
			
			/*
			plugin destroy method 
			completely removes the scrollber and returns the element to its original state
			----------------------------------------
			usage: $(selector).mThumbnailScroller("destroy"); 
			*/
			destroy:function(){
				
				var selector=_selector.call(this); /* validate selector */
				
				return $(selector).each(function(){
					
					var $this=$(this);
					
					if($this.data(pluginPfx)){ /* check if plugin has initialized */
					
						var d=$this.data(pluginPfx),o=d.opt,
							mTS_wrapper=$("#mTS_"+d.idx),
							mTS_container=$("#mTS_"+d.idx+"_container"),
							mTS_buttons=$("#mTS_"+d.idx+"_buttonUp,#mTS_"+d.idx+"_buttonDown,#mTS_"+d.idx+"_buttonLeft,#mTS_"+d.idx+"_buttonRight");
					
						if(o.live){removeLiveTimers(selector);} /* remove live timer */
						
						_autoUpdate.call(this,"remove"); /* remove automatic updating */
						
						_unbindEvents.call(this); /* unbind events */
						
						_resetContentPosition.call(this); /* reset content position */
						
						$this.removeData(pluginPfx); /* remove plugin data object */
						
						_delete(this,"mts"); /* delete callbacks object */
						
						/* remove plugin markup */
						mTS_buttons.remove(); /* remove buttons first (those can be either inside or outside plugin's inner wrapper) */
						mTS_wrapper.replaceWith(d.html); /* replace plugin's inner wrapper with the original content */
						/* remove plugin classes from the element and add destroy class */
						$this.removeClass(pluginNS+" _"+pluginPfx+"_"+d.idx+" "+pluginPfx+"-"+o.theme+" "+classes[2]+" "+classes[0]).addClass(classes[1]);
					
					}
					
				});
				
			}
			/* ---------------------------------------- */
			
		},
	
	
	
	
		
	/* 
	----------------------------------------
	FUNCTIONS
	----------------------------------------
	*/
	
		/* validates selector (if selector is invalid or undefined uses the default one) */
		_selector=function(){
			return (typeof $(this)!=="object" || $(this).length<1) ? defaultSelector : this;
		},
		/* -------------------- */
		
		/* changes options according to theme */
		_theme=function(obj){
			var buttonsPlaceholderOutside=["buttons-out"],
				buttonsHtmlSet2=["buttons-in"],
				buttonsHtmlSet3=["buttons-out"],
				typeHover85=["hover-classic"],
				typeHoverPrecise=["hover-full"];
			obj.markup.buttonsPlaceholder=$.inArray(obj.theme,buttonsPlaceholderOutside) > -1 ? "outside" : obj.markup.buttonsPlaceholder;
			obj.markup.buttonsHTML=$.inArray(obj.theme,buttonsHtmlSet2) > -1 ? {up:"SVG set 2",down:"SVG set 2",left:"SVG set 2",right:"SVG set 2"} : $.inArray(obj.theme,buttonsHtmlSet3) > -1 ? {up:"SVG set 3",down:"SVG set 3",left:"SVG set 3",right:"SVG set 3"} : obj.markup.buttonsHTML;
			obj.type=$.inArray(obj.theme,typeHover85) > -1 ? "hover-85" : $.inArray(obj.theme,typeHoverPrecise) > -1 ? "hover-precise" : obj.type;
			obj.speed=$.inArray(obj.theme,typeHover85) > -1 ? 60 : $.inArray(obj.theme,typeHoverPrecise) > -1 ? 10 : obj.speed;
		},
		/* -------------------- */
		
		
		/* live option timers removal */
		removeLiveTimers=function(selector){
			if(liveTimers[selector]){
				clearTimeout(liveTimers[selector]);
				_delete(liveTimers,selector);
			}
		},
		/* -------------------- */
		
		
		/* generates plugin markup */
		_pluginMarkup=function(){
			var $this=$(this),d=$this.data(pluginPfx),o=d.opt,
				wrapperClass=o.axis==="yx" ? "mTS_vertical_horizontal" : o.axis==="x" ? "mTS_horizontal" : "mTS_vertical",
				thumbsContainer=o.markup.thumbnailsContainer || "ul",
				thumbContainer=o.markup.thumbnailContainer || "li",
				thumbElement=o.markup.thumbnailElement || "img";
			d.html=$this.children().clone(true,true); /* store element original html to restore when destroy method is called */
			if(!$this.find(thumbsContainer).length){ /* create images container automatically if not present */
				var thumbsAutoContainer=$this.find("li").length ? "<ul class='"+pluginPfx+"AutoContainer' />" : "<div class='"+pluginPfx+"AutoContainer' />";
				$this.wrapInner(thumbsAutoContainer);
				thumbsContainer="."+pluginPfx+"AutoContainer";
			}
			if(o.setWidth){$this.css("width",o.setWidth);} /* set element width */
			if(o.setHeight){$this.css("height",o.setHeight);} /* set element height */
			o.setLeft=(o.axis!=="y" && d.langDir==="rtl") ? "-989999px" : o.setLeft; /* adjust left position for rtl direction */
			$this	.addClass(pluginNS+" _"+pluginPfx+"_"+d.idx+" "+pluginPfx+"-"+o.theme)
					.find(thumbsContainer).wrap("<div id='mTS_"+d.idx+"' class='mTSWrapper "+wrapperClass+"' />")
						.addClass(pluginPfx+"Container").attr("id","mTS_"+d.idx+"_container")
						.css({"position":"relative","top":o.setTop,"left":o.setLeft})
					.find(thumbContainer).addClass(pluginPfx+"ThumbContainer")
					.find(thumbElement).addClass(pluginPfx+"Thumb");
			_scrollButtons.call(this); /* add scroller buttons */
		},
		/* -------------------- */
		
		
		/* expands content horizontally */
		_expandContentHorizontally=function(){
			var $this=$(this),d=$this.data(pluginPfx),o=d.opt,
				mTS_container=$("#mTS_"+d.idx+"_container");
			if(o.advanced.autoExpandHorizontalScroll && o.axis!=="y"){
				/* 
				wrap content with an infinite width div and set its position to absolute and width to auto. 
				Setting width to auto before calculating the actual width is important! 
				We must let the browser set the width as browser zoom values are impossible to calculate.
				*/
				mTS_container.css({"position":"absolute","width":"auto"})
					.wrap("<div class='mTS_h_wrapper' style='position:relative; left:0; width:999999px;' />")
					.css({ /* set actual width, original position and un-wrap */
						/* 
						get the exact width (with decimals) and then round-up. 
						Using jquery outerWidth() will round the width value which will mess up with inner elements that have non-integer width
						*/
						"width":(Math.ceil(mTS_container[0].getBoundingClientRect().right)-Math.floor(mTS_container[0].getBoundingClientRect().left)),
						"position":"relative"
					}).unwrap();
			}
		},
		/* -------------------- */
		
		
		/* adds scroller buttons */
		_scrollButtons=function(){
			var $this=$(this),d=$this.data(pluginPfx),o=d.opt,
				placeholder=!o.markup.buttonsPlaceholder ? $("#mTS_"+d.idx) : o.markup.buttonsPlaceholder==="outside" ? $this : $(o.markup.buttonsPlaceholder),
				btnHTML=[
					"<a href='#' id='mTS_"+d.idx+"_buttonUp' class='mTSButton mTSButtonUp'><span class='mTSButtonIconContainer'>"+_scrollButtonsIcons.call(this,"up")+"</span></a>",
					"<a href='#' id='mTS_"+d.idx+"_buttonDown' class='mTSButton mTSButtonDown'><span class='mTSButtonIconContainer'>"+_scrollButtonsIcons.call(this,"down")+"</span></a>",
					"<a href='#' id='mTS_"+d.idx+"_buttonLeft' class='mTSButton mTSButtonLeft'><span class='mTSButtonIconContainer'>"+_scrollButtonsIcons.call(this,"left")+"</span></a>",
					"<a href='#' id='mTS_"+d.idx+"_buttonRight' class='mTSButton mTSButtonRight'><span class='mTSButtonIconContainer'>"+_scrollButtonsIcons.call(this,"right")+"</span></a>"
				],
				btn=[(o.axis==="x" ? btnHTML[2] : btnHTML[0]),(o.axis==="x" ? btnHTML[3] : btnHTML[1])];
			if(placeholder.hasClass(pluginNS) && placeholder.css("position")==="static"){ /* requires elements with non-static position */
				placeholder.css("position","relative");
			}
			if(o.type.indexOf("click")!==-1){
				if(o.axis!=="x"){
					placeholder.append(btnHTML[0]+btnHTML[1]);
				}
				if(o.axis!=="y"){
					placeholder.append(btnHTML[2]+btnHTML[3]);
				}
			}
		},
		/* -------------------- */
		
		
		/* sets scroller buttons icons */
		_scrollButtonsIcons=function(b){
			var $this=$(this),d=$this.data(pluginPfx),o=d.opt,
				btn=o.markup.buttonsHTML,
				i=btn[b]==="SVG set 1" ? 0 : btn[b]==="SVG set 2" ? 1 : btn[b]==="SVG set 3" ? 2 : btn[b]==="SVG set 4" ? 3 : btn[b]==="SVG set 5" ? 4 : null;
			switch(b){
				case "up":
					return i===null ? btn[b] : oldIE ? "&uarr;" : _icons(btn[b])[i][0];
					break;
				case "down":
					return i===null ? btn[b] : oldIE ? "&darr;" : _icons(btn[b])[i][1];
					break;
				case "left":
					return i===null ? btn[b] : oldIE ? "&larr;" : _icons(btn[b])[i][2];
					break;
				case "right":
					return i===null ? btn[b] : oldIE ? "&rarr;" : _icons(btn[b])[i][3];
					break;
			}
		},
		/* -------------------- */
		
		
		/* icons */
		_icons=function(){
			/* SVG */
			var svgo="<svg version='1.1' viewBox='0 0 24 24' preserveAspectRatio='xMinYMin meet' class='mTSButtonIcon'><g><line stroke-width='1' x1='' y1='' x2='' y2='' stroke='#449FDB' opacity=''></line></g>",
				svgc="</svg>";
			return [
				/* set 1 */
				[svgo+"<path d='M20.561 9.439l-7.5-7.5c-0.586-0.586-1.535-0.586-2.121 0l-7.5 7.5c-0.586 0.586-0.586 1.536 0 2.121s1.536 0.586 2.121 0l4.939-4.939v14.379c0 0.828 0.672 1.5 1.5 1.5s1.5-0.672 1.5-1.5v-14.379l4.939 4.939c0.293 0.293 0.677 0.439 1.061 0.439s0.768-0.146 1.061-0.439c0.586-0.586 0.586-1.535 0-2.121z'></path>"+svgc,svgo+"<path d='M3.439 14.561l7.5 7.5c0.586 0.586 1.536 0.586 2.121 0l7.5-7.5c0.586-0.586 0.586-1.536 0-2.121s-1.536-0.586-2.121 0l-4.939 4.939v-14.379c0-0.828-0.672-1.5-1.5-1.5s-1.5 0.672-1.5 1.5v14.379l-4.939-4.939c-0.293-0.293-0.677-0.439-1.061-0.439s-0.768 0.146-1.061 0.439c-0.586 0.586-0.586 1.536 0 2.121z'></path>"+svgc,svgo+"<path d='M9.439 3.439l-7.5 7.5c-0.586 0.586-0.586 1.536 0 2.121l7.5 7.5c0.586 0.586 1.536 0.586 2.121 0s0.586-1.536 0-2.121l-4.939-4.939h14.379c0.828 0 1.5-0.672 1.5-1.5s-0.672-1.5-1.5-1.5h-14.379l4.939-4.939c0.293-0.293 0.439-0.677 0.439-1.061s-0.146-0.768-0.439-1.061c-0.586-0.586-1.536-0.586-2.121 0z'></path>"+svgc,svgo+"<path d='M14.561 20.561l7.5-7.5c0.586-0.586 0.586-1.536 0-2.121l-7.5-7.5c-0.586-0.586-1.536-0.586-2.121 0s-0.586 1.536 0 2.121l4.939 4.939h-14.379c-0.828 0-1.5 0.672-1.5 1.5s0.672 1.5 1.5 1.5h14.379l-4.939 4.939c-0.293 0.293-0.439 0.677-0.439 1.061s0.146 0.768 0.439 1.061c0.586 0.586 1.536 0.586 2.121 0z'></path>"+svgc],
				/* set 2 */
				[svgo+"<path d='M18.58 13.724c-0.488-0.502-5.634-5.402-5.634-5.402-0.262-0.268-0.604-0.402-0.946-0.402-0.343 0-0.685 0.134-0.946 0.402 0 0-5.146 4.901-5.635 5.402-0.488 0.502-0.522 1.404 0 1.939 0.523 0.534 1.252 0.577 1.891 0l4.69-4.496 4.688 4.496c0.641 0.577 1.37 0.534 1.891 0 0.523-0.536 0.491-1.439 0-1.939z'</path>"+svgc,svgo+"<path d='M18.58 10.276c-0.488 0.502-5.634 5.404-5.634 5.404-0.262 0.268-0.604 0.401-0.946 0.401-0.343 0-0.685-0.133-0.946-0.401 0 0-5.146-4.902-5.635-5.404-0.488-0.502-0.522-1.403 0-1.939 0.523-0.535 1.252-0.577 1.891 0l4.69 4.498 4.688-4.496c0.641-0.577 1.37-0.535 1.891 0 0.523 0.535 0.491 1.438 0 1.938z'></path>"+svgc,svgo+"<path d='M13.724 5.419c-0.502 0.49-5.402 5.635-5.402 5.635-0.268 0.262-0.401 0.604-0.401 0.946s0.133 0.684 0.401 0.946c0 0 4.901 5.146 5.402 5.634 0.502 0.49 1.404 0.523 1.939 0 0.534-0.522 0.576-1.25-0.001-1.89l-4.496-4.69 4.496-4.69c0.577-0.641 0.535-1.369 0.001-1.891-0.536-0.522-1.439-0.49-1.939 0z'></path>"+svgc,svgo+"<path d='M10.276 5.419c0.502 0.49 5.402 5.635 5.402 5.635 0.269 0.262 0.402 0.604 0.402 0.946s-0.133 0.684-0.402 0.946c0 0-4.901 5.146-5.402 5.634-0.502 0.49-1.403 0.523-1.939 0-0.535-0.522-0.577-1.25 0-1.89l4.498-4.69-4.496-4.69c-0.577-0.641-0.535-1.369 0-1.891s1.438-0.49 1.938 0z'></path>"+svgc],
				/* set 3 */
				[svgo+"<path d='M20.902 17.279c0.325 0.322 0.851 0.322 1.175 0 0.325-0.322 0.325-0.841 0-1.163l-9.49-9.396c-0.324-0.322-0.85-0.322-1.174 0l-9.49 9.396c-0.324 0.322-0.325 0.841 0 1.163s0.85 0.322 1.175 0l8.902-8.569 8.902 8.569z'></path>"+svgc,svgo+"<path d='M3.098 6.721c-0.325-0.322-0.851-0.322-1.175 0-0.324 0.32-0.324 0.841 0 1.163l9.49 9.396c0.325 0.322 0.85 0.322 1.175 0l9.49-9.396c0.324-0.322 0.325-0.841 0-1.163s-0.852-0.322-1.175-0.001l-8.903 8.569-8.902-8.568z'></path>"+svgc,svgo+"<path d='M17.279 20.902c0.322 0.325 0.322 0.85 0 1.175s-0.841 0.325-1.163 0l-9.396-9.488c-0.322-0.325-0.322-0.851 0-1.175l9.396-9.49c0.322-0.325 0.841-0.325 1.163 0s0.322 0.85 0 1.175l-8.568 8.902 8.568 8.902z'</path>"+svgc,svgo+"<path d='M6.72 20.902c-0.322 0.325-0.322 0.85 0 1.175s0.841 0.325 1.163 0l9.396-9.488c0.322-0.325 0.322-0.851 0-1.175l-9.396-9.49c-0.322-0.325-0.841-0.325-1.163 0s-0.322 0.85 0 1.175l8.568 8.902-8.568 8.902z'</path>"+svgc],
				/* set 4 */
				[svgo+"<path d='M12 0l-12 12h7.5v12l9 0v-12h7.5z'></path>"+svgc,svgo+"<path d='M12 24l12-12h-7.5v-12l-9-0v12h-7.5z'></path>"+svgc,svgo+"<path d='M0 12l12 12v-7.5h12l0-9h-12v-7.5z'></path>"+svgc,svgo+"<path d='M24 12l-12-12v7.5h-12l-0 9h12v7.5z'></path>"+svgc],
				/* set 5 */
				[svgo+"<path d='M6.48 16.8h11.040l-5.521-9.6z'></path>"+svgc,svgo+"<path d='M17.52 7.201l-11.040-0.001 5.52 9.6z'></path>"+svgc,svgo+"<path d='M16.799 6.48l0.001 11.040-9.6-5.52z'></path>"+svgc,svgo+"<path d='M7.201 6.48l-0.001 11.040 9.6-5.52z'></path>"+svgc]
			];
		},
		/* -------------------- */
		
		
		/* detects/sets css max-height value */
		_maxHeight=function(){
			var $this=$(this),d=$this.data(pluginPfx),o=d.opt,
				mTS_wrapper=$("#mTS_"+d.idx),
				mh=$this.css("max-height"),pct=mh.indexOf("%")!==-1,
				bs=$this.css("box-sizing");
			if(mh!=="none"){
				var val=pct ? $this.parent().height()*parseInt(mh)/100 : parseInt(mh);
				/* if element's css box-sizing is "border-box", subtract any paddings and/or borders from max-height value */
				if(bs==="border-box"){val-=(($this.innerHeight()-$this.height())+($this.outerHeight()-$this.innerHeight()));}
				mTS_wrapper.css("max-height",Math.round(val));
			}
		},
		/* -------------------- */
		
		
		/* checks if content overflows its container to determine if scrolling is required */
		_overflowed=function(){
			var $this=$(this),d=$this.data(pluginPfx),
				mTS_wrapper=$("#mTS_"+d.idx),
				mTS_container=$("#mTS_"+d.idx+"_container");
			return [mTS_container.height()>mTS_wrapper.height(),mTS_container.width()>mTS_wrapper.width()];
		},
		/* -------------------- */
		
		
		/* resets content position to 0 */
		_resetContentPosition=function(){
			var $this=$(this),d=$this.data(pluginPfx),o=d.opt,
				mTS_wrapper=$("#mTS_"+d.idx),
				mTS_container=$("#mTS_"+d.idx+"_container");
			_stop($this); /* stop any current scrolling before resetting */
			if((o.axis!=="x" && !d.overflowed[0]) || (o.axis==="y" && d.overflowed[0])){mTS_container.css("top",0);} /* reset y */
			if((o.axis!=="y" && !d.overflowed[1]) || (o.axis==="x" && d.overflowed[1])){ /* reset x */
				var rp=d.langDir==="rtl" ? mTS_wrapper.width()-mTS_container.width() : 0;
				mTS_container.css("left",rp);
			}
		},
		/* -------------------- */
		
		
		/* binds scroller events */
		_bindEvents=function(){
			var $this=$(this),d=$this.data(pluginPfx),o=d.opt;
			if(!d.bindEvents){ /* check if events are already bound */
				if(o.contentTouchScroll){_contentDraggable.call(this);}
				if(o.type.indexOf("hover")!==-1){
					if(o.type==="hover-precise"){
						_hoverPrecise.call(this);
					}else{
						_hover.call(this);
					}
				}else if(o.type.indexOf("click")!==-1){
					_click.call(this);
				}
				d.bindEvents=true;
			}
		},
		/* -------------------- */
		
		
		/* unbinds scroller events */
		_unbindEvents=function(){
			var $this=$(this),d=$this.data(pluginPfx),
				namespace=pluginPfx+"_"+d.idx,
				sel=$("#mTS_"+d.idx+",#mTS_"+d.idx+"_container,#mTS_"+d.idx+"_buttonUp,#mTS_"+d.idx+"_buttonDown,#mTS_"+d.idx+"_buttonLeft,#mTS_"+d.idx+"_buttonRight"),
				mTS_container=$("#mTS_"+d.idx+"_container");
			if(d.bindEvents){ /* check if events are bound */
				/* unbind namespaced events from selectors */
				sel.each(function(){
					$(this).unbind("."+namespace);
				});
				/* clear and delete timeouts/objects */
				clearTimeout(mTS_container[0].onCompleteTimeout); _delete(mTS_container[0],"onCompleteTimeout");
				d.bindEvents=false;
			}
		},
		/* -------------------- */
		
		
		/* toggles scroller buttons visibility */
		_buttonsVisibility=function(disabled,hideBtn,dir){
			var $this=$(this),d=$this.data(pluginPfx),o=d.opt;
			if(o.type.indexOf("click")!==-1){
				if(!dir){dir=o.axis;}
				var	mTS_buttons=[$("#mTS_"+d.idx+"_buttonUp"),$("#mTS_"+d.idx+"_buttonDown"),$("#mTS_"+d.idx+"_buttonLeft"),$("#mTS_"+d.idx+"_buttonRight")],
					hideClass=pluginPfx+"-hidden";
				if(dir!=="x"){
					if(d.overflowed[0] && !disabled && !hideBtn){
						sel=[!d.overflowed[1] ? mTS_buttons[2].add(mTS_buttons[3]) : null,mTS_buttons[0].add(mTS_buttons[1])];
					}else{
						sel=hideBtn===1 ? [mTS_buttons[0],mTS_buttons[1]] : hideBtn===2 ? [mTS_buttons[1],mTS_buttons[0]] : [mTS_buttons[0].add(mTS_buttons[1]),null];
					}
				}
				if(dir!=="y"){
					if(d.overflowed[1] && !disabled && !hideBtn){
						sel=[!d.overflowed[0] ? mTS_buttons[0].add(mTS_buttons[1]) : null,mTS_buttons[2].add(mTS_buttons[3])];
					}else{
						sel=hideBtn===1 ? [mTS_buttons[2],mTS_buttons[3]] : hideBtn===2 ? [mTS_buttons[3],mTS_buttons[2]] : [mTS_buttons[2].add(mTS_buttons[3]),null];
					}
				}
				if(sel[0]){sel[0].addClass(hideClass);}
				if(sel[1]){sel[1].removeClass(hideClass);}
			}
		},
		/* -------------------- */
		
		
		/* returns input coordinates of pointer, touch and mouse events (relative to document) */
		_coordinates=function(e){
			var t=e.type;
			switch(t){
				case "pointerdown": case "MSPointerDown": case "pointermove": case "MSPointerMove": case "pointerup": case "MSPointerUp":
					return [e.originalEvent.pageY,e.originalEvent.pageX];
					break;
				case "touchstart": case "touchmove": case "touchend":
					var touch=e.originalEvent.touches[0] || e.originalEvent.changedTouches[0];
					return [touch.pageY,touch.pageX];
					break;
				default:
					return [e.pageY,e.pageX];
			}
		},
		/* -------------------- */
		
		/* returns input type */
		_inputType=function(e){
			return touchi || e.type.indexOf("touch")!==-1 || (typeof e.pointerType!=="undefined" && (e.pointerType===2 || e.pointerType==="touch")) ? "touch" : "mouse";
		},
		/* -------------------- */
		
		
		/* 
		TOUCH SWIPE EVENTS
		scrolls content via touch swipe 
		Emulates the native touch-swipe scrolling with momentum found in iOS, Android and WP devices 
		*/
		_contentDraggable=function(){
			var $this=$(this),d=$this.data(pluginPfx),o=d.opt,
				namespace=pluginPfx+"_"+d.idx,
				mTS_wrapper=$("#mTS_"+d.idx),
				mTS_container=$("#mTS_"+d.idx+"_container"),
				dragY,dragX,touchStartY,touchStartX,touchMoveY=[],touchMoveX=[],startTime,runningTime,endTime,distance,speed,amount,
				durA=0,durB,overwrite=o.axis==="yx" ? "none" : "all",touchIntent=[];
			mTS_container.bind("touchstart."+namespace+" pointerdown."+namespace+" MSPointerDown."+namespace,function(e){
				if(!_pointerTouch(e) || touchActive){return;}
				$this.removeClass("mTS_touch_action");
				var offset=mTS_container.offset();
				dragY=_coordinates(e)[0]-offset.top;
				dragX=_coordinates(e)[1]-offset.left;
				touchIntent=[_coordinates(e)[0],_coordinates(e)[1]];
			}).bind("touchmove."+namespace+" pointermove."+namespace+" MSPointerMove."+namespace,function(e){
				if(!_pointerTouch(e) || touchActive){return;}
				e.stopImmediatePropagation();
				runningTime=_getTime();
				var offset=mTS_wrapper.offset(),y=_coordinates(e)[0]-offset.top,x=_coordinates(e)[1]-offset.left,
					easing="linearOut";
				touchMoveY.push(y);
				touchMoveX.push(x);
				touchIntent[2]=Math.abs(_coordinates(e)[0]-touchIntent[0]); touchIntent[3]=Math.abs(_coordinates(e)[1]-touchIntent[1]);
				if(d.overflowed[0]){
					var limit=mTS_wrapper.height()-mTS_container.height(),
						prevent=((dragY-y)>0 && (y-dragY)>limit && (touchIntent[3]*2<touchIntent[2]));
				}
				if(d.overflowed[1]){
					var limitX=mTS_wrapper.width()-mTS_container.width(),
						preventX=((dragX-x)>0 && (x-dragX)>limitX && (touchIntent[2]*2<touchIntent[3]));
				}
				if(prevent || preventX){e.preventDefault();}else{$this.addClass("mTS_touch_action");} /* prevent native document scrolling */
				amount=o.axis==="yx" ? [(dragY-y),(dragX-x)] : o.axis==="x" ? [null,(dragX-x)] : [(dragY-y),null];
				mTS_container[0].idleTimer=250;
				if(d.overflowed[0]){_drag(amount[0],durA,easing,"y","all");}
				if(d.overflowed[1]){_drag(amount[1],durA,easing,"x",overwrite);}
			});
			mTS_wrapper.bind("touchstart."+namespace+" pointerdown."+namespace+" MSPointerDown."+namespace,function(e){
				if(!_pointerTouch(e) || touchActive){return;}
				e.stopImmediatePropagation();
				touchi=true;
				_stop($this);
				startTime=_getTime();
				var offset=mTS_wrapper.offset();
				touchStartY=_coordinates(e)[0]-offset.top;
				touchStartX=_coordinates(e)[1]-offset.left;
				touchMoveY=[]; touchMoveX=[];
			}).bind("touchend."+namespace+" pointerup."+namespace+" MSPointerUp."+namespace,function(e){
				if(!_pointerTouch(e) || touchActive){return;}
				e.stopImmediatePropagation();
				endTime=_getTime();
				var offset=mTS_wrapper.offset(),y=_coordinates(e)[0]-offset.top,x=_coordinates(e)[1]-offset.left;
				if((endTime-runningTime)>30){return;}
				speed=1000/(endTime-startTime);
				var easing="easeOut",slow=speed<2.5,
					diff=slow ? [touchMoveY[touchMoveY.length-2],touchMoveX[touchMoveX.length-2]] : [0,0];
				distance=slow ? [(y-diff[0]),(x-diff[1])] : [y-touchStartY,x-touchStartX];
				var absDistance=[Math.abs(distance[0]),Math.abs(distance[1])];
				speed=slow ? [Math.abs(distance[0]/4),Math.abs(distance[1]/4)] : [speed,speed];
				var a=[
					Math.abs(mTS_container[0].offsetTop)-(distance[0]*_m((absDistance[0]/speed[0]),speed[0])),
					Math.abs(mTS_container[0].offsetLeft)-(distance[1]*_m((absDistance[1]/speed[1]),speed[1]))
				];
				amount=o.axis==="yx" ? [a[0],a[1]] : o.axis==="x" ? [null,a[1]] : [a[0],null];
				durB=[(absDistance[0]*4)+(o.speed*60),(absDistance[1]*4)+(o.speed*60)];
				var md=parseInt(o.contentTouchScroll) || 0; /* absolute minimum distance required */
				amount[0]=absDistance[0]>md ? amount[0] : 0;
				amount[1]=absDistance[1]>md ? amount[1] : 0;
				if(d.overflowed[0]){_drag(amount[0],durB[0],easing,"y",overwrite);}
				if(d.overflowed[1]){_drag(amount[1],durB[1],easing,"x",overwrite);}
			});
			function _m(ds,s){
				var r=[s*1.5,s*2,s/1.5,s/2];
				if(ds>90){
					return s>4 ? r[0] : r[3];
				}else if(ds>60){
					return s>3 ? r[3] : r[2];
				}else if(ds>30){
					return s>8 ? r[1] : s>6 ? r[0] : s>4 ? s : r[2];
				}else{
					return s>8 ? s : r[3];
				}
			}
			function _drag(amount,dur,easing,dir,overwrite){
				if(!amount){return;}
				_scrollTo($this,-amount.toString(),{dur:dur,easing:easing,dir:dir,overwrite:overwrite});
			}
		},
		/* -------------------- */
		
		
		/* 
		HOVER PRECISE EVENT
		scrolls content via cursor movement
		*/
		_hoverPrecise=function(){
			var $this=$(this),d=$this.data(pluginPfx),o=d.opt,
				namespace=pluginPfx+"_"+d.idx,
				mTS_wrapper=$("#mTS_"+d.idx),
				mTS_container=$("#mTS_"+d.idx+"_container"),
				evt=window.navigator.pointerEnabled ? "pointermove" : window.navigator.msPointerEnabled ? "MSPointerMove" : "mousemove",
				cursor,dest,to;
			mTS_wrapper.bind(evt+"."+namespace,function(e){
				if(_inputType(e.originalEvent || e)==="touch" || (!d.overflowed[0] && !d.overflowed[1])){return;}
				e.preventDefault();
				var wrapperHeight=mTS_wrapper.height(),containerHeight=mTS_container.height(),
					wrapperWidth=mTS_wrapper.width(),containerWidth=mTS_container.width(),
					speed=((containerWidth/wrapperWidth)*7000)/(o.speed || 1);
				cursor=[_coordinates(e)[0]-mTS_wrapper.offset().top,_coordinates(e)[1]-mTS_wrapper.offset().left];
				dest=[cursor[0]/mTS_wrapper.height(),cursor[1]/mTS_wrapper.width()];
				to=[Math.round(-((containerHeight-wrapperHeight)*(dest[0]))),Math.round(-((containerWidth-wrapperWidth)*(dest[1])))];
				if(o.axis!=="x" && d.overflowed[0]){
					_scrollTo($this,to[0].toString(),{dir:"y",dur:speed,easing:"easeOut"});
				}
				if(o.axis!=="y" && d.overflowed[1]){
					_scrollTo($this,to[1].toString(),{dir:"x",dur:speed,easing:"easeOut"});
				}
			});
		},
		/* -------------------- */
		
		
		/* 
		HOVER EVENT
		scrolls content via cursor movement
		*/
		_hover=function(){
			var $this=$(this),d=$this.data(pluginPfx),o=d.opt,
				namespace=pluginPfx+"_"+d.idx,
				mTS_wrapper=$("#mTS_"+d.idx),
				mTS_container=$("#mTS_"+d.idx+"_container"),
				evt=window.navigator.pointerEnabled ? ["pointerover","pointermove","pointerout"] : 
					window.navigator.msPointerEnabled ? ["MSPointerOver","MSPointerMove","MSPointerOut"] : 
					["mouseenter","mousemove","mouseleave"],
				rAF,cursor,dest,to,fps,delay=(!window.requestAnimationFrame) ? 17 : 0,
				speed=o.speed,pct=parseInt(o.type.split("hover-")[1]) || 1,idle=speed*pct/100,
				_pause=[0,0];
			mTS_wrapper.bind(evt[0]+"."+namespace,function(e){
				if(_inputType(e.originalEvent || e)==="touch" || (!d.overflowed[0] && !d.overflowed[1])){return;}
				_on();
			}).bind(evt[1]+"."+namespace,function(e){
				if(_inputType(e.originalEvent || e)==="touch" || (!d.overflowed[0] && !d.overflowed[1])){return;}
				cursor=[_coordinates(e)[0]-mTS_wrapper.offset().top,_coordinates(e)[1]-mTS_wrapper.offset().left];
				dest=[Math.round((Math.cos((cursor[0]/mTS_wrapper.height())*Math.PI))*speed),Math.round((Math.cos((cursor[1]/mTS_wrapper.width())*Math.PI))*speed)];
				dest[0]=dest[0]<=-idle ? dest[0]+=idle : dest[0]>=idle ? dest[0]-=idle : dest[0]=0;
				dest[1]=dest[1]<=-idle ? dest[1]+=idle : dest[1]>=idle ? dest[1]-=idle : dest[1]=0;
				_pause=[0,0];
			}).bind(evt[2]+"."+namespace,function(e){
				if(_inputType(e.originalEvent || e)==="touch" || (!d.overflowed[0] && !d.overflowed[1])){return;}
				_off();
			});
			function _on(){
				if(mTS_wrapper[0].rAF){return;}
				rAF=(!window.requestAnimationFrame) ? function(f){return setTimeout(f,17);} : window.requestAnimationFrame;
				mTS_wrapper[0].rAF=rAF(_anim);
			}
			function _off(){
				if(mTS_wrapper[0].rAF==null){return;}
				if(!window.requestAnimationFrame){
					clearTimeout(mTS_wrapper[0].rAF);
				}else{
					window.cancelAnimationFrame(mTS_wrapper[0].rAF);
				}
				clearTimeout(fps);
				mTS_wrapper[0].rAF=null;
			}
			function _anim(){
				if(touchi){return;} /* this is for android native browser (at least for version 4.1.2) */
				to=[dest[0]+mTS_container[0].offsetTop,dest[1]+mTS_container[0].offsetLeft];
				var limit=[mTS_wrapper.height()-mTS_container.height(),mTS_wrapper.width()-mTS_container.width()];
				if(o.axis!=="x" && d.overflowed[0]){
					to[0]=to[0]>0 ? 0 : to[0]<limit[0] ? limit[0] : to[0];
					if(dest[0] && !_pause[0]){
						_scrollTo($this,to[0],{dir:"y",dur:0,easing:"linear"});
					}
					if(to[0]>=0 || to[0]<=limit[0]){
						_pause[0]=1;
					}
				}
				if(o.axis!=="y" && d.overflowed[1]){
					to[1]=to[1]>0 ? 0 : to[1]<limit[1] ? limit[1] : to[1];
					if(dest[1] && !_pause[1]){
						_scrollTo($this,to[1],{dir:"x",dur:0,easing:"linear"});
					}
					if(to[1]>=0 || to[1]<=limit[1]){
						_pause[1]=1;
					}
				}
				fps=setTimeout(function(){mTS_wrapper[0].rAF=rAF(_anim);},delay);					
			}
		},
		/* -------------------- */
		
		
		/* 
		CLICK EVENT
		scrolls content via scrolling buttons
		*/
		_click=function(){
			var $this=$(this),d=$this.data(pluginPfx),o=d.opt,
				namespace=pluginPfx+"_"+d.idx,
				mTS_wrapper=$("#mTS_"+d.idx),
				mTS_container=$("#mTS_"+d.idx+"_container"),
				mTS_buttons=[$("#mTS_"+d.idx+"_buttonUp"),$("#mTS_"+d.idx+"_buttonDown"),$("#mTS_"+d.idx+"_buttonLeft"),$("#mTS_"+d.idx+"_buttonRight")],
				sel=mTS_buttons[0].add(mTS_buttons[1]).add(mTS_buttons[2]).add(mTS_buttons[3]);
			sel.bind("click."+namespace,function(e){
				if(!_mouseBtnLeft(e) || (!d.overflowed[0] && !d.overflowed[1])){return;}
				e.preventDefault();
				if(d.tweenRunning){return;}
				if(o.axis!=="x" && d.overflowed[0]){
					var h=mTS_wrapper.height(),dir=o.type==="click-thumb" ? 0 : $(this).hasClass("mTSButtonUp") ? "+=" : $(this).hasClass("mTSButtonDown") ? "-=" : 0;
					if(o.type!=="click-thumb"){
						var pct=parseInt(o.type.split("click-")[1]) || 1,amount=dir ? [dir+(h*pct/100),null] : 0;
					}else{
						var firstThumb=_firstLast.call($this[0])[0],lastThumb=_firstLast.call($this[0])[1];
						if($(this).hasClass("mTSButtonDown")){
							var	amount=lastThumb ? (lastThumb[0].offsetTop-parseInt(lastThumb.css("margin-bottom")))-h : 989999;
						}else if($(this).hasClass("mTSButtonUp")){
							var	amount=firstThumb ? firstThumb[0].offsetTop-parseInt(firstThumb.css("margin-top")) : 0;
							if(mTS_container[0].offsetTop===0){return;}
						}
					}
				}
				if(o.axis!=="y" && d.overflowed[1]){
					var w=mTS_wrapper.width(),dir=o.type==="click-thumb" ? 0 : $(this).hasClass("mTSButtonLeft") ? "+=" : $(this).hasClass("mTSButtonRight") ? "-=" : 0;
					if(o.type!=="click-thumb"){
						var pct=parseInt(o.type.split("click-")[1]) || 1,amount=dir ? [null,dir+(w*pct/100)] : amount;
					}else{
						var firstThumb=_firstLast.call($this[0])[2],lastThumb=_firstLast.call($this[0])[3];
						if($(this).hasClass("mTSButtonRight")){
							var	amount=lastThumb ? (lastThumb[0].offsetLeft-parseInt(lastThumb.css("margin-right")))-w : 989999;
						}else if($(this).hasClass("mTSButtonLeft")){
							var	amount=firstThumb ? firstThumb[0].offsetLeft-parseInt(firstThumb.css("margin-left")) : 0;
							if(mTS_container[0].offsetLeft===0){return;}
						}
					}
				}
				if(amount!==null){methods.scrollTo.call($this[0],amount,{duration:0});}
			});
		},
		/* -------------------- */
		
		
		/* returns the first and last items within the viewport */
		_firstLast=function(){
			var $this=$(this),d=$this.data(pluginPfx),o=d.opt,
				mTS_container=$("#mTS_"+d.idx+"_container"),
				mTS_wrapper=$("#mTS_"+d.idx),
				mTS_item=mTS_container.find(".mTSThumbContainer"),
				f,l,fx,lx;
			mTS_item.each(function(){
				var el=$(this),
					pos=[
						Math.round((el.offset().top-mTS_container.offset().top)+mTS_container[0].offsetTop),
						Math.round((el.offset().left-mTS_container.offset().left)+mTS_container[0].offsetLeft)
					];
				if(pos[0]<=0-parseInt(el.css("margin-top"))){
					f=pos[0]===0 ? mTS_item.eq(el.index()-1) : mTS_item.eq(el.index());
				}else if(pos[0]<=mTS_wrapper.height()+parseInt(el.css("margin-bottom"))){
					var i=mTS_item.eq(el.index()+1);
					l=i.length ? i : null;
				}
				if(pos[1]<=0-parseInt(el.css("margin-left"))){
					fx=pos[1]===0 ? mTS_item.eq(el.index()-1) : mTS_item.eq(el.index());
				}else if(pos[1]<=mTS_wrapper.width()+parseInt(el.css("margin-right"))){
					var ix=mTS_item.eq(el.index()+1);
					lx=ix.length ? ix : null;
				}
			});
			return [f,l,fx,lx];
		},
		/* -------------------- */
		
		
		/* returns a yx array from value */
		_arr=function(val){
			var o=$(this).data(pluginPfx).opt,vals=[];
			if(typeof val==="function"){val=val();} /* check if the value is a single anonymous function */
			/* check if value is object or array, its length and create an array with yx values */
			if(!(val instanceof Array)){ /* object value (e.g. {y:"100",x:"100"}, 100 etc.) */
				vals[0]=val.y ? val.y : val.x || o.axis==="x" ? null : val;
				vals[1]=val.x ? val.x : val.y || o.axis==="y" ? null : val;
			}else{ /* array value (e.g. [100,100]) */
				vals=val.length>1 ? [val[0],val[1]] : o.axis==="x" ? [null,val[0]] : [val[0],null];
			}
			/* check if array values are anonymous functions */
			if(typeof vals[0]==="function"){vals[0]=vals[0]();}
			if(typeof vals[1]==="function"){vals[1]=vals[1]();}
			return vals;
		},
		/* -------------------- */
		
		
		/* translates values (e.g. "top", 100, "100px", "#id") to actual scroll-to positions */
		_to=function(val,dir){
			if(val==null || typeof val=="undefined"){return;}
			var $this=$(this),d=$this.data(pluginPfx),o=d.opt,
				mTS_wrapper=$("#mTS_"+d.idx),
				mTS_container=$("#mTS_"+d.idx+"_container"),
				t=typeof val;
			if(!dir){dir=o.axis==="x" ? "x" : "y";}
			var contentLength=dir==="x" ? mTS_container.width() : mTS_container.height(),
				contentOffset=dir==="x" ? mTS_container.offset().left : mTS_container.offset().top,
				contentPos=dir==="x" ? mTS_container[0].offsetLeft : mTS_container[0].offsetTop,
				cssProp=dir==="x" ? "left" : "top";
			switch(t){
				case "function": /* this currently is not used. Consider removing it */
					return val();
					break;
				case "object":
					if(val.nodeType){ /* DOM */
						var objOffset=dir==="x" ? $(val).offset().left : $(val).offset().top;
					}else if(val.jquery){ /* jquery object */
						if(!val.length){return;}
						var objOffset=dir==="x" ? val.offset().left : val.offset().top;
					}
					return objOffset-contentOffset;
					break;
				case "string": case "number":
					if(_isNumeric(val)){ /* numeric value */
						return Math.abs(val);
					}else if(val.indexOf("%")!==-1){ /* percentage value */
						return Math.abs(contentLength*parseInt(val)/100);
					}else if(val.indexOf("-=")!==-1){ /* decrease value */
						return Math.abs(contentPos-parseInt(val.split("-=")[1]));
					}else if(val.indexOf("+=")!==-1){ /* inrease value */
						var p=(contentPos+parseInt(val.split("+=")[1]));
						return p>=0 ? 0 : Math.abs(p);
					}else if(val.indexOf("px")!==-1 && _isNumeric(val.split("px")[0])){ /* pixels string value (e.g. "100px") */
						return Math.abs(val.split("px")[0]);
					}else{
						if(val==="top" || val==="left"){ /* special strings */
							return 0;
						}else if(val==="bottom"){
							return Math.abs(mTS_wrapper.height()-mTS_container.height());
						}else if(val==="right"){
							return Math.abs(mTS_wrapper.width()-mTS_container.width());
						}else if(val==="first" || val==="last"){
							var obj=mTS_container.find(":"+val),
								objOffset=dir==="x" ? $(obj).offset().left : $(obj).offset().top;
							return objOffset-contentOffset;
						}else{
							if($(val).length){ /* jquery selector */
								var objOffset=dir==="x" ? $(val).offset().left : $(val).offset().top;
								return objOffset-contentOffset;
							}else{ /* other values (e.g. "100em") */
								mTS_container.css(cssProp,val);
								methods.update.call(null,$this[0]);
								return;
							}
						}
					}
					break;
			}
		},
		/* -------------------- */
		
		
		/* calls the update method automatically */
		_autoUpdate=function(rem){
			var $this=$(this),d=$this.data(pluginPfx),o=d.opt,
				mTS_wrapper=$("#mTS_"+d.idx),
				mTS_container=$("#mTS_"+d.idx+"_container");
			if(rem){
				/* 
				removes autoUpdate timer 
				usage: functions._autoUpdate.call(this,"remove");
				*/
				clearTimeout(mTS_container[0].autoUpdate);
				_delete(mTS_container[0],"autoUpdate");
				return;
			}
			var	oldSelSize=sizesSum(),newSelSize,
				os=[mTS_container.height(),mTS_container.width(),mTS_wrapper.height(),mTS_wrapper.width(),$this.height(),$this.width()],ns,
				oldImgsLen=imgSum(),newImgsLen;
			upd();
			function upd(){
				clearTimeout(mTS_container[0].autoUpdate);
				if($this.parents("html").length===0){
					/* check element in dom tree */
					$this=null;
					return;
				}
				mTS_container[0].autoUpdate=setTimeout(function(){
					/* update on specific selector(s) length and size change */
					if(o.advanced.updateOnSelectorChange){
						newSelSize=sizesSum();
						if(newSelSize!==oldSelSize){
							doUpd();
							oldSelSize=newSelSize;
							return;
						}
					}
					/* update on main element and scroller size changes */
					if(o.advanced.updateOnContentResize){
						ns=[mTS_container.height(),mTS_container.width(),mTS_wrapper.height(),mTS_wrapper.width(),$this.height(),$this.width()];
						if(ns[0]!==os[0] || ns[1]!==os[1] || ns[2]!==os[2] || ns[3]!==os[3] || ns[4]!==os[4] || ns[5]!==os[5]){
							doUpd();
							os=ns;
						}
					}
					/* update on image load */
					if(o.advanced.updateOnImageLoad){
						newImgsLen=imgSum();
						if(newImgsLen!==oldImgsLen){
							mTS_container.find("img").each(function(){
								imgLoader(this.src);
							});
							oldImgsLen=newImgsLen;
						}
					}
					if(o.advanced.updateOnSelectorChange || o.advanced.updateOnContentResize || o.advanced.updateOnImageLoad){upd();}
				},60);
			}
			/* returns images amount */
			function imgSum(){
				var total=0
				if(o.advanced.updateOnImageLoad){total=mTS_container.find("img").length;}
				return total;
			}
			/* a tiny image loader */
			function imgLoader(src){
				var img=new Image();
				function createDelegate(contextObject,delegateMethod){
					return function(){return delegateMethod.apply(contextObject,arguments);}
				}
				function imgOnLoad(){
					this.onload=null;
					doUpd();
				}
				img.onload=createDelegate(img,imgOnLoad);
				img.src=src;
			}
			/* returns the total height and width sum of all elements matching the selector */
			function sizesSum(){
				if(o.advanced.updateOnSelectorChange===true){o.advanced.updateOnSelectorChange="*";}
				var total=0,sel=mTS_container.find(o.advanced.updateOnSelectorChange);
				if(o.advanced.updateOnSelectorChange && sel.length>0){sel.each(function(){total+=$(this).height()+$(this).width();});}
				return total;
			}
			/* calls the update method */
			function doUpd(){
				clearTimeout(mTS_container[0].autoUpdate); 
				methods.update.call(null,$this[0]);
			}
		},
		/* -------------------- */
		
		
		/* stops content animations */
		_stop=function(el){
			var d=el.data(pluginPfx),
				sel=$("#mTS_"+d.idx+"_container");
			sel.each(function(){
				_stopTween.call(this);
			});
		},
		/* -------------------- */
		
		
		/* 
		ANIMATES CONTENT 
		This is where the actual scrolling happens
		*/
		_scrollTo=function(el,to,options){
			var d=el.data(pluginPfx),o=d.opt,
				defaults={
					trigger:"internal",
					dir:"y",
					easing:"easeOut",
					dur:o.speed*60,
					overwrite:"all",
					callbacks:true,
					onStart:true,
					onUpdate:true,
					onComplete:true
				},
				options=$.extend(defaults,options),
				mTS_wrapper=$("#mTS_"+d.idx),
				mTS_container=$("#mTS_"+d.idx+"_container"),
				totalScrollOffsets=o.callbacks.onTotalScrollOffset ? _arr.call(el,o.callbacks.onTotalScrollOffset) : [0,0],
				totalScrollBackOffsets=o.callbacks.onTotalScrollBackOffset ? _arr.call(el,o.callbacks.onTotalScrollBackOffset) : [0,0];
			d.trigger=options.trigger;
			if(mTS_wrapper.scrollTop()!==0 || mTS_wrapper.scrollLeft()!==0){ /* always reset scrollTop/Left */
				mTS_wrapper.scrollTop(0).scrollLeft(0);
			}
			switch(options.dir){
				case "x":
					var property="left",
						contentPos=mTS_container[0].offsetLeft,
						limit=mTS_wrapper.width()-mTS_container.width(),
						scrollTo=to,
						tso=totalScrollOffsets[1],
						tsbo=totalScrollBackOffsets[1],
						totalScrollOffset=tso>0 ? tso : 0,
						totalScrollBackOffset=tsbo>0 ? tsbo : 0;
					break;
				case "y":
					var property="top",
						contentPos=mTS_container[0].offsetTop,
						limit=mTS_wrapper.height()-mTS_container.height(),
						scrollTo=to,
						tso=totalScrollOffsets[0],
						tsbo=totalScrollBackOffsets[0],
						totalScrollOffset=tso>0 ? tso : 0,
						totalScrollBackOffset=tsbo>0 ? tsbo : 0;
					break;
			}
			if(scrollTo>=0){
				scrollTo=0;
				_buttonsVisibility.call(el,false,1,options.dir); /* show/hide buttons */
			}else if(scrollTo<=limit){
				scrollTo=limit;
				_buttonsVisibility.call(el,false,2,options.dir); /* show/hide buttons */
			}else{
				scrollTo=scrollTo;
				_buttonsVisibility.call(el,false,0,options.dir); /* show/hide buttons */
			}
			if(!el[0].mts){ 
				_mts(); /* init mts object (once) to make it available before callbacks */
				if(_cb("onInit")){o.callbacks.onInit.call(el[0]);} /* callbacks: onInit */
			}
			clearTimeout(mTS_container[0].onCompleteTimeout);
			if(!d.tweenRunning && ((contentPos===0 && scrollTo>=0) || (contentPos===limit && scrollTo<=limit))){return;}
			_tweenTo(mTS_container[0],property,Math.round(scrollTo),options.dur,options.easing,options.overwrite,{
				onStart:function(){
					if(options.callbacks && options.onStart && !d.tweenRunning){
						/* callbacks: onScrollStart */
						if(_cb("onScrollStart")){_mts(); o.callbacks.onScrollStart.call(el[0]);}
						d.tweenRunning=true;
						d.cbOffsets=_cbOffsets();
					}
				},onUpdate:function(){
					if(options.callbacks && options.onUpdate){
						/* callbacks: whileScrolling */
						if(_cb("whileScrolling")){_mts(); o.callbacks.whileScrolling.call(el[0]);}
					}
				},onComplete:function(){
					if(options.callbacks && options.onComplete){
						if(o.axis==="yx"){clearTimeout(mTS_container[0].onCompleteTimeout);}
						var t=mTS_container[0].idleTimer || 0;
						mTS_container[0].onCompleteTimeout=setTimeout(function(){
							/* callbacks: onScroll, onTotalScroll, onTotalScrollBack */
							if(_cb("onScroll")){_mts(); o.callbacks.onScroll.call(el[0]);}
							if(_cb("onTotalScroll") && scrollTo<=limit+totalScrollOffset && d.cbOffsets[0]){_mts(); o.callbacks.onTotalScroll.call(el[0]);}
							if(_cb("onTotalScrollBack") && scrollTo>=-totalScrollBackOffset && d.cbOffsets[1]){_mts(); o.callbacks.onTotalScrollBack.call(el[0]);}
							d.tweenRunning=false;
							mTS_container[0].idleTimer=0;
						},t);
					}
				}
			});
			/* checks if callback function exists */
			function _cb(cb){
				return d && o.callbacks[cb] && typeof o.callbacks[cb]==="function";
			}
			/* checks whether callback offsets always trigger */
			function _cbOffsets(){
				return [o.callbacks.alwaysTriggerOffsets || contentPos>=limit+tso,o.callbacks.alwaysTriggerOffsets || contentPos<=-tsbo];
			}
			/* 
			populates object with useful values for the user 
			values: 
				content: this.mts.content
				content top position: this.mts.top 
				content left position: this.mts.left 
				scrolling y percentage: this.mts.topPct 
				scrolling x percentage: this.mts.leftPct 
				scrolling direction: this.mts.direction
			*/
			function _mts(){
				var cp=[mTS_container[0].offsetTop,mTS_container[0].offsetLeft], /* content position */
					cl=[mTS_container.height(),mTS_container.width()], /* content length */
					pl=[mTS_wrapper.height(),mTS_wrapper.width()]; /* content parent length */
				el[0].mts={
					content:mTS_container, /* original content wrapper as jquery object */
					top:cp[0],left:cp[1],
					topPct:Math.round((100*Math.abs(cp[0]))/(Math.abs(cl[0])-pl[0])),leftPct:Math.round((100*Math.abs(cp[1]))/(Math.abs(cl[1])-pl[1])),
					direction:options.dir
				};
				/* 
				this refers to the original element containing the scroller
				usage: this.mts.top, this.mts.leftPct etc. 
				*/
			}
		},
		/* -------------------- */
		
		
		/* 
		CUSTOM JAVASCRIPT ANIMATION TWEEN 
		Lighter and faster than jquery animate() and css transitions 
		Animates top/left properties and includes easings 
		*/
		_tweenTo=function(el,prop,to,duration,easing,overwrite,callbacks){
			if(!el._mTween){el._mTween={top:{},left:{}};}
			var callbacks=callbacks || {},
				onStart=callbacks.onStart || function(){},onUpdate=callbacks.onUpdate || function(){},onComplete=callbacks.onComplete || function(){},
				startTime=_getTime(),_delay,progress=0,from=el.offsetTop,elStyle=el.style,_request,tobj=el._mTween[prop];
			if(prop==="left"){from=el.offsetLeft;}
			var diff=to-from;
			tobj.stop=0;
			if(overwrite!=="none"){_cancelTween();}
			_startTween();
			function _step(){
				if(tobj.stop){return;}
				if(!progress){onStart.call();}
				progress=_getTime()-startTime;
				_tween();
				if(progress>=tobj.time){
					tobj.time=(progress>tobj.time) ? progress+_delay-(progress-tobj.time) : progress+_delay-1;
					if(tobj.time<progress+1){tobj.time=progress+1;}
				}
				if(tobj.time<duration){tobj.id=_request(_step);}else{onComplete.call();}
			}
			function _tween(){
				if(duration>0){
					tobj.currVal=_ease(tobj.time,from,diff,duration,easing);
					elStyle[prop]=Math.round(tobj.currVal)+"px";
				}else{
					elStyle[prop]=to+"px";
				}
				onUpdate.call();
			}
			function _startTween(){
				_delay=1000/60;
				tobj.time=progress+_delay;
				_request=(!window.requestAnimationFrame) ? function(f){_tween(); return setTimeout(f,0.01);} : window.requestAnimationFrame;
				tobj.id=_request(_step);
			}
			function _cancelTween(){
				if(tobj.id==null){return;}
				if(!window.requestAnimationFrame){clearTimeout(tobj.id);
				}else{window.cancelAnimationFrame(tobj.id);}
				tobj.id=null;
			}
			function _ease(t,b,c,d,type){
				switch(type){
					case "linear":
						return c*t/d + b;
						break;
					case "linearOut":
						t/=d; t--; return c * Math.sqrt(1 - t*t) + b;
						break;
					case "easeInOutSmooth":
						t/=d/2;
						if(t<1) return c/2*t*t + b;
						t--;
						return -c/2 * (t*(t-2) - 1) + b;
						break;
					case "easeInOutStrong":
						t/=d/2;
						if(t<1) return c/2 * Math.pow( 2, 10 * (t - 1) ) + b;
						t--;
						return c/2 * ( -Math.pow( 2, -10 * t) + 2 ) + b;
						break;
					case "easeInOut":
						t/=d/2;
						if(t<1) return c/2*t*t*t + b;
						t-=2;
						return c/2*(t*t*t + 2) + b;
						break;
					case "easeOutSmooth":
						t/=d; t--;
						return -c * (t*t*t*t - 1) + b;
						break;
					case "easeOutStrong":
						return c * ( -Math.pow( 2, -10 * t/d ) + 1 ) + b;
						break;
					case "easeOut": default:
						var ts=(t/=d)*t,tc=ts*t;
						return b+c*(0.499999999999997*tc*ts + -2.5*ts*ts + 5.5*tc + -6.5*ts + 4*t);
				}
			}
		},
		/* -------------------- */
		
		
		/* returns current time */
		_getTime=function(){
			if(window.performance && window.performance.now){
				return window.performance.now();
			}else{
				if(window.performance && window.performance.webkitNow){
					return window.performance.webkitNow();
				}else{
					if(Date.now){return Date.now();}else{return new Date().getTime();}
				}
			}
		},
		/* -------------------- */
		
		
		/* stops a tween */
		_stopTween=function(){
			var el=this;
			if(!el._mTween){el._mTween={top:{},left:{}};}
			var props=["top","left"];
			for(var i=0; i<props.length; i++){
				var prop=props[i];
				if(el._mTween[prop].id){
					if(!window.requestAnimationFrame){clearTimeout(el._mTween[prop].id);
					}else{window.cancelAnimationFrame(el._mTween[prop].id);}
					el._mTween[prop].id=null;
					el._mTween[prop].stop=1;
				}
			}
		},
		/* -------------------- */
		
		
		/* deletes a property (avoiding the exception thrown by IE) */
		_delete=function(c,m){
			try{delete c[m];}catch(e){c[m]=null;}
		},
		/* -------------------- */
		
		
		/* detects left mouse button */
		_mouseBtnLeft=function(e){
			return !(e.which && e.which!==1);
		},
		/* -------------------- */
		
		
		/* detects if pointer type event is touch */
		_pointerTouch=function(e){
			var t=e.originalEvent.pointerType;
			return !(t && t!=="touch" && t!==2);
		},
		/* -------------------- */
		
		
		/* checks if value is numeric */
		_isNumeric=function(val){
			return !isNaN(parseFloat(val)) && isFinite(val);
		};
		/* -------------------- */
		
	
	
	
	
	/* 
	----------------------------------------
	PLUGIN SETUP 
	----------------------------------------
	*/
	
	/* plugin constructor functions */
	$.fn[pluginNS]=function(method){ /* usage: $(selector).fn(); */
		if(methods[method]){
			return methods[method].apply(this,Array.prototype.slice.call(arguments,1));
		}else if(typeof method==="object" || !method){
			return methods.init.apply(this,arguments);
		}else{
			$.error("Method "+method+" does not exist");
		}
	};
	$[pluginNS]=function(method){ /* usage: $.fn(); */
		if(methods[method]){
			return methods[method].apply(this,Array.prototype.slice.call(arguments,1));
		}else if(typeof method==="object" || !method){
			return methods.init.apply(this,arguments);
		}else{
			$.error("Method "+method+" does not exist");
		}
	};
	
	/* 
	allow setting plugin default options. 
	usage: $.mThumbnailScroller.defaults.speed=15; 
	to apply any changed default options on default selectors (below), use inside document ready fn 
	e.g.: $(document).ready(function(){ $.mThumbnailScroller.defaults.speed=15; });
	*/
	$[pluginNS].defaults=defaults;
	
	/* 
	add window object (window.mThumbnailScroller) 
	usage: if(window.mThumbnailScroller){console.log("plugin script loaded");}
	*/
	window[pluginNS]=true;
	
	/* call plugin fn automatically on default selector with HTML data attributes */
	$(window).load(function(){
		var elems=$(defaultSelector),instances=[];
		if(elems.length){
			elems.each(function(){
				var elem=$(this),axis=elem.data("mts-axis") || defaults.axis,type=elem.data("mts-type") || defaults.type,theme=elem.data("mts-theme") || defaults.theme,
					elemClass="auto-"+pluginPfx+"-"+axis+"-"+type+"-"+theme,instance=[elemClass,axis,type];
				elem.addClass(elemClass);
				if($.inArray(elemClass,instances)===-1){
					instances.push(instance);
				}
			});
			for(var i=0; i<instances.length; i++){
				$("."+instances[i][0])[pluginNS]({axis:instances[i][1],type:instances[i][2]}); 
			}
		}
	});
	
})(jQuery,window,document);

(function($){$.extend({tablesorter:new
function(){var parsers=[],widgets=[];this.defaults={cssHeader:"header",cssAsc:"headerSortUp",cssDesc:"headerSortDown",cssChildRow:"expand-child",sortInitialOrder:"asc",sortMultiSortKey:"shiftKey",sortForce:null,sortAppend:null,sortLocaleCompare:true,textExtraction:"simple",parsers:{},widgets:[],widgetZebra:{css:["even","odd"]},headers:{},widthFixed:false,cancelSelection:true,sortList:[],headerList:[],dateFormat:"us",decimal:'/\.|\,/g',onRenderHeader:null,selectorHeaders:'thead th',debug:false};function benchmark(s,d){log(s+","+(new Date().getTime()-d.getTime())+"ms");}this.benchmark=benchmark;function log(s){if(typeof console!="undefined"&&typeof console.debug!="undefined"){console.log(s);}else{alert(s);}}function buildParserCache(table,$headers){if(table.config.debug){var parsersDebug="";}if(table.tBodies.length==0)return;var rows=table.tBodies[0].rows;if(rows[0]){var list=[],cells=rows[0].cells,l=cells.length;for(var i=0;i<l;i++){var p=false;if($.metadata&&($($headers[i]).metadata()&&$($headers[i]).metadata().sorter)){p=getParserById($($headers[i]).metadata().sorter);}else if((table.config.headers[i]&&table.config.headers[i].sorter)){p=getParserById(table.config.headers[i].sorter);}if(!p){p=detectParserForColumn(table,rows,-1,i);}if(table.config.debug){parsersDebug+="column:"+i+" parser:"+p.id+"\n";}list.push(p);}}if(table.config.debug){log(parsersDebug);}return list;};function detectParserForColumn(table,rows,rowIndex,cellIndex){var l=parsers.length,node=false,nodeValue=false,keepLooking=true;while(nodeValue==''&&keepLooking){rowIndex++;if(rows[rowIndex]){node=getNodeFromRowAndCellIndex(rows,rowIndex,cellIndex);nodeValue=trimAndGetNodeText(table.config,node);if(table.config.debug){log('Checking if value was empty on row:'+rowIndex);}}else{keepLooking=false;}}for(var i=1;i<l;i++){if(parsers[i].is(nodeValue,table,node)){return parsers[i];}}return parsers[0];}function getNodeFromRowAndCellIndex(rows,rowIndex,cellIndex){return rows[rowIndex].cells[cellIndex];}function trimAndGetNodeText(config,node){return $.trim(getElementText(config,node));}function getParserById(name){var l=parsers.length;for(var i=0;i<l;i++){if(parsers[i].id.toLowerCase()==name.toLowerCase()){return parsers[i];}}return false;}function buildCache(table){if(table.config.debug){var cacheTime=new Date();}var totalRows=(table.tBodies[0]&&table.tBodies[0].rows.length)||0,totalCells=(table.tBodies[0].rows[0]&&table.tBodies[0].rows[0].cells.length)||0,parsers=table.config.parsers,cache={row:[],normalized:[]};for(var i=0;i<totalRows;++i){var c=$(table.tBodies[0].rows[i]),cols=[];if(c.hasClass(table.config.cssChildRow)){cache.row[cache.row.length-1]=cache.row[cache.row.length-1].add(c);continue;}cache.row.push(c);for(var j=0;j<totalCells;++j){cols.push(parsers[j].format(getElementText(table.config,c[0].cells[j]),table,c[0].cells[j]));}cols.push(cache.normalized.length);cache.normalized.push(cols);cols=null;};if(table.config.debug){benchmark("Building cache for "+totalRows+" rows:",cacheTime);}return cache;};function getElementText(config,node){var text="";if(!node)return"";if(!config.supportsTextContent)config.supportsTextContent=node.textContent||false;if(config.textExtraction=="simple"){if(config.supportsTextContent){text=node.textContent;}else{if(node.childNodes[0]&&node.childNodes[0].hasChildNodes()){text=node.childNodes[0].innerHTML;}else{text=node.innerHTML;}}}else{if(typeof(config.textExtraction)=="function"){text=config.textExtraction(node);}else{text=$(node).text();}}return text;}function appendToTable(table,cache){if(table.config.debug){var appendTime=new Date()}var c=cache,r=c.row,n=c.normalized,totalRows=n.length,checkCell=(n[0].length-1),tableBody=$(table.tBodies[0]),rows=[];for(var i=0;i<totalRows;i++){var pos=n[i][checkCell];rows.push(r[pos]);if(!table.config.appender){var l=r[pos].length;for(var j=0;j<l;j++){tableBody[0].appendChild(r[pos][j]);}}}if(table.config.appender){table.config.appender(table,rows);}rows=null;if(table.config.debug){benchmark("Rebuilt table:",appendTime);}applyWidget(table);setTimeout(function(){$(table).trigger("sortEnd");},0);};function buildHeaders(table){if(table.config.debug){var time=new Date();}var meta=($.metadata)?true:false;var header_index=computeTableHeaderCellIndexes(table);$tableHeaders=$(table.config.selectorHeaders,table).each(function(index){this.column=header_index[this.parentNode.rowIndex+"-"+this.cellIndex];this.order=formatSortingOrder(table.config.sortInitialOrder);this.count=this.order;if(checkHeaderMetadata(this)||checkHeaderOptions(table,index))this.sortDisabled=true;if(checkHeaderOptionsSortingLocked(table,index))this.order=this.lockedOrder=checkHeaderOptionsSortingLocked(table,index);if(!this.sortDisabled){var $th=$(this).addClass(table.config.cssHeader);if(table.config.onRenderHeader)table.config.onRenderHeader.apply($th);}table.config.headerList[index]=this;});if(table.config.debug){benchmark("Built headers:",time);log($tableHeaders);}return $tableHeaders;};function computeTableHeaderCellIndexes(t){var matrix=[];var lookup={};var thead=t.getElementsByTagName('THEAD')[0];var trs=thead.getElementsByTagName('TR');for(var i=0;i<trs.length;i++){var cells=trs[i].cells;for(var j=0;j<cells.length;j++){var c=cells[j];var rowIndex=c.parentNode.rowIndex;var cellId=rowIndex+"-"+c.cellIndex;var rowSpan=c.rowSpan||1;var colSpan=c.colSpan||1
var firstAvailCol;if(typeof(matrix[rowIndex])=="undefined"){matrix[rowIndex]=[];}for(var k=0;k<matrix[rowIndex].length+1;k++){if(typeof(matrix[rowIndex][k])=="undefined"){firstAvailCol=k;break;}}lookup[cellId]=firstAvailCol;for(var k=rowIndex;k<rowIndex+rowSpan;k++){if(typeof(matrix[k])=="undefined"){matrix[k]=[];}var matrixrow=matrix[k];for(var l=firstAvailCol;l<firstAvailCol+colSpan;l++){matrixrow[l]="x";}}}}return lookup;}function checkCellColSpan(table,rows,row){var arr=[],r=table.tHead.rows,c=r[row].cells;for(var i=0;i<c.length;i++){var cell=c[i];if(cell.colSpan>1){arr=arr.concat(checkCellColSpan(table,headerArr,row++));}else{if(table.tHead.length==1||(cell.rowSpan>1||!r[row+1])){arr.push(cell);}}}return arr;};function checkHeaderMetadata(cell){if(($.metadata)&&($(cell).metadata().sorter===false)){return true;};return false;}function checkHeaderOptions(table,i){if((table.config.headers[i])&&(table.config.headers[i].sorter===false)){return true;};return false;}function checkHeaderOptionsSortingLocked(table,i){if((table.config.headers[i])&&(table.config.headers[i].lockedOrder))return table.config.headers[i].lockedOrder;return false;}function applyWidget(table){var c=table.config.widgets;var l=c.length;for(var i=0;i<l;i++){getWidgetById(c[i]).format(table);}}function getWidgetById(name){var l=widgets.length;for(var i=0;i<l;i++){if(widgets[i].id.toLowerCase()==name.toLowerCase()){return widgets[i];}}};function formatSortingOrder(v){if(typeof(v)!="Number"){return(v.toLowerCase()=="desc")?1:0;}else{return(v==1)?1:0;}}function isValueInArray(v,a){var l=a.length;for(var i=0;i<l;i++){if(a[i][0]==v){return true;}}return false;}function setHeadersCss(table,$headers,list,css){$headers.removeClass(css[0]).removeClass(css[1]);var h=[];$headers.each(function(offset){if(!this.sortDisabled){h[this.column]=$(this);}});var l=list.length;for(var i=0;i<l;i++){h[list[i][0]].addClass(css[list[i][1]]);}}function fixColumnWidth(table,$headers){var c=table.config;if(c.widthFixed){var colgroup=$('<colgroup>');$("tr:first td",table.tBodies[0]).each(function(){colgroup.append($('<col>').css('width',$(this).width()));});$(table).prepend(colgroup);};}function updateHeaderSortCount(table,sortList){var c=table.config,l=sortList.length;for(var i=0;i<l;i++){var s=sortList[i],o=c.headerList[s[0]];o.count=s[1];o.count++;}}function multisort(table,sortList,cache){if(table.config.debug){var sortTime=new Date();}var dynamicExp="var sortWrapper = function(a,b) {",l=sortList.length;for(var i=0;i<l;i++){var c=sortList[i][0];var order=sortList[i][1];var s=(table.config.parsers[c].type=="text")?((order==0)?makeSortFunction("text","asc",c):makeSortFunction("text","desc",c)):((order==0)?makeSortFunction("numeric","asc",c):makeSortFunction("numeric","desc",c));var e="e"+i;dynamicExp+="var "+e+" = "+s;dynamicExp+="if("+e+") { return "+e+"; } ";dynamicExp+="else { ";}var orgOrderCol=cache.normalized[0].length-1;dynamicExp+="return a["+orgOrderCol+"]-b["+orgOrderCol+"];";for(var i=0;i<l;i++){dynamicExp+="}; ";}dynamicExp+="return 0; ";dynamicExp+="}; ";if(table.config.debug){benchmark("Evaling expression:"+dynamicExp,new Date());}eval(dynamicExp);cache.normalized.sort(sortWrapper);if(table.config.debug){benchmark("Sorting on "+sortList.toString()+" and dir "+order+" time:",sortTime);}return cache;};function makeSortFunction(type,direction,index){var a="a["+index+"]",b="b["+index+"]";if(type=='text'&&direction=='asc'){return"("+a+" == "+b+" ? 0 : ("+a+" === null ? Number.POSITIVE_INFINITY : ("+b+" === null ? Number.NEGATIVE_INFINITY : ("+a+" < "+b+") ? -1 : 1 )));";}else if(type=='text'&&direction=='desc'){return"("+a+" == "+b+" ? 0 : ("+a+" === null ? Number.POSITIVE_INFINITY : ("+b+" === null ? Number.NEGATIVE_INFINITY : ("+b+" < "+a+") ? -1 : 1 )));";}else if(type=='numeric'&&direction=='asc'){return"("+a+" === null && "+b+" === null) ? 0 :("+a+" === null ? Number.POSITIVE_INFINITY : ("+b+" === null ? Number.NEGATIVE_INFINITY : "+a+" - "+b+"));";}else if(type=='numeric'&&direction=='desc'){return"("+a+" === null && "+b+" === null) ? 0 :("+a+" === null ? Number.POSITIVE_INFINITY : ("+b+" === null ? Number.NEGATIVE_INFINITY : "+b+" - "+a+"));";}};function makeSortText(i){return"((a["+i+"] < b["+i+"]) ? -1 : ((a["+i+"] > b["+i+"]) ? 1 : 0));";};function makeSortTextDesc(i){return"((b["+i+"] < a["+i+"]) ? -1 : ((b["+i+"] > a["+i+"]) ? 1 : 0));";};function makeSortNumeric(i){return"a["+i+"]-b["+i+"];";};function makeSortNumericDesc(i){return"b["+i+"]-a["+i+"];";};function sortText(a,b){if(table.config.sortLocaleCompare)return a.localeCompare(b);return((a<b)?-1:((a>b)?1:0));};function sortTextDesc(a,b){if(table.config.sortLocaleCompare)return b.localeCompare(a);return((b<a)?-1:((b>a)?1:0));};function sortNumeric(a,b){return a-b;};function sortNumericDesc(a,b){return b-a;};function getCachedSortType(parsers,i){return parsers[i].type;};this.construct=function(settings){return this.each(function(){if(!this.tHead||!this.tBodies)return;var $this,$document,$headers,cache,config,shiftDown=0,sortOrder;this.config={};config=$.extend(this.config,$.tablesorter.defaults,settings);$this=$(this);$.data(this,"tablesorter",config);$headers=buildHeaders(this);this.config.parsers=buildParserCache(this,$headers);cache=buildCache(this);var sortCSS=[config.cssDesc,config.cssAsc];fixColumnWidth(this);$headers.click(function(e){var totalRows=($this[0].tBodies[0]&&$this[0].tBodies[0].rows.length)||0;if(!this.sortDisabled&&totalRows>0){$this.trigger("sortStart");var $cell=$(this);var i=this.column;this.order=this.count++%2;if(this.lockedOrder)this.order=this.lockedOrder;if(!e[config.sortMultiSortKey]){config.sortList=[];if(config.sortForce!=null){var a=config.sortForce;for(var j=0;j<a.length;j++){if(a[j][0]!=i){config.sortList.push(a[j]);}}}config.sortList.push([i,this.order]);}else{if(isValueInArray(i,config.sortList)){for(var j=0;j<config.sortList.length;j++){var s=config.sortList[j],o=config.headerList[s[0]];if(s[0]==i){o.count=s[1];o.count++;s[1]=o.count%2;}}}else{config.sortList.push([i,this.order]);}};setTimeout(function(){setHeadersCss($this[0],$headers,config.sortList,sortCSS);appendToTable($this[0],multisort($this[0],config.sortList,cache));},1);return false;}}).mousedown(function(){if(config.cancelSelection){this.onselectstart=function(){return false};return false;}});$this.bind("update",function(){var me=this;setTimeout(function(){me.config.parsers=buildParserCache(me,$headers);cache=buildCache(me);},1);}).bind("updateCell",function(e,cell){var config=this.config;var pos=[(cell.parentNode.rowIndex-1),cell.cellIndex];cache.normalized[pos[0]][pos[1]]=config.parsers[pos[1]].format(getElementText(config,cell),cell);}).bind("sorton",function(e,list){$(this).trigger("sortStart");config.sortList=list;var sortList=config.sortList;updateHeaderSortCount(this,sortList);setHeadersCss(this,$headers,sortList,sortCSS);appendToTable(this,multisort(this,sortList,cache));}).bind("appendCache",function(){appendToTable(this,cache);}).bind("applyWidgetId",function(e,id){getWidgetById(id).format(this);}).bind("applyWidgets",function(){applyWidget(this);});if($.metadata&&($(this).metadata()&&$(this).metadata().sortlist)){config.sortList=$(this).metadata().sortlist;}if(config.sortList.length>0){$this.trigger("sorton",[config.sortList]);}applyWidget(this);});};this.addParser=function(parser){var l=parsers.length,a=true;for(var i=0;i<l;i++){if(parsers[i].id.toLowerCase()==parser.id.toLowerCase()){a=false;}}if(a){parsers.push(parser);};};this.addWidget=function(widget){widgets.push(widget);};this.formatFloat=function(s){var i=parseFloat(s);return(isNaN(i))?0:i;};this.formatInt=function(s){var i=parseInt(s);return(isNaN(i))?0:i;};this.isDigit=function(s,config){return/^[-+]?\d*$/.test($.trim(s.replace(/[,.']/g,'')));};this.clearTableBody=function(table){if($.browser.msie){function empty(){while(this.firstChild)this.removeChild(this.firstChild);}empty.apply(table.tBodies[0]);}else{table.tBodies[0].innerHTML="";}};}});$.fn.extend({tablesorter:$.tablesorter.construct});var ts=$.tablesorter;ts.addParser({id:"text",is:function(s){return true;},format:function(s){return $.trim(s.toLocaleLowerCase());},type:"text"});ts.addParser({id:"digit",is:function(s,table){var c=table.config;return $.tablesorter.isDigit(s,c);},format:function(s){return $.tablesorter.formatFloat(s);},type:"numeric"});ts.addParser({id:"currency",is:function(s){return/^[£$€?.]/.test(s);},format:function(s){return $.tablesorter.formatFloat(s.replace(new RegExp(/[£$€]/g),""));},type:"numeric"});ts.addParser({id:"ipAddress",is:function(s){return/^\d{2,3}[\.]\d{2,3}[\.]\d{2,3}[\.]\d{2,3}$/.test(s);},format:function(s){var a=s.split("."),r="",l=a.length;for(var i=0;i<l;i++){var item=a[i];if(item.length==2){r+="0"+item;}else{r+=item;}}return $.tablesorter.formatFloat(r);},type:"numeric"});ts.addParser({id:"url",is:function(s){return/^(https?|ftp|file):\/\/$/.test(s);},format:function(s){return jQuery.trim(s.replace(new RegExp(/(https?|ftp|file):\/\//),''));},type:"text"});ts.addParser({id:"isoDate",is:function(s){return/^\d{4}[\/-]\d{1,2}[\/-]\d{1,2}$/.test(s);},format:function(s){return $.tablesorter.formatFloat((s!="")?new Date(s.replace(new RegExp(/-/g),"/")).getTime():"0");},type:"numeric"});ts.addParser({id:"percent",is:function(s){return/\%$/.test($.trim(s));},format:function(s){return $.tablesorter.formatFloat(s.replace(new RegExp(/%/g),""));},type:"numeric"});ts.addParser({id:"usLongDate",is:function(s){return s.match(new RegExp(/^[A-Za-z]{3,10}\.? [0-9]{1,2}, ([0-9]{4}|'?[0-9]{2}) (([0-2]?[0-9]:[0-5][0-9])|([0-1]?[0-9]:[0-5][0-9]\s(AM|PM)))$/));},format:function(s){return $.tablesorter.formatFloat(new Date(s).getTime());},type:"numeric"});ts.addParser({id:"shortDate",is:function(s){return/\d{1,2}[\/\-]\d{1,2}[\/\-]\d{2,4}/.test(s);},format:function(s,table){var c=table.config;s=s.replace(/\-/g,"/");if(c.dateFormat=="us"){s=s.replace(/(\d{1,2})[\/\-](\d{1,2})[\/\-](\d{4})/,"$3/$1/$2");}else if(c.dateFormat=="uk"){s=s.replace(/(\d{1,2})[\/\-](\d{1,2})[\/\-](\d{4})/,"$3/$2/$1");}else if(c.dateFormat=="dd/mm/yy"||c.dateFormat=="dd-mm-yy"){s=s.replace(/(\d{1,2})[\/\-](\d{1,2})[\/\-](\d{2})/,"$1/$2/$3");}return $.tablesorter.formatFloat(new Date(s).getTime());},type:"numeric"});ts.addParser({id:"time",is:function(s){return/^(([0-2]?[0-9]:[0-5][0-9])|([0-1]?[0-9]:[0-5][0-9]\s(am|pm)))$/.test(s);},format:function(s){return $.tablesorter.formatFloat(new Date("2000/01/01 "+s).getTime());},type:"numeric"});ts.addParser({id:"metadata",is:function(s){return false;},format:function(s,table,cell){var c=table.config,p=(!c.parserMetadataName)?'sortValue':c.parserMetadataName;return $(cell).metadata()[p];},type:"numeric"});ts.addWidget({id:"zebra",format:function(table){if(table.config.debug){var time=new Date();}var $tr,row=-1,odd;$("tr:visible",table.tBodies[0]).each(function(i){$tr=$(this);if(!$tr.hasClass(table.config.cssChildRow))row++;odd=(row%2==0);$tr.removeClass(table.config.widgetZebra.css[odd?0:1]).addClass(table.config.widgetZebra.css[odd?1:0])});if(table.config.debug){$.tablesorter.benchmark("Applying Zebra widget",time);}}});})(jQuery);
/*!
 * jquery-timepicker v1.8.8 - A jQuery timepicker plugin inspired by Google Calendar. It supports both mouse and keyboard navigation.
 * Copyright (c) 2015 Jon Thornton - http://jonthornton.github.com/jquery-timepicker/
 * License: MIT
 */

!function(a){"object"==typeof exports&&exports&&"object"==typeof module&&module&&module.exports===exports?a(require("jquery")):"function"==typeof define&&define.amd?define(["jquery"],a):a(jQuery)}(function(a){function b(a){var b=a[0];return b.offsetWidth>0&&b.offsetHeight>0}function c(b){if(b.minTime&&(b.minTime=u(b.minTime)),b.maxTime&&(b.maxTime=u(b.maxTime)),b.durationTime&&"function"!=typeof b.durationTime&&(b.durationTime=u(b.durationTime)),"now"==b.scrollDefault)b.scrollDefault=function(){return b.roundingFunction(u(new Date),b)};else if(b.scrollDefault&&"function"!=typeof b.scrollDefault){var c=b.scrollDefault;b.scrollDefault=function(){return b.roundingFunction(u(c),b)}}else b.minTime&&(b.scrollDefault=function(){return b.roundingFunction(b.minTime,b)});if("string"===a.type(b.timeFormat)&&b.timeFormat.match(/[gh]/)&&(b._twelveHourTime=!0),b.showOnFocus===!1&&-1!=b.showOn.indexOf("focus")&&b.showOn.splice(b.showOn.indexOf("focus"),1),b.disableTimeRanges.length>0){for(var d in b.disableTimeRanges)b.disableTimeRanges[d]=[u(b.disableTimeRanges[d][0]),u(b.disableTimeRanges[d][1])];b.disableTimeRanges=b.disableTimeRanges.sort(function(a,b){return a[0]-b[0]});for(var d=b.disableTimeRanges.length-1;d>0;d--)b.disableTimeRanges[d][0]<=b.disableTimeRanges[d-1][1]&&(b.disableTimeRanges[d-1]=[Math.min(b.disableTimeRanges[d][0],b.disableTimeRanges[d-1][0]),Math.max(b.disableTimeRanges[d][1],b.disableTimeRanges[d-1][1])],b.disableTimeRanges.splice(d,1))}return b}function d(b){var c=b.data("timepicker-settings"),d=b.data("timepicker-list");if(d&&d.length&&(d.remove(),b.data("timepicker-list",!1)),c.useSelect){d=a("<select />",{"class":"ui-timepicker-select"});var g=d}else{d=a("<ul />",{"class":"ui-timepicker-list"});var g=a("<div />",{"class":"ui-timepicker-wrapper",tabindex:-1});g.css({display:"none",position:"absolute"}).append(d)}if(c.noneOption)if(c.noneOption===!0&&(c.noneOption=c.useSelect?"Time...":"None"),a.isArray(c.noneOption)){for(var h in c.noneOption)if(parseInt(h,10)==h){var i=e(c.noneOption[h],c.useSelect);d.append(i)}}else{var i=e(c.noneOption,c.useSelect);d.append(i)}if(c.className&&g.addClass(c.className),(null!==c.minTime||null!==c.durationTime)&&c.showDuration){"function"==typeof c.step?"function":c.step;g.addClass("ui-timepicker-with-duration"),g.addClass("ui-timepicker-step-"+c.step)}var k=c.minTime;"function"==typeof c.durationTime?k=u(c.durationTime()):null!==c.durationTime&&(k=c.durationTime);var m=null!==c.minTime?c.minTime:0,n=null!==c.maxTime?c.maxTime:m+w-1;m>n&&(n+=w),n===w-1&&"string"===a.type(c.timeFormat)&&c.show2400&&(n=w);var p=c.disableTimeRanges,q=0,v=p.length,x=c.step;"function"!=typeof x&&(x=function(){return c.step});for(var h=m,z=0;n>=h;z++,h+=60*x(z)){var A=h,B=t(A,c);if(c.useSelect){var C=a("<option />",{value:B});C.text(B)}else{var C=a("<li />");C.addClass(43200>A%86400?"ui-timepicker-am":"ui-timepicker-pm"),C.data("time",86400>=A?A:A%86400),C.text(B)}if((null!==c.minTime||null!==c.durationTime)&&c.showDuration){var D=s(h-k,c.step);if(c.useSelect)C.text(C.text()+" ("+D+")");else{var E=a("<span />",{"class":"ui-timepicker-duration"});E.text(" ("+D+")"),C.append(E)}}v>q&&(A>=p[q][1]&&(q+=1),p[q]&&A>=p[q][0]&&A<p[q][1]&&(c.useSelect?C.prop("disabled",!0):C.addClass("ui-timepicker-disabled"))),d.append(C)}if(g.data("timepicker-input",b),b.data("timepicker-list",g),c.useSelect)b.val()&&d.val(f(u(b.val()),c)),d.on("focus",function(){a(this).data("timepicker-input").trigger("showTimepicker")}),d.on("blur",function(){a(this).data("timepicker-input").trigger("hideTimepicker")}),d.on("change",function(){o(b,a(this).val(),"select")}),o(b,d.val(),"initial"),b.hide().after(d);else{var F=c.appendTo;"string"==typeof F?F=a(F):"function"==typeof F&&(F=F(b)),F.append(g),l(b,d),d.on("mousedown","li",function(c){b.off("focus.timepicker"),b.on("focus.timepicker-ie-hack",function(){b.off("focus.timepicker-ie-hack"),b.on("focus.timepicker",y.show)}),j(b)||b[0].focus(),d.find("li").removeClass("ui-timepicker-selected"),a(this).addClass("ui-timepicker-selected"),r(b)&&(b.trigger("hideTimepicker"),d.on("mouseup.timepicker","li",function(a){d.off("mouseup.timepicker"),g.hide()}))})}}function e(b,c){var d,e,f;return"object"==typeof b?(d=b.label,e=b.className,f=b.value):"string"==typeof b?d=b:a.error("Invalid noneOption value"),c?a("<option />",{value:f,"class":e,text:d}):a("<li />",{"class":e,text:d}).data("time",f)}function f(a,b){return a=b.roundingFunction(a,b),null!==a?t(a,b):void 0}function g(){return new Date(1970,1,1,0,0,0)}function h(b){var c=a(b.target),d=c.closest(".ui-timepicker-input");0===d.length&&0===c.closest(".ui-timepicker-wrapper").length&&(y.hide(),a(document).unbind(".ui-timepicker"),a(window).unbind(".ui-timepicker"))}function j(a){var b=a.data("timepicker-settings");return(window.navigator.msMaxTouchPoints||"ontouchstart"in document)&&b.disableTouchKeyboard}function k(b,c,d){if(!d&&0!==d)return!1;var e=b.data("timepicker-settings"),f=!1,d=e.roundingFunction(d,e);return c.find("li").each(function(b,c){var e=a(c);if("number"==typeof e.data("time"))return e.data("time")==d?(f=e,!1):void 0}),f}function l(a,b){b.find("li").removeClass("ui-timepicker-selected");var c=u(n(a),a.data("timepicker-settings"));if(null!==c){var d=k(a,b,c);if(d){var e=d.offset().top-b.offset().top;(e+d.outerHeight()>b.outerHeight()||0>e)&&b.scrollTop(b.scrollTop()+d.position().top-d.outerHeight()),d.addClass("ui-timepicker-selected")}}}function m(b,c){if(""!==this.value&&"timepicker"!=c){var d=a(this);if(!d.is(":focus")||b&&"change"==b.type){var e=d.data("timepicker-settings"),f=u(this.value,e);if(null===f)return void d.trigger("timeFormatError");var g=!1;null!==e.minTime&&f<e.minTime?g=!0:null!==e.maxTime&&f>e.maxTime&&(g=!0),a.each(e.disableTimeRanges,function(){return f>=this[0]&&f<this[1]?(g=!0,!1):void 0}),e.forceRoundTime&&(f=e.roundingFunction(f,e));var h=t(f,e);g?o(d,h,"error")&&d.trigger("timeRangeError"):o(d,h)}}}function n(a){return a.is("input")?a.val():a.data("ui-timepicker-value")}function o(a,b,c){if(a.is("input")){a.val(b);var d=a.data("timepicker-settings");d.useSelect&&"select"!=c&&"initial"!=c&&a.data("timepicker-list").val(f(u(b),d))}return a.data("ui-timepicker-value")!=b?(a.data("ui-timepicker-value",b),"select"==c?a.trigger("selectTime").trigger("changeTime").trigger("change","timepicker"):"error"!=c&&a.trigger("changeTime"),!0):(a.trigger("selectTime"),!1)}function p(c){var d=a(this),e=d.data("timepicker-list");if(!e||!b(e)){if(40!=c.keyCode)return!0;y.show.call(d.get(0)),e=d.data("timepicker-list"),j(d)||d.focus()}switch(c.keyCode){case 13:return r(d)&&y.hide.apply(this),c.preventDefault(),!1;case 38:var f=e.find(".ui-timepicker-selected");return f.length?f.is(":first-child")||(f.removeClass("ui-timepicker-selected"),f.prev().addClass("ui-timepicker-selected"),f.prev().position().top<f.outerHeight()&&e.scrollTop(e.scrollTop()-f.outerHeight())):(e.find("li").each(function(b,c){return a(c).position().top>0?(f=a(c),!1):void 0}),f.addClass("ui-timepicker-selected")),!1;case 40:return f=e.find(".ui-timepicker-selected"),0===f.length?(e.find("li").each(function(b,c){return a(c).position().top>0?(f=a(c),!1):void 0}),f.addClass("ui-timepicker-selected")):f.is(":last-child")||(f.removeClass("ui-timepicker-selected"),f.next().addClass("ui-timepicker-selected"),f.next().position().top+2*f.outerHeight()>e.outerHeight()&&e.scrollTop(e.scrollTop()+f.outerHeight())),!1;case 27:e.find("li").removeClass("ui-timepicker-selected"),y.hide();break;case 9:y.hide();break;default:return!0}}function q(c){var d=a(this),e=d.data("timepicker-list"),f=d.data("timepicker-settings");if(!e||!b(e)||f.disableTextInput)return!0;switch(c.keyCode){case 96:case 97:case 98:case 99:case 100:case 101:case 102:case 103:case 104:case 105:case 48:case 49:case 50:case 51:case 52:case 53:case 54:case 55:case 56:case 57:case 65:case 77:case 80:case 186:case 8:case 46:f.typeaheadHighlight?l(d,e):e.hide()}}function r(a){var b=a.data("timepicker-settings"),c=a.data("timepicker-list"),d=null,e=c.find(".ui-timepicker-selected");return e.hasClass("ui-timepicker-disabled")?!1:(e.length&&(d=e.data("time")),null!==d&&("string"!=typeof d&&(d=t(d,b)),o(a,d,"select")),!0)}function s(a,b){a=Math.abs(a);var c,d,e=Math.round(a/60),f=[];return 60>e?f=[e,x.mins]:(c=Math.floor(e/60),d=e%60,30==b&&30==d&&(c+=x.decimal+5),f.push(c),f.push(1==c?x.hr:x.hrs),30!=b&&d&&(f.push(d),f.push(x.mins))),f.join(" ")}function t(b,c){if(null===b)return null;var d=new Date(v.valueOf()+1e3*b);if(isNaN(d.getTime()))return null;if("function"===a.type(c.timeFormat))return c.timeFormat(d);for(var e,f,g="",h=0;h<c.timeFormat.length;h++)switch(f=c.timeFormat.charAt(h)){case"a":g+=d.getHours()>11?x.pm:x.am;break;case"A":g+=d.getHours()>11?x.PM:x.AM;break;case"g":e=d.getHours()%12,g+=0===e?"12":e;break;case"G":e=d.getHours(),b===w&&(e=24),g+=e;break;case"h":e=d.getHours()%12,0!==e&&10>e&&(e="0"+e),g+=0===e?"12":e;break;case"H":e=d.getHours(),b===w&&(e=c.show2400?24:0),g+=e>9?e:"0"+e;break;case"i":var i=d.getMinutes();g+=i>9?i:"0"+i;break;case"s":b=d.getSeconds(),g+=b>9?b:"0"+b;break;case"\\":h++,g+=c.timeFormat.charAt(h);break;default:g+=f}return g}function u(a,b){if(""===a)return null;if(!a||a+0==a)return a;if("object"==typeof a)return 3600*a.getHours()+60*a.getMinutes()+a.getSeconds();a=a.toLowerCase().replace(/[\s\.]/g,""),("a"==a.slice(-1)||"p"==a.slice(-1))&&(a+="m");var c="("+x.am.replace(".","")+"|"+x.pm.replace(".","")+"|"+x.AM.replace(".","")+"|"+x.PM.replace(".","")+")?",d=new RegExp("^"+c+"([0-9]?[0-9])\\W?([0-5][0-9])?\\W?([0-5][0-9])?"+c+"$"),e=a.match(d);if(!e)return null;var f=parseInt(1*e[2],10)%24,g=e[1]||e[5],h=f;if(12>=f&&g){var i=g==x.pm||g==x.PM;h=12==f?i?12:0:f+(i?12:0)}var j=1*e[3]||0,k=1*e[4]||0,l=3600*h+60*j+k;if(12>f&&!g&&b&&b._twelveHourTime&&b.scrollDefault){var m=l-b.scrollDefault();0>m&&m>=w/-2&&(l=(l+w/2)%w)}return l}var v=g(),w=86400,x={am:"am",pm:"pm",AM:"AM",PM:"PM",decimal:".",mins:"mins",hr:"hr",hrs:"hrs"},y={init:function(b){return this.each(function(){var e=a(this),f=[];for(var g in a.fn.timepicker.defaults)e.data(g)&&(f[g]=e.data(g));var h=a.extend({},a.fn.timepicker.defaults,f,b);if(h.lang&&(x=a.extend(x,h.lang)),h=c(h),e.data("timepicker-settings",h),e.addClass("ui-timepicker-input"),h.useSelect)d(e);else{if(e.prop("autocomplete","off"),h.showOn)for(i in h.showOn)e.on(h.showOn[i]+".timepicker",y.show);e.on("change.timepicker",m),e.on("keydown.timepicker",p),e.on("keyup.timepicker",q),h.disableTextInput&&e.on("keydown.timepicker",function(a){a.preventDefault()}),m.call(e.get(0))}})},show:function(c){var e=a(this),f=e.data("timepicker-settings");if(c&&c.preventDefault(),f.useSelect)return void e.data("timepicker-list").focus();j(e)&&e.blur();var g=e.data("timepicker-list");if(!e.prop("readonly")&&(g&&0!==g.length&&"function"!=typeof f.durationTime||(d(e),g=e.data("timepicker-list")),!b(g))){e.data("ui-timepicker-value",e.val()),l(e,g),y.hide(),g.show();var i={};f.orientation.match(/r/)?i.left=e.offset().left+e.outerWidth()-g.outerWidth()+parseInt(g.css("marginLeft").replace("px",""),10):i.left=e.offset().left+parseInt(g.css("marginLeft").replace("px",""),10);var m;m=f.orientation.match(/t/)?"t":f.orientation.match(/b/)?"b":e.offset().top+e.outerHeight(!0)+g.outerHeight()>a(window).height()+a(window).scrollTop()?"t":"b","t"==m?(g.addClass("ui-timepicker-positioned-top"),i.top=e.offset().top-g.outerHeight()+parseInt(g.css("marginTop").replace("px",""),10)):(g.removeClass("ui-timepicker-positioned-top"),i.top=e.offset().top+e.outerHeight()+parseInt(g.css("marginTop").replace("px",""),10)),g.offset(i);var o=g.find(".ui-timepicker-selected");if(!o.length){var p=u(n(e));null!==p?o=k(e,g,p):f.scrollDefault&&(o=k(e,g,f.scrollDefault()))}if(o&&o.length){var q=g.scrollTop()+o.position().top-o.outerHeight();g.scrollTop(q)}else g.scrollTop(0);return f.stopScrollPropagation&&a(document).on("wheel.ui-timepicker",".ui-timepicker-wrapper",function(b){b.preventDefault();var c=a(this).scrollTop();a(this).scrollTop(c+b.originalEvent.deltaY)}),a(document).on("touchstart.ui-timepicker mousedown.ui-timepicker",h),a(window).on("resize.ui-timepicker",h),f.closeOnWindowScroll&&a(document).on("scroll.ui-timepicker",h),e.trigger("showTimepicker"),this}},hide:function(c){var d=a(this),e=d.data("timepicker-settings");return e&&e.useSelect&&d.blur(),a(".ui-timepicker-wrapper").each(function(){var c=a(this);if(b(c)){var d=c.data("timepicker-input"),e=d.data("timepicker-settings");e&&e.selectOnBlur&&r(d),c.hide(),d.trigger("hideTimepicker")}}),this},option:function(b,e){return this.each(function(){var f=a(this),g=f.data("timepicker-settings"),h=f.data("timepicker-list");if("object"==typeof b)g=a.extend(g,b);else if("string"==typeof b&&"undefined"!=typeof e)g[b]=e;else if("string"==typeof b)return g[b];g=c(g),f.data("timepicker-settings",g),h&&(h.remove(),f.data("timepicker-list",!1)),g.useSelect&&d(f)})},getSecondsFromMidnight:function(){return u(n(this))},getTime:function(a){var b=this,c=n(b);if(!c)return null;var d=u(c);if(null===d)return null;a||(a=v);var e=new Date(a);return e.setHours(d/3600),e.setMinutes(d%3600/60),e.setSeconds(d%60),e.setMilliseconds(0),e},setTime:function(a){var b=this,c=b.data("timepicker-settings");if(c.forceRoundTime)var d=f(u(a),c);else var d=t(u(a),c);return a&&null===d&&c.noneOption&&(d=a),o(b,d),b.data("timepicker-list")&&l(b,b.data("timepicker-list")),this},remove:function(){var a=this;if(a.hasClass("ui-timepicker-input")){var b=a.data("timepicker-settings");return a.removeAttr("autocomplete","off"),a.removeClass("ui-timepicker-input"),a.removeData("timepicker-settings"),a.off(".timepicker"),a.data("timepicker-list")&&a.data("timepicker-list").remove(),b.useSelect&&a.show(),a.removeData("timepicker-list"),this}}};a.fn.timepicker=function(b){return this.length?y[b]?this.hasClass("ui-timepicker-input")?y[b].apply(this,Array.prototype.slice.call(arguments,1)):this:"object"!=typeof b&&b?void a.error("Method "+b+" does not exist on jQuery.timepicker"):y.init.apply(this,arguments):this},a.fn.timepicker.defaults={appendTo:"body",className:null,closeOnWindowScroll:!1,disableTextInput:!1,disableTimeRanges:[],disableTouchKeyboard:!1,durationTime:null,forceRoundTime:!1,maxTime:null,minTime:null,noneOption:!1,orientation:"l",roundingFunction:function(a,b){if(null===a)return null;var c=a%(60*b.step);return c>=30*b.step?a+=60*b.step-c:a-=c,a},scrollDefault:null,selectOnBlur:!1,show2400:!1,showDuration:!1,showOn:["click","focus"],showOnFocus:!0,step:30,stopScrollPropagation:!1,timeFormat:"g:ia",typeaheadHighlight:!0,useSelect:!1}});
$(document).ready(function(){
////// Requested Collection //////
    var $requestedCollectionHolder;
        $requestedCollectionHolder = $('ul.requested_collection');
        
    var $addRequestedCollectionLink = $('<a href="#" class="add_requestedcollection_link">+ Add Collection</a>');
    var $newRequestedCollectionLi = $('<li></li>').append($addRequestedCollectionLink);

    // add the "+ Add Collection" li to the ul
    $requestedCollectionHolder.append($newRequestedCollectionLi);

    // index when inserting a new item (e.g. 2)
    $requestedCollectionHolder.data('index', $requestedCollectionHolder.find(':input').length);
    
    //Add an additional archives collection form each time a user clicks the $addRequestedCollectionLink
    $addRequestedCollectionLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new collection form
        addRequestedCollectionForm($requestedCollectionHolder, $newRequestedCollectionLi);
    });
    
    //Add an initial collection form.
    addRequestedCollectionForm($requestedCollectionHolder, $newRequestedCollectionLi);
    
    //Add an additional box collection form each time a user clicks the newBoxQuantity anchor
    $(document).on('click', '.add_requestedboxquantity_link', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();
        
        // add a new collection form
        addRequestedBoxForm($(this), $requestedCollectionHolder);
    });
    
////// Digitization Collection //////
    var $digitizationCollectionHolder;
        $digitizationCollectionHolder = $('ul.digitization_collection');
        
    var $addDigitizationCollectionLink = $('<a href="#" class="add_digitizationcollection_link">+ Add Collection</a>');
    var $newDigitizationCollectionLi = $('<li></li>').append($addDigitizationCollectionLink);

    // add the "+ Add Collection" li to the ul
    $digitizationCollectionHolder.append($newDigitizationCollectionLi);

    // index when inserting a new item (e.g. 2)
    $digitizationCollectionHolder.data('index', $digitizationCollectionHolder.find(':input').length);
    
    //Add an additional archives collection form each time a user clicks the $addDigitizationCollectionLink
    $addDigitizationCollectionLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new collection form
        addDigitizationCollectionForm($digitizationCollectionHolder, $newDigitizationCollectionLi);
    });
    
    //Add an initial collection form.
    addDigitizationCollectionForm($digitizationCollectionHolder, $newDigitizationCollectionLi);
    
    //Add an additional box collection form each time a user clicks the newBoxQuantity anchor
    $(document).on('click', '.add_digitizationboxquantity_link', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();
        
        // add a new collection form
        addDigitizationBoxForm($(this), $digitizationCollectionHolder);
    });

    
    /**
     * Uses Symfony's prototype code to generate a new list item for a REQUESTED collection 
     * and a sub-form for a boxquantity (box number and quantity)
     *
     * @param jQuery Object $collectionHolder   The <ul> which holds the collection and prototypes
     * @param jQuery Object $newLinkLi          The jQuery element of the link that was just clicked.
     */
    function addRequestedCollectionForm($collectionHolder, $newLinkLi, bootstrapListStyle) {
        // Get the data-prototype-collections and data-prototype-boxquantity
        var collectionsPrototype = $collectionHolder.data('prototype-collections');
        var boxquantityPrototype = $collectionHolder.data('prototype-boxquantity');
        
        // get the new index
        var index = $collectionHolder.data('index');

        // Replace '__name__' in the prototype's HTML to
        // instead be a number based on how many items we have
        var newCollectionForm = collectionsPrototype.replace(/__name__/g, index);
        var newBoxForm = boxquantityPrototype.replace(/__boxname__/g, 0);
            newBoxForm = newBoxForm.replace(/__collectionname__/g, index);

        // Display the collection form in the page in an li, before the "Add collection" link li
        if(bootstrapListStyle === true){
            var $newCollectionFormLi = $('<li class="list-group-item requestedcollection-item-container"></li>').append(newCollectionForm);
        } else {
            var $newCollectionFormLi = $('<li class="requestedcollection-item-container"></li>').append(newCollectionForm);
        }    
        
        // Display the box form in the boxquantity list in an li, before the "Add box" link li
        var newBoxFormUl = '<ul class="requested_collection_boxquantity" id="requested_collection_boxquantity___index__"></ul>';
            newBoxFormUl = newBoxFormUl.replace(/__index__/g, index);
        var $newBoxFormUl = $(newBoxFormUl);
        var $newBoxFormLi = $('<li class="list-group-item requestedcollectionbox-item-container"></li>');
        
        // COLLECTION BOXES
        var newBoxQuantityLink = '<a href="#" class="add_requestedboxquantity_link" id="add_requestedboxquantity_link___index__">+ Box</a>';
            newBoxQuantityLink = newBoxQuantityLink.replace(/__index__/g, index);
        var $newBoxQuantityLink = $(newBoxQuantityLink);
        var $newBoxQuantityLi = $('<li></li>').append($newBoxQuantityLink);
        
        // increase the index with one for the next item
        $collectionHolder.data('index', index + 1);
        
        $newBoxFormLi.append(newBoxForm);
        $newBoxFormUl.append($newBoxFormLi);
        $newBoxFormUl.append($newBoxQuantityLi); 
        $newCollectionFormLi.append($newBoxFormUl);
        // end of COLLECTION BOXES
        
        // Add the collection and box before the +Add Collection list item
        $newLinkLi.before($newCollectionFormLi);
    }
    
    /**
     * Uses Symfony's prototype code to generate a new list item for a DIGITIZATION collection 
     * and a sub-form for a boxquantity (box number and quantity)
     *
     * @param jQuery Object $collectionHolder   The <ul> which holds the collection and prototypes
     * @param jQuery Object $newLinkLi          The jQuery element of the link that was just clicked.
     */
    function addDigitizationCollectionForm($collectionHolder, $newLinkLi, bootstrapListStyle) {
        // Get the data-prototype-collections and data-prototype-boxquantity
        var collectionsPrototype = $collectionHolder.data('prototype-collections');
        var boxquantityPrototype = $collectionHolder.data('prototype-boxquantity');
        
        // get the new index
        var index = $collectionHolder.data('index');

        // Replace '__name__' in the prototype's HTML to
        // instead be a number based on how many items we have
        var newCollectionForm = collectionsPrototype.replace(/__name__/g, index);
        var newBoxForm = boxquantityPrototype.replace(/__boxname__/g, 0);
            newBoxForm = newBoxForm.replace(/__collectionname__/g, index);

        // Display the collection form in the page in an li, before the "Add collection" link li
        if(bootstrapListStyle === true){
            var $newCollectionFormLi = $('<li class="list-group-item digitizationcollection-item-container"></li>').append(newCollectionForm);
        } else {
            var $newCollectionFormLi = $('<li class="digitizationcollection-item-container"></li>').append(newCollectionForm);
        }    
        
        // Display the box form in the boxquantity list in an li, before the "Add box" link li
        var newBoxFormUl = '<ul class="digitization_collection_boxquantity" id="digitization_collection_boxquantity___index__"></ul>';
            newBoxFormUl = newBoxFormUl.replace(/__index__/g, index);
        var $newBoxFormUl = $(newBoxFormUl);
        var $newBoxFormLi = $('<li class="list-group-item digitizationcollectionbox-item-container"></li>');
        
        // COLLECTION BOXES
        var newBoxQuantityLink = '<a href="#" class="add_digitizationboxquantity_link" id="add_digitizationboxquantity_link___index__">+ Box</a>';
            newBoxQuantityLink = newBoxQuantityLink.replace(/__index__/g, index);
        var $newBoxQuantityLink = $(newBoxQuantityLink);
        var $newBoxQuantityLi = $('<li></li>').append($newBoxQuantityLink);
        
        // increase the index with one for the next item
        $collectionHolder.data('index', index + 1);
        
        $newBoxFormLi.append(newBoxForm);
        $newBoxFormUl.append($newBoxFormLi);
        $newBoxFormUl.append($newBoxQuantityLi); 
        $newCollectionFormLi.append($newBoxFormUl);
        // end of COLLECTION BOXES
        
        // Add the collection and box before the +Add Collection list item
        $newLinkLi.before($newCollectionFormLi);
    }
    
    /**
     * Add a boxquantity using the boxquantity prototype (box number and quantity) to a REQUESTED COLLECTION.
     *
     * @param jQuery Object $newLinkLi                  The jQuery element of the link that was just clicked.
     * @param jQuery Object $parentCollectionHolder     The jQuery element of the collection, which contains the boxquantity prototype
     *
     * return
     */
    function addRequestedBoxForm($newLinkLi, $parentCollectionHolder){
        var boxquantityPrototype = $parentCollectionHolder.data('prototype-boxquantity');
        
        var $parentUl = $newLinkLi.parents('.requested_collection_boxquantity');
        var parentUlId = $parentUl.attr('id');
        var collectionIndex = parentUlId.match(/\d+$/); //matches the number at the end of the ID string
        
        var boxIndexForThisUl = $parentUl.find('li.requestedcollectionbox-item-container').length;
        
        // Replace '__boxname__' in the prototype's HTML to
        // instead be a number based on how many items we have
        var newBoxForm = boxquantityPrototype.replace(/__boxname__/g, boxIndexForThisUl);
            newBoxForm = newBoxForm.replace(/__collectionname__/g, collectionIndex);
        
        // Display the collection form in the page in an li, before the "Add collection" link li
        var $newBoxFormLi = $('<li class="list-group-item requestedcollectionbox-item-container"></li>').append(newBoxForm);
 
        $newLinkLi.before($newBoxFormLi);
        
        return;
    }
    
    /**
     * Add a boxquantity using the boxquantity prototype (box number and quantity) to a DIGITIZATION COLLECTION.
     *
     * @param jQuery Object $newLinkLi                  The jQuery element of the link that was just clicked.
     * @param jQuery Object $parentCollectionHolder     The jQuery element of the collection, which contains the boxquantity prototype
     *
     * return
     */
    function addDigitizationBoxForm($newLinkLi, $parentCollectionHolder){
        var boxquantityPrototype = $parentCollectionHolder.data('prototype-boxquantity');
        
        var $parentUl = $newLinkLi.parents('.digitization_collection_boxquantity');
        var parentUlId = $parentUl.attr('id');
        var collectionIndex = parentUlId.match(/\d+$/); //matches the number at the end of the ID string
        
        var boxIndexForThisUl = $parentUl.find('li.digitizationcollectionbox-item-container').length;
        
        var newBoxForm = boxquantityPrototype.replace(/__boxname__/g, boxIndexForThisUl);
            newBoxForm = newBoxForm.replace(/__collectionname__/g, collectionIndex);
        
        var $newBoxFormLi = $('<li class="list-group-item digitizationcollectionbox-item-container"></li>').append(newBoxForm);
 
        $newLinkLi.before($newBoxFormLi);
        
        return;
    }
});

