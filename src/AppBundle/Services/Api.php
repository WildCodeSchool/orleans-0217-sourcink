<?php
/**
 * Created by PhpStorm.
 * User: Quentin
 * Date: 02/06/2017
 * Time: 10:41
 */

namespace AppBundle\Services;

use GuzzleHttp\Client;
use UserBundle\Entity\User;


/**
 * Class Api
 *
 * @package AppBundle\Services
 */
class Api
{
    const mobility = 'mobilité géo';
    const current_job = 'Poste Actuel';
    const wanted_job = 'Poste voulu';
    const experience = 'Expérience';
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

        $data = $this->getClient()->request(
            'GET', $query, [
            'headers' => [
                'Authorization' => 'Token ' . $this->getApiKey(),
                'Content-Type' => 'application/json'
            ]
            ]
        );
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
        $data = $this->getClient()->request(
            'GET', $query . '/' . $id, [
            'headers' => [
                'Authorization' => 'Token ' . $this->getApiKey(),
                'Content-Type' => 'application/json'
            ]
            ]
        );
        return json_decode($data->getBody()->getContents());
    }

    public function getSearch($query, $search)
    {
        $data = $this->getClient()->request(
            'GET', $query . '/search?query=' . $search, [
            'headers' => [
                'Authorization' => 'Token ' . $this->getApiKey()
            ]
            ]
        );
        return json_decode($data->getBody()->getContents());
    }

    public function parsing($request)
    {
        $parsing = $this->getClient()->request(
            'POST', 'attachments/parse', [
            'headers' => [
                'Authorization' => 'Token ' . $this->getApiKey(),
                'content-type' => 'application/octet-stream'
            ],
            'body' => fopen(realpath($request->files->get('resume')), 'r')
            ]
        );
        return $parsing->getBody()->getContents();
    }

    public function updateCandidatResume($resumeJson)
    {
        $resumeData = json_decode($resumeJson);
        $candidate = $this->getClient()->request(
            'POST', 'candidates?check_duplicate=true', [
            'headers' => [
                'Authorization' => 'Token ' . $this->getApiKey(),
                'content-type' => 'application/json'
            ],
            'json' => [
                "first_name" => $resumeData->first_name,
                "last_name" => $resumeData->last_name,
                "emails" => [
                    "primary" => $resumeData->emails->primary
                ],
                "title" => $resumeData->title,
                "current_pay" => $resumeData->current_pay,
                "desired_pay" => $resumeData->desired_pay,
                "phones" => [
                    "cell" => $resumeData->phones
                ],
            ]
            ]
        );
        return $candidate->getHeaders()['Location'][0];
    }

    public function candidateCustomFields()
    {
        $customFields = $this->getClient()->request(
            'GET', 'candidates/custom_fields', [
            'headers' => [
                'Authorization' => 'Token ' . $this->getApiKey(),
                'content-type' => 'application/json'
            ],
            ]
        );
        return json_decode($customFields->getBody()->getContents())->_embedded->custom_fields;
    }

    public function createCandidateUser(User $user)
    {
        $fields = $this->candidateCustomFields();
        $customFields = [];
        foreach ($fields as $field) {
            if ($field->name == self::mobility) {
                $value = $user->getMobility();
            } else if ($field->name == self::current_job) {
                $value = $user->getCurrentJob();
            } else if ($field->name == self::wanted_job) {
                $value = $user->getWantedJob();
            } else if ($field->name == self::experience) {
                $value = $user->getExperience();
            }
            $customFields[] = ['id' => $field->id, 'value' => $value];
        }
        $candidate = $this->getClient()->request(
            'POST', 'candidates?check_duplicate=true', [
            'headers' => [
                'Authorization' => 'Token ' . $this->getApiKey(),
                'content-type' => 'application/json'
            ],
            'json' => [
                "first_name" => $user->getFirstname(),
                "last_name" => $user->getLastname(),
                "emails" => [
                    "primary" => $user->getEmail()
                ],
                "title" => $user->getTitle(),
                "current_pay" => $user->getSalary(),
                "desired_pay" => $user->getWantedSalary(),
                "phones" => [
                    "cell" => $user->getPhone()
                ],
                "custom_fields" => $customFields
            ]
            ]
        );
        return $candidate->getHeaders();
    }

    public function deleteCandidate($id)
    {
        $data = $this->getClient()->request(
            'DELETE',  'candidates/'.$id, [
                'headers' => [
                    'Authorization' => 'Token ' . $this->getApiKey()
                ]
            ]
        );
        return json_decode($data->getBody()->getContents());
    }
    public function sendResume($request, $id)
    {
        $resume = $this->getClient()->request(
            'POST', 'candidates/' . $id . '/resumes?filename=cv.pdf', [
            'headers' => [
                'Authorization' => 'Token ' . $this->getApiKey(),
                'content-type' => 'application/octet-stream'
            ],
            'body' => fopen(realpath($request->files->get('resume')), 'r')
            ]
        );
        return $resume;
    }

    public function updateCandidate(User $user, $catsUser)
    {
        $fields = $this->candidateCustomFields();
        $customFields = [];
        foreach ($fields as $field) {
            if ($field->name == self::mobility) {
                $value = $user->getMobility();
            } else if ($field->name == self::current_job) {
                $value = $user->getCurrentJob();
            } else if ($field->name == self::wanted_job) {
                $value = $user->getWantedJob();
            } else if ($field->name == self::experience) {
                $value = $user->getExperience();
            }
            $customFields[] = ["id" => $field->id, "value" => $value];
        }
        $update = $this->getClient()->request(
            'PUT', 'candidates/' . $catsUser->id, [
            'headers' => [
                'Authorization' => 'Token ' . $this->getApiKey(),
                'content-type' => 'application/octet-stream'
            ],
            'json' => [
                "first_name" => $user->getFirstname(),
                "last_name" => $user->getLastname(),
                "emails" => [
                    "primary" => $user->getEmail()
                ],
                "title" => $user->getTitle(),
                "current_pay" => $user->getSalary(),
                "desired_pay" => $user->getWantedSalary(),
                "phones" => [
                    "cell" => $user->getPhone()
                ],
                "custom_fields" => $customFields
            ]
            ]
        );
        return $update;
    }
  
    public function apply($user, $id)
    {
        $candidate = $user->id;
        $job = $id;
        $apply = $this->getClient()->request(
            'POST', 'pipelines',
            [
                'headers' => [
                    'Authorization' => 'Token ' . $this->getApiKey(),
                    'content-type' => 'application/json'
                ],
                'body' => '{"candidate_id": ' . $candidate . ',"job_id": ' . $job . '}'
            ]
        );
        return $apply;
    }
}

