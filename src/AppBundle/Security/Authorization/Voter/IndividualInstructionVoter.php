<?php

namespace AppBundle\Security\Authorization\Voter;

use Symfony\Component\Security\Core\Authorization\Voter\AbstractVoter;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;

class IndividualInstructionVoter extends AbstractVoter{
    const EDIT = 'edit';
    
    protected function getSupportedAttributes(){
        return array(self::EDIT);
    }
    
    protected function getSupportedClasses(){
        return array('AppBundle\Entity\IndividualInstruction');
    }
    
    protected function isGranted($attribute, $record, $user = null){
        // make sure there is a user object (i.e. that the user is logged in)
        if(!$user instanceof UserInterface){
            return false;
        }
        
        //double-check that the User object is the expected entity (this
        //only happens when you did not configure the security system property)
        if(!$user instanceof User){
            throw new \LogicException('The user is somehow not of the User type!');
        }
        
        switch($attribute){
            case self::EDIT:
                //Grant access if the current user is the user who created the record
                if($user->getId() === $record->getCreatedBy()->getId()){
                    return true;
                }
                break;
        }
        
        return false;
    }
}

