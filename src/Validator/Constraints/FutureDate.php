<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class FutureDate extends Constraint
{
    public string $message = 'The event start time must be in the future.';
}

