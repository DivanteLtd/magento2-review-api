<?php
/**
 * @package  Divante\ReviewApi
 * @author Agata Firlejczyk <afirlejczyk@divante.pl>
 * @copyright 2018 Divante Sp. z o.o.
 * @license See LICENSE_DIVANTE.txt for license details.
 */

namespace Divante\ReviewApi\Model;

use Divante\ReviewApi\Model\Review\Command\DeleteByIdInterface;
use Divante\ReviewApi\Model\Review\Command\GetInterface;
use Divante\ReviewApi\Model\Review\Command\GetListInterface;
use Divante\ReviewApi\Model\Review\Command\SaveInterface;
use Divante\ReviewApi\Api\ReviewRepositoryInterface;
use Divante\ReviewApi\Api\Data\ReviewInterface;
use Magento\Framework\Api\SearchCriteria;

/**
 * Class ReviewRepository
 */
class ReviewRepository implements ReviewRepositoryInterface
{
    /**
     * @var SaveInterface
     */
    private $commandSave;

    /**
     * @var GetInterface
     */
    private $commandGet;

    /**
     * @var GetListInterface
     */
    private $commandGetList;

    /**
     * @var DeleteByIdInterface
     */
    private $commandDeleteById;

    /**
     * ReviewRepository constructor.
     *
     * @param GetInterface $commandGet
     * @param SaveInterface $commandSave
     * @param GetListInterface $commandGetList
     * @param DeleteByIdInterface $commandDeleteById
     */
    public function __construct(
        GetInterface $commandGet,
        SaveInterface $commandSave,
        GetListInterface $commandGetList,
        DeleteByIdInterface $commandDeleteById
    ) {
        $this->commandGet = $commandGet;
        $this->commandSave = $commandSave;
        $this->commandGetList = $commandGetList;
        $this->commandDeleteById = $commandDeleteById;
    }

    /**
     * @inheritdoc
     */
    public function save(ReviewInterface $review)
    {
        return $this->commandSave->execute($review);
    }

    /**
     * @inheritdoc
     */
    public function get($reviewId)
    {
        return $this->commandGet->execute($reviewId);
    }

    /**
     * @inheritdoc
     */
    public function getList(SearchCriteria $searchCriteria)
    {
        return $this->commandGetList->execute($searchCriteria);
    }

    /**
     * @inheritdoc
     */
    public function deleteById($reviewId)
    {
        $this->commandDeleteById->execute($reviewId);
    }
}
