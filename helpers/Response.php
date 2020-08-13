<?php

namespace App\Helpers;

use App\Library\Localisation;

/**
 * class Response
 * @package Helpers
 */
class Response
{
    /**
     * @var boolean
     */
    public $success;

    /**
     * @var integer
     */
    public $code;

    /**
     * @var string
     */
    public $status;

    /**
     * @var array
     */
    public $message;

    /**
     * @var
     */
    public $data;

    /**
     * Response constructor.
     * @param $success boolean
     * @param $code integer
     * @param $status string
     * @param $message string
     * @param $data
     * @param $errors
     */
    private function __construct($success, $code, $status, $message, $data = [], $errors = [])
    {
        $this->success = $success;
        $this->code = $code;
        $this->status = $status;
        $this->message = $message;
        $this->data = $data;
        $this->errors = $errors;
    }

    /**
     * @param $localisation
     * @param $code integer
     * @param $message string
     * @param $data
     * @return Response
     */
    public static function makePositive(Localisation $localisation, $code, $message, $data)
    {
        return new self(true, $code, 'OK', $localisation->translate_message($message), $data);
    }

    /**
     * @param $localisation
     * @param $code integer
     * @param $message string
     * @param $errors
     * @return Response
     */
    public static function makeNegative(Localisation $localisation, $code, $message, $errors)
    {

        $status = 'Unknown';

        switch ($code) {
            case 400:
                $status = 'Bad Request';
                break;
            case 401:
                $status = 'Unauthorized';
                break;
            case 403:
                $status = 'Forbidden';
                break;
            case 404:
                $status = 'Not Found';
                break;
            case 409:
                $status = 'Conflict';
                break;
            case 422:
                $status = 'Unprocessable Entity';
                break;
        }

        return new self(false, $code, $status, $localisation->translate_message($message), [], $errors);
    }


}