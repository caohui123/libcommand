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
     * Documents (new.html.twig) 
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
        addTagForm($documentsCollectionHolder, $newDocumentsLi);
    });

    /**
     * Uses Symfony's prototype code to generate a new list item for a form collection
     */
    function addTagForm($collectionHolder, $newLinkLi) {
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
        var $newFormLi = $('<li></li>').append(newForm);
        $newLinkLi.before($newFormLi);
    }
    
    /******
     * Documents (edit.html.twig)
     ******/
    var $documentCollectionHolder;
    var $addDocumentLink = $('<a href="#" class="add_document_link">+ Add Document</a>');
    var $newDocumentTr = $('<tr></tr>').append($addDocumentLink);

    $documentCollectionHolder = $('table.documents_collection');

    $documentCollectionHolder.append($newDocumentTr);

    $documentCollectionHolder.data('index', $documentCollectionHolder.find(':input').length);

    //Add an additional documents form each time a user clicks the $addDocumentLink
    $addDocumentLink.on('click', function(e) {
        e.preventDefault();
        addDocumentRow($documentCollectionHolder, $newDocumentTr);
    });
    
    /**
     * Uses Symfony's prototype code to generate a new table row for a form collection
     */
    function addDocumentRow($collectionHolder, $newDocumentTr) {
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
        var $newFormTr = $('<tr></tr>').append(newForm);
        console.log($newFormTr);
        $newDocumentTr.before($newFormTr);
    }

    $(document).on('click', '.delete-staff, .delete-detail, .delete-document', function(event){
        event.preventDefault();
        $(this).parents('.annualreport-item-container').remove();
    });

});