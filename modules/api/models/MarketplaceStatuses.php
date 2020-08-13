<?php

namespace App\Api\Models;

class MarketplaceStatuses extends \App\Mappers\MarketplaceStatuses
{

    public function initialize()
    {
        parent::initialize();

        $this->hasMany('id', 'App\Api\Models\Marketplace', 'marketplace_status_id', ['alias' => 'Marketplace']);
    }

}