<?php

namespace App\Api\Requests\Token;

use App\Traits\Validity;
use App\Library\Localisation;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
class OrgTokenRequest extends Validation
{
    use Validity;

    public function __construct(Localisation $localisation)
    {
        $this->localisation = $localisation;

        $this->add('organisation_hash',
            new PresenceOf([
                'message' => 'validation.PRESENCE_OF',
                'cancelOnFail' => true
            ])
        );
    }


    public static function make($data, Localisation $localisation)
    {
        $v = new self($localisation);
        return $v->validate($data);
    }

}