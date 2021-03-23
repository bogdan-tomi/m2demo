<?php
/**
 * This file was created to provide a simple interface for warranty providers
 *
 * @package     Evozon_GraphQlDemo
 * @subpackage
 * @author      Bogdan Tomi <bogdan.tomi@evozon.com>
 * @copyright   Copyright (c) Evozon Systems
 * See COPYING.txt for license details.
 */

namespace Evozon\GraphQlDemo\Api\Data;

/**
 * Represents a warranty provider
 *
 * @package Evozon\GraphQlDemo\Api\Data
 */
interface WarrantyProviderInterface
{
    /**
     * constants representing database table columns
     */
    const NAME = 'name';
    const COUNTRY = 'country';
    const RATING_COUNT = 'rating_count';
    const RATING_AVERAGE = 'rating_average';

    /**
     * Returns the warranty provider name
     *
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * Sets the warranty provider name
     *
     * @param string|null $name
     */
    public function setName(?string $name): void;

    /**
     * Returns the warranty provider country
     *
     * @return string|null
     */
    public function getCountry(): ?string;

    /**
     * Sets the warranty provider country
     *
     * @param string|null $country
     */
    public function setCountry(?string $country): void;

    /**
     * Returns the warranty provider rating count
     *
     * @return int|null
     */
    public function getRatingCount(): ?int;

    /**
     * Sets the warranty provider rating count
     *
     * @param int|null $ratingCount
     */
    public function setRatingCount(?int $ratingCount): void;

    /**
     * Returns the warranty provider rating average
     *
     * @return float|null
     */
    public function getRatingAverage(): ?float;

    /**
     * Sets the warranty provider rating average
     *
     * @param float|null $ratingAverage
     */
    public function setRatingAverage(?float $ratingAverage): void;

}
