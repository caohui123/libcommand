<?php

namespace AppBundle\Exception;

use AppBundle\Exception\LibcommandExceptionInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

class NoAssociatedStaffException extends HttpException implements LibcommandExceptionInterface{
    public function __construct($message = 'This NetID is not associated with a Staff entity.', \Exception $previous = null, $code = 0)
    {
        parent::__construct(422, $message, $previous, array(), $code);
    }
}