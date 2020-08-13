<?php

namespace App\Mappers;

/**
 * UsersCourses
 * 
 * @package App\Mappers
 */
class UsersCourses extends BaseMapper
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
    public $marketplace_id;

    /**
     *
     * @var integer
     */
    public $assigned_by_id;


    /**
     *
     * @var integer
     */
    public $is_obligatory;

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
        $this->setSource("users_courses");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'users_courses';
    }

}
