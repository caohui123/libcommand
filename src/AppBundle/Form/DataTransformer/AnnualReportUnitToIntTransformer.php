<?php

namespace AppBundle\Form\DataTransformer;

use AppBundle\Entity\AnnualReportUnit;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class AnnualReportUnitToIntTransformer implements DataTransformerInterface
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Transforms an object (staff) to a string (number).
     *
     * @param  Staff|null $staff
     * @return string
     */
    public function transform($staff)
    {
        if (null === $staff) {
            return '';
        }

        return $staff->getId();
    }

    /**
     * Transforms a string (number) to an object (Staff).
     *
     * @param  string $staffNumber
     * @return Staff|null
     * @throws TransformationFailedException if object (Staff) is not found.
     */
    public function reverseTransform($staffNumber)
    {
        // no staff number? It's optional, so that's ok
        if (!$staffNumber) {
            return;
        }

        $staff = $this->manager
            ->getRepository('AppBundle:AnnualReportUnit')
            // query for the staff with this id
            ->find($staffNumber)
        ;

        if (null === $staff) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'An AnnualReportUnit entity with number "%s" does not exist!',
                $staffNumber
            ));
        }

        return $staff;
    }
}

