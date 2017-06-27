<?php
/**
 * Created by PhpStorm.
 * User: Quentin
 * Date: 02/06/2017
 * Time: 10:41
 */

namespace AppBundle\Services;

use GuzzleHttp\Client;


/**
 * Class Api
 * @package AppBundle\Services
 */
class Api
{
    private $apiUrl;
    private $apiKey;
    private $client;

    /**
     * Api constructor.
     */
    public function __construct($apiUrl, $apiKey)
    {
        $this->setApiKey($apiKey)->setApiUrl($apiUrl);
        $this->setClient(new Client(['base_uri' => $this->getApiUrl()]));
    }

    /**
     * @return mixed
     */
    public function getApiUrl()
    {
        return $this->apiUrl;
    }

    /**
     * @param mixed $apiUrl
     * @return Api
     */
    public function setApiUrl($apiUrl)
    {
        $this->apiUrl = $apiUrl;
        return $this;
    }

    public function get($query)
    {

        $data = $this->getClient()->request('GET', $query, [
            'headers' => [
                'Authorization' => 'Token ' . $this->getApiKey(),
                'Content-Type' => 'application/json'
            ]
        ]);
        return json_decode($data->getBody()->getContents());
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param mixed $client
     * @return Api
     */
    public function setClient($client)
    {
        $this->client = $client;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param mixed $apiKey
     * @return Api
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
        return $this;
    }

    public function getId($query, $id)
    {
        $data = $this->getClient()->request('GET', $query . '/' . $id, [
            'headers' => [
                'Authorization' => 'Token ' . $this->getApiKey(),
                'Content-Type' => 'application/json'
            ]
        ]);
        return json_decode($data->getBody()->getContents());
    }

    public function getSearch($query, $search)
    {
        $data = $this->getClient()->request('GET', $query . '/search?query=' . $search, [
            'headers' => [
                'Authorization' => 'Token ' . $this->getApiKey()
            ]
        ]);
        return json_decode($data->getBody()->getContents());
    }

    public function parsing($request)
    {
        $parsing = $this->getClient()->request('POST', 'attachments/parse', [
            'headers' => [
                'Authorization' => 'Token ' . $this->getApiKey(),
                'content-type' => 'application/octet-stream'
            ],
            'body' => fopen(realpath($request->files->get('resume')), 'r')
        ]);
        return $parsing->getBody()->getContents();
    }

    public function createCandidate($resumeJson)
    {
        $resumeData = json_decode($resumeJson);
        $candidate = $this->getClient()->request('POST', 'candidates?check_duplicate=true', [
            'headers' => [
                'Authorization' => 'Token ' . $this->getApiKey(),
                'content-type' => 'application/json'
            ],
            'json' => [
                "first_name" => $resumeData->first_name,
                "last_name" => $resumeData->last_name,
                "emails" => [
                    "primary" => $resumeData->emails->primary
                ]
            ]
        ]);
        return $candidate->getHeaders()['Location'][0];
    }

    public function sendResume($request, $id)
    {
        $resume = $this->getClient()->request('POST', 'candidates/' . $id . '/resumes?filename=cv.pdf', [
            'headers' => [
                'Authorization' => 'Token ' . $this->getApiKey(),
                'content-type' => 'application/octet-stream'
            ],
            'body' => fopen(realpath($request->files->get('resume')), 'r')
        ]);
        return $resume;
    }

    public function updateCandidate($user)
    {
        $update = $this->getClient()->request('PUT', 'candidates/' . $user->id, [
            'headers' => [
                'Authorization' => 'Token ' . $this->getApiKey(),
                'content-type' => 'application/octet-stream'
            ],
            'json' => [
                "title" => $user->title,
            ]
        ]);
        return $update;
    }



    public function searchFilter($query, $params)
    {
        $filters = json_encode(['and' => $params]);
        $data = $this->getClient()->request('POST', $query . '?query=', [
            'headers' => [
                'Authorization' => 'Token ' . $this->getApiKey(),
                'content-type' => 'application/json'
            ],
            'body' => $filters

        ]);

        return json_decode($data->getBody()->getContents());
    }
}
