<?php

namespace App\Mappers;

use Phalcon\Validation;
use Phalcon\Validation\Validator\Email as EmailValidator;

/**
 * DevelopersAccounts
 * 
 * @package App\Mappers
 */
class DevelopersAccounts extends BaseMapper
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $acc_key;

    /**
     *
     * @var string
     */
    public $acc_secret;

    /**
     *
     * @var string
     */
    public $issued_to;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var string
     */
    public $dev_token_issued_at;

    /**
     *
     * @var string
     */
    public $created_at;

    /**
     *
     * @var string
     */
    public $updated_at;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema($this->getDI()->getShared('config')->database->dbname);
        $this->setSource("developers_accounts");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'developers_accounts';
    }

}
