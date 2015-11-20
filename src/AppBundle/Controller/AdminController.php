<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Resources\Services\UserService as UserService;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin")
     * @Template()
     */
    public function dashboardAction()
    {
      $registeredUsers = $this->getDoctrine()->getRepository('AppBundle\Entity\User')->listUsers();
      
      return $this->render('AppBundle:Admin:dashboard.html.twig', 
          array('page_title' => 'Administration Panel', 
                'num_registeredusers' => count($registeredUsers), 
                'registeredusers' => $registeredUsers,
          )
      );  
    }
    
    /**
     * @Route("/admin/isactive", name="isactive")
     * @Method("POST")
     */
    public function updateUserActivationStatusAction(Request $request){
      $userId = $request->request->get('userId');
      
      $em = $this->getDoctrine();
      
      $user = $em->getRepository('AppBundle\Entity\User')->find($userId);
      
      if(!$user){
        throw $this->createNotFoundException(
            "No user found for id: " . $userId . "."
        );
      }
      
      if($user->getIsActive()){
        $user->setIsActive(0);
      } else {
        $user->setIsActive(1);
      }
      $em->getManager()->flush($user);
      
      return new JsonResponse('User status updated');
    }
    
    /**
     * Creates a form to create a User entity.
     *
     * @param User $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    public function createUserForm(User $entity){
      $form = $this->createForm(new UserType(), $entity, array(
          'action' => $this->generateUrl('user_update', array('id' => $entity->getId(),)),
          'method' => 'PUT',
      ));
      return $form;
    }
}
