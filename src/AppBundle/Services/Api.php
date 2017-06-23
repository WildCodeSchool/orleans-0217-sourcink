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
    public function getSearch($query, $search, $params)
    {
        $data = $this->getClient()->request('GET', $query . '?query=' . $search, [
            'headers' => [
                'Authorization' => 'Token ' . $this->getApiKey(),
                'Content-Type' => 'application/json'
            ],
            'body' => $params
        ]);
        return json_decode($data->getBody()->getContents());
    }
    public function parsing($request)
    {
        $parsing = $this->getClient()->request('POST', 'attachments/parse', [
            'headers' => [
                'Authorization' => 'Token '.$this->getApiKey(),
                'content-type' => 'application/octet-stream'
            ],
            'body' => fopen(realpath($request->files->get('resume')), 'r')
        ]);
        return $parsing->getBody()->getContents();
    }
    public function createCandidate($resumeJson)
    {
        $resumeData = json_decode($resumeJson);
        $candidate = $this->getClient()->request('POST', 'candidates?check_duplicate=false', [
            'headers' => [
                'Authorization' => 'Token '.$this->getApiKey(),
                'content-type' => 'application/json'
            ],
            'json' => [
                "first_name" => $resumeData->first_name,
                "last_name" => $resumeData->last_name,
                "emails" =>[
                    "primary"=>$resumeData->emails->primary
                ]
            ]
        ]);
        return $candidate->getHeaders()['Location'][0];
    }
    public function sendResume($request, $id)
    {
        $resume = $this->getClient()->request('POST', 'candidates/'.$id.'/resumes?filename=cv.pdf', [
            'headers' => [
                'Authorization' => 'Token '.$this->getApiKey(),
                'content-type' => 'application/octet-stream'
            ],
            'body' => fopen(realpath($request->files->get('resume')), 'r')
        ]);
        return $resume;
    }
    public function filterJobs($query, $params, $search = '')
    {
        $filters = json_encode(['and' => $params]);
        $url = 'https://api.catsone.com/v3/' . $query . '?query=' . $search;

        $apiKey = '52190b469513a91f73c29789304acd48';
        $content = 'Content-type: application/json';
        $headers = array('authorization: Token ' . $apiKey, $content);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $filters);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response);
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
}
