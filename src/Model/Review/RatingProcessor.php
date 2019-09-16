<?php
/**
 * @package  Divante\ReviewApi
 * @author Agata Firlejczyk <afirlejczyk@divante.pl>
 * @copyright 2018 Divante Sp. z o.o.
 * @license See LICENSE_DIVANTE.txt for license details.
 */

namespace Divante\ReviewApi\Model\Review;

use Magento\Framework\Data\Collection;
use Magento\Review\Model\ResourceModel\Rating\Collection as RatingCollection;
use Magento\Review\Model\ResourceModel\Rating\CollectionFactory as RatingsFactory;
use Magento\Review\Model\ResourceModel\Rating\Option\CollectionFactory as RatingOptionCollectionFactory;
use Magento\Review\Model\ResourceModel\Rating\Option\Collection as RatingOptionCollection;

/**
 * Class RatingProcessor
 */
class RatingProcessor
{

    /**
     * Rating resource model
     *
     * @var RatingsFactory
     */
    private $ratingsFactory;

    /**
     * @var RatingOptionCollectionFactory
     */
    private $ratingOptionFactory;

    /**
     * @var RatingCollection
     */
    private $ratings = [];

    /**
     * @var
     */
    private $ratingOptionsByRating;

    /**
     * RatingProcessor constructor.
     *
     * @param RatingsFactory $ratingsFactory
     * @param RatingOptionCollectionFactory $ratingOptionFactory
     */
    public function __construct(
        RatingsFactory $ratingsFactory,
        RatingOptionCollectionFactory $ratingOptionFactory
    ) {
        $this->ratingsFactory = $ratingsFactory;
        $this->ratingOptionFactory = $ratingOptionFactory;
    }

    /**
     * @param string $ratingName
     * @param int $storeId
     *
     * @return int|null
     */
    public function getRatingIdByName(string $ratingName, int $storeId): ?int
    {
        if (!isset($this->ratings[$storeId])) {
            $collection = $this->ratingsFactory->create();
            $collection->setStoreFilter($storeId);
            $this->ratings[$storeId] = $this->toOptionHash($collection, 'rating_code');
        }

        $ratingId = array_search($ratingName, $this->ratings[$storeId]);

        return $ratingId !== false ? (int)$ratingId : null;
    }

    /**
     * @param int $ratingId
     * @param int $value
     *
     * @return int|null
     */
    public function getOptionIdByRatingIdAndValue(int $ratingId, int $value): ?int
    {
        if (!isset($this->ratingOptionsByRating[$ratingId])) {
            /** @var RatingOptionCollection $collection */
            $collection = $this->ratingOptionFactory->create();
            $collection->addRatingFilter($ratingId);

            $this->ratingOptionsByRating[$ratingId] = $this->toOptionHash($collection, 'value');
        }

        $optionId = array_search($value, $this->ratingOptionsByRating[$ratingId]);

        return $optionId !== false ? (int)$optionId : null;
    }

    /**
     * @param Collection $collection
     * @param string $labelField
     *
     * @return array
     */
    private function toOptionHash(Collection $collection, string $labelField): array
    {
        $valueField = $collection->getResource()->getIdFieldName();
        $res = [];

        foreach ($collection as $item) {
            $res[$item->getData($valueField)] = $item->getData($labelField);
        }

        return $res;
    }
}
