<?php

namespace App\Api\Controllers;

use App\Helpers\Response;
use Phalcon\Mvc\Controller;
use DateTime;
use DateTimeZone;

class BaseController extends Controller
{

    /**
     * Generated NOW datetime based on a timezone
     */
    public function getNowDateTime()
    {
        $now = new DateTime();
        $now->setTimezone(new DateTimeZone('UTC'));
        $now = $now->format('Y-m-d H:i:s');
        return $now;
    }

    /**
     * Encode token.
     */
    public function encodeToken($data)
    {
        // Encode token
        $token_encoded = $this->jwt->encode($data, $this->config->get('authentication')['secret']);
        $token_encoded = $this->mycrypt->encryptBase64($token_encoded);
        return $token_encoded;
    }

    /**
     * Decode token.
     */
    public function decodeToken($token)
    {
        // Decode token
        $token = $this->mycrypt->decryptBase64($token);
        $token = $this->jwt->decode($token, $this->config->get('authentication')['secret'], array('HS256'));
        return $token;
    }

    /**
     * Returns token from the request.
     * Uses token URL query field, or Authorization header
     */
    public function getToken()
    {
        $authHeader = $this->request->getHeader('Authorization');
        $authQuery = $this->request->getQuery('token');
        return $authQuery ? $authQuery : $this->parseBearerValue($authHeader);
    }

    /**
     * Parse Bearer Value
     * 
     * @param $string $string
     * 
     * @return string
     */
    protected function parseBearerValue(string $string)
    {
        if (strpos(trim($string), 'Bearer') !== 0) {
            return null;
        }
        return preg_replace('/.*\s/', '', $string);
    }

    /**
     * Builds success responses.
     */
    public function buildSuccessResponse($message, $data = '')
    {
        $this->returnResponse(Response::makePositive($this->localisation, 200, $message, $data));
    }

    /**
     * Builds error responses.
     */
    public function buildErrorResponse($code, $message, $data = '')
    {
        $this->returnResponse(Response::makeNegative($this->localisation, $code, $message, $data));
    }

    /**
     * Return Response
     *
     * @param Response $response
     *
     * @return void
     */
    private function returnResponse(Response $response)
    {
        $this->response->setStatusCode($response->code, $response->status)->sendHeaders();
        $this->response->setJsonContent($response, JSON_NUMERIC_CHECK)->send();
        die();
    }

}