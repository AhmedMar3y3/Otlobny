<?php

namespace App\Enums;

enum OrderPayStatus:int
{
    case NOT_PAIED   = 0;
    case PAIED       = 1;
}