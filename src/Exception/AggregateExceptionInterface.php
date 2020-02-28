<?php
/**
 * @package  Divante\ReviewApi
 * @author Agata Firlejczyk <afirlejczyk@divante.pl>
 * @copyright 2018 Divante Sp. z o.o.
 * @license See LICENSE_DIVANTE.txt for license details.
 */

namespace Divante\ReviewApi\Exception;

use Magento\Framework\Exception\LocalizedException;

/**
 * Interface AggregateExceptionInterface
 */
interface AggregateExceptionInterface
{
    /**
     * Returns LocalizedException[] array
     *
     * @see the \Magento\Framework\Webapi\Exception which receives $errors as a set of Localized Exceptions
     *
     * @return LocalizedException[]
     */
    public function getErrors();
}
