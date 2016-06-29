$(document).ready(function(){
// Navigation tabs
    $('#research-container, #digitization-container').hide();
    $('ul#monthlyarchives-tabs > li a').on('click', function(e){
        e.preventDefault();
        
        var divToShow = $(this).attr('href'); //the ID of the div to display is stored in the href of the nav tab
        $('.monthlyarchives-tab').each(function(){
            $(this).removeClass('active'); // remove the active class from all tabs
        });
        $(this).parent('.monthlyarchives-tab').addClass('active'); // put an active class on the tab that was clicked
        
        // hide all form sections
        $('.monthly-stats-section').each(function(){
            $(this).hide();
        });
        
        $(divToShow).show(); //show the form section for the tab that was clicked
    })
    
////// Requested Collection //////
    var $requestedCollectionHolder;
        $requestedCollectionHolder = $('ul.requested_collection');
        
    var $addRequestedCollectionLink = $('<a href="#" class="btn btn-sm btn-info add_requestedcollection_link archives_addbtn">+ Collection</a>');
    var $newRequestedCollectionLi = $('<li class="list-style-none"></li>').append($addRequestedCollectionLink);

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
        
    var $addDigitizationCollectionLink = $('<a href="#" class="btn btn-sm btn-info add_digitizationcollection_link archives_addbtn">+ Collection</a>');
    var $newDigitizationCollectionLi = $('<li class="list-style-none"></li>').append($addDigitizationCollectionLink);

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
    
    //Add an additional box collection form each time a user clicks the newBoxQuantity anchor
    $(document).on('click', '.add_digitizationboxquantity_link', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();
        
        // add a new collection form
        addDigitizationBoxForm($(this), $digitizationCollectionHolder);
    });
    
////// Requested Books //////
    var $requestedBookHolder;
        $requestedBookHolder = $('ul.requested_book');
        
    var $addRequestedBookLink = $('<a href="#" class="btn btn-sm btn-info add_requestedcollection_link archives_addbtn">+ Book</a>');
    var $newRequestedBookLi = $('<li class="list-style-none"></li>').append($addRequestedBookLink);

    // add the "+ Add Book" li to the ul
    $requestedBookHolder.append($newRequestedBookLi);

    $requestedBookHolder.data('index', $requestedBookHolder.find(':input').length);
    
    //Add an additional archives book form each time a user clicks the $addRequestedBookLink
    $addRequestedBookLink.on('click', function(e) {
        e.preventDefault();
        addBookForm($requestedBookHolder, $newRequestedBookLi, 'requested', true);
    });
    
////// Digitization Books //////
    var $digitizationBookHolder;
        $digitizationBookHolder = $('ul.digitization_book');
        
    var $addDigitizationBookLink = $('<a href="#" class="btn btn-sm btn-info add_digitizationcollection_link archives_addbtn">+ Book</a>');
    var $newDigitizationBookLi = $('<li class="list-style-none"></li>').append($addDigitizationBookLink);

    // add the "+ Add Book" li to the ul
    $digitizationBookHolder.append($newDigitizationBookLi);

    $digitizationBookHolder.data('index', $digitizationBookHolder.find(':input').length);
    
    //Add an additional archives book form each time a user clicks the $addDigitizationBookLink
    $addDigitizationBookLink.on('click', function(e) {
        e.preventDefault();
        addBookForm($digitizationBookHolder, $newDigitizationBookLi, 'digitization', true);
    });
    
////// Requested Files //////
    var $requestedFileHolder;
        $requestedFileHolder = $('ul.requested_file');
        
    var $addRequestedFileLink = $('<a href="#" class="btn btn-sm btn-info add_requestedfile_link archives_addbtn">+ File</a>');
    var $newRequestedFileLi = $('<li class="list-style-none"></li>').append($addRequestedFileLink);

    // add the "+ Add File" li to the ul
    $requestedFileHolder.append($newRequestedFileLi);

    $requestedFileHolder.data('index', $requestedFileHolder.find(':input').length);
    
    //Add an additional archives book form each time a user clicks the $addRequestedFileLink
    $addRequestedFileLink.on('click', function(e) {
        e.preventDefault();
        addFileForm($requestedFileHolder, $newRequestedFileLi, 'requested', true);
    });
    
////// Digitization Files //////
    var $digitizationFileHolder;
        $digitizationFileHolder = $('ul.digitization_file');
        
    var $addDigitizationFileLink = $('<a href="#" class="btn btn-sm btn-info add_digitizationfile_link archives_addbtn">+ File</a>');
    var $newDigitizationFileLi = $('<li class="list-style-none"></li>').append($addDigitizationFileLink);

    // add the "+ Add File" li to the ul
    $digitizationFileHolder.append($newDigitizationFileLi);

    $digitizationFileHolder.data('index', $digitizationFileHolder.find(':input').length);
    
    //Add an additional archives book form each time a user clicks the $addDigitizationFileLink
    $addDigitizationFileLink.on('click', function(e) {
        e.preventDefault();
        addFileForm($digitizationFileHolder, $newDigitizationFileLi, 'digitization', true);
    });
    
////// Collection Processed //////
    var $processedCollectionHolder;
        $processedCollectionHolder = $('ul.processed_collection');
        
    var $addProcessedCollectionLink = $('<a href="#" class="btn btn-sm btn-info add_processedcollection_link archives_addbtn">+ Processed Collection</a>');
    var $newProcessedCollectionLi = $('<li class="list-style-none"></li>').append($addProcessedCollectionLink);

    // add the "+ Processed Collection" li to the ul
    $processedCollectionHolder.append($newProcessedCollectionLi);

    $processedCollectionHolder.data('index', $processedCollectionHolder.find(':input').length);
    
    //Add an additional archives book form each time a user clicks the $addProcessedCollectionLink
    $addProcessedCollectionLink.on('click', function(e) {
        e.preventDefault();
        addCollectionProcessedStoredForm($processedCollectionHolder, $newProcessedCollectionLi, 'processed', true);
    });
    
////// Collection Stored //////
    var $storedCollectionHolder;
        $storedCollectionHolder = $('ul.stored_collection');
        
    var $addStoredCollectionLink = $('<a href="#" class="btn btn-sm btn-info add_storedcollection_link archives_addbtn">+ Stored Collection</a>');
    var $newStoredCollectionLi = $('<li class="list-style-none"></li>').append($addStoredCollectionLink);

    // add the "+ Stored Collection" li to the ul
    $storedCollectionHolder.append($newStoredCollectionLi);

    $storedCollectionHolder.data('index', $storedCollectionHolder.find(':input').length);
    
    //Add an additional archives book form each time a user clicks the $addStoredCollectionLink
    $addStoredCollectionLink.on('click', function(e) {
        e.preventDefault();
        addCollectionProcessedStoredForm($storedCollectionHolder, $newStoredCollectionLi, 'stored', true);
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
            var $newCollectionFormLi = $('<li class="list-style-none requestedcollection-item-container"></li>').append(newCollectionForm);
        }    
        
        // Display the box form in the boxquantity list in an li, before the "Add box" link li
        var newBoxFormUl = '<ul class="requested_collection_boxquantity" id="requested_collection_boxquantity___index__"></ul>';
            newBoxFormUl = newBoxFormUl.replace(/__index__/g, index);
        var $newBoxFormUl = $(newBoxFormUl);
        var $newBoxFormLi = $('<li class="list-group-item requestedcollectionbox-item-container"></li>');
        
        // COLLECTION BOXES
        var newBoxQuantityLink = '<a href="#" class="btn btn-sm btn-default add_requestedboxquantity_link archives_addbtn" id="add_requestedboxquantity_link___index__">+ Box</a>';
            newBoxQuantityLink = newBoxQuantityLink.replace(/__index__/g, index);
        var $newBoxQuantityLink = $(newBoxQuantityLink);
        var $newBoxQuantityLi = $('<li class="list-style-none"></li>').append($newBoxQuantityLink);
        
        // increase the index with one for the next item
        $collectionHolder.data('index', index + 1);
        
        $newBoxFormLi.append(newBoxForm);
        $newBoxFormUl.append($newBoxFormLi);
        $newBoxFormUl.append($newBoxQuantityLi); 
        $newCollectionFormLi.append($newBoxFormUl);
        // end of COLLECTION BOXES
        
        // Add the collection and box before the +Add Collection list item
        $newLinkLi.before($newCollectionFormLi);
        
        //Update the total number of digitization collections
        $('#requested_collections_total').html($(document).find('.requestedcollection-item-container').length);
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
            var $newCollectionFormLi = $('<li class="list-style-none digitizationcollection-item-container"></li>').append(newCollectionForm);
        }    
        
        // Display the box form in the boxquantity list in an li, before the "Add box" link li
        var newBoxFormUl = '<ul class="digitization_collection_boxquantity" id="digitization_collection_boxquantity___index__"></ul>';
            newBoxFormUl = newBoxFormUl.replace(/__index__/g, index);
        var $newBoxFormUl = $(newBoxFormUl);
        var $newBoxFormLi = $('<li class="list-group-item digitizationcollectionbox-item-container"></li>');
        
        // COLLECTION BOXES
        var newBoxQuantityLink = '<a href="#" class="btn btn-sm btn-default add_digitizationboxquantity_link archives_addbtn" id="add_digitizationboxquantity_link___index__">+ Box</a>';
            newBoxQuantityLink = newBoxQuantityLink.replace(/__index__/g, index);
        var $newBoxQuantityLink = $(newBoxQuantityLink);
        var $newBoxQuantityLi = $('<li class="list-style-none"></li>').append($newBoxQuantityLink);
        
        // increase the index with one for the next item
        $collectionHolder.data('index', index + 1);
        
        $newBoxFormLi.append(newBoxForm);
        $newBoxFormUl.append($newBoxFormLi);
        $newBoxFormUl.append($newBoxQuantityLi); 
        $newCollectionFormLi.append($newBoxFormUl);
        // end of COLLECTION BOXES
        
        // Add the collection and box before the +Add Collection list item
        $newLinkLi.before($newCollectionFormLi);
        
        //Update the total number of digitization collections
        $('#digitization_collections_total').html($(document).find('.digitizationcollection-item-container').length);
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
    
    /**
     * Uses Symfony's prototype code to generate a new list item for a book 
     *
     * @param jQuery Object $collectionHolder   The <ul> which holds the collection and prototypes
     * @param jQuery Object $newLinkLi          The jQuery element of the link that was just clicked.
     */
    function addBookForm($collectionHolder, $newLinkLi, formType, bootstrapListStyle) {
        // Get the data-prototype explained earlier
        var prototype = $collectionHolder.data('prototype');

        // get the new index
        var index = $collectionHolder.data('index');

        // Replace '__name__' in the prototype's HTML to
        // instead be a number based on how many items we have
        var newForm = prototype.replace(/__name__/g, index);

        // increase the index with one for the next item
        $collectionHolder.data('index', index + 1);

        // Display the form in the page in an li, before the "Add book" link li
        if(bootstrapListStyle === true){
            var newFormLi = '<li class="list-group-item __formType__bookquantity-item-container"></li>';
                newFormLi = newFormLi.replace(/__formType__/g, formType);
            var $newFormLi = $(newFormLi).append(newForm);
        } else {
            var newFormLi = '<li class="list-style-none __formType__bookquantity-item-container"></li>';
                newFormLi = newFormLi.replace(/__formType__/g, formType);
            var $newFormLi = $(newFormLi).append(newForm);
        }    
        $newLinkLi.before($newFormLi);
    }
    
    /**
     * Uses Symfony's prototype code to generate a new list item for a file 
     *
     * @param jQuery Object $collectionHolder   The <ul> which holds the collection and prototype
     * @param jQuery Object $newLinkLi          The jQuery element of the link that was just clicked.
     */
    function addFileForm($collectionHolder, $newLinkLi, formType, bootstrapListStyle) {
        // Get the data-prototype explained earlier
        var prototype = $collectionHolder.data('prototype');

        // get the new index
        var index = $collectionHolder.data('index');

        // Replace '__name__' in the prototype's HTML to
        // instead be a number based on how many items we have
        var newForm = prototype.replace(/__name__/g, index);

        // increase the index with one for the next item
        $collectionHolder.data('index', index + 1);

        // Display the form in the page in an li, before the "Add form" link li
        if(bootstrapListStyle === true){
            var newFormLi = '<li class="list-group-item __formType__file-item-container"></li>';
                newFormLi = newFormLi.replace(/__formType__/g, formType);
            var $newFormLi = $(newFormLi).append(newForm);
        } else {
            var newFormLi = '<li class="list-style-none __formType__file-item-container"></li>';
                newFormLi = newFormLi.replace(/__formType__/g, formType);
            var $newFormLi = $(newFormLi).append(newForm);
        }    
        $newLinkLi.before($newFormLi);
    }
    
    /**
     * Uses Symfony's prototype code to generate a new list item for a processed or stored collection
     *
     * @param jQuery Object $collectionHolder   The <ul> which holds the collection and prototype
     * @param jQuery Object $newLinkLi          The jQuery element of the link that was just clicked.
     */
    function addCollectionProcessedStoredForm($collectionHolder, $newLinkLi, formType, bootstrapListStyle) {
        // Get the data-prototype explained earlier
        var prototype = $collectionHolder.data('prototype');

        // get the new index
        var index = $collectionHolder.data('index');

        // Replace '__name__' in the prototype's HTML to
        // instead be a number based on how many items we have
        var newForm = prototype.replace(/__name__/g, index);

        // increase the index with one for the next item
        $collectionHolder.data('index', index + 1);

        // Display the form in the page in an li, before the "Add form" link li
        if(bootstrapListStyle === true){
            var newFormLi = '<li class="list-group-item __formType__collection-item-container"></li>';
                newFormLi = newFormLi.replace(/__formType__/g, formType);
            var $newFormLi = $(newFormLi).append(newForm);
        } else {
            var newFormLi = '<li class="list-style-none __formType__collection-item-container"></li>';
                newFormLi = newFormLi.replace(/__formType__/g, formType);
            var $newFormLi = $(newFormLi).append(newForm);
        }    
        $newLinkLi.before($newFormLi);
        
        //Update the total number of processed/stored collections
        var containerClass = '.__formType__collection-item-container';
            containerClass = containerClass.replace(/__formType__/g, formType);
        var totalCollections = 0;
            totalCollections += $(document).find(containerClass).length;
            
        var totalDiv = '#__formType___collections_total';
            totalDiv = totalDiv.replace(/__formType__/g, formType);
            
        $(totalDiv).html(totalCollections);
    }
    
// Item deletions
    $(document).on('click', '.delete-requestedbook', function(event){
        event.preventDefault();
        $(this).parents('.requestedbookquantity-item-container').remove();
        
        updateTotal($('.requestedbook_quantity'), $('#requested_books_total'));
    });
    $(document).on('click', '.delete-digitizationbook', function(event){
        event.preventDefault();
        $(this).parents('.digitizationbookquantity-item-container').remove();
        
        updateTotal($('.digitizationbook_quantity'), $('#digitization_books_total'));
    });
    $(document).on('click', '.delete-requestedfile', function(event){
        event.preventDefault();
        $(this).parents('.requestedfile-item-container').remove();
        
        updateTotal($('.requestedfile_quantity'), $('#requested_files_total'));
    });
    $(document).on('click', '.delete-digitizationfile', function(event){
        event.preventDefault();
        $(this).parents('.digitizationfile-item-container').remove();
        
        updateTotal($('.digitizationfile_quantity'), $('#digitization_files_total'));
    });
    $(document).on('click', '.delete-requestedcollectionsbox', function(event){
        event.preventDefault();
        $(this).parents('.requestedcollectionbox-item-container').remove();
        
        updateTotal($('.requestedcollectionbox_quantity'), $('#requested_collectionboxes_total'));
    });
    $(document).on('click', '.delete-digitizationcollectionsbox', function(event){
        event.preventDefault();
        $(this).parents('.digitizationcollectionbox-item-container').remove();
        
        updateTotal($('.digitizationcollectionbox_quantity'), $('#digitization_collectionboxes_total'));
    });
    $(document).on('click', '.delete-requestedcollection', function(event){
        event.preventDefault();
        $(this).parents('.requestedcollection-item-container').remove();
        
        updateTotal($('.requestedcollectionbox_quantity'), $('#requested_collectionboxes_total')); //boxes
        
        //update collection totals
        $('#requested_collections_total').html( $(document).find('.requestedcollection-item-container').length );
    });
    $(document).on('click', '.delete-digitizationcollection', function(event){
        event.preventDefault();
        $(this).parents('.digitizationcollection-item-container').remove();
        
        updateTotal($('.digitizationcollectionbox_quantity'), $('#digitization_collectionboxes_total')); //boxes
        
        //update collection totals
        $('#digitization_collections_total').html( $(document).find('.digitizationcollection-item-container').length );
    });
    $(document).on('click', '.delete-processedcollection', function(event){
        event.preventDefault();
        $(this).parents('.processedcollection-item-container').remove();
        
        //update collection totals
        $('#processed_collections_total').html( $(document).find('.processedcollection-item-container').length );
    });
    $(document).on('click', '.delete-storedcollection', function(event){
        event.preventDefault();
        $(this).parents('.storedcollection-item-container').remove();
        
        //update collection totals
        $('#stored_collections_total').html( $(document).find('.storedcollection-item-container').length );
    });
  
// Update minute totals on page load and whenever a .jscript_total number input is changed
    $('.jscript_total').each(function(){
       updateMinutes($(this)); 
    });
    
    $(document).on('change', '.jscript_total', function(e){
        updateMinutes($(this));
    })
    
// Update book/file/box totals on page load and when changed (new.html.twig and edit.html.twig)
// NOTE: Collection totals updated in the addCollection functions when a new collection is added.
    
    $('#requested_collections_total').html($(document).find('.requestedcollection-item-container').length);
    $('#digitization_collections_total').html($(document).find('.digitizationcollection-item-container').length);
    $('#processed_collections_total').html($(document).find('.processedcollection-item-container').length);
    $('#stored_collections_total').html($(document).find('.storedcollection-item-container').length);
    updateTotal($('.requestedbook_quantity'), $('#requested_books_total'));
    updateTotal($('.digitizationbook_quantity'), $('#digitization_books_total'));
    updateTotal($('.requestedfile_quantity'), $('#requested_files_total'));
    updateTotal($('.digitizationfile_quantity'), $('#digitization_files_total'));
    updateTotal($('.requestedcollectionbox_quantity'), $('#requested_collectionboxes_total'));
    updateTotal($('.digitizationcollectionbox_quantity'), $('#digitization_collectionboxes_total'));
    
    $(document).on('change', '.requestedbook_quantity', function(e){
        updateTotal($('.requestedbook_quantity'), $('#requested_books_total'));
    });
    $(document).on('change', '.digitizationbook_quantity', function(e){
        updateTotal($('.digitizationbook_quantity'), $('#digitization_books_total'));
    });
    $(document).on('change', '.requestedfile_quantity', function(e){
        updateTotal($('.requestedfile_quantity'), $('#requested_files_total'));
    });
    $(document).on('change', '.digitizationfile_quantity', function(e){
        updateTotal($('.digitizationfile_quantity'), $('#digitization_files_total'));
    });
    $(document).on('change', '.requestedcollectionbox_quantity', function(e){
        updateTotal($('.requestedcollectionbox_quantity'), $('#requested_collectionboxes_total'));
    });
    $(document).on('change', '.digitizationcollectionbox_quantity', function(e){
        updateTotal($('.digitizationcollectionbox_quantity'), $('#digitization_collectionboxes_total'));
    });
    
//Calculate book/file/box/collection totals on page load (show.html.twig)    
    $('#show_requested_collections_total').html($(document).find('.show_requested_collections_quantity').length);
    $('#show_digitization_collections_total').html($(document).find('.show_digitization_collections_quantity').length);
    $('#show_processed_collections_total').html($(document).find('.show_processed_collections_quantity').length);
    $('#show_stored_collections_total').html($(document).find('.show_stored_collections_quantity').length);
    updateTotal($('.show_requested_books_quantity'), $('#show_requested_books_total'), true);
    updateTotal($('.show_digitization_books_quantity'), $('#show_digitization_books_total'), true);
    updateTotal($('.show_requested_collectionboxes_quantity'), $('#show_requested_collectionboxes_total'), true);
    updateTotal($('.show_digitization_collectionboxes_quantity'), $('#show_digitization_collectionboxes_total'), true);
    updateTotal($('.show_requested_files_quantity'), $('#show_requested_files_total'), true);
    updateTotal($('.show_digitization_files_quantity'), $('#show_digitization_files_total'), true);
    
    /**
     * Sum up the total for all values given in each input field (new.html.twig, edit.html.twig, show.html.twig).
     * 
     * @param jQuery Object $items      The class of items whose total should be added.
     * @param jQuery Object $targetDiv  The target div where the sum should be updated.
     * @param boolean $html             Should an html value be parsed as an int (true) or should an input value be parsed as an int (false).
     */ 
    function updateTotal($items, $targetDiv, $html){
        var total = 0;
        
        $items.each(function(){
            if($html === true){
                total += parseInt($(this).html()); 
            } else {
                total += parseInt($(this).val()); 
            }
        });
        $targetDiv.html(total)
    }
    
    /**
     * Multiply the number value of the given item times the multiplier specified in the div ID (new.html.twig and edit.html.twig).
     * 
     * @param jQuery Object $changedItem  The element whose total should be multiplied.
     */ 
    function updateMinutes($changedItem){
        var id = $changedItem.attr('id');
        var multiplier = id.match(/\d+$/); //matches the number at the end of the ID string
       
        if( $changedItem.hasClass('research_minutes') ){
            var targetDiv = 'research_minutes___minutes___total';
               targetDiv = targetDiv.replace(/__minutes__/g, multiplier);
           
            $('#' + targetDiv).html($changedItem.val() * multiplier);
        } 
        if( $changedItem.hasClass('instructional_minutes') ){
           var targetDiv = 'instructional_minutes___minutes___total';
               targetDiv = targetDiv.replace(/__minutes__/g, multiplier);
               
           $('#' + targetDiv).html($changedItem.val() * multiplier);
        }
    }
});

