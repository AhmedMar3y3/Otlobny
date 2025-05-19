<?php

namespace App\Enums;

enum OrderStatus: int
{
    case PREPARING = 0;
    case WAITING = 1;
    case SHIPPING = 2;
    case DELIVERED = 3;

    public function formattedName(): string
    {
        return ucfirst(strtolower($this->name));
    }
}