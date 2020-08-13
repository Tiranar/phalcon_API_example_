<?php

namespace App\Api\Classes;


final class TokenDeveloper extends Token
{

    /**
     * @var string
     */
    public $type = 'developer';

    /**
     * TokenDeveloper constructor.
     * @param $decoded_token object|null
     */
    public function __construct($decoded_token = null)
    {
        parent::__construct($decoded_token);
    }

}