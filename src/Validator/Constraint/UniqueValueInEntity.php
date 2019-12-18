<?php

namespace App\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

class UniqueValueInEntity extends Constraint
{
    public $message = 'This value is already used.';
    public $entityClass;
    public $field;

    public function getRequiredOptions(): array
    {
        return ['entityClass', 'field'];
    }

    public function getTargets(): string
    {
        return self::PROPERTY_CONSTRAINT;
    }

    public function validatedBy(): string
    {
        return UniqueValueInEntityValidator::class;
    }
}
