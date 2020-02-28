<?php
/**
 * @package  Divante\ReviewApi
 * @author Agata Firlejczyk <afirlejczyk@divante.pl>
 * @copyright 2018 Divante Sp. z o.o.
 * @license See LICENSE_DIVANTE.txt for license details.
 */

namespace Divante\ReviewApi\Model;

use Divante\ReviewApi\Api\Data\ReviewSearchResultInterface;
use Magento\Framework\Api\SearchResults;

/**
 * @inheritdoc
 */
class ReviewSearchResult extends SearchResults implements ReviewSearchResultInterface
{
}
