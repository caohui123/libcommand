<?php

namespace AppBundle\Resources\Security\Authorization\Voter;

use Symfony\Component\Security\Core\Authorization\Voter\AbstractVoter;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Role\RoleHierarchy;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class AvRequestVoter extends AbstractVoter{
    const VIEW = 'ROLE_AV_VIEW';
    const EDIT = 'ROLE_AV_EDIT';
    const DELETE = 'ROLE_AV_DELETE';
    
    protected $securityContext;
    
    public function __construct($securityContext) {
      $this->securityContext = $securityContext;
    }

    protected function getSupportedAttributes()
    {
        return array(self::VIEW, self::EDIT, self::DELETE);
    }

    protected function getSupportedClasses()
    {
        return array('AppBundle\Entity\AvRequest');
    }

    protected function isGranted($attribute, $avrequest, $user = null)
    {
        // make sure there is a user object (i.e. that the user is logged in)
        if (!$user instanceof UserInterface) {
            return false;
        }

        // double-check that the User object is the expected entity (this
        // only happens when you did not configure the security system properly)
        if (!$user instanceof User) {
            throw new \LogicException('The user is somehow not our User class!');
        }

        return false;
    }
}

