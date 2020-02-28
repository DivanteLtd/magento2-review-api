<?php
/**
 * @package  Divante\ReviewApi
 * @author Agata Firlejczyk <afirlejczyk@divante.pl>
 * @copyright 2018 Divante Sp. z o.o.
 * @license See LICENSE_DIVANTE.txt for license details.
 */

declare(strict_types=1);

namespace Divante\ReviewApi\Model\Review\Command;

use Divante\ReviewApi\Api\Data\ReviewInterface;
use Divante\ReviewApi\Model\Converter\Review\ToModel;
use Divante\ReviewApi\Model\Converter\Review\ToDataModel;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Review\Model\ResourceModel\Review as ReviewResource;
use Divante\ReviewApi\Validation\ValidationException;
use Divante\ReviewApi\Model\ReviewValidatorInterface;
use Magento\Review\Model\Review;
use Magento\Store\Model\StoreManagerInterface;
use Divante\ReviewApi\Model\Review\Rating\SaveHandler;

/**
 * @inheritdoc
 */
class Save implements SaveInterface
{
    /**
     * @var ToModel
     */
    private $toModelConverter;

    /**
     * @var ToDataModel
     */
    private $toDataModelConverter;

    /**
     * @var ReviewResource
     */
    private $reviewResource;

    /**
     * @var ReviewValidatorInterface
     */
    private $reviewValidator;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var SaveHandler
     */
    private $ratingSaveHandler;

    /**
     * Save constructor.
     *
     * @param ReviewValidatorInterface $reviewValidator
     * @param ToModel $toModelConverter
     * @param ToDataModel $toDataModelConvert
     * @param StoreManagerInterface $storeManager
     * @param ReviewResource $reviewResource
     * @param SaveHandler $ratingSaveHandler
     */
    public function __construct(
        ReviewValidatorInterface $reviewValidator,
        ToModel $toModelConverter,
        ToDataModel $toDataModelConvert,
        StoreManagerInterface $storeManager,
        ReviewResource $reviewResource,
        SaveHandler $ratingSaveHandler
    ) {
        $this->reviewValidator = $reviewValidator;
        $this->toDataModelConverter = $toDataModelConvert;
        $this->toModelConverter = $toModelConverter;
        $this->reviewResource = $reviewResource;
        $this->storeManager = $storeManager;
        $this->ratingSaveHandler = $ratingSaveHandler;
    }

    /**
     * Save Review
     *
     * @param ReviewInterface $dataModel
     *
     * @return ReviewInterface
     * @throws ValidationException
     * @throws AlreadyExistsException
     * @throws NoSuchEntityException
     */
    public function execute(ReviewInterface $dataModel): ReviewInterface
    {
        $this->updateStores($dataModel);
        $validationResult = $this->reviewValidator->validate($dataModel);

        if (!$validationResult->isValid()) {
            $msg = implode(' ', $validationResult->getErrors());
            throw new ValidationException(__($msg), null, 0, $validationResult);
        }

        $model = $this->saveReview($dataModel);
        $this->reviewResource->aggregate($model);

        return $this->toDataModelConverter->toDataModel($model);
    }

    /**
     * Save Review
     *
     * @param ReviewInterface $dataModel
     *
     * @return Review
     * @throws AlreadyExistsException
     * @throws NoSuchEntityException
     */
    private function saveReview(ReviewInterface $dataModel): Review
    {
        $model = $this->toModelConverter->toModel($dataModel);
        $this->reviewResource->save($model);
        $this->reviewResource->load($model, $model->getId());

        if ($dataModel->getStoreId() === null) {
            $dataModel->setStoreId($model->getStoreId());
        }

        $dataModel->setId($model->getId());
        $this->ratingSaveHandler->execute($dataModel);

        return $model;
    }

    /**
     * Update Review Stores
     *
     * @param ReviewInterface $dataModel
     *
     * @return void
     *
     * @throws NoSuchEntityException
     */
    private function updateStores(ReviewInterface $dataModel): void
    {
        $stores = $dataModel->getStores();

        if ($stores === null || empty($stores)) {
            $dataModel->setStores([$this->storeManager->getStore()->getId()]);
        }

        if (($dataModel->getId() === null) && ($dataModel->getStoreId() === null)) {
            $dataModel->setStoreId($this->storeManager->getStore()->getId());
        }
    }
}
