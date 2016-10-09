<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class IsNotSpam extends Constraint
{
    public $message = 'The message is spammy.';
}