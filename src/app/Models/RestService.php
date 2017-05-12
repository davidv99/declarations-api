<?php

namespace app\Models;

use app\Contracts\ServiceInterface;
use app\Exceptions\MyException;
use app\Traits\FoolTrait;

/**
 * Class Service
 * @package app\Models
 */
class RestService implements ServiceInterface
{
    use FoolTrait;

    const WSDL = 'https://bender.freddie.dev/declarations/public/api/v1/company-bidders';

    /**
     * @var array
     */
    private $authentication = [];

    /**
     * @return array
     */
    public function request()
    {
        return array_merge($this->authentication, $this->request['payload']);
    }

    /**
     * @param array $authentication
     * @return $this
     */
    public function setAuthentication(array $authentication = [])
    {
        if (isset($authentication['login']) && isset($authentication['password'])) {
            $this->authentication = [
                'authorization' => [
                    'username' => $authentication['login'],
                    'secret' => $authentication['password'],
                ]
            ];
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getServiceRequest()
    {
        return $this->request();
    }

    /**
     * @return mixed
     * @throws MyException
     */
    public function serviceCall()
    {
        $headers[] = 'Accept: application/json';
        $headers[] = 'multipart/form-data';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, self::WSDL);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($this->request()));
        $result = curl_exec($curl);

        if ($result === false) {
            $info = curl_getinfo($curl);
            curl_close($curl);
            throw new MyException($info);
        }

        curl_close($curl);

        $decoded = json_decode($result);
        if (isset($decoded->error)) {
            throw new MyException($decoded);
        }

        return $decoded;
    }

    /**
     * @param mixed $response
     * @param string $result
     * @return mixed
     */
    public function serviceResponse($response, $result)
    {
        return $response;
    }
}