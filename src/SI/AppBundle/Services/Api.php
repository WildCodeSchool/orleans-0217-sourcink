<?php
/**
 * Created by PhpStorm.
 * User: Quentin
 * Date: 02/06/2017
 * Time: 10:41
 */

namespace SI\AppBundle\Services;


class Api
{
    public function api($query, $params = [])
    {
        $filters = '';
        foreach($params as $param=>$value){
            $filters .= $param.':'.$value;
        }
        $url = 'https://api.catsone.com/v3/'.$query;
        $apiKey = '52190b469513a91f73c29789304acd48';
        $headers = array('Authorization: Token '.$apiKey, $filters);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response);
    }

}