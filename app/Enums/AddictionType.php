<?php

namespace App\Enums;

enum AddictionType: int
{
    case Unknown = 0;
    case Nicotine = 1;
    case Alcohol = 2;
    case Pornography = 3;
    case Gambling = 4;
    case VideoGame = 5;
    case Sex = 6;
}
