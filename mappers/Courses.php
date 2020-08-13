<?php

namespace App\Mappers;

/**
 * Courses
 * 
 * @package App\Mappers
 */
class Courses extends BaseMapper
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
    public $author_id;

    /**
     *
     * @var integer
     */
    public $original_author_id;

    /**
     *
     * @var integer
     */
    public $thumbnail_id;

    /**
     *
     * @var integer
     */
    public $featured_background_id;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $subtitle;

    /**
     *
     * @var string
     */
    public $description;

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
        $this->setSource("courses");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'courses';
    }

}
