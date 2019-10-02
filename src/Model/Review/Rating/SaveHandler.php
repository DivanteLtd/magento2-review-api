<?php
/**
 * @package  Divante\ReviewApi
 * @author Agata Firlejczyk <afirlejczyk@divante.pl>
 * @copyright 2018 Divante Sp. z o.o.
 * @license See LICENSE_DIVANTE.txt for license details.
 */

namespace Divante\ReviewApi\Model\Review\Rating;

use Divante\ReviewApi\Api\Data\ReviewInterface;
use Divante\ReviewApi\Model\Review\RatingProcessor;
use Magento\Framework\EntityManager\Operation\ExtensionInterface;
use Magento\Review\Model\Rating;
use Magento\Review\Model\Review as ReviewModel;
use Magento\Review\Model\RatingFactory;
use Magento\Review\Model\ResourceModel\Rating\Option\Vote\Collection;
use Magento\Review\Model\ResourceModel\Review;
use Magento\Review\Model\ResourceModel\Rating\Option\Vote\CollectionFactory;

/**
 * Class SaveHandler
 */
class SaveHandler implements ExtensionInterface
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
     * @var RatingProcessor
     */
    private $ratingProcessor;

    /**
     * SaveHandler constructor.
     *
     * @param CollectionFactory $collectionFactory
     * @param RatingFactory $ratingFactory
     * @param RatingProcessor $getRatingByCode
     * @param \Magento\Review\Model\ResourceModel\Review $reviewResource
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        RatingFactory $ratingFactory,
        RatingProcessor $getRatingByCode,
        \Magento\Review\Model\ResourceModel\Review $reviewResource,
        ReviewModel $reviewModel
    ) {
        $this->ratingProcessor = $getRatingByCode;
        $this->ratingFactory = $ratingFactory;
        $this->voteCollectionFactory = $collectionFactory;
        $this->reviewResource = $reviewResource;
        $this->reviewModel = $reviewModel;
    }

    /**
     * @param object|ReviewInterface $entity
     * @param array $arguments
     *
     * @return bool|object|void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute($entity, $arguments = [])
    {
        $storeId = $entity->getStoreId();
        $reviewRatings = $entity->getRatings() ?? [];
        $reviewId = $entity->getId();
        $votes = $this->getVotes($reviewId);

        foreach ($reviewRatings as $ratingVote) {
            $ratingCode = $ratingVote->getRatingName();

            $ratingId = $this->ratingProcessor->getRatingIdByName($ratingCode, $storeId);

            if (!$ratingId) {
                /*TODO Throw error if given rating is not available in store*/
                continue;
            }

            $optionId = $this->ratingProcessor->getOptionIdByRatingIdAndValue($ratingId, $ratingVote->getValue());
            $vote = $votes->getItemByColumnValue('rating_id', $ratingId);

            if ($vote) {
                $this->ratingFactory->create()
                                    ->setVoteId($vote->getId())
                                    ->setReviewId($reviewId)
                                    ->updateOptionVote($optionId);
            } else {
                /** @var Rating $rating */
                $this->ratingFactory->create()
                                    ->setRatingId($ratingId)
                                    ->setReviewId($entity->getId())
                                    ->addOptionVote($optionId, $entity->getEntityPkValue());
            }
        }
        
        $reviewObject = $this->reviewModel->load($reviewId);
        $this->reviewResource->aggregate($reviewObject);
    }

    /**
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
