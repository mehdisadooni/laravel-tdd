<?php

namespace App\Enums;

enum TaskStatus :string
{
    case NOT_STARTED = 'not_started';
    case STARTED = 'started';
    case PENDING = 'pending';
}
