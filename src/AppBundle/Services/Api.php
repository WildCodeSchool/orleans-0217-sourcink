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
    /**
     * Api constructor.
     */
    public function __construct($apiUrl, $apiKey)
    {
        $this->setApiKey($apiKey)->setApiUrl($apiUrl);
    }

    public function get($query)
    {
        $client = new Client([
            'base_uri' => $this->getApiUrl(),
        ]);
        $data = $client->request('GET', $query, [
            'headers' => [
                'Authorization' => 'Token '.$this->getApiKey(),
                'Content-Type'=> 'application/json'
            ]
        ]);
        return json_decode($data->getBody()->getContents());
    }

    public function getId($query, $id)
    {
        $client = new Client([
            'base_uri' => $this->getApiUrl(),
        ]);
        $data = $client->request('GET', $query.'/'.$id, [
            'headers' => [
                'Authorization' => 'Token '.$this->getApiKey(),
                'Content-Type'=> 'application/json'
            ]
        ]);
        return json_decode($data->getBody()->getContents());
    }
    public function getSearch($query, $search, $params)
    {
        $client = new Client([
            'base_uri' => $this->getApiUrl(),
        ]);
        $data = $client->request('GET', $query.'?query='.$search, [
            'headers' => [
                'Authorization' => 'Token '.$this->getApiKey(),
                'Content-Type'=> 'application/json'
            ],
            'body' => $params
        ]);
        return json_decode($data->getBody()->getContents());
    }
    /**
     * @param $query
     * @param array $params
     * @return mixed
     */
    public function apiOld($query, $params = [], $page=1, $parPage=9)
    {
        $filters = '';
        foreach($params as $param=>$value){
            $filters .= $param.':'.$value;
        }
        $url = 'https://api.catsone.com/v3/'.$query.'?per_page='.$parPage.'&page='.$page;

        $apiKey = '52190b469513a91f73c29789304acd48';
        $headers = array('Authorization: Token '.$apiKey, $filters);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response);
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