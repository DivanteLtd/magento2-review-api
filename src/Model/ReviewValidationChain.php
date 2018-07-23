<?php
/**
 * @package  Divante\ReviewApi
 * @author Agata Firlejczyk <afirlejczyk@divante.pl>
 * @copyright 2018 Divante Sp. z o.o.
 * @license See LICENSE_DIVANTE.txt for license details.
 */

namespace Divante\ReviewApi\Model;

use Divante\ReviewApi\Api\Data\ReviewInterface;
use Divante\ReviewApi\Validation\ValidationResult;
use Divante\ReviewApi\Validation\ValidationResultFactory;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class ReviewValidationChain
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
     */
    public function validate(ReviewInterface $stock): ValidationResult
    {
        $errors = [];

        foreach ($this->validators as $validator) {
            $validationResult = $validator->validate($stock);

            if (!$validationResult->isValid()) {
                $errors = array_merge($errors, $validationResult->getErrors());
            }
        }

        return $this->validationResultFactory->create(['errors' => $errors]);
    }
}
