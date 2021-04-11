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
    
    public function getFranceData(): array
    {
        return $this->getApi(('FranceLiveGlobalData'));
    }

    public function getAllDepartment()
    {
        return $this->getApi('AllLiveData');
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
