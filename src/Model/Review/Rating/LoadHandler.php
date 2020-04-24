<?php
/**
 * Copyright Divante Sp. z o.o.
 * See LICENSE_DIVANTE.txt for license details.
 */
declare(strict_types=1);

namespace Divante\ReviewApi\Model\Review\Rating;

use Divante\ReviewApi\Api\Data\RatingVoteInterface;
use Divante\ReviewApi\Model\Converter\RatingVote;
use Magento\Catalog\Model\Product;
use Magento\Framework\DataObject;
use Magento\Review\Model\Rating;
use Magento\Review\Model\Rating\Option\Vote;
use Magento\Review\Model\ResourceModel\Rating\Collection as RatingCollection;
use Magento\Review\Model\ResourceModel\Rating\CollectionFactory as RatingsCollectionFactory;
use Magento\Review\Model\ResourceModel\Rating\Option\Vote\Collection as VoteCollection;
use Magento\Review\Model\ResourceModel\Rating\Option\Vote\CollectionFactory as VoteCollectionFactory;
use Magento\Review\Model\Review;

/**
 * Load Ratings for a Review
 */
class LoadHandler
{
    /**
     * @var RatingVote
     */
    private $ratingConverter;

    /**
     * Rating resource model
     *
     * @var RatingsCollectionFactory
     */
    private $ratingsCollectionFactory;

    /**
     * @var RatingCollection
     */
    private $ratingCollection;

    /**
     * @var VoteCollectionFactory
     */
    private $voteCollectionFactory;

    /**
     * RatingLoaderHandler constructor.
     *
     * @param RatingVote $ratingConverter
     * @param VoteCollectionFactory $voteCollectionFactory
     * @param RatingsCollectionFactory $ratingsFactory
     */
    public function __construct(
        RatingVote $ratingConverter,
        VoteCollectionFactory $voteCollectionFactory,
        RatingsCollectionFactory $ratingsFactory
    ) {
        $this->ratingsCollectionFactory = $ratingsFactory;
        $this->ratingConverter = $ratingConverter;
        $this->voteCollectionFactory = $voteCollectionFactory;
    }

    /**
     * Retrieve review ratings
     *
     * @param Product|Review $productReview
     *
     * @return array
     */
    public function execute($productReview): array
    {
        $ratingList = [];
        $reviewRatings = $this->getReviewRatingVotes($productReview);
        $storeId = (int) $productReview->getStoreId();
        $ratingCollection = $this->getRatingCollection($storeId);

        foreach ($reviewRatings as $ratingVote) {
            $rating = $ratingCollection->getItemByColumnValue('rating_id', $ratingVote->getRatingId());

            if ($rating) {
                $ratingList[] = $this->convertRatingVoteToDataModel($ratingVote, $rating);
            }
        }

        return $ratingList;
    }

    /**
     * Convert Rating Vote Model to Rating Data Object
     *
     * @param Vote $ratingVote
     * @param Rating $rating
     *
     * @return RatingVoteInterface
     */
    private function convertRatingVoteToDataModel(
        Vote $ratingVote,
        Rating $rating
    ): RatingVoteInterface {
        $ratingData = [
            'value' => $ratingVote->getValue(),
            'percent' => $ratingVote->getPercent(),
            'vote_id' => $ratingVote->getVoteId(),
            'rating_id' => $rating->getId(),
            'rating_name' => $rating->getRatingCode(),
        ];

        return $this->ratingConverter->arrayToDataModel($ratingData);
    }

    /**
     * Retrieve Review Ratings
     *
     * @param Review|Product $productReview
     *
     * @return array|DataObject[]
     */
    private function getReviewRatingVotes($productReview)
    {
        /**
         * @var VoteCollection $ratingsVotes
         */
        $ratingsVotes = $productReview->getRatingVotes();

        if ($ratingsVotes === null) {
            $ratingsVotes = $this->loadRatingVotes($productReview);
            $reviewRatings = $ratingsVotes->getItems();
        } else {
            $reviewRatings = $ratingsVotes->getItemsByColumnValue('review_id', $productReview->getReviewId());
        }

        return $reviewRatings;
    }

    /**
     * Load Rating Votes for review
     *
     * @param Review|Product $productReview
     *
     * @return VoteCollection
     */
    private function loadRatingVotes($productReview): VoteCollection
    {
        $storeId = (int) $productReview->getStoreId();

        return $this->voteCollectionFactory->create()
            ->setReviewFilter($productReview->getReviewId())
            ->setStoreFilter($storeId)
            ->setEntityPkFilter($productReview->getData('entity_pk_value'))
            ->load();
    }

    /**
     * Get Rating Collection
     *
     * @param int $storeId
     *
     * @return RatingCollection
     */
    private function getRatingCollection(int $storeId): RatingCollection
    {
        if ($this->ratingCollection === null) {
            /** @var RatingCollection $ratingCollection */
            $ratingCollection = $this->ratingsCollectionFactory->create()
                ->addEntityFilter('product')
                ->setStoreFilter($storeId)
                ->addRatingPerStoreName($storeId)
                ->setPositionOrder()->load();

            $this->ratingCollection = $ratingCollection;
        }

        return $this->ratingCollection;
    }
}
