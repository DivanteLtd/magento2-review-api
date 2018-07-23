<?php
/**
 * @package  Divante\ReviewApi
 * @author Agata Firlejczyk <afirlejczyk@divante.pl>
 * @copyright 2018 Divante Sp. z o.o.
 * @license See LICENSE_DIVANTE.txt for license details.
 */

namespace Divante\ReviewApi\Model\Review\Command;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Review\Model\ResourceModel\Review\Collection;
use Magento\Review\Model\ResourceModel\Review\CollectionFactory;
use \Divante\ReviewApi\Api\Data\ReviewSearchResultInterface;
use \Divante\ReviewApi\Api\Data\ReviewSearchResultInterfaceFactory;
use Divante\ReviewApi\Model\Converter\Review\ToDataModel;
use \Magento\Store\Model\StoreManagerInterface;

/**
 * Class GetList
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
     * @param ToDataModel $toDataModelConvert
     * @param CollectionProcessorInterface $collectionProcessor
     * @param CollectionFactory $sourceCollectionFactory
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
     */
    public function execute(SearchCriteriaInterface $searchCriteria = null): ReviewSearchResultInterface
    {
        /** @var Collection $collection */
        $collection = $this->reviewCollectionFactory->create();
        $collection->addStoreData();
        $collection->addStoreFilter($this->storeManager->getStore()->getId());

        if (null === $searchCriteria) {
            $searchCriteria = $this->searchCriteriaBuilder->create();
        } else {
            $this->collectionProcessor->process($searchCriteria, $collection);
        }

        $collection->load();

        /** @var ReviewSearchResultInterface $searchResult */
        $searchResult = $this->reviewSearchResultsFactory->create();
        $searchResult->setItems($this->convertItemsToDataModel($collection->getItems()));
        $searchResult->setTotalCount($collection->getSize());
        $searchResult->setSearchCriteria($searchCriteria);

        return $searchResult;
    }

    /**
     * @param array $items
     *
     * @return array
     */
    private function convertItemsToDataModel($items)
    {
        $data = [];

        foreach ($items as $item) {
            $data[] = $this->toDataModelConverter->toDataModel($item);
        }

        return $data;
    }
}
