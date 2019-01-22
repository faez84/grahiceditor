<?php

namespace App\Service;

use App\Exceptions\BadRequestHttpException;
use App\Interfaces\Shape;
use App\Models\AbstractShape;
use Symfony\Component\Validator\Validator\RecursiveValidator;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validation;

class Validator
{
    /**
     * @param AbstractShape $shape
     * @throws BadRequestHttpException
     */
    public static function basicValidation(AbstractShape $shape): void
    {
        /** @var RecursiveValidator $validator */
        $validator = Validation::createValidatorBuilder()
            ->enableAnnotationMapping()
            ->getValidator();
        /** @var ConstraintViolationList  $errors */
        $errors = $validator->validate($shape);
        if (count($errors)) {
            $errorMessages = self::getErrorMessages($errors);

            throw new BadRequestHttpException(implode($errorMessages, ', '));
        }
    }

    /**
     * @param $errors
     * @return array
     */
    private static function getErrorMessages($errors): array
    {
        $errorMessages = [];
        /** @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $errorMessages[] = sprintf(
                '%s: %s',
                $error->getPropertyPath(),
                $error->getMessage()
            );
        }

        return $errorMessages;
    }
}
