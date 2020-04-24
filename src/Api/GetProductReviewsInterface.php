<?php
/**
 * Copyright Divante Sp. z o.o.
 * See LICENSE_DIVANTE.txt for license details.
 */
declare(strict_types=1);

namespace Divante\ReviewApi\Api;

/**
 * Retrieve product reviews by sku
 *
 * Used fully qualified namespaces in annotations for proper work of WebApi request parser
 *
 * @api
 */
interface GetProductReviewsInterface
{
    /**
     * Get product reviews.
     *
     * @param string $sku
     * @return \Divante\ReviewApi\Api\Data\ReviewInterface[]
     */
    public function execute(string $sku);
}
