<?php
/**
 * @package  Divante\ReviewApi
 * @author Agata Firlejczyk <afirlejczyk@divante.pl>
 * @copyright 2018 Divante Sp. z o.o.
 * @license See LICENSE_DIVANTE.txt for license details.
 */

namespace Divante\ReviewApi\Model\Review\Rating;

use Divante\ReviewApi\Api\Data\ReviewInterface;
use Magento\Review\Model\Rating;
use Magento\Review\Model\RatingFactory;
use Magento\Review\Model\ResourceModel\Rating\Option\Vote\Collection;
use Magento\Review\Model\ResourceModel\Rating\Option\Vote\CollectionFactory;

/**
 * Review Rating data save handler
 */
class SaveHandler
{
    /**
     * @var CollectionFactory
     */
    private $voteCollectionFactory;

    /**
     * @var RatingFactory
     */
    private $ratingFactory;

    /**
     * @var GetOptionIdByRatingIdAndValue
     */
    private $ratingProcessor;

    /**
     * @var GetRatingIdByName
     */
    private $getRatingIdByCode;

    /**
     * SaveHandler constructor.
     *
     * @param CollectionFactory $collectionFactory
     * @param RatingFactory $ratingFactory
     * @param GetRatingIdByName $getRatingIdByCode
     * @param GetOptionIdByRatingIdAndValue $getRatingByCode
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        RatingFactory $ratingFactory,
        GetRatingIdByName $getRatingIdByCode,
        GetOptionIdByRatingIdAndValue $getRatingByCode
    ) {
        $this->getRatingIdByCode = $getRatingIdByCode;
        $this->ratingProcessor = $getRatingByCode;
        $this->ratingFactory = $ratingFactory;
        $this->voteCollectionFactory = $collectionFactory;
    }

    /**
     * Save Review Rating Votes
     *
     * @param ReviewInterface $entity
     *
     * @return void
     */
    public function execute(ReviewInterface $entity)
    {
        $storeId = $entity->getStoreId();
        $reviewRatings = $entity->getRatings() ?? [];
        $reviewId = $entity->getId();
        $votes = $this->getVotes($reviewId);

        foreach ($reviewRatings as $ratingVote) {
            $ratingCode = $ratingVote->getRatingName();
            $ratingId = $this->getRatingIdByCode->execute($ratingCode, $storeId);

            if (!$ratingId) {
                /*TODO Throw error if given rating is not available in store*/
                continue;
            }

            $optionId = $this->ratingProcessor->execute($ratingId, $ratingVote->getValue());
            $vote = $votes->getItemByColumnValue('rating_id', $ratingId);

            if ($vote) {
                $this->updateVote($vote->getId(), $reviewId, $optionId);
            } else {
                $this->createRatingVote($entity, $ratingId, $optionId);
            }
        }
    }

    /**
     * Create Rating Vote
     *
     * @param ReviewInterface $entity
     * @param int $ratingId
     * @param int $optionId
     *
     * @return void
     */
    private function createRatingVote(ReviewInterface $entity, int $ratingId, int $optionId)
    {
        /** @var Rating $rating */
        $this->ratingFactory->create()
            ->setRatingId($ratingId)
            ->setReviewId($entity->getId())
            ->addOptionVote($optionId, $entity->getEntityPkValue());
    }

    /**
     * Update Rating Vote
     *
     * @param int $voteId
     * @param int $reviewId
     * @param int $optionId
     *
     * @return void
     */
    private function updateVote(int $voteId, int $reviewId, int $optionId)
    {
        $this->ratingFactory->create()
            ->setVoteId($voteId)
            ->setReviewId($reviewId)
            ->updateOptionVote($optionId);
    }

    /**
     * Get Votes for Review
     *
     * @param int $reviewId
     *
     * @return Collection
     */
    private function getVotes(int $reviewId): Collection
    {
        /** @var Collection $collection */
        $collection = $this->voteCollectionFactory->create();
        $collection->setReviewFilter($reviewId)
            ->addOptionInfo()
            ->load()
            ->addRatingOptions();

        return $collection;
    }
}
