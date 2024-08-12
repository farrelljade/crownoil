<?php

namespace App\Enums;

enum LeadSource: string
{
    case OUTBOUND_PROSPECT_CALL = 'Outbound Prospect Call';
    case INBOUND_REFERRAL = 'Inbound Referral';
    case INBOUND_WEBSITE = 'Inbound Website';
    case LIVE_CHAT = 'Live Chat';
}
