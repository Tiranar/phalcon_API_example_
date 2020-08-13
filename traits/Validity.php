<?php

namespace App\Traits;

trait Validity {
    /**
     * @var object
     */
    public $localisation;

    /**
     * Validate
     * 
     * @param mixed $data
     * @param mixed $entity
     * 
     * @return array
     */
    public function validate($data = null, $entity = null)
    {
        $problems = parent::validate($data, $entity);

        $validity = [
            'success' => true,
            'problems' => []
        ];

        if (count($problems)) {
            $validity['success'] = false;
            foreach ($problems as $p) {
                $validity['problems'][$p->getField()][] = $this->localisation->translate_validation($p->getField(), $p->getMessage());
            }
        }

        return $validity;
    }
}