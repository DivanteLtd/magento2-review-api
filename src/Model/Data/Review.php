<?php
/**
 * Copyright Divante Sp. z o.o.
 * See LICENSE_DIVANTE.txt for license details.
 */
declare(strict_types=1);

namespace Divante\ReviewApi\Model\Data;

use Divante\ReviewApi\Api\Data\ReviewInterface;
use Magento\Framework\Api\AbstractSimpleObject;

/**
 * @inheritdoc
 */
class Review extends AbstractSimpleObject implements ReviewInterface
{
    /**
     * @inheritdoc
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->_get(self::ID);
    }

    /**
     * @inheritdoc
     *
     * @return int|null
     */
    public function getCustomerId()
    {
        return $this->_get(self::CUSTOMER_ID);
    }

    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getDetail()
    {
        return $this->_get(self::DETAIL);
    }

    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getNickname()
    {
        return $this->_get(self::NICKNAME);
    }

    /**
     * @inheritdoc
     *
     * @return \Divante\ReviewApi\Api\Data\RatingVoteInterface[]
     */
    public function getRatings()
    {
        return $this->_get(self::RATINGS);
    }

    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getReviewEntity()
    {
        return $this->_get(self::REVIEW_ENTITY);
    }

    /**
     * @inheritdoc
     *
     * @return int
     */
    public function getReviewType()
    {
        return $this->_get(self::REVIEW_TYPE);
    }

    /**
     * @inheritdoc
     *
     * @return int
     */
    public function getReviewStatus()
    {
        return $this->_get(self::REVIEW_STATUS);
    }

    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->_get(self::TITLE);
    }

    /**
     * @inheritdoc
     *
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * @inheritdoc
     *
     * @param string $detail
     *
     * @return ReviewInterface
     */
    public function setDetail($detail)
    {
        return $this->setData(self::DETAIL, $detail);
    }

    /**
     * @inheritdoc
     *
     * @param int|null $customerId
     *
     * @return ReviewInterface
     */
    public function setCustomerId($customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    /**
     * @inheritdoc
     *
     * @param string $nickName
     *
     * @return ReviewInterface
     */
    public function setNickname($nickName)
    {
        return $this->setData(self::NICKNAME, $nickName);
    }

    /**
     * @inheritdoc
     *
     * @param \Divante\ReviewApi\Api\Data\RatingVoteInterface[] $ratings
     *
     * @return Review|void
     */
    public function setRatings($ratings)
    {
        return $this->setData(self::RATINGS, $ratings);
    }

    /**
     * @inheritdoc
     *
     * @param string $entity
     *
     * @return $this
     */
    public function setReviewEntity($entity)
    {
        return $this->setData(self::REVIEW_ENTITY, $entity);
    }

    /**
     * @inheritdoc
     *
     * @param int $type
     *
     * @return $this
     */
    public function setReviewType(int $type)
    {
        return $this->setData(self::REVIEW_TYPE, $type);
    }

    /**
     * @inheritdoc
     *
     * @param int $status
     *
     * @return $this
     */
    public function setReviewStatus($status)
    {
        return $this->setData(self::REVIEW_STATUS, $status);
    }

    /**
     * @inheritdoc
     *
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->_get(self::CREATED_AT);
    }

    /**
     * @inheritdoc
     *
     * @param string $createdAt
     *
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * @inheritdoc
     *
     * @return int
     */
    public function getEntityPkValue()
    {
        return $this->_get(self::ENTITY_PK_VALUE);
    }

    /**
     * @inheritdoc
     *
     * @param int $id
     *
     * @return $this
     */
    public function setEntityPkValue($id)
    {
        return $this->setData(self::ENTITY_PK_VALUE, $id);
    }

    /**
     * @inheritdoc
     *
     * @return array
     */
    public function getStores()
    {
        return $this->_get(self::STORES);
    }

    /**
     * @inheritdoc
     *
     * @param array $stores
     *
     * @return $this
     */
    public function setStores(array $stores)
    {
        return $this->setData(self::STORES, $stores);
    }

    /**
     * @inheritdoc
     *
     * @return int
     */
    public function getStoreId()
    {
        return $this->_get(self::STORE_ID);
    }

    /**
     * @inheritdoc
     *
     * @param int $storeId
     *
     * @return $this
     */
    public function setStoreId($storeId)
    {
        return $this->setData(self::STORE_ID, $storeId);
    }
}
