$(document).ready(function(){
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
    * Search Instruction sessions (i.e. "AppBundle:Instruction:index.html.twig")
    */
   

});


