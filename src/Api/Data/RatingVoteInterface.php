<?php
/**
 * Copyright Divante Sp. z o.o.
 * See LICENSE_DIVANTE.txt for license details.
 */

declare(strict_types=1);

namespace Divante\ReviewApi\Api\Data;

/**
 * Represents a ReviewVote object
 *
 * Used fully qualified namespaces in annotations for proper work of WebApi request parser
 *
 * @api
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
     * Retrieve Review Vote in percent
     *
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
     * Set Review Percent
     *
     * @param int $percent
     * @return RatingVoteInterface
     */
    public function setPercent($percent);

    /**
     * Set vote id.
     *
     * @param int $id
     *
     * @return RatingVoteInterface
     */
    public function setVoteId($id);

    /**
     * Set Rating Id
     *
     * @param int $ratingRatingId
     *
     * @return $this
     */
    public function setRatingId($ratingRatingId);

    /**
     * Set rating code.
     *
     * @param string $ratingCode
     *
     * @return RatingVoteInterface
     */
    public function setRatingName($ratingCode);

    /**
     * Set rating value.
     *
     * @param int $value
     * @return RatingVoteInterface
     */
    public function setValue($value);
}
