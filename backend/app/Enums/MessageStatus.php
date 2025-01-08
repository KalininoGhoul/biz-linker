<?php

namespace App\Enums;

enum MessageStatus: string
{
    case SENT = 'sent';

    case DELIVERED = 'delivered';
}
