<?php

namespace App\Api\Classes;

use App\Api\Models\DevelopersAccounts;
use App\Api\Models\Organisations;
use Phalcon\DiInterface;

class Identity
{

    private $di;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var Token|TokenDeveloper|TokenOrganisation
     */
    protected $token_decoded;

    /**
     * @var DevelopersAccounts|null
     */
    protected $dev_acc;

    /**
     * @var Organisations|null
     */
    protected $organisation;

    /**
     * Identity constructor.
     * @param DiInterface $di
     */
    public function __construct(DiInterface $di)
    {
        $this->di = $di;
        $this->token = '';
        $this->token_decoded = new Token();
        $this->dev_acc = new DevelopersAccounts();
        $this->organisation = new Organisations();
    }

    /**
     * Set Token
     *
     * @param string $token
     * @param object $token_decoded
     * 
     * @return boolean
     */
    public function setToken(string $token, $token_decoded)
    {
        $this->token = $token;

        $this->dev_acc = DevelopersAccounts::findFirst([
            'conditions' => 'acc_key = :acc_key:',
            'bind' => [
                'acc_key' => $token_decoded->acc_key
            ]
        ]);

        if (!$this->dev_acc) {
            return false;
        }

        if ($token_decoded->type == 'developer') {
            $this->token_decoded = new TokenDeveloper($token_decoded);
        }

        if ($token_decoded->type == 'organisation') {
            $this->token_decoded = new TokenOrganisation($token_decoded);

            $this->organisation = Organisations::findFirst([
                'conditions' => 'id = :decoded_hash:',
                'bind' => [
                    'decoded_hash' => $this->di->getShared('encrypter')->decryptString($token_decoded->organisation_hash)
                ]
            ]);

            if (!$this->organisation) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check Organisation Token
     */
    public function isOrganisation()
    {
        return $this->token_decoded->type == 'organisation';
    }

    /**
     * Check Developer Token
     */
    public function isDeveloper()
    {
        return $this->token_decoded->type == 'developer';
    }

    /**
     * Get Developer Account
     */
    public function getDevAcc()
    {
        return $this->dev_acc;
    }

    /**
     * Get Organisation Info
     */
    public function getOrganisation()
    {
        return $this->organisation;
    }

    /**
     * Get Token Decoded
     */
    public function getTokenDecoded()
    {
        return $this->token_decoded;
    }

    /**
     * Get Token
     */
    public function getToken()
    {
        return $this->token;
    }
}