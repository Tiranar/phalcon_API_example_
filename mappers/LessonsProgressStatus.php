<?php

namespace App\Mappers;

/**
 * LessonsProgressStatus
 * 
 * @package App\Mappers
 */
class LessonsProgressStatus extends BaseMapper
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
    public $name;

    /**
     *
     * @var integer
     */
    public $percent;

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
        $this->setSource("lessons_progress_status");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'lessons_progress_status';
    }

}
