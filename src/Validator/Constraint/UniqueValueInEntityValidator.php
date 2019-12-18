<?php

namespace App\Validator\Constraint;

use Doctrine\ORM\EntityManager;
use InvalidArgumentException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueValueInEntityValidator extends ConstraintValidator
{
    private EntityManager $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function validate($value, Constraint $constraint): void
    {
        if (!is_scalar($constraint->field)) {
            throw new InvalidArgumentException('"field" parameter should be any scalar type');
        }

        $entityRepository = $this->em->getRepository($constraint->entityClass);

        $searchResults = $entityRepository->findBy([
            $constraint->field => $value
        ]);

        if (count($searchResults) > 0) {
            $this->context
                ->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
