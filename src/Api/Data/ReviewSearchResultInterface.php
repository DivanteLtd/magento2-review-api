<?php
/**
 * @package  Divante\ReviewApi
 * @author Agata Firlejczyk <afirlejczyk@divante.pl>
 * @copyright 2018 Divante Sp. z o.o.
 * @license See LICENSE_DIVANTE.txt for license details.
 */

namespace Divante\ReviewApi\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface ReviewSearchResultsInterface
 */
interface ReviewSearchResultInterface extends SearchResultsInterface
{
    /**
     * Get attributes list.
     *
     * @return \Divante\ReviewApi\Api\Data\ReviewInterface[]
     */
    public function getItems();

    /**
     * Set attributes list.
     *
     * @param \Divante\ReviewApi\Api\Data\ReviewInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
