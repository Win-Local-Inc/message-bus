<?php

namespace WinLocal\MessageBus\Enums;

use WinLocal\MessageBus\Contracts\SubjectEnum;

enum WinlocalSubject: string implements SubjectEnum
{
    case CardCreated = 'card.created';
    case CardPublishStart = 'card.publish.start';
    case CardPublishEnd = 'card.publish.end';
    case CardPublishMyNetworkStart = 'card.publish.my_network.start';
    case CardPublishMyNetworkEnd = 'card.publish.my_network.end';
    case TemplateCreated = 'template.created';
    case TemplateUpdated = 'template.updated';

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

    case CreditCardExpiring = 'credit-card.expiring';

    case DeferredPaymantFailed = 'campaign.deferred.payment.failed';

    case DevicesCreated = 'devices.created';
    case DevicesOrderPaid = 'devices.order.paid';
    case DeviceUsed = 'device.used';

    case LeaderBoardCreated = 'leaderboard.created';
    case LeaderBoardDisabled = 'leaderboard.disabled';
    case LeaderBoardEnabled = 'leaderboard.enabled';
    case LeaderBoardStarted = 'leaderboard.started';

    case FacebookAudienceCreated = 'audience.facebook.created';
    case FacebookAudienceUpdated = 'audience.facebook.updated';
    case FacebookAudienceDeleted = 'audience.facebook.deleted';
    case FacebookAdvertCreated = 'advert.facebook.created';
    case FacebookAdvertUpdated = 'advert.facebook.updated';
    case FacebookAdvertInsightsReceived = 'advert.facebook.insights.received';
    case FacebookCampaignActivated = 'campaigns.facebook.activated';
    case FacebookCampaignEnded = 'campaigns.facebook.ended';
    case FacebookCampaignFailed = 'campaigns.facebook.failed';

    case MbcSharecardCreated = 'mbc.sharecard.created';
    case MbcSharecardShared = 'mbc.sharecard.shared';
    case MbcSharecardShareOwnerNotified = 'mbc.sharcard.share.owner.notified';
    case MbcSharecardUpdated = 'mbc.sharecard.updated';
    case MbcSharecardVisited = 'mbc.sharecard.visited';
    case MbcSharecardTemplateUnsharedFromUser = 'mbc.sharecard.template.unshared_from_user';
    case MbcSharecardTemplateSharedToUser = 'mbc.sharecard.template.shared_to_user';
    case MbcSharecardConnectOwnerNotified = 'mbc.sharecard.connected';
    case MbcSharecardConnected = 'mbc.sharecard.connect.owner.notified';
    case MbcSharecardMyNetworkUserAttached = 'mbc.sharecard.mynetwork.user.attached';
    case MbcSharecardMyNetworkUserActivated = 'mbc.sharecard.mynetwork.user.activated';
    case MbcSharecardMyNetworkUserUnarchived = 'mbc.sharecard.mynetwork.user.unarchived';
    case MbcSharecardMyNetworkUserWithdrawn = 'mbc.sharecard.mynetwork.user.withdrawn';
    case MbcSharecardMyNetworkShared = 'mbc.sharecard.mynetwork.shared';

    case MediaShared = 'media.shared';
    case MediaCatalogShared = 'media.catalog.shared';

    case PaymentSucceeded = 'payment.succeeded';

    case PlayerAttachedToLeaderBoard = 'leaderboard.player.attached_to_leaderboard';
    case PlayerDetachedFromLeaderBoard = 'leaderboard.player.detached_from_leaderboard';

    case ShareLinkShared = 'sharelink.shared';
    case ShareLinkUnshared = 'sharelink.unshared';

    case ShortlinkCreated = 'shortlink.created';
    case ShortlinkEnteredUnique = 'shortlink.entered.unique';

    case StatsTest = 'stats.test';

    case UserAttachedToWorkspace = 'auth.user.workspace.attached';
    case UserCreated = 'auth.user.created';
    case UserFromDeviceOnboarded = 'user.device.onboarded';
    case UserGroupAttached = 'group.user.attached';
    case UserGroupDetached = 'group.user.detached';
    case UserPasswordForgotten = 'user.password.forgotten';
    case UserUpdated = 'auth.user.updated';
    case UserSetPassword = 'user.set.password';
    case UserStatusDeactivated = 'user.status.deactivated';
    case UserStatusActivated = 'user.status.activated';
    case UserWorkspaceInvited = 'user.workspace.invited';
    case UserWorkspaceMoved = 'user.workspace.moved';
    case UserOnboarded = 'user.onboarded';
    case UserToMyNetworkInvited = 'auth.user.mynetwork.invited';
    case UserToMyNetworkInvitationReminded = 'user.mynetwork.invitation.reminded';
    case UserSignedUp = 'user.signed.up';

    case WalletTopUp = 'wallet.top.up';

    case WorkspaceCreated = 'auth.workspace.created';
    case WorkspaceUpdated = 'auth.workspace.updated';
    case WorkspaceEngagePlusCreated = 'workspace.engageplus.created';
    case WorkspaceFranchiseCreated = 'workspace.franchise.created';
    case WorkspaceStatusActivated = 'workspace.status.activated';
    case WorkspaceStatusDeactivated = 'workspace.status.deactivated';
    case WorkspaceSubscriptionEnded = 'workspace.subscription.ended';
    case WorkspaceSubscriptionExpiring = 'workspace.subscription.expiring';
    case WorkspaceSubscriptionCreated = 'workspace.subscription.created';
    case WorkspaceSubscriptionUpdated = 'workspace.subscription.updated';
    case WorkspaceSubscriptionRenewalFailed = 'workspace.subscription.failed';
    case WorkspaceSubscriptionRenewalSucceeded = 'workspace.subscription.succeeded';
    case WorkspaceSubscriptionEndedNonPayment = 'workspace.subscription.ended.non.payment';
    case WorkspaceSubscriptionEndedContractTerminated = 'workspace.subscription.ended.contract.terminated';
    case WorkspaceSubscriptionRenewalReminded = 'workspace.subscription.renewal.reminded';
    case WorkspaceSubscriptionOrdered = 'workspace.subscription.ordered';
    case WorkspaceSubscriptionCancellationOrdered = 'workspace.subscription.cancellation.ordered';
}
