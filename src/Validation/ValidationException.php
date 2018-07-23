<?php
/**
 * @package  Divante\ReviewApi
 * @author Agata Firlejczyk <afirlejczyk@divante.pl>
 * @copyright 2018 Divante Sp. z o.o.
 * @license See LICENSE_DIVANTE.txt for license details.
 */

namespace Divante\ReviewApi\Validation;

use Magento\Framework\Exception\LocalizedException;
use Divante\ReviewApi\Exception\AggregateExceptionInterface;
use Magento\Framework\Phrase;

/**
 * Class ValidationException
 */
class ValidationException extends LocalizedException implements AggregateExceptionInterface
{
    /**
     * @var ValidationResult|null
     */
    private $validationResult;

    /**
     * @param Phrase $phrase
     * @param \Exception $cause
     * @param int $code
     * @param ValidationResult|null $validationResult
     */
    public function __construct(
        Phrase $phrase,
        \Exception $cause = null,
        $code = 0,
        ValidationResult $validationResult = null
    ) {
        parent::__construct($phrase, $cause, $code);
        $this->validationResult = $validationResult;
    }

    /**
     * @inheritdoc
     */
    public function getErrors(): array
    {
        $localizedErrors = [];

        if (null !== $this->validationResult) {
            foreach ($this->validationResult->getErrors() as $error) {
                $localizedErrors[] = new LocalizedException($error);
            }
        }

        return $localizedErrors;
    }
}
