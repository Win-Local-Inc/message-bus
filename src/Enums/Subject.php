<?php

namespace WinLocal\MessageBus\Enums;

enum Subject: string
{
    case AdvertCreated = 'advert.created';
    case AdvertUpdated = 'advert.updated';
    case AudienceCreated = 'audience.created';
    case AudienceUpdated = 'audience.updated';
    case AudienceDeleted = 'audience.deleted';
}