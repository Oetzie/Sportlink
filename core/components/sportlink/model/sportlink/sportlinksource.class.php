<?php

/**
 * Sportlink
 *
 * Copyright 2019 by Oene Tjeerd de Bruin <modx@oetzie.nl>
 */

class SportlinkSource
{
    const API_ENDPOINT = 'https://data.sportlink.com';

    /**
     * @access public.
     * @var modX.
     */
    public $modx;

    /**
     * @access protected.
     * @var Array.
     */
    protected $response = [];

    /**
     * @access public.
     * @param modX $modx.
     */
    public function __construct(modX &$modx)
    {
        $this->modx =& $modx;
    }

    /**
     * @access public.
     * @return String.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @access public.
     * @return String.
     */
    public function getClientID()
    {
        return $this->modx->getOption('sportlink.api_client_id');
    }

    /**
     * @access public.
     * @param Integer $code.
     * @param Array|String $data.
     * @return Array.
     */
    public function setResponse($code, $data)
    {
        if ((int) $code === 200) {
            $this->response = [
                'code'      => (int) $code,
                'data'      => $data
            ];
        } else {
            $this->response = [
                'code'      => (int) $code,
                'message'   => $data
            ];
        }

        return $this->response;
    }

    /**
     * @access public.
     * @return Array.
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @access public.
     * @return Boolean.
     */
    public function hasResponseError()
    {
        return isset($this->response['code']) && $this->response['code'] !== 200;
    }

    /**
     * @access public.
     * @param String $endpoint.
     * @param Array $parameters.
     * @param String $method.
     * @param Array $options.
     * @return Array.
     */
    public function makeRequest($endpoint, array $parameters = [], $method = 'GET', array $options = [])
    {
        $options += [
            CURLOPT_HEADER          => false,
            CURLOPT_USERAGENT       => 'SocialMediaApi 1.0',
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_TIMEOUT         => 10
        ];

        $parameters = array_merge($parameters, [
            'client_id' => $this->getClientID()
        ]);

        if (strtoupper($method) === 'POST') {
            $options = [
                CURLOPT_URL          => rtrim(self::API_ENDPOINT, '/') . '/' . trim($endpoint, '/'),
                CURLOPT_POSTFIELDS   => http_build_query($parameters)
            ] + $options;
        } else {
            $options = [
                CURLOPT_URL         => rtrim(self::API_ENDPOINT, '/') . '/' . trim($endpoint, '/') . '?' . http_build_query($parameters)
            ] + $options;
        }

        $curl = curl_init();

        curl_setopt_array($curl, $options);

        $response       = curl_exec($curl);
        $responseInfo   = curl_getinfo($curl);

        curl_close($curl);

        if (!isset($responseInfo['http_code']) || (int) $responseInfo['http_code'] !== 200) {
            $reponseError = json_decode($response, true);

            if (isset($reponseError['error']['message'])) {
                return $this->setResponse($responseInfo['http_code'], $reponseError['error']['message']);
            }

            return $this->setResponse($responseInfo['http_code'], 'API returned incorrect HTTP code.');
        }

        return $this->setResponse(200, json_decode($response, true));
    }
}
