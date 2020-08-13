<?php

namespace App\Api\Controllers;

use App\Api\Classes\TokenDeveloper;
use App\Api\Classes\TokenOrganisation;
use App\Api\Models\DevelopersAccounts;
use App\Api\Models\DevelopersAccountsOrganisations;
use App\Api\Requests\Token\DevTokenRequest;
use App\Api\Requests\Token\OrgTokenRequest;
use App\Traits\SlackBot;

class TokenController extends BaseController
{
    use SlackBot;

    /**
     * Get Developer Token Action
     */
    public function devTokenAction()
    {
        $data = $this->request->getJsonRawBody();
        $validity = DevTokenRequest::make($data, $this->localisation);

        if ($validity['success']) {

            $dev_acc = DevelopersAccounts::findFirst([
                'conditions' => 'acc_key = :acc_key:',
                'bind' => [
                    'acc_key' => $data->acc_key
                ]
            ]);

            if ($dev_acc && $data->acc_secret === $this->encrypter->decryptString($dev_acc->acc_secret)) {

                $iat = strtotime($this->getNowDateTime());
                $exp = strtotime("+" . $this->config->get('authentication')['dev_token_expiration_time'] . " seconds", $iat);

                $token_data = new TokenDeveloper();
                $token_data->iss = $this->config->get('authentication')['iss'];
                $token_data->aud = $this->config->get('authentication')['aud'];
                $token_data->iat = $iat;
                $token_data->exp = $exp;
                $token_data->acc_key = $dev_acc->acc_key;
                $token_data->acc_email = $dev_acc->email;
                $token_data->rand = rand() . microtime();
                $token = $this->encodeToken($token_data);

                $resp = [
                    'token' => [
                        'code' => $token,
                        'expires' => date('Y-m-d h:i:s', $token_data->exp) . ' UTC',
                        'type' => $token_data->type
                    ],
                    'dev_account' => $dev_acc
                ];

                if (APPLICATION_ENV == 'production') {
                    $this->notifyReceivedDeveloperTokenSlack($dev_acc->email);
                }

                $this->buildSuccessResponse('common.SUCCESSFUL_REQUEST', $resp);

            }

            $this->buildErrorResponse(422, 'common.UNPROCESSABLE_ENTITY', [
                'acc_key' => [$this->localisation->translate_validation('acc_key', 'validation.ACC_KEY_ACCESS_CREDS')],
                'acc_secret' => [$this->localisation->translate_validation('acc_secret', 'validation.ACC_KEY_ACCESS_CREDS')]
            ]);
        }

        $this->buildErrorResponse(422, 'common.UNPROCESSABLE_ENTITY', $validity['problems']);

    }

    /**
     * Get Organisation Token Action
     */
    public function orgTokenAction()
    {
        $data = $this->request->getJsonRawBody();
        $validity = OrgTokenRequest::make($data, $this->localisation);

        if ($validity['success']) {
            $organisation_id = $this->encrypter->decryptString($data->organisation_hash);
            $dev_acc = $this->identity->getDevAcc();

            if ($organisation_id) {

                $relation = DevelopersAccountsOrganisations::findFirst([
                    'conditions' => 'org_id = :org_id: and dev_acc_id = :dev_acc_id:',
                    'bind' => [
                        'org_id' => $organisation_id,
                        'dev_acc_id' => $dev_acc->id
                    ]
                ]);

                $organisation = false;

                if ($relation) {
                    $organisation = $relation->getRelated('Organisations');
                }

                if ($relation && $organisation) {

                    $iat = strtotime($this->getNowDateTime());
                    $exp = strtotime("+" . $this->config->get('authentication')['org_token_expiration_time'] . " seconds", $iat);

                    $token_data = new TokenOrganisation();
                    $token_data->iss = $this->config->get('authentication')['iss'];
                    $token_data->aud = $this->config->get('authentication')['aud'];
                    $token_data->iat = $iat;
                    $token_data->exp = $exp;
                    $token_data->acc_key = $dev_acc->acc_key;
                    $token_data->acc_email = $dev_acc->email;
                    $token_data->organisation_hash = $this->encrypter->encryptString($organisation_id);
                    $token_data->rand = rand() . microtime();
                    $token = $this->encodeToken($token_data);

                    $resp = [
                        'token' => [
                            'code' => $token,
                            'expires' => date('Y-m-d h:i:s', $token_data->exp) . ' UTC',
                            'type' => $token_data->type
                        ],
                        'dev_account' => $dev_acc,
                        'organisation' => $organisation
                    ];

                    $this->buildSuccessResponse('common.SUCCESSFUL_REQUEST', $resp);

                }
            }

            $this->buildErrorResponse(422, 'common.UNPROCESSABLE_ENTITY', [
                'organisation_hash' => [$this->localisation->translate_validation('organisation_hash', 'validation.ACC_KEY_ACCESS_CREDS')],

            ]);

        }

        $this->buildErrorResponse(422, 'common.UNPROCESSABLE_ENTITY', $validity['problems']);
    }

    /**
     * Validate Token Action
     */
    public function validateAction()
    {

        $resp = [
            'token' => [
                'code' => $this->identity->getToken(),
                'expires' => date('Y-m-d h:i:s', $this->identity->getTokenDecoded()->exp) . ' UTC',
                'type' => $this->identity->getTokenDecoded()->type
            ],
            'dev_account' => $this->identity->getDevAcc()
        ];

        if ($this->identity->isOrganisation()) {
            $resp['organisation'] = $this->identity->getOrganisation();
        }

        $this->buildSuccessResponse('common.SUCCESSFUL_REQUEST', $resp);
    }

}