<?php
/**
 * Copyright Divante Sp. z o.o.
 * See LICENSE_DIVANTE.txt for license details.
 */
declare(strict_types=1);

namespace Divante\ReviewApi\Model\Review\Command;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Review\Model\ResourceModel\Review\Collection;
use Magento\Review\Model\ResourceModel\Review\CollectionFactory;
use Divante\ReviewApi\Api\Data\ReviewSearchResultInterface;
use Divante\ReviewApi\Api\Data\ReviewSearchResultInterfaceFactory;
use Divante\ReviewApi\Model\Converter\Review\ToDataModel;
use Magento\Store\Model\StoreManagerInterface;

/**
 * @inheritdoc
 */
class GetList implements GetListInterface
{
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var CollectionFactory
     */
    private $reviewCollectionFactory;

    /**
     * @var ReviewSearchResultInterfaceFactory
     */
    private $reviewSearchResultsFactory;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var ToDataModel
     */
    private $toDataModelConverter;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * GetList constructor.
     *
     * @param ToDataModel $toDataModelConvert
     * @param CollectionProcessorInterface $collectionProcessor
     * @param CollectionFactory $sourceCollectionFactory
     * @param StoreManagerInterface $storeManager
     * @param ReviewSearchResultInterfaceFactory $reviewSearchResultInterfaceFactory
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        ToDataModel $toDataModelConvert,
        CollectionProcessorInterface $collectionProcessor,
        CollectionFactory $sourceCollectionFactory,
        StoreManagerInterface $storeManager,
        ReviewSearchResultInterfaceFactory $reviewSearchResultInterfaceFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->collectionProcessor = $collectionProcessor;
        $this->reviewCollectionFactory = $sourceCollectionFactory;
        $this->reviewSearchResultsFactory = $reviewSearchResultInterfaceFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->toDataModelConverter = $toDataModelConvert;
        $this->storeManager = $storeManager;
    }

    /**
     * @inheritdoc
     *
     * @param SearchCriteriaInterface|null $searchCriteria
     *
     * @return ReviewSearchResultInterface
     */
    public function execute(SearchCriteriaInterface $searchCriteria = null): ReviewSearchResultInterface
    {
        /** @var Collection $collection */
        $collection = $this->reviewCollectionFactory->create();
        $collection->addStoreData();
        $collection->addStoreFilter($this->getStoreId());

        if (null === $searchCriteria) {
            $searchCriteria = $this->searchCriteriaBuilder->create();
        } else {
            $this->collectionProcessor->process($searchCriteria, $collection);
        }

        $collection->load();
        $collection->addRateVotes();

        /** @var ReviewSearchResultInterface $searchResult */
        $searchResult = $this->reviewSearchResultsFactory->create();
        $searchResult->setItems($this->convertItemsToDataModel($collection->getItems()));
        $searchResult->setTotalCount($collection->getSize());
        $searchResult->setSearchCriteria($searchCriteria);

        return $searchResult;
    }

    /**
     * Convert Review Models to Data Models
     *
     * @param array $items
     *
     * @return array
     */
    private function convertItemsToDataModel(array $items): array
    {
        $data = [];

        foreach ($items as $item) {
            $dataModel = $this->toDataModelConverter->toDataModel($item);
            $dataModel->setStoreId($this->getStoreId());
            $data[] = $dataModel;
        }

        return $data;
    }

    /**
     * Retrive Store Id
     *
     * @return int
     */
    private function getStoreId(): int
    {
        return (int) $this->storeManager->getStore()->getId();
    }
}
