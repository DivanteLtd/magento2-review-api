<?php
/**
 * @package  Divante\ReviewApi
 * @author Agata Firlejczyk <afirlejczyk@divante.pl>
 * @copyright 2018 Divante Sp. z o.o.
 * @license See LICENSE_DIVANTE.txt for license details.
 */

declare(strict_types=1);

namespace Divante\ReviewApi\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Search results of Repository::getList method
 *
 * Used fully qualified namespaces in annotations for proper work of WebApi request parser
 *
 * @api
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
