<?php

namespace WinLocal\MessageBus\Enums;

use WinLocal\MessageBus\Contracts\SubjectEnum;

enum SharetagSubject: string implements SubjectEnum
{
    case SHOPIFY_ORDER_CREATED  = 'shopify.order.created';
    case ORDER_CREATED  = 'order.created';
}
