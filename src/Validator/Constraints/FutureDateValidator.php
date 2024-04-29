<?php


namespace App\Validator\Constraints;

use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class FutureDateValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof FutureDate) {
            throw new UnexpectedTypeException($constraint, FutureDate::class);
        }

        if (null === $value) {
            return; // NotNull constraint should handle this case
        }

        if (!$value instanceof \DateTimeInterface) {
            throw new UnexpectedValueException($value, \DateTimeInterface::class);
        }

        $today = new \DateTime();
        if ($value <= $today) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
