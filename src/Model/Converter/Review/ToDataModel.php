<?php
/**
 * @package  Divante\ReviewApi
 * @author Agata Firlejczyk <afirlejczyk@divante.pl>
 * @copyright 2018 Divante Sp. z o.o.
 * @license See LICENSE_DIVANTE.txt for license details.
 */

namespace Divante\ReviewApi\Model\Converter\Review;

use Divante\ReviewApi\Api\Data\ReviewInterface;
use Divante\ReviewApi\Api\Data\ReviewInterfaceFactory;
use Divante\ReviewApi\Model\Converter\RatingVote;
use Magento\Framework\DataObject\Copy as ObjectCopyService;
use Magento\Review\Model\ResourceModel\Rating\Collection as RatingCollection;
use Magento\Review\Model\ResourceModel\Rating\CollectionFactory as RatingsFactory;
use Magento\Review\Model\ResourceModel\Rating\Option\Vote\Collection as VoteCollection;
use Magento\Review\Model\ResourceModel\Rating\Option\Vote\CollectionFactory as VoteCollectionFactory;
use Magento\Store\Model\Store;

/**
 * Class Review
 */
class ToDataModel
{
    /**
     * @var RatingVote
     */
    private $ratingConverter;

    /**
     * @var ReviewInterfaceFactory
     */
    private $reviewFactory;

    /**
     * Rating resource model
     *
     * @var RatingsFactory
     */
    private $ratingsFactory;

    /**
     * @var ObjectCopyService
     */
    private $objectCopyService;

    /**
     * @var RatingCollection
     */
    private $ratingCollection;

    /**
     * @var VoteCollectionFactory
     */
    private $voteCollectionFactory;

    /**
     * Review constructor.
     *
     * @param RatingVote $ratingConverter
     * @param VoteCollectionFactory $voteCollectionFactory
     * @param RatingsFactory $ratingsFactory
     * @param ReviewInterfaceFactory $reviewInterfaceFactory
     * @param ObjectCopyService $objectCopyService
     */
    public function __construct(
        RatingVote $ratingConverter,
        VoteCollectionFactory $voteCollectionFactory,
        RatingsFactory $ratingsFactory,
        ReviewInterfaceFactory $reviewInterfaceFactory,
        ObjectCopyService $objectCopyService
    ) {
        $this->reviewFactory = $reviewInterfaceFactory;
        $this->ratingsFactory = $ratingsFactory;
        $this->ratingConverter = $ratingConverter;
        $this->objectCopyService = $objectCopyService;
        $this->voteCollectionFactory = $voteCollectionFactory;
    }

    /**
     * @param \Magento\Catalog\Model\Product|\Magento\Review\Model\Review $productReview
     *
     * @return ReviewInterface
     */
    public function toDataModel($productReview)
    {
        /** @var ReviewInterface $reviewDataObject */
        $reviewDataObject = $this->reviewFactory->create();
        $this->objectCopyService->copyFieldsetToTarget(
            'review_api_convert_review',
            'to_review_data_object',
            $productReview,
            $reviewDataObject
        );

        $reviewDataObject->setReviewType($this->getReviewType($productReview));
        $reviewDataObject->setReviewEntity(\Magento\Review\Model\Review::ENTITY_PRODUCT_CODE);
        $ratings = $this->getRatings($productReview);
        $reviewDataObject->setRatings($ratings);

        return $reviewDataObject;
    }

    /**
     * @param \Magento\Catalog\Model\Product $productReview
     *
     * @return array
     */
    private function getRatings($productReview)
    {
        $ratings = [];

        /**
         * @var VoteCollection $ratingVotesForProduct
         */
        $ratingVotesForProduct = $productReview->getRatingVotes();

        if (null === $ratingVotesForProduct) {
            /** @var VoteCollection $ratingVotesForProduct */
            $ratingVotesForProduct = $this->voteCollectionFactory->create()
                ->setEntityPkFilter($productReview->getData('entity_pk_value'))
                ->load();
        }

        if ($ratingVotesForProduct) {
            $reviewRatings = $ratingVotesForProduct->getItemsByColumnValue('review_id', $productReview->getReviewId());
            /** @var  $ratingCollection */
            $ratingCollection = $this->getRatingCollection();

            foreach ($reviewRatings as $ratingVote) {
                $rating = $ratingCollection->getItemByColumnValue('rating_id', $ratingVote->getRatingId());

                if ($rating) {
                    $ratingData = [
                        'review_id' => $productReview->getReviewId(),
                        'value' => $ratingVote->getValue(),
                        'id' => $ratingVote->getId(),
                        'attribute_code' => $rating->getRatingCode(),
                    ];

                    $ratings[] = $this->ratingConverter->arrayToDataModel($ratingData);
                }
            }
        }

        return $ratings;
    }

    /**
     * @return RatingCollection
     */
    private function getRatingCollection()
    {
        if (null === $this->ratingCollection) {
            /** @var RatingCollection $ratingCollection */
            $ratingCollection = $this->ratingsFactory->create()
                ->addEntityFilter('product')
                ->setPositionOrder()->load();

            $this->ratingCollection = $ratingCollection;
        }

        return $this->ratingCollection;
    }

    /**
     * @param \Magento\Review\Model\Review $productReview
     *
     * @return string
     */
    public function getReviewType($productReview)
    {
        $customerId = $productReview->getCustomerId();

        if ($customerId) {
            return ReviewInterface::REVIEW_TYPE_CUSTOMER;
        }

        $storeId = (int)$productReview->getStoreId();

        if ($storeId === Store::DEFAULT_STORE_ID) {
            return ReviewInterface::REVIEW_TYPE_ADMIN;
        }

        return ReviewInterface::REVIEW_TYPE_GUEST;
    }
}
