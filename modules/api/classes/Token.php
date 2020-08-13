<?php

namespace App\Api\Classes;


/**
 * Class Token
 * @package App\Api\Classes
 */
class Token
{
    /**
     * @var string
     */
    public $type = 'unknown';

    /**
     * @var string
     */
    public $iss;

    /**
     * @var string
     */
    public $aud;

    /**
     * @var string
     */
    public $acc_key;

    /**
     * @var string
     */
    public $acc_email;

    /**
     * @var integer
     */
    public $iat;

    /**
     * @var integer
     */
    public $exp;

    /**
     * @var mixed
     */
    public $rand;


    /**
     * Token constructor.
     * @param $decoded_token object|null
     */
    public function __construct($decoded_token = null)
    {
        if ($decoded_token) {
            if (is_object($decoded_token)) {
                $this->iss = $decoded_token->iss;
                $this->aud = $decoded_token->aud;
                $this->acc_key = $decoded_token->acc_key;
                $this->iat = $decoded_token->iat;
                $this->exp = $decoded_token->exp;
                $this->rand = $decoded_token->rand;
            }
        }
    }
}