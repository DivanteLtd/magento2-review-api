<?php
/**
 * @package  Divante\ReviewApi
 * @author Agata Firlejczyk <afirlejczyk@divante.pl>
 * @copyright 2018 Divante Sp. z o.o.
 * @license See LICENSE_DIVANTE.txt for license details.
 */

namespace Divante\ReviewApi\Model\Review\Command;

use Divante\ReviewApi\Model\Converter\Review\ToDataModel;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Review\Model\ResourceModel\Review as ReviewResource;
use Magento\Review\Model\ReviewFactory;
use Magento\Review\Model\Review;

/**
 * Class Get
 */
class Get implements GetInterface
{
    /**
     * @var ToDataModel
     */
    private $toDataModelConverter;

    /**
     * @var ReviewResource
     */
    private $reviewResource;

    /**
     * @var ReviewFactory
     */
    private $reviewFactory;

    /**
     * Get constructor.
     *
     * @param ReviewFactory $reviewFactory
     * @param ToDataModel $toDataModelConvert
     * @param ReviewResource $reviewResource
     */
    public function __construct(
        ReviewFactory $reviewFactory,
        ToDataModel $toDataModelConvert,
        ReviewResource $reviewResource
    ) {
        $this->reviewFactory = $reviewFactory;
        $this->toDataModelConverter = $toDataModelConvert;
        $this->reviewResource = $reviewResource;
    }

    /**
     * @inheritdoc
     */
    public function execute($reviewId)
    {
        /** @var Review $reviewModel */
        $reviewModel = $this->reviewFactory->create();
        $this->reviewResource->load($reviewModel, $reviewId);

        if (null === $reviewModel->getId()) {
            throw new NoSuchEntityException(
                __('Review with id "%value" does not exist.', ['value' => $reviewId])
            );
        }

        $dataModel = $this->toDataModelConverter->toDataModel($reviewModel);

        return $dataModel;
    }
}
