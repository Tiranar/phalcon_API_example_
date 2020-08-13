<?php

namespace App\Api\Controllers;

use App\Api\Models\DevelopersAccountsOrganisations;
use App\Api\Models\UsersOrganisations;
use App\Api\Models\Users;
use App\Api\Models\Marketplace;
use App\Api\Models\UsersCourses;
use App\Api\Requests\User\CreateUserRequest;
use App\Traits\CURL;
use Phalcon\Mvc\Model\Query;

class OrganisationController extends BaseController
{
    
    use CURL;

    /**
     * Get Organisations List Action
     * 
     * @return string
     */
    public function getListAction()
    {
        if ($this->identity->isDeveloper()) {
            $orgs = [];
            $devOrgs = DevelopersAccountsOrganisations::find([
                'conditions' => 'dev_acc_id = :dev_acc_id:',
                'bind' => [
                    'dev_acc_id' => $this->identity->getDevAcc()->id
                ]
            ]);

            foreach ($devOrgs as $k=>$v) {
                $org = $v->getRelated('Organisations');
                $orgs[$k]['hash'] = $this->encrypter->encryptString($org->id);
                $orgs[$k]['email'] = $org->email;
                $orgs[$k]['name'] = $org->name;
            }

            $this->buildSuccessResponse('common.SUCCESSFUL_REQUEST', $orgs);
        }

        $this->buildErrorResponse(403, 'common.ACCESS_DENIED');
    }

    /**
     * Get Organisation Users List Action
     *
     * @return string
     */
    public function getUsersListAction()
    {
        if ($this->identity->isOrganisation()) {
            $data = [];
            $courses = [];
            $organisation = $this->identity->getOrganisation();
            $usersOrganisations = UsersOrganisations::find([
                'conditions' => 'organisation_id = :organisation_id:',
                'bind' => [
                    'organisation_id' => $organisation->id
                ]
            ]);

            foreach ($usersOrganisations as $key=>$uo) {
                $ids = [];
                $user = $uo->getRelated('Users');

                if (!$user) {
                    continue;
                }

                $usersCourses = $user->getRelated('UsersCourses');

                foreach ($usersCourses as $uc) {
                    @$ids[] = (int)$uc->course_id;
                }


                if (!empty($ids)) {
                    $ids = implode(',', $ids);

                    /********************/
                    /* Temp Decision    */
                    /********************/
                    $phql = 'SELECT App\Api\Models\Courses.id,
                            App\Api\Models\Courses.name,
                            App\Api\Models\Courses.subtitle,
                            App\Api\Models\Courses.description,
                            App\Api\Models\Users.id as author_id,
                            ROUND(AVG(App\Api\Models\LessonsProgressStatus.percent)) AS completion 
                          FROM App\Api\Models\Courses 
                          INNER JOIN App\Api\Models\Lessons 
                              ON App\Api\Models\Lessons.course_id = App\Api\Models\Courses.id 
                            AND App\Api\Models\Lessons.deleted_at IS NULL 
                          LEFT JOIN App\Api\Models\UsersCoursesProgress 
                              ON App\Api\Models\UsersCoursesProgress.lesson_id = App\Api\Models\Lessons.id 
                            AND App\Api\Models\UsersCoursesProgress.user_id = ' . ((int)$user->id) . '
                          LEFT JOIN App\Api\Models\LessonsProgressStatus 
                            ON App\Api\Models\LessonsProgressStatus.id = App\Api\Models\UsersCoursesProgress.progress_status_id 
                          LEFT JOIN App\Api\Models\Users 
                            ON App\Api\Models\Users.id = App\Api\Models\Courses.author_id 
                          WHERE App\Api\Models\Courses.id IN (' . $ids . ') AND App\Api\Models\Courses.deleted_at IS NULL 
                          GROUP BY App\Api\Models\Courses.id
                    ';

                    $query = new Query(
                        $phql,
                        $this->getDI()
                    );

                    $executed = $query->execute();
                    /********************/
                    /********************/

                    foreach ($executed as $ek=>$e) {
                        $courses[$ek]['course_hash'] = $this->encrypter->encryptString($e->id);
                        $courses[$ek]['name'] = $e->name;
                        $courses[$ek]['subtitle'] = $e->subtitle;
                        $courses[$ek]['description'] = $e->description;
                        $courses[$ek]['author'] = Users::findFirst([
                            'conditions' => 'id = :id:',
                            'bind' => [
                                'id' => $e->author_id
                            ]
                        ]);
                    }
                }

                $data[$key]['user'] = $user;
                $data[$key]['courses'] = $courses;
            }

            $this->buildSuccessResponse('common.SUCCESSFUL_REQUEST', $data);
        }

        $this->buildErrorResponse(403, 'common.ACCESS_DENIED');
    }

    /**
     * Create Organisation User Action
     *
     * @return string
     */
    public function createUserAction()
    {
        $data = [];
        $request = $this->request->getJsonRawBody();
        $validity = CreateUserRequest::make($request, $this->localisation);
        $organisation = $this->identity->getOrganisation();

        if ($validity['success']) {
            foreach ($request as $k=>$r) {
                $data[$k] = $r;
            }
            
            $url = $this->config->get('cms_api')['url'] . $this->config->get('cms_api')['auth_path'];

            $header = [
                "Content-Type: application/json"
            ];

            $auth = [
                'email' => $this->config->get('cms_api')['auth_email'],
                'password' => $this->config->get('cms_api')['auth_password']
            ];

            $data_string = json_encode($auth);

            $api = $this->postDataHeaderWithHeaderJson($url, $header, $data_string, false);

            if (!empty($api['headers']['Authorization'])) {
                $header = [
                    "Authorization: Bearer " . $api['headers']['Authorization'],
                    "Content-Type: application/json"
                ];
                $data['organisation'] = $organisation->id;
                $data_string = json_encode($data);
                $url = $this->config->get('cms_api')['url'] . $this->config->get('cms_api')['create_user_path'];
                
                $api = $this->postDataHeaderJson($url, $header, $data_string, false);

                if ($api->success) {
                    $data = [];
                    foreach ($api->data as $kd=>$d) {
                        $data[$kd] = $d;
                    }

                    $this->addUserToCourses($data['id'], $organisation->id);
                    
                    unset($data['id']);

                    $this->buildSuccessResponse('common.SUCCESSFUL_REQUEST', $data);
                } else {
                    $this->buildSuccessResponse(422, $api->errors);
                }
            }
        }

        $this->buildErrorResponse(422, 'common.UNPROCESSABLE_ENTITY', $validity['problems']);
    }

    /**
     * Add Users to Courses
     *
     * @param  int $usersId
     * @param  int $orgId
     */
    private function addUserToCourses($usersId, $orgId)
    {

        $marketplaces = Marketplace::find([
            'conditions' => 'organisation_id = :organisation_id: AND is_wildcard_assigned = :is_wildcard_assigned:',
            'bind' => [
                'organisation_id' => $orgId,
                'is_wildcard_assigned' => 1
            ],
            'groupBy' => ['course_id']
        ]);

        foreach ($marketplaces as $marketplace) {
            $uc = UsersCourses::find([
                'conditions' => '
                    organisation_id = :organisation_id: AND course_id = :course_id: AND
                    user_id = :user_id: AND marketplace_id = :marketplace_id: AND
                    is_obligatory = :is_obligatory:
                ',
                'bind' => [
                    'organisation_id' => $orgId,
                    'course_id' => $marketplace->course_id,
                    'user_id' => $usersId,
                    'marketplace_id' => $marketplace->id,
                    'is_obligatory' => 1,
                ]
            ]);

            if (!count($uc)) {
                $uc = new UsersCourses();
                $uc->organisation_id = $orgId;
                $uc->course_id = $marketplace->course_id;
                $uc->user_id = $usersId;
                $uc->marketplace_id = $marketplace->id;
                $uc->is_obligatory = 1;
                $uc->created_at = date('Y-m-d H:i:s'); // TODO rewrite this code at future
                $uc->updated_at = date('Y-m-d H:i:s'); // TODO rewrite this code at future
                $uc->save();
            }
        }
    }
}