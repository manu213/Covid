<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiService
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }
    
    public function getFranceData()
    {
        return $this->getApi(('FranceLiveGlobalData'));
    }

    public function getAllDepartment()
    {
        return $this->getApi('AllLiveData');
    }

    public function getDepartmentData($department)
    {
        return $this->getApi('LiveDataByDepartement?Departement=' . $department);
    }

    public function getAllDataByDate($date)
    {
        return $this->getApi('AllDataByDate?date=' . $date);
    }

    public function getApi($var): array
    {
        $response = $this->client->request(
            'GET',
            'https://coronavirusapi-france.vercel.app/' . $var
        );
        return $response->toArray(); 
    }
}
