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
    const KEY_VALUE = 'value';
    const KEY_RATING_NAME = 'rating_name';

    /**
     * Get rating vote id.
     *
     * @return int|null
     */
    public function getVoteId();

    /**
     * Get rating code.
     *
     * @return string
     */
    public function getRatingName();

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
    public function setVoteId($id);

    /**
     * Set rating code.
     *
     * @param string $attributeCode
     *
     * @return void
     */
    public function setRatingName($attributeCode);

    /**
     * Set rating value.
     *
     * @param int $value
     * @return void
     */
    public function setValue($value);
}
