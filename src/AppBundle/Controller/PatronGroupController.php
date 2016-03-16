<?php
/**
 * Methods of this controller should be accessible to ADMINS ONLY!
 */
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\PatronGroup;
use AppBundle\Form\PatronGroupType;

/**
 * PatronStatus controller.
 *
 * Security is controlled for all /admin/* paths by the access_control setting in security.yml.
 * 
 * @Route("/admin/patrongroup")
 */
class PatronGroupController extends Controller
{

    /**
     * Lists all PatronGroup entities.
     *
     * @Route("/", name="admin_patrongroup")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:PatronGroup')->findBy(array(), array('name'=>'ASC'));

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new PatronGroup entity.
     *
     * @Route("/", name="admin_patrongroup_create")
     * @Method("POST")
     * @Template("AppBundle:PatronGroup:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new PatronGroup();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_patrongroup_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a PatronGroup entity.
     *
     * @param PatronGroup $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(PatronGroup $entity)
    {
        $form = $this->createForm(new PatronGroupType(), $entity, array(
            'action' => $this->generateUrl('admin_patrongroup_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new PatronGroup entity.
     *
     * @Route("/new", name="admin_patrongroup_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new PatronGroup();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a PatronGroup entity.
     *
     * @Route("/{id}", name="admin_patrongroup_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:PatronGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PatronGroup entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing PatronGroup entity.
     *
     * @Route("/{id}/edit", name="admin_patrongroup_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:PatronGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PatronGroup entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a PatronGroup entity.
    *
    * @param PatronGroup $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(PatronGroup $entity)
    {
        $form = $this->createForm(new PatronGroupType(), $entity, array(
            'action' => $this->generateUrl('admin_patrongroup_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr'=>array('class'=>'btn btn-sm btn-success')));

        return $form;
    }
    /**
     * Edits an existing PatronGroup entity.
     *
     * @Route("/{id}", name="admin_patrongroup_update")
     * @Method("PUT")
     * @Template("AppBundle:PatronGroup:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:PatronGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PatronGroup entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_patrongroup_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a PatronGroup entity.
     *
     * @Route("/{id}", name="admin_patrongroup_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:PatronGroup')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find PatronGroup entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_patronstatus'));
    }

    /**
     * Creates a form to delete a PatronGroup entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_patrongroup_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array(
                'label' => 'Delete', 
                'attr' => array(
                    'class' => 'btn btn-sm btn-danger',
                    'onclick' => 'return confirm("Are you sure you want to delete this patron group?")'
                    )
                )
            )
            ->getForm()
        ;
    }
}
