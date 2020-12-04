<?php declare(strict_types=1);

namespace Evozon\Cache\Model;

use Magento\Framework\View\Element\Block\ArgumentInterface;

class Counties
{
    public function getAllCounties(): array
    {
        return [
            'Alba',
            'Arad',
            'Arges',
            'Bacău',
            'Bihor',
            'Bistriţa-Năsăud',
            'Botoşani',
            'Braşov',
            'Brăila',
            'Bucureşti',
            'Buzău',
            'Caraş-Severin',
            'Călăraşi',
            'Cluj',
            'Constanţa',
            'Covasna',
            'Dâmboviţa',
            'Dolj',
            'Galaţi',
            'Giurgiu',
            'Gorj',
            'Harghita',
            'Hunedoara',
            'Ialomiţa',
            'Iaşi',
            'Ilfov',
            'Maramureş',
            'Mehedinţi',
            'Mureş',
            'Neamţ',
            'Olt',
            'Prahova',
            'Satu-Mare',
            'Sălaj',
            'Sibiu',
            'Suceava',
            'Teleorman',
            'Timiş',
            'Tulcea',
            'Vâlcea',
            'Vaslui',
            'Vrancea'
        ];
    }
}
