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
 * Class TitleValidator - validates review stores
 */
class StoresValidator implements ReviewValidatorInterface
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
     * Check if review has stores set
     *
     * @param ReviewInterface $review
     *
     * @return ValidationResult
     */
    public function validate(ReviewInterface $review): ValidationResult
    {
        $value = (array)$review->getStores();
        $errors = [];

        if (empty($value)) {
            $errors[] = __('"%field" can not be empty.', ['field' => ReviewInterface::STORES]);
        }

        return $this->validationResultFactory->create(['errors' => $errors]);
    }
}
