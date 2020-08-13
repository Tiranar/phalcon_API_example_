<?php

namespace App\Mappers;

/**
 * Marketplace
 * 
 * @package App\Mappers
 */
class Marketplace extends BaseMapper
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
    public $organisation_id;

    /**
     *
     * @var integer
     */
    public $course_id;

    /**
     *
     * @var integer
     */
    public $marketplace_status_id;

    /**
     *
     * @var integer
     */
    public $reviewed_by;

    /**
     *
     * @var integer
     */
    public $is_published;

    /**
     *
     * @var integer
     */
    public $is_wildcard_assigned;

    /**
     *
     * @var integer
     */
    public $is_wildcard_obligatory;

    /**
     *
     * @var integer
     */
    public $review_completed;

    /**
     *
     * @var string
     */
    public $review_message;

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
        $this->setSource("marketplace");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'marketplace';
    }

}
