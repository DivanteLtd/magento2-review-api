<?php
/**
 * @package  Divante\ReviewApi
 * @author Agata Firlejczyk <afirlejczyk@divante.pl>
 * @copyright 2018 Divante Sp. z o.o.
 * @license See LICENSE_DIVANTE.txt for license details.
 */

namespace Divante\ReviewApi\Model\Converter\Review;

use Divante\ReviewApi\Api\Data\ReviewInterface;
use Magento\Review\Model\Review;
use Magento\Review\Model\ReviewFactory;
use Magento\Review\Model\ResourceModel\Review as ReviewResource;
use \Magento\Framework\Reflection\DataObjectProcessor;
use Divante\ReviewApi\Api\Data\ReviewInterface as ReviewData;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class ToModel
 */
class ToModel
{
    /**
     * @var \Magento\Framework\Reflection\DataObjectProcessor
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
     * @param ReviewData $dataModel
     *
     * @return Review
     * @throws NoSuchEntityException
     */
    public function toModel(ReviewData $dataModel)
    {
        $reviewId = $dataModel->getId();

        if ($reviewId) {
            /** @var Review $reviewModel */
            $reviewModel = $this->reviewFactory->create();
            $this->resourceModel->load($reviewModel, $reviewId);

            if (null === $reviewModel->getId()) {
                throw new NoSuchEntityException(
                    __('Review with id "%value" does not exist.', ['value' => $reviewId])
                );
            }
        } else {
            /** @var Review $reviewModel */
            $reviewModel = $this->reviewFactory->create();
        }

        $data = $this->dataObjectProcessor->buildOutputDataArray(
            $dataModel,
            ReviewInterface::class
        );

        $modelData = $reviewModel->getData();
        $mergedData = array_merge($modelData, $data);

        $reviewModel->setData($mergedData);

        $this->mapFields($reviewModel, $dataModel);

        return $reviewModel;
    }

    /**
     * @param Review $reviewModel
     * @param ReviewData $reviewData
     */
    private function mapFields(Review $reviewModel, ReviewData $reviewData)
    {
        $reviewModel->setEntityId($reviewModel->getEntityIdByCode($reviewData->getReviewEntity()));
        $reviewModel->setStatusId($reviewData->getReviewStatus());
        $reviewModel->setStores($reviewData->getStores());

        if (!$reviewModel->getStatusId()) {
            $reviewModel->setStatusId(Review::STATUS_PENDING);
        }
    }
}
