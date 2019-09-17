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
    const KEY_VOTE_ID = 'vote_id';
    const KEY_RATING_ID = 'rating_id';
    const KEY_VALUE = 'value';
    const KEY_PERCENT = 'percent';
    const KEY_RATING_NAME = 'rating_name';

    /**
     * Get rating vote id.
     *
     * @return int
     */
    public function getVoteId();

    /**
     * Get rating id
     *
     * @return int
     */
    public function getRatingId();

    /**
     * Get rating code.
     *
     * @return string
     */
    public function getRatingName();

    /**
     * @return int
     */
    public function getPercent();

    /**
     * Get rating value.
     * 1 - 20%, 2 - 40%..5 - 100%
     *
     * @return int
     */
    public function getValue();

    /**
     * @param int $percent
     * @return RatingVoteInterface
     */
    public function setPercent($percent);

    /**
     * Set rating id.
     *
     * @param int|null $id
     *
     * @return RatingVoteInterface
     */
    public function setVoteId($id);

    /**
     * @param int RatingVoteInterface
     *
     * @return mixed
     */
    public function setRatingId($ratingRatingId);

    /**
     * Set rating code.
     *
     * @param string $attributeCode
     *
     * @return RatingVoteInterface
     */
    public function setRatingName($attributeCode);

    /**
     * Set rating value.
     *
     * @param int $value
     * @return RatingVoteInterface
     */
    public function setValue($value);
}
