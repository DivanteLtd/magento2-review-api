<?php
/**
 * Copyright Divante Sp. z o.o.
 * See LICENSE_DIVANTE.txt for license details.
 */
declare(strict_types=1);

namespace Divante\ReviewApi\Model\Review\Rating;

use Magento\Review\Model\ResourceModel\Rating\Collection as RatingCollection;
use Magento\Review\Model\ResourceModel\Rating\CollectionFactory as RatingsFactory;

/**
 * Class GetRatingIdByName retrieve Rating Id by rating code
 */
class GetRatingIdByName
{
    /**
     * Rating resource model
     *
     * @var RatingsFactory
     */
    private $ratingsCollectionFactory;

    /**
     * @var RatingCollection
     */
    private $ratings = [];

    /**
     * GetRatingIdByName constructor.
     *
     * @param RatingsFactory $ratingsFactory
     */
    public function __construct(RatingsFactory $ratingsFactory)
    {
        $this->ratingsCollectionFactory = $ratingsFactory;
    }

    /**
     * Get Rating Id by Rating Code
     *
     * @param string $ratingName
     * @param int $storeId
     *
     * @return int|null
     */
    public function execute(string $ratingName, int $storeId): ?int
    {
        if (!isset($this->ratings[$storeId])) {
            /** @var RatingCollection $collection */
            $collection = $this->ratingsCollectionFactory->create();
            $collection->setStoreFilter($storeId);
            $collection->addRatingPerStoreName($storeId);
            $this->ratings[$storeId] = $this->toOptionHash($collection, 'rating_code');
        }

        $ratingId = array_search($ratingName, $this->ratings[$storeId]);

        return $ratingId !== false ? (int) $ratingId : null;
    }

    /**
     * Group rating code by id
     *
     * @param RatingCollection $collection
     * @param string $labelField
     *
     * @return array
     */
    private function toOptionHash(RatingCollection $collection, string $labelField): array
    {
        $valueField = $collection->getResource()->getIdFieldName();
        $res = [];

        foreach ($collection as $item) {
            $res[$item->getData($valueField)] = $item->getData($labelField);
        }

        return $res;
    }
}
