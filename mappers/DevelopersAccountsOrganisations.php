<?php

namespace App\Mappers;

/**
 * DevelopersAccountsOrganisations
 * 
 * @package App\Mappers
 */
class DevelopersAccountsOrganisations extends BaseMapper
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
    public $dev_acc_id;

    /**
     *
     * @var integer
     */
    public $org_id;

    /**
     *
     * @var string
     */
    public $org_token_issued_at;

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
        $this->setSource("developers_accounts_organisations");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'developers_accounts_organisations';
    }

}
