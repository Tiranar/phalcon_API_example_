<?php

namespace App\Library;

class Localisation
{

    public $locale = 'en_EN';

    private $available_locales = [
        'en_EN',
        'es_ES'
    ];

    public function set_locale($locale = 'en_EN')
    {
        if (in_array($locale, $this->available_locales)) {
            $this->locale = $locale;
        } else {
            $this->locale = 'en_EN';
        }

        return $this;
    }

    public function translate_message($phrase)
    {
        $parts = explode('.', $phrase);

        if (is_file(APP_PATH . '/langs/' . $this->locale . '/messages/' . $parts[0] . '.php')) {
            $dictionary = require(APP_PATH . '/langs/' . $this->locale . '/messages/' . $parts[0] . '.php');

            if (is_array($dictionary)) {
                return (isset($dictionary[$parts[1]])) ? $dictionary[$parts[1]] : $phrase;
            }
        }

        return $phrase;
    }

    public function translate_validation($field, $message)
    {
        $parts = explode('.', $message);

        if (is_file(APP_PATH . '/langs/' . $this->locale . '/validation/errors.php')) {
            $dictionary = require(APP_PATH . '/langs/' . $this->locale . '/validation/errors.php');

            if (is_array($dictionary)) {
                $m = (isset($dictionary[$parts[1]])) ? $dictionary[$parts[1]] : $message;

                if (strpos($m, ':field')) {
                    $fields = require(APP_PATH . '/langs/' . $this->locale . '/validation/fields.php');

                    if (is_array($fields)) {
                        $field = (isset($fields[$field])) ? $fields[$field] : $field;
                    }

                    $m = str_replace(':field', $field, $m);
                }

                return $m;

            }
        }

        return $message;

    }

}