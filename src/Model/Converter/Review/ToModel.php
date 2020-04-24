<?php
/**
 * Copyright Divante Sp. z o.o.
 * See LICENSE_DIVANTE.txt for license details.
 */
declare(strict_types=1);

namespace Divante\ReviewApi\Model\Converter\Review;

use Divante\ReviewApi\Api\Data\ReviewInterface;
use Divante\ReviewApi\Api\Data\ReviewInterface as ReviewData;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Review\Model\ResourceModel\Review as ReviewResource;
use Magento\Review\Model\Review;
use Magento\Review\Model\ReviewFactory;

/**
 * Class ToModel convert Review Data Object to Review Model
 */
class ToModel
{
    /**
     * @var DataObjectProcessor
     */
    private $dataObjectProcessor;

    /**
     * @var ReviewFactory
     */
    private $reviewFactory;

    /**
     * @var ReviewResource
     */
    private $resourceModel;

    /**
     * ToModel constructor.
     *
     * @param ReviewResource $reviewResource
     * @param ReviewFactory $reviewFactory
     * @param DataObjectProcessor $dataObjectProcessor
     */
    public function __construct(
        ReviewResource $reviewResource,
        ReviewFactory $reviewFactory,
        DataObjectProcessor $dataObjectProcessor
    ) {
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->reviewFactory = $reviewFactory;
        $this->resourceModel = $reviewResource;
    }

    /**
     * Convert Review Data Object to Review Model
     *
     * @param ReviewData $dataModel
     *
     * @return Review
     *
     * @throws NoSuchEntityException
     */
    public function toModel(ReviewData $dataModel): Review
    {
        $reviewId = (int) $dataModel->getId();
        $reviewModel = $this->getReviewModel($reviewId);
        $mergedData = $this->mergeReviewData($reviewModel, $dataModel);
        $reviewModel->setData($mergedData);

        $this->mapFields($reviewModel, $dataModel);

        return $reviewModel;
    }

    /**
     * Merge Review data from current Review and review data object
     *
     * @param Review $reviewModel
     * @param ReviewData $reviewData
     *
     * @return array
     */
    private function mergeReviewData(Review $reviewModel, ReviewData $reviewData): array
    {
        $data = $this->dataObjectProcessor->buildOutputDataArray(
            $reviewData,
            ReviewInterface::class
        );

        $modelData = $reviewModel->getData();

        return array_merge($modelData, $data);
    }

    /**
     * Get Review Model
     *
     * @param int $reviewId
     *
     * @return Review
     *
     * @throws NoSuchEntityException
     */
    private function getReviewModel(int $reviewId): Review
    {
        if ($reviewId) {
            /** @var Review $reviewModel */
            $reviewModel = $this->reviewFactory->create();
            $this->resourceModel->load($reviewModel, $reviewId);

            if ($reviewModel->getId() === null) {
                throw new NoSuchEntityException(
                    __('Review with id "%value" does not exist.', ['value' => $reviewId])
                );
            }

            return $reviewModel;
        }

        return $this->reviewFactory->create();
    }

    /**
     * Map fields from Data Object to Review Model
     *
     * @param Review $reviewModel
     * @param ReviewData $reviewData
     *
     * @return void
     */
    private function mapFields(Review $reviewModel, ReviewData $reviewData): void
    {
        $reviewModel->setEntityId($reviewModel->getEntityIdByCode($reviewData->getReviewEntity()));
        $reviewModel->setStatusId($reviewData->getReviewStatus());
        $reviewModel->setStores($reviewData->getStores());

        if (! $reviewModel->getStatusId()) {
            $reviewModel->setStatusId(Review::STATUS_PENDING);
        }
    }
}
