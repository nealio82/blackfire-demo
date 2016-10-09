<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class IsNotSpamValidator extends ConstraintValidator
{

    private $spamValidator;

    public function __construct($spamValidator)
    {
        $this->spamValidator = $spamValidator;
    }

    public function validate($value, Constraint $constraint)
    {

        if (!$this->spamValidator->validate($value)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }

    }
}