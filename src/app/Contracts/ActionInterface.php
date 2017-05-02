<?php

namespace app\Contracts;

interface ActionInterface
{
    const ACTION_MANAGE_COMPANY_BIDDER = 'manageCompanyBidder';
    const ACTION_MANAGE_COMPANY = 'manageCompany';
    const ACTION_CREATE_REQUEST = 'createRequest';
    const ACTION_INFORMATION_REQUEST = 'informationRequest';

    public function action();
}