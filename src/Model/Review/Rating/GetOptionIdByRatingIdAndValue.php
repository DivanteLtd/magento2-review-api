<?php
/**
 * Copyright Divante Sp. z o.o.
 * See LICENSE_DIVANTE.txt for license details.
 */
declare(strict_types=1);

namespace Divante\ReviewApi\Model\Review\Rating;

use Magento\Review\Model\ResourceModel\Rating\Option\CollectionFactory as RatingOptionCollectionFactory;
use Magento\Review\Model\ResourceModel\Rating\Option\Collection as RatingOptionCollection;

/**
 * Class RatingProcessor retrieve details for ratings: rating name, option id
 */
class GetOptionIdByRatingIdAndValue
{
    /**
     * @var RatingOptionCollectionFactory
     */
    private $ratingOptionFactory;

    /**
     * @var array
     */
    private $ratingOptionsByRating;

    /**
     * GetOptionIdByRatingIdAndValue constructor.
     *
     * @param RatingOptionCollectionFactory $ratingOptionFactory
     */
    public function __construct(RatingOptionCollectionFactory $ratingOptionFactory)
    {
        $this->ratingOptionFactory = $ratingOptionFactory;
    }

    /**
     * Get Option Id by Rating Id and Value
     *
     * @param int $ratingId
     * @param int $value
     *
     * @return int|null
     */
    public function execute(int $ratingId, int $value): ?int
    {
        if (!isset($this->ratingOptionsByRating[$ratingId])) {
            /** @var RatingOptionCollection $collection */
            $collection = $this->ratingOptionFactory->create();
            $collection->addRatingFilter($ratingId);

            $this->ratingOptionsByRating[$ratingId] = $this->toOptionHash($collection, 'value');
        }

        $optionId = array_search($value, $this->ratingOptionsByRating[$ratingId]);

        return $optionId !== false ? (int) $optionId : null;
    }

    /**
     * Group option value by option ID
     *
     * @param RatingOptionCollection $collection
     * @param string $labelField
     *
     * @return array
     */
    private function toOptionHash(RatingOptionCollection $collection, string $labelField): array
    {
        $valueField = $collection->getResource()->getIdFieldName();
        $res = [];

        foreach ($collection as $item) {
            $res[$item->getData($valueField)] = $item->getData($labelField);
        }

        return $res;
    }
}
