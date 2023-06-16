<?php

namespace WinLocal\MessageBus\Enums;

enum Subject: string
{
    case AdvertCreated = 'advert.created';
    case AdvertUpdated = 'advert.updated';
    case AudienceCreated = 'audience.created';
    case AudienceDeleted = 'audience.deleted';
    case AudienceShared = 'audience.shared';
    case AudienceUpdated = 'audience.updated';

    case CampaignKeywordChanged = 'campaign.keyword.changed';
    case CampaignSmsBrandedSmsReceived = 'campaign.sms.branded.sms.received';
    case CampaignSmsSharecardSmsReceived = 'campaign.sms.sharecard.sms.received';
    case CampaignSocialStandardLeadReceived = 'campaign.social.standard.lead.received';
    case CampaignSmsBrandedReceiverAdded = 'campaign.sms.branded.receiver.added';
    case CampaignSmsBrandedReceiverRemoved = 'campaign.sms.branded.receiver.removed';
    case CampaignSmsSharecardReceiverAdded = 'campaign.sms.sharecard.receiver.added';

    case ContactCreated = 'contact.contact.created';
    case ContactUpdated = 'contact.contact.updated';

    case DevicesCreated = 'devices.created';
    case DevicesOrderPaid = 'devices.order.paid';
    case DeviceUsed = 'device.used';

    case FacebookAudienceCreated = 'audience.facebook.created';
    case FacebookAudienceDeleted = 'audience.facebook.deleted';
    case FacebookAdvertCreated = 'advert.facebook.created';
    case FacebookAdvertUpdated = 'advert.facebook.updated';
    case FacebookAdvertInsightsReceived = 'advert.facebook.insights.received';

    case MbcSharecardCreated = 'mbc.sharecard.created';
    case MbcSharecardShared = 'mbc.sharecard.shared';
    case MbcSharecardShareOwnerNotified = 'mbc.sharcard.share.owner.notified';
    case MbcSharecardUpdated = 'mbc.sharecard.updated';
    case MbcSharecardVisited = 'mbc.sharecard.visited';

    case MediaShared = 'media.shared';
    case MediaCatalogShared = 'media.catalog.shared';

    case ShortlinkCreated = 'shortlink.created';
    case ShortlinkEnteredUnique = 'shortlink.entered.unique';

    case StatsTest = 'stats.test';

    case UserAttachedToWorkspace = 'auth.user.workspace.attached';
    case UserCreated = 'auth.user.created';
    case UserGroupAttached = 'group.user.attached';
    case UserGroupDetached = 'group.user.detached';
    case UserPasswordForgotten = 'user.password.forgotten';
    case UserUpdated = 'auth.user.updated';
    case UserSetPassword = 'user.set.password';
    case UserStatusDeactivated = 'user.status.deactivated';
    case UserStatusActivated = 'user.status.activated';
    case UserWorkspaceInvited = 'user.workspace.invited';
    case UserWorkspaceMoved = 'user.workspace.moved';

    case WorkspaceCreated = 'auth.workspace.created';
    case WorkspaceUpdated = 'auth.workspace.updated';
    case WorkspaceEngagePlusCreated = 'workspace.engageplus.created';
    case WorkspaceFranchiseCreated = 'workspace.franchise.created';
    case WorkspaceStatusActivated = 'workspace.status.activated';
    case WorkspaceStatusDeactivated = 'workspace.status.deactivated';
    case WorkspaceSubscriptionEnded = 'workspace.subscription.ended';
    case WorkspaceSubscriptionExpiringNotified = 'workspace.subscription.expiring.notified';
    case WorkspaceSubscriptionCreated = 'workspace.subscription.created';
    case WorkspaceSubscriptionUpdated = 'workspace.subscription.updated';
}
