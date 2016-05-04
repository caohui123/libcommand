<?php
namespace AppBundle\Security\Authorization\Voter;

use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

abstract class AbstractVoter implements VoterInterface{
    abstract protected function getSupportedClasses();
    abstract protected function getSupportedAttributes();
    abstract protected function isGranted($attribute, $object, $user = null);
}