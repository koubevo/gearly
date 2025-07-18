<?php

namespace App\Enums;

enum MessageType: int
{
    case Normal = 1;
    case Sold = 2;
    case Received = 3;
    case Rating = 4;
}
