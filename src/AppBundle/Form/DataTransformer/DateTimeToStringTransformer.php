<?php
namespace AppBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class DateTimeToStringTransformer implements DataTransformerInterface
{
    /**
     * Transforms a DateTime to a string.
     *
     * @param  \DateTime|null $dateTime
     * @return string
     */
    public function transform($dateTime)
    {
        if (null === $dateTime) {
            return '';
        }

        return $dateTime->format('Y-m-d');
    }

    /**
     * Transforms a string to a \DateTime object.
     *
     * @param  string $date
     * @return \DateTime|null
     */
    public function reverseTransform($date)
    {
        // no event number? It's optional, so that's ok
        if (!$date) {
            return;
        }

        return new \DateTime($date);
    }
}

