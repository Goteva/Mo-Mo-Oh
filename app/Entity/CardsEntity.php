<?php

namespace App\Entity;

use Core\Entity\Entity;

class CardsEntity extends Entity{

    public function getUrl()
    {
        return 'index.php?p=cards.detail&id='.$this->id_cards;
    } 
}