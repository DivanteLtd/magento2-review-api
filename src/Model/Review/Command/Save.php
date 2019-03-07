<?php
/**
 * @package  Divante\ReviewApi
 * @author Agata Firlejczyk <afirlejczyk@divante.pl>
 * @copyright 2018 Divante Sp. z o.o.
 * @license See LICENSE_DIVANTE.txt for license details.
 */

namespace Divante\ReviewApi\Model\Review\Command;

use Divante\ReviewApi\Model\Converter\Review\ToModel;
use Divante\ReviewApi\Model\Converter\Review\ToDataModel;
use Magento\Review\Model\ResourceModel\Review as ReviewResource;
use Divante\ReviewApi\Validation\ValidationException;
use Divante\ReviewApi\Model\ReviewValidatorInterface;
use \Magento\Store\Model\StoreManagerInterface;

/**
 * Class Save
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
     * @var ReviewValidator
     */
    private $reviewValidator;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * Save constructor.
     *
     * @param ReviewValidatorInterface $reviewValidator
     * @param ToModel $toModelConverter
     * @param ToDataModel $toDataModelConvert
     * @param StoreManagerInterface $storeManager
     * @param ReviewResource $reviewResource
     */
    public function __construct(
        ReviewValidatorInterface $reviewValidator,
        ToModel $toModelConverter,
        ToDataModel $toDataModelConvert,
        StoreManagerInterface $storeManager,
        ReviewResource $reviewResource
    ) {
        $this->reviewValidator = $reviewValidator;
        $this->toDataModelConverter = $toDataModelConvert;
        $this->toModelConverter = $toModelConverter;
        $this->reviewResource = $reviewResource;
        $this->storeManager = $storeManager;
    }

    /**
     * @inheritdoc
     */
    public function execute($dataModel)
    {
        $stores = $dataModel->getStores();

        if (null === $stores || empty($stores)) {
            $dataModel->setStores([$this->storeManager->getStore()->getId()]);
        }

        if ((null === $dataModel->getId()) && (null === $dataModel->getStoreId())) {
            $dataModel->setStoreId($this->storeManager->getStore()->getId());
        }

        $validationResult = $this->reviewValidator->validate($dataModel);

        if (!$validationResult->isValid()) {
            $msg = implode(' ', $validationResult->getErrors());
            throw new ValidationException(__($msg), null, 0, $validationResult);
        }

        $model = $this->toModelConverter->toModel($dataModel);

        $this->reviewResource->save($model);
        $this->reviewResource->load($model, $model->getId());

        return $this->toDataModelConverter->toDataModel($model);
    }
}
