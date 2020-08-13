<?php

namespace App\Traits;

trait CURL {

    /**
     * Post Data and Header by Json
     *
     * @param string $url
     * @param array $header
     * @param string $data_string
     * @param bool $ssl
     *
     * @return mixed
     */
    private function postDataHeaderJson(string $url, array $header, string $data_string, bool $ssl = true)
    {
        try {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);

            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, $ssl);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $return = json_decode(curl_exec($curl));
            curl_close($curl);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return $return;
    }

    /**
     * Post Data and Header With Headers by Json
     *
     * @param string $url
     * @param array $header
     * @param string $data_string
     * @param bool $ssl
     *
     * @return mixed
     */
    private function postDataHeaderWithHeaderJson(string $url, array $header, string $data_string, bool $ssl = true)
    {
        try {
            $headers = [];
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
            curl_setopt($curl, CURLOPT_VERBOSE, 1);
            curl_setopt($curl, CURLOPT_HEADER, 1);

            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, $ssl);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $return = curl_exec($curl);
            list($header, $body) = explode("\r\n\r\n", $return, 2);
            $header = explode("\r\n", $header);
            
            foreach ($header as $h) {
                $tmp = explode(':', $h);
                if (count($tmp) > 1) {
                    @$headers[$tmp[0]] = $tmp[1];
                }
                
            }

            $return = [
                'headers' => $headers,
                'body' => json_decode($body)
            ];
            
            curl_close($curl);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return $return;
    }
}