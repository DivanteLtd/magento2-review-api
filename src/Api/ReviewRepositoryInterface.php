<?php
/**
 * @package  Divante\ReviewApi
 * @author Agata Firlejczyk <afirlejczyk@divante.pl>
 * @copyright 2018 Divante Sp. z o.o.
 * @license See LICENSE_DIVANTE.txt for license details.
 */

namespace Divante\ReviewApi\Api;

use Divante\ReviewApi\Api\Data\ReviewInterface;
use Magento\Framework\Api\SearchCriteria;

/**
 * Interface ReviewRepositoryInterface
 */
interface ReviewRepositoryInterface
{
    /**
     * Save review.
     * It doesn't update/create rating votes
     *
     * @param \Divante\ReviewApi\Api\Data\ReviewInterface $review
     *
     * @return \Divante\ReviewApi\Api\Data\ReviewInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function save(ReviewInterface $review);

    /**
     * Get review by id.
     *
     * @param int $reviewId
     *
     * @return \Divante\ReviewApi\Api\Data\ReviewInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get($reviewId);

    /**
     * Lists the review items that match specified search criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteria $searchCriteria
     * @return \Divante\ReviewApi\Api\Data\ReviewSearchResultInterface
     */
    public function getList(SearchCriteria $searchCriteria);

    /**
     * @param int $reviewId
     * @return void
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteById($reviewId);
}
