<?php
/**
 * @package  Divante\ReviewApi
 * @author Agata Firlejczyk <afirlejczyk@divante.pl>
 * @copyright 2020 Divante Sp. z o.o.
 * @license See LICENSE_DIVANTE.txt for license details.
 */

namespace Divante\ReviewApi\Model\Review;

/**
 * Interface ReviewTypeResolverInterface
 */
interface ReviewTypeResolverInterface
{
    /**
     * Resolver Review Type
     *
     * @param \Magento\Review\Model\Review $productReview
     *
     * @return int
     */
    public function getReviewType($productReview): int;
}
