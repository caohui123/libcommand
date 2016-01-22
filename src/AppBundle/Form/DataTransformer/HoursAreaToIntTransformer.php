<?php
namespace AppBundle\Form\DataTransformer;

use AppBundle\Entity\HoursArea;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class HoursAreaToIntTransformer implements DataTransformerInterface
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Transforms an object (HoursArea) to a string (number).
     *
     * @param  HoursArea|null $area
     * @return string
     */
    public function transform($area)
    {
        if (null === $area) {
            return '';
        }

        return $area->getId();
    }

    /**
     * Transforms a string (number) to an object (HoursArea).
     *
     * @param  string $areaId
     * @return HoursArea|null
     * @throws TransformationFailedException if object (HoursArea) is not found.
     */
    public function reverseTransform($areaId)
    {
        // no area number? It's optional, so that's ok
        if (!$areaId) {
            return;
        }

        $area = $this->manager
            ->getRepository('AppBundle:HoursArea')
            // query for the issue with this id
            ->find($areaId)
        ;

        if (null === $area) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'An area with number "%s" does not exist!',
                $areaId
            ));
        }

        return $area;
    }
}

