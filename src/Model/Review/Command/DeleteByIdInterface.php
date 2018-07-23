<?php
/**
 * @package  Divante\ReviewApi
 * @author Agata Firlejczyk <afirlejczyk@divante.pl>
 * @copyright 2018 Divante Sp. z o.o.
 * @license See LICENSE_DIVANTE.txt for license details.
 */

namespace Divante\ReviewApi\Model\Review\Command;

use Magento\Framework\Exception\CouldNotDeleteException;

/**
 * Interface DeleteByIdInterface
 */
interface DeleteByIdInterface
{
    /**
     * Delete the review data by review.
     *
     * @param int $reviewId
     * @return void
     * @throws CouldNotDeleteException
     */
    public function execute(int $reviewId);
}
