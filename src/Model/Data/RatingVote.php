<?php
/**
 * @package  Divante\ReviewApi
 * @author Agata Firlejczyk <afirlejczyk@divante.pl>
 * @copyright 2018 Divante Sp. z o.o.
 * @license See LICENSE_DIVANTE.txt for license details.
 */

namespace Divante\ReviewApi\Model\Data;

use Divante\ReviewApi\Api\Data\RatingVoteInterface;
use Magento\Framework\Api\AbstractSimpleObject;

/**
 * Class Rating
 */
class RatingVote extends AbstractSimpleObject implements RatingVoteInterface
{

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->_get(self::KEY_ID);
    }

    /**
     * @inheritdoc
     */
    public function setId($id)
    {
        return $this->setData(self::KEY_ID, $id);
    }

    /**
     * @inheritdoc
     */
    public function getReviewId()
    {
        return $this->_get(self::KEY_REVIEW_ID);
    }

    /**
     * @inheritdoc
     */
    public function setReviewId($reviewId)
    {
        return $this->setData(self::KEY_REVIEW_ID, $reviewId);
    }

    /**
     * @inheritdoc
     */
    public function getAttributeCode()
    {
        return $this->_get(self::KEY_ATTRIBUTE_CODE);
    }

    /**
     * @inheritdoc
     */
    public function setAttributeCode($attributeCode)
    {
        return $this->setData(self::KEY_ATTRIBUTE_CODE, $attributeCode);
    }

    /**
     * @inheritdoc
     */
    public function getValue()
    {
        return $this->_get(self::KEY_VALUE);
    }

    /**
     * @inheritdoc
     */
    public function setValue($value)
    {
        return $this->setData(self::KEY_VALUE, $value);
    }
}
