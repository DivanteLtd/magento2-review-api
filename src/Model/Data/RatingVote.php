<?php
/**
 * @package  Divante\ReviewApi
 * @author Agata Firlejczyk <afirlejczyk@divante.pl>
 * @copyright 2018 Divante Sp. z o.o.
 * @license See LICENSE_DIVANTE.txt for license details.
 */

declare(strict_types=1);

namespace Divante\ReviewApi\Model\Data;

use Divante\ReviewApi\Api\Data\RatingVoteInterface;
use Magento\Framework\Api\AbstractSimpleObject;

/**
 * @inheritdoc
 */
class RatingVote extends AbstractSimpleObject implements RatingVoteInterface
{
    /**
     * @inheritdoc
     *
     * @return int
     */
    public function getVoteId()
    {
        return (int)$this->_get(self::KEY_VOTE_ID);
    }

    /**
     * @inheritdoc
     *
     * @param int $id
     *
     * @return $this
     */
    public function setVoteId($id)
    {
        return $this->setData(self::KEY_VOTE_ID, $id);
    }

    /**
     * @inheritdoc
     *
     * @return int
     */
    public function getRatingId()
    {
        return (int) $this->_get(self::KEY_RATING_ID);
    }

    /**
     * @inheritdoc
     *
     * @param int $ratingId
     *
     * @return $this
     */
    public function setRatingId($ratingId)
    {
        return $this->setData(self::KEY_RATING_ID, $ratingId);
    }

    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getRatingName()
    {
        return $this->_get(self::KEY_RATING_NAME);
    }

    /**
     * @inheritdoc
     *
     * @param string $ratingCode
     *
     * @return $this
     */
    public function setRatingName($ratingCode)
    {
        return $this->setData(self::KEY_RATING_NAME, $ratingCode);
    }

    /**
     * @inheritdoc
     *
     * @return int
     */
    public function getValue()
    {
        return $this->_get(self::KEY_VALUE);
    }

    /**
     * @inheritdoc
     *
     * @param int $value
     *
     * @return $this
     */
    public function setValue($value)
    {
        return $this->setData(self::KEY_VALUE, $value);
    }

    /**
     * @inheritdoc
     *
     * @return int
     */
    public function getPercent()
    {
        return (int) $this->_get(self::KEY_PERCENT);
    }

    /**
     * @inheritdoc
     *
     * @param int $percent
     *
     * @return $this
     */
    public function setPercent($percent)
    {
        return $this->setData(self::KEY_PERCENT, $percent);
    }
}
