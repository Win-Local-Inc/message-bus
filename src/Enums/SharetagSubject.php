<?php

namespace WinLocal\MessageBus\Enums;

use WinLocal\MessageBus\Contracts\SubjectEnum;

enum SharetagSubject: string implements SubjectEnum
{
    case SHOPIFY_ORDER_PAID  = 'shopify.orders/paid';
    case ORDER_CREATED  = 'order.created';
}
