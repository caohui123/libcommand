<?php

namespace AppBundle\Controller\Interfaces;

use Symfony\Component\HttpFoundation\Request;

/**
 * Document interface. Use this interface for ALL Entity controllers where the entity extends the Document base entity
 * 
 * ROUTE TO ALL MEDIA INDEX LOCATED IN DefaultController.php
 */
interface DocumentControllerInterface
{
    public function indexAction(Request $request); //Lists all entities (request parameter for pagination purposes).
    public function createAction(Request $request); //Create a new entity
    public function createAjaxAction(Request $request); //Same as createAction but for AJAX creation
    public function newAction(); //Displays a form to create a new entity.
    public function showAction($id); //Finds and displays an entity.
    public function editAction($id); //Displays a form to edit an existing Document entity.
    public function updateAction(Request $request, $id); //Edits an existing entity.
    public function deleteAction(Request $request, $id); //Deletes a entity.
}
