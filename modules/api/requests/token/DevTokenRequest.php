<?php

namespace App\Api\Requests\Token;

use App\Traits\Validity;
use App\Library\Localisation;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Alnum;
use Phalcon\Validation\Validator\StringLength;

class DevTokenRequest extends Validation
{
    use Validity;

    public function __construct(Localisation $localisation)
    {
        $this->localisation = $localisation;

        $this->add('acc_key',
            new PresenceOf([
                'message' => 'validation.PRESENCE_OF',
                'cancelOnFail' => true
            ])
        );

        $this->add('acc_secret',
            new PresenceOf([
                'message' => 'validation.PRESENCE_OF',
                'cancelOnFail' => true
            ])
        );

        $this->add('acc_key',
            new Alnum([
                'message' => 'validation.ALNUM'
            ])
        );

        $this->add('acc_secret',
            new Alnum([
                'message' => 'validation.ALNUM'
            ])
        );

        $this->add(
            [
                "acc_key",
                "acc_secret",
            ],
            new StringLength(
                [
                    "max" => [
                        "acc_key"  => 32,
                        "acc_secret" => 32,
                    ],
                    "min" => [
                        "acc_key"  => 32,
                        "acc_secret" => 32,
                    ],
                    "messageMaximum" => [
                        "acc_key"  => "validation.STRING_LENGTH",
                        "acc_secret" => "validation.STRING_LENGTH",
                    ],
                    "messageMinimum" => [
                        "acc_key"  => "validation.STRING_LENGTH",
                        "acc_secret" => "validation.STRING_LENGTH",
                    ]
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