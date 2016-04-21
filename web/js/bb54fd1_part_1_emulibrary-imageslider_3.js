/* 
 * Created by Chris Puzzuoli for the EMU Library
 * v. 0.0.1  4/21/16
 */

(function ($, undefined){
    
    var defaults = {
        color: 'red'
    };
    
    $.fn.libraryImageSlider = function(options){
        /*if (this.length === 0) {
            return this;
        }

        if (this.length > 1) {
            this.each(function () {
                $(this).libraryImageSlider(options);
            });
            return this;
        }*/
        
        var settings = $.extend(true, {}, defaults, options);
        
        this.css({
            color: settings.color,
            "list-style-type": "none",
        });
        
        this.filter("ul").each(function(){
            var $list = $(this);
            $list.filter("li").each(function(){
                alert("GOT ONE!");
            });
        });
        
        return this;
    };
}(jQuery));


