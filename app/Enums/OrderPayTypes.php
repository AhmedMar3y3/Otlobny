<?php

namespace App\Enums;

enum OrderPayTypes:int
{
    case CASH      = 0;
    case ONLINE    = 1;

    public function formattedName(): string
    {
        return ucfirst(strtolower($this->name));
    }
}