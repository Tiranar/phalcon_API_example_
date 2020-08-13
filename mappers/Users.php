<?php

namespace App\Mappers;

use Phalcon\Validation;
use Phalcon\Validation\Validator\Email as EmailValidator;

/**
 * Users
 * 
 * @package App\Mappers
 */
class Users extends BaseMapper
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $last_seen_org_id;

    /**
     *
     * @var integer
     */
    public $avatar_id;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var string
     */
    public $contact_email;

    /**
     *
     * @var string
     */
    public $first_name;

    /**
     *
     * @var string
     */
    public $last_name;

    /**
     *
     * @var string
     */
    public $nickname;

    /**
     *
     * @var string
     */
    public $phone_number;

    /**
     *
     * @var string
     */
    public $birthday;

    /**
     *
     * @var string
     */
    public $password;

    /**
     *
     * @var string
     */
    public $confirm_code;

    /**
     *
     * @var integer
     */
    public $is_internal;

    /**
     *
     * @var string
     */
    public $remember_token;

    /**
     *
     * @var string
     */
    public $login_at;

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
     *
     * @var string
     */
    public $deleted_at;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema($this->getDI()->getShared('config')->database->dbname);
        $this->setSource("users");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'users';
    }

}
