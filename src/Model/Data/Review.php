<?php
/**
 * @package  Divante\ReviewApi
 * @author Agata Firlejczyk <afirlejczyk@divante.pl>
 * @copyright 2018 Divante Sp. z o.o.
 * @license See LICENSE_DIVANTE.txt for license details.
 */

namespace Divante\ReviewApi\Model\Data;

use Divante\ReviewApi\Api\Data\ReviewInterface;
use Magento\Framework\Api\AbstractSimpleObject;

/**
 * Class Review
 */
class Review extends AbstractSimpleObject implements ReviewInterface
{
    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->_get(self::ID);
    }

    /**
     * @inheritdoc
     */
    public function getCustomerId()
    {
        return $this->_get(self::CUSTOMER_ID);
    }

    /**
     * @inheritdoc
     */
    public function getDetail()
    {
        return $this->_get(self::DETAIL);
    }

    /**
     * @inheritdoc
     */
    public function getNickname()
    {
        return $this->_get(self::NICKNAME);
    }

    /**
     * @inheritdoc
     */
    public function getRatings()
    {
        return $this->_get(self::RATINGS);
    }

    /**
     * @inheritdoc
     */
    public function getReviewEntity()
    {
        return $this->_get(self::REVIEW_ENTITY);
    }

    /**
     * @inheritdoc
     */
    public function getReviewType()
    {
        return $this->_get(self::REVIEW_TYPE);
    }

    /**
     * @inheritdoc
     */
    public function getReviewStatus()
    {
        return $this->_get(self::REVIEW_STATUS);
    }

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        return $this->_get(self::TITLE);
    }

    /**
     * @inheritdoc
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * @inheritdoc
     */
    public function setDetail($detail)
    {
        return $this->setData(self::DETAIL, $detail);
    }

    /**
     * @inheritdoc
     */
    public function setCustomerId($customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    /**
     * @inheritdoc
     */
    public function setNickname($nickName)
    {
        return $this->setData(self::NICKNAME, $nickName);
    }

    /**
     * @inheritdoc
     */
    public function setRatings($ratings)
    {
        return $this->setData(self::RATINGS, $ratings);
    }

    /**
     * @inheritdoc
     */
    public function setReviewEntity($entity)
    {
        return $this->setData(self::REVIEW_ENTITY, $entity);
    }

    /**
     * @inheritdoc
     */
    public function setReviewType($type)
    {
        return $this->setData(self::REVIEW_TYPE, $type);
    }

    /**
     * @inheritdoc
     */
    public function setReviewStatus($status)
    {
        return $this->setData(self::REVIEW_STATUS, $status);
    }

    /**
     * @inheritdoc
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * @inheritdoc
     */
    public function getCreatedAt()
    {
        return $this->_get(self::CREATED_AT);
    }

    /**
     * @inheritdoc
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * @inheritdoc
     */
    public function getEntityPkValue()
    {
        return $this->_get(self::ENTITY_PK_VALUE);
    }

    /**
     * @inheritdoc
     */
    public function setEntityPkValue($id)
    {
        return $this->setData(self::ENTITY_PK_VALUE, $id);
    }

    /**
     * @inheritdoc
     */
    public function getStores()
    {
        return $this->_get(self::STORES);
    }

    /**
     * @inheritdoc
     */
    public function setStores($stores)
    {
        return $this->setData(self::STORES, $stores);
    }

    /**
     * @inheritdoc
     */
    public function getStoreId()
    {
        return $this->_get(self::STORE_ID);
    }

    /**
     * @inheritdoc
     */
    public function setStoreId($storeId)
    {
        return $this->setData(self::STORE_ID, $storeId);
    }
}
