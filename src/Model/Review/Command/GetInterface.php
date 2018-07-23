<?php
/**
 * @package  Divante\ReviewApi
 * @author Agata Firlejczyk <afirlejczyk@divante.pl>
 * @copyright 2018 Divante Sp. z o.o.
 * @license See LICENSE_DIVANTE.txt for license details.
 */

namespace Divante\ReviewApi\Model\Review\Command;

use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Interface GetInterface
 */
interface GetInterface
{
    /***
     * @param int $reviewId
     *
     * @return \Divante\ReviewApi\Api\Data\ReviewInterface
     * @throws NoSuchEntityException
     */
    public function execute($reviewId);
}
