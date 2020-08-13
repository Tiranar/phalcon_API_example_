<?php

namespace App\Api\Controllers;

use App\Api\Models\Marketplace;
use App\Api\Models\MarketplaceStatuses;
use App\Api\Models\Courses;

class CourseController extends BaseController
{
    /**
     * Get Courses List Action
     *
     * @return string
     */
    public function getListAction()
    {
        if ($this->identity->isOrganisation()) {
            $array = [];
            $data = [];
            $accepted = MarketplaceStatuses::findFirst([
                'conditions' => 'status = :status:',
                'bind' => [
                    'status' => 'accepted'
                ]
            ]);
            $organisation = $this->identity->getOrganisation();

            $marketplace = Marketplace::find([
                'conditions' => 'organisation_id = :organisation_id: and marketplace_status_id = :status:',
                'bind' => [
                    'organisation_id' => $organisation->id,
                    'status' => $accepted->id
                ],
                'columns' => 'distinct(course_id)'
            ]);

            foreach ($marketplace as $m) {
                $m = $m->toArray();
                $array[] = $m[0];
            }

            $courses = Courses::query();
            $courses = $courses->inWhere("id",$array)->execute();

            foreach ($courses as $k => $c) {
                $users = [];
                
                foreach ($c->getRelated('UsersCourses') as $key=>$uc) {
                    $users[$key] = $uc->getRelated('Users');
                }
                
                $data[$k]['course_hash'] = $this->encrypter->encryptString($c->id);
                $data[$k]['name'] = $c->name;
                $data[$k]['subtitle'] = $c->subtitle;
                $data[$k]['description'] = $c->description;
                $data[$k]['author'] = $c->getRelated('Author');
                $data[$k]['users'] = $users;
            }

            $this->buildSuccessResponse('common.SUCCESSFUL_REQUEST', $data);
        }

        $this->buildErrorResponse(403, 'common.ACCESS_DENIED');
    }
}