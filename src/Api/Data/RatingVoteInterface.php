<?php
/**
 * @package  Divante\ReviewApi
 * @author Agata Firlejczyk <afirlejczyk@divante.pl>
 * @copyright 2018 Divante Sp. z o.o.
 * @license See LICENSE_DIVANTE.txt for license details.
 */

namespace Divante\ReviewApi\Api\Data;

/**
 * Interface RatingVoteInterface
 */
interface RatingVoteInterface
{
    const KEY_ID = 'id';
    const KEY_VALUE = 'value';
    const KEY_ATTRIBUTE_CODE = 'attribute_code';
    const KEY_REVIEW_ID = 'review_id';

    /**
     * Get rating id.
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get review id.
     *
     * @return int
     */
    public function getReviewId();

    /**
     * Get rating code.
     *
     * @return string
     */
    public function getAttributeCode();

    /**
     * Get rating value.
     * 1 - 20%, 2 - 40%..5 - 100%
     *
     * @return int
     */
    public function getValue();

    /**
     * Set rating id.
     *
     * @param int|null $id
     *
     * @return void
     */
    public function setId($id);

    /**
     * Set review id.
     *
     * @param int $reviewId
     *
     * @return void
     */
    public function setReviewId($reviewId);

    /**
     * Set rating code.
     *
     * @param string $attributeCode
     *
     * @return void
     */
    public function setAttributeCode($attributeCode);

    /**
     * Set rating value.
     *
     * @param int $value
     * @return void
     */
    public function setValue($value);
}
