<?php

namespace AppBundle\Resources\Security\Authorization\Voter;

use Symfony\Component\Security\Core\Authorization\Voter\AbstractVoter;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;

class AvRequestVoter extends AbstractVoter{
    const ADMIN = 'admin';
    const SUPER_ADMIN = 'super_admin';

    protected function getSupportedAttributes()
    {
        return array('ROLE_ADMIN', 'ROLE_SUPER_ADMIN');
    }

    protected function getSupportedClasses()
    {
        return array('AppBundle\Entity\Post');
    }

    protected function isGranted($attribute, $post, $user = null)
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

        switch($attribute) {
            case 'ROLE_ADMIN':
                // the data object could have for example a method isPrivate()
                // which checks the Boolean attribute $private
                if (!$post->isPrivate()) {
                    return true;
                }

                break;
            case 'ROLE_SUPER_ADMIN':
                // this assumes that the data object has a getOwner() method
                // to get the entity of the user who owns this data object
                if ($user->getId() === $post->getOwner()->getId()) {
                    return true;
                }

                break;
        }

        return false;
    }
}
