<?php

namespace App\Mappers;

/**
 * Certificates
 * 
 * @package App\Mappers
 */
class Certificates extends BaseMapper
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
    public $course_id;

    /**
     *
     * @var integer
     */
    public $org_id;

    /**
     *
     * @var string
     */
    public $cert_name;

    /**
     *
     * @var string
     */
    public $issued_user_name;

    /**
     *
     * @var string
     */
    public $issued_course_name;

    /**
     *
     * @var string
     */
    public $issued_course_author_name;

    /**
     *
     * @var string
     */
    public $issued_course_count_lessons;

    /**
     *
     * @var string
     */
    public $issued_org_name;

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
        $this->setSource("certificates");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'certificates';
    }

}
