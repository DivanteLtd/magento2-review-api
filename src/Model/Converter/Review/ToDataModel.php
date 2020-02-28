<?php
/**
 * Copyright Divante Sp. z o.o.
 * See LICENSE_DIVANTE.txt for license details.
 */
declare(strict_types=1);

namespace Divante\ReviewApi\Model\Converter\Review;

use Divante\ReviewApi\Api\Data\ReviewInterface;
use Divante\ReviewApi\Api\Data\ReviewInterfaceFactory;
use Divante\ReviewApi\Model\Review\ReviewTypeResolverInterface;
use Magento\Catalog\Model\Product;
use Magento\Framework\DataObject\Copy as ObjectCopyService;
use Magento\Review\Model\Review;
use Divante\ReviewApi\Model\Review\Rating\LoadHandler as RatingLoadHandler;

/**
 * Class ToDataModel convert Review Model to Review Data Object
 */
class ToDataModel
{
    /**
     * @var RatingLoadHandler
     */
    private $ratingLoadHandler;

    /**
     * @var ReviewInterfaceFactory
     */
    private $reviewFactory;

    /**
     * @var ObjectCopyService
     */
    private $objectCopyService;

    /**
     * @var ReviewTypeResolverInterface
     */
    private $reviewTypeResolver;

    /**
     * ToDataModel constructor.
     *
     * @param RatingLoadHandler $ratingLoadHandler
     * @param ReviewInterfaceFactory $reviewInterfaceFactory
     * @param ReviewTypeResolverInterface $reviewTypeResolver
     * @param ObjectCopyService $objectCopyService
     */
    public function __construct(
        RatingLoadHandler $ratingLoadHandler,
        ReviewInterfaceFactory $reviewInterfaceFactory,
        ReviewTypeResolverInterface $reviewTypeResolver,
        ObjectCopyService $objectCopyService
    ) {
        $this->reviewFactory = $reviewInterfaceFactory;
        $this->objectCopyService = $objectCopyService;
        $this->reviewTypeResolver = $reviewTypeResolver;
        $this->ratingLoadHandler = $ratingLoadHandler;
    }

    /**
     * Convert Review to Data Object
     *
     * @param Product|Review $productReview
     *
     * @return ReviewInterface
     */
    public function toDataModel($productReview): ReviewInterface
    {
        $reviewDataObject = $this->createReviewDataObject($productReview);
        $ratings = $this->ratingLoadHandler->execute($productReview);
        $reviewDataObject->setRatings($ratings);

        return $reviewDataObject;
    }

    /**
     * Create Review Data Object
     *
     * @param Product|Review $productReview
     *
     * @return ReviewInterface
     */
    private function createReviewDataObject($productReview): ReviewInterface
    {
        /** @var ReviewInterface $reviewDataObject */
        $reviewDataObject = $this->reviewFactory->create();
        $this->objectCopyService->copyFieldsetToTarget(
            'review_api_convert_review',
            'to_review_data_object',
            $productReview,
            $reviewDataObject
        );
        $reviewDataObject->setReviewType($this->reviewTypeResolver->getReviewType($productReview));
        $reviewDataObject->setReviewEntity(Review::ENTITY_PRODUCT_CODE);

        return $reviewDataObject;
    }
}
