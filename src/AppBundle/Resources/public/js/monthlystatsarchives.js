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
    
////// Requested Books //////
    var $requestedBookHolder;
        $requestedBookHolder = $('ul.requested_book');
        
    var $addRequestedBookLink = $('<a href="#" class="add_requestedcollection_link">+ Add Book</a>');
    var $newRequestedBookLi = $('<li></li>').append($addRequestedBookLink);

    // add the "+ Add Book" li to the ul
    $requestedBookHolder.append($newRequestedBookLi);

    $requestedBookHolder.data('index', $requestedBookHolder.find(':input').length);
    
    //Add an additional archives book form each time a user clicks the $addRequestedBookLink
    $addRequestedBookLink.on('click', function(e) {
        e.preventDefault();
        addBookForm($requestedBookHolder, $newRequestedBookLi);
    });
    
    addBookForm($requestedBookHolder, $newRequestedBookLi, 'requested');
    
////// Digitization Books //////
    var $digitizationBookHolder;
        $digitizationBookHolder = $('ul.digitization_book');
        
    var $addDigitizationBookLink = $('<a href="#" class="add_digitizationcollection_link">+ Add Book</a>');
    var $newDigitizationBookLi = $('<li></li>').append($addDigitizationBookLink);

    // add the "+ Add Book" li to the ul
    $digitizationBookHolder.append($newDigitizationBookLi);

    $digitizationBookHolder.data('index', $digitizationBookHolder.find(':input').length);
    
    //Add an additional archives book form each time a user clicks the $addDigitizationBookLink
    $addDigitizationBookLink.on('click', function(e) {
        e.preventDefault();
        addBookForm($digitizationBookHolder, $newDigitizationBookLi);
    });
    
    addBookForm($digitizationBookHolder, $newDigitizationBookLi, 'digitization');

    
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

        // Display the form in the page in an li, before the "Add a tag" link li
        if(bootstrapListStyle === true){
            var newFormLi = '<li class="list-group-item __formType__bookquantity-item-container"></li>';
                newFormLi = newFormLi.replace(/__formType__/g, formType);
            var $newFormLi = $(newFormLi).append(newForm);
        } else {
            var newFormLi = '<li class="__formType__bookquantity-item-container"></li>';
                newFormLi = newFormLi.replace(/__formType__/g, formType);
            var $newFormLi = $(newFormLi).append(newForm);
        }    
        $newLinkLi.before($newFormLi);
    }
});

