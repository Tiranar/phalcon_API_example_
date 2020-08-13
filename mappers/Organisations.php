<?php

namespace App\Mappers;

use Phalcon\Validation;
use Phalcon\Validation\Validator\Email as EmailValidator;

/**
 * Organisations
 * 
 * @package App\Mappers
 */
class Organisations extends BaseMapper
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
    public $logo_id;

    /**
     *
     * @var integer
     */
    public $cover_picture_id;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $phone_number;

    /**
     *
     * @var string
     */
    public $state;

    /**
     *
     * @var string
     */
    public $city;

    /**
     *
     * @var string
     */
    public $street;

    /**
     *
     * @var string
     */
    public $zip;

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
        $this->setSource("organisations");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'organisations';
    }

}
