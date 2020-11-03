<?php

namespace Evozon\M2Demo\Model\Api\Data;

interface CustomerFlairInterface
{
    /**
     * @return void
     */
    public function setId($id);

    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getNickname(): ?string;

    /**
     * @return void
     */
    public function setNickname(?string $nickname): void;

    /**
     * @return int
     */
    public function getCustomerId(): int;

    /**
     * @return void
     */
    public function setCustomerId($customerId): void;

    /**
     * @return string
     */
    public function getMotto(): ?string;

    /**
     * @return void
     */
    public function setMotto(?string $motto): void;
}
