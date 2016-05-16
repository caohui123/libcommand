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

    function changeActivationStatus(userId){
        $.post("{{ path('isactive') }}", {userId: userId})
            .done(function(data){
                console.log("Finished updating " + userId);
            })
            .fail(function(){
                console.log("User could not be updated");
            });
    };    

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
});


