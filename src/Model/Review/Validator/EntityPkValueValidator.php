<?php
/**
 * @package  Divante\ReviewApi
 * @author Agata Firlejczyk <afirlejczyk@divante.pl>
 * @copyright 2018 Divante Sp. z o.o.
 * @license See LICENSE_DIVANTE.txt for license details.
 */

namespace Divante\ReviewApi\Model\Review\Validator;

use Divante\ReviewApi\Api\Data\ReviewInterface;
use Divante\ReviewApi\Validation\ValidationResult;
use Divante\ReviewApi\Validation\ValidationResultFactory;
use Divante\ReviewApi\Model\ReviewValidatorInterface;

/**
 * Class TitleValidator - validates review entityPkValue
 */
class EntityPkValueValidator implements ReviewValidatorInterface
{
    /**
     * @var ValidationResultFactory
     */
    private $validationResultFactory;

    /**
     * @param ValidationResultFactory $validationResultFactory
     */
    public function __construct(ValidationResultFactory $validationResultFactory)
    {
        $this->validationResultFactory = $validationResultFactory;
    }

    /**
     * Check if Review has entity pk value
     *
     * @param ReviewInterface $review
     *
     * @return ValidationResult
     */
    public function validate(ReviewInterface $review): ValidationResult
    {
        $value = (int)$review->getEntityPkValue();
        $errors = [];

        if (!$value) {
            $errors[] = __('"%field" can not be empty. Add Product ID.', ['field' => ReviewInterface::ENTITY_PK_VALUE]);
        }

        return $this->validationResultFactory->create(['errors' => $errors]);
    }
}
