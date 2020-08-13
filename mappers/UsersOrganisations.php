<?php

namespace App\Mappers;

/**
 * UsersOrganisations
 * 
 * @package App\Mappers
 */
class UsersOrganisations extends BaseMapper
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
    public $user_id;

    /**
     *
     * @var integer
     */
    public $organisation_id;

    /**
     *
     * @var integer
     */
    public $is_admin;

    /**
     *
     * @var integer
     */
    public $is_owner;

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
        $this->setSource("users_organisations");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'users_organisations';
    }

}
