<?php

namespace App\Mappers;

/**
 * UsersCoursesProgress
 * 
 * @package App\Mappers
 */
class UsersCoursesProgress extends BaseMapper
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
    public $lesson_id;

    /**
     *
     * @var integer
     */
    public $progress_status_id;

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
        $this->setSource("users_courses_progress");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'users_courses_progress';
    }

}
