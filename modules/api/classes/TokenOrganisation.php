<?php

namespace App\Api\Classes;


final class TokenOrganisation extends Token
{

    /**
     * @var string
     */
    public $type = 'organisation';

    /**
     * @var string|null
     */
    public $organisation_hash;

    /**
     * TokenOrganisation constructor.
     * @param $decoded_token object|null
     */
    public function __construct($decoded_token = null)
    {
        parent::__construct($decoded_token);

        $this->organisation_hash = $decoded_token->organisation_hash;
    }

}