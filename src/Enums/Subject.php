<?php

namespace WinLocal\MessageBus\Enums;

enum Subject: string
{
    case AdvertCreated = 'advert.created';
    case AdvertUpdated = 'advert.updated';
    case AudienceCreated = 'audience.created';
    case AudienceDeleted = 'audience.deleted';
    case AudienceUpdated = 'audience.updated';

    case CampaignKeywordChanged = 'campaign.keyword.changed';

    case FacebookAudienceCreated = 'audience.facebook.created';
    case FacebookAudienceDeleted = 'audience.facebook.deleted';
    case FacebookAdvertCreated = 'advert.facebook.created';
    case FacebookAdvertUpdated = 'advert.facebook.updated';
    case FacebookAdvertInsightsReceived = 'advert.facebook.insights.received';

    case MbcSharecardCreated = 'mbc.sharecard.created';

    case ShortlinkCreated = 'shortlink.created';

    case UserAttachedToWorkspace = 'auth.user.workspace.attached';
    case UserCreated = 'auth.user.created';
    case UserStatusDeactivated = 'user.status.deactivated';
    case UserStatusActivated = 'user.status.activated';
    case UserWorkspaceMoved = 'user.workspace.moved';

    case WorkspaceStatusActivated = 'workspace.status.activated';
    case WorkspaceStatusDeactivated = 'workspace.status.deactivated';
}
