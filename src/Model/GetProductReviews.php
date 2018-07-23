<?php
/**
 * @package  Divante\ReviewApi
 * @author Agata Firlejczyk <afirlejczyk@divante.pl>
 * @copyright 2018 Divante Sp. z o.o.
 * @license See LICENSE_DIVANTE.txt for license details.
 */

namespace Divante\ReviewApi\Model;

use Divante\ReviewApi\Api\Data\ReviewInterfaceFactory;
use Divante\ReviewApi\Api\GetProductReviewsInterface;
use Magento\Review\Model\ResourceModel\Review\Product\Collection as ReviewCollection;
use Magento\Review\Model\ResourceModel\Review\Product\CollectionFactory as ReviewCollectionFactory;
use Divante\ReviewApi\Model\Converter\Review\ToDataModel as ReviewConverter;

/**
 * Class GetProductReviews
 */
class GetProductReviews implements GetProductReviewsInterface
{

    /**
     * @var ReviewConverter
     */
    private $reviewConverter;

    /**
     * @var ReviewCollectionFactory
     */
    private $reviewCollectionFactory;

    /**
     * GetProductReviews constructor.
     *
     * @param ReviewConverter $reviewConverter
     * @param ReviewCollectionFactory $collectionFactory
     */
    public function __construct(
        ReviewConverter $reviewConverter,
        ReviewCollectionFactory $collectionFactory
    ) {
        $this->reviewConverter = $reviewConverter;
        $this->reviewCollectionFactory = $collectionFactory;
    }

    /**
     * @inheritdoc
     */
    public function execute($sku)
    {
        /** @var ReviewCollection $collection */
        $collection = $this->reviewCollectionFactory->create();
        $collection->addStoreData();
        $collection->addFieldToFilter('sku', $sku);
        $collection->addRateVotes();

        $reviews = [];

        /** @var \Magento\Catalog\Model\Product $productReview */
        foreach ($collection as $productReview) {
            $reviewDataObject = $this->reviewConverter->toDataModel($productReview);
            $reviews[] = $reviewDataObject;
        }

        return $reviews;
    }
}
