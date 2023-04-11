<?php

namespace WinLocal\MessageBus\Enums;

enum Subject: string
{
    case AdvertCreated = 'advert.created';
    case AdvertUpdated = 'advert.updated';
    case AudienceCreated = 'audience.created';
    case AudienceDeleted = 'audience.deleted';
}
