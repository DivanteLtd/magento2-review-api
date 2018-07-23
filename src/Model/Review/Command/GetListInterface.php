<?php
/**
 * @package  Divante\ReviewApi
 * @author Agata Firlejczyk <afirlejczyk@divante.pl>
 * @copyright 2018 Divante Sp. z o.o.
 * @license See LICENSE_DIVANTE.txt for license details.
 */

namespace Divante\ReviewApi\Model\Review\Command;

use Divante\ReviewApi\Api\Data\ReviewSearchResultInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Interface GetListInterface
 */
interface GetListInterface
{
    /**
     * Find Sources by given SearchCriteria
     * SearchCriteria is not required because load all sources is useful case
     *
     * @param SearchCriteriaInterface|null $searchCriteria
     * @return ReviewSearchResultInterface
     */
    public function execute(SearchCriteriaInterface $searchCriteria = null): ReviewSearchResultInterface;
}
