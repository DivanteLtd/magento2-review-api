<?php
/**
 * Copyright Divante Sp. z o.o.
 * See LICENSE_DIVANTE.txt for license details.
 */
declare(strict_types=1);

namespace Divante\ReviewApi\Model;

use Divante\ReviewApi\Api\Data\ReviewInterface;
use Divante\ReviewApi\Validation\ValidationResult;
use Divante\ReviewApi\Validation\ValidationResultFactory;
use Magento\Framework\Exception\LocalizedException;

/**
 * Chain of validators. Extension point for new validators via di configuration
 *
 * @api
 */
class ReviewValidationChain implements ReviewValidatorInterface
{
    /**
     * @var ValidationResultFactory
     */
    private $validationResultFactory;

    /**
     * @var StockValidatorInterface[]
     */
    private $validators;

    /**
     * @param ValidationResultFactory $validationResultFactory
     * @param ReviewValidatorInterface[] $validators
     * @throws LocalizedException
     */
    public function __construct(
        ValidationResultFactory $validationResultFactory,
        array $validators = []
    ) {
        $this->validationResultFactory = $validationResultFactory;

        foreach ($validators as $validator) {
            if (!$validator instanceof ReviewValidatorInterface) {
                throw new LocalizedException(
                    __('Review Validator must implement ReviewValidatorInterface.')
                );
            }
        }

        $this->validators = $validators;
    }

    /**
     * @inheritdoc
     *
     * @param ReviewInterface $stock
     *
     * @return ValidationResult
     */
    public function validate(ReviewInterface $stock): ValidationResult
    {
        $errors = [];

        foreach ($this->validators as $validator) {
            $validationResult = $validator->validate($stock);

            if (!$validationResult->isValid()) {
                $errors[] = $validationResult->getErrors();
            }
        }

        $errors = count($errors) ? array_merge(...$errors) : [];

        return $this->validationResultFactory->create(['errors' => $errors]);
    }
}
