<?php

namespace Evozon\Cache\Model;

use Magento\Framework\Session\SessionManager;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class FavouritePetSession extends SessionManager implements ArgumentInterface
{

    private const STORAGE_KEY = 'favourite_pet';

    private const PET_CAT = 'cat';

    private const PET_DOG = 'dog';

    private $pet = '';

    public function hatesDogs()
    {
        return $this->getFavouritePet() === self::PET_CAT;
    }

    public function hatesCats()
    {
        return $this->getFavouritePet() === self::PET_DOG;
    }

    public function setFavouritePet($pet)
    {
        if (!in_array($pet, [self::PET_CAT, self::PET_DOG], true)) {
            throw new \InvalidArgumentException('Invalid favourite pet: ' . $pet);
        }
        $this->pet = $pet;
        $this->getSessionStorage()->setData(self::STORAGE_KEY, $pet);
    }

    public function getSessionStorage()
    {
        return $this->storage;
    }

    public function getFavouritePet()
    {
        $pet = $this->pet ?: $this->getSessionStorage()->getData(self::STORAGE_KEY);
        return (string) $pet;
    }

    public function hasChosen()
    {
        return (bool) $this->getFavouritePet();
    }

    public function getFavouritePetByCustomerId($customerId)
    {
        // this is where we pretend to retrieve the value from the database
        $randomizedArray = [self::PET_CAT, self::PET_DOG];
        return $randomizedArray[array_rand($randomizedArray)];
    }
}
