<?php

namespace App\Api\Requests\User;

use App\Traits\Validity;
use App\Library\Localisation;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Uniqueness;
use App\Api\Models\Users;

class CreateUserRequest extends Validation
{
    use Validity;
    
    public function __construct(Localisation $localisation)
    {
        $this->localisation = $localisation;

        $this->add([
            'email',
            'contact_email'
        ],
            new PresenceOf([
                'message' => 'validation.PRESENCE_OF',
            ])
        );

        $this->add([
                'email',
                'contact_email'
            ],
            new Email([
                'message' => 'validation.EMAIL',
            ])
        );

        $this->add(
            "email",
            new Uniqueness(
                [
                    "model" => new Users(),
                    "attribute" => "email",
                    'message' => 'validation.EMAIL_UNIQUE'
                ]
            )
        );

        $this->add(
            [
                "email",
                "contact_email",
                "first_name",
                "last_name",
                "phone_number"
            ],
            new StringLength(
                [
                    "max" => [
                        "email"  => 255,
                        "contact_email" => 255,
                        "first_name" => 255,
                        "last_name" => 255,
                        "phone_number" => 12,
                    ],
                    "messageMaximum" => [
                        "email"  => 'validation.STRING_LENGTH',
                        "contact_email" => 'validation.STRING_LENGTH'
                    ],
                ]
            )
        );
    }


    public static function make($data, Localisation $localisation)
    {
        $v = new self($localisation);
        return $v->validate($data);
    }
}