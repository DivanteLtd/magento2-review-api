<?php
declare(strict_types=1);

namespace Divante\ReviewApi\Api;

interface ReviewAggregatorInterface
{
    public function aggregate(\Divante\ReviewApi\Api\Data\ReviewInterface $review): void;
}
