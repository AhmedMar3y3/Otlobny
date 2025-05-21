<?php

namespace App\Enums;

enum SpecialOrderType: int
{
    case SENDING = 0;
    case RECEIVING = 1;

    public function formattedName(): string
    {
        return ucfirst(strtolower($this->name));
    }
}