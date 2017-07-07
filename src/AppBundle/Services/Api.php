<?php
/**
 * Created by PhpStorm.
 * User: Quentin
 * Date: 02/06/2017
 * Time: 10:41
 */

namespace AppBundle\Services;

use Doctrine\ORM\EntityManager;
use GuzzleHttp\Client;
use UserBundle\Entity\User;


/**
 * Class Api
 *
 * @package AppBundle\Services
 */
class Api
{
    const mobility = 'Mobilité Géographique';
    const wanted_job = 'Poste voulu';
    const experience = 'Expérience';
    private $apiUrl;
    private $apiKey;
    private $client;
    private $tagCandidate;
    private $em;

    /**
     * Api constructor.
     */
    public function __construct($apiUrl, $apiKey, $tagCandidate, EntityManager $entityManager)
    {
        $this->setApiKey($apiKey)->setApiUrl($apiUrl)->setTagCandidate($tagCandidate)->setEm($entityManager)
            ->setClient(new Client(['base_uri' => $this->getApiUrl()]));
    }

    /**
     * @return mixed
     */
    public function getEm()
    {
        return $this->em;
    }

    /**
     * @param mixed $em
     * @return Api
     */
    public function setEm($em)
    {
        $this->em = $em;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getTagCandidate()
    {
        return $this->tagCandidate;
    }

    /**
     * @param mixed $tagCandidate
     * @return Api
     */
    public function setTagCandidate($tagCandidate)
    {
        $this->tagCandidate = $tagCandidate;
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


    public function updateCandidateFromCats(User $user, $userData)
    {
        $user->setFirstName($userData->first_name);
        $user->setLastName($userData->last_name);
        $user->setTitle($userData->title);
        $user->setEmail($userData->emails->primary);
        $user->setPhone($userData->phones->cell);
        $user->setSalary($userData->current_pay);
        $user->setWantedSalary($userData->desired_pay);
        foreach ($userData->_embedded->custom_fields as $field) {
            if ($field->_embedded->definition->name == self::mobility) {
                $user->setMobility($field->value);
            } else if ($field->_embedded->definition->name == self::wanted_job) {
                $user->setWantedJob($field->value);
            } else if ($field->_embedded->definition->name == self::experience) {
                $user->setExperience($field->value);
            }
        }
        $this->getEm()->persist($user);
        $this->getEm()->flush();
        return $user;
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

    public function parsing($file)
    {
        $parsing = $this->getClient()->request(
            'POST', 'attachments/parse', [
                'headers' => [
                    'Authorization' => 'Token ' . $this->getApiKey(),
                    'content-type' => 'application/octet-stream'
                ],

                'body' => fopen(realpath($file), 'r')
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

    public function getRegions()
    {
        $fields = $this->candidateCustomFields();
        $regions = array();
        foreach ($fields as $field) {
            if ($field->name == self::mobility) {
                foreach ($field->field->selections as $region){
                    $regions[$region->label] = $region->id;
                }
                break;
            }
        }
        return $regions;
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
        $value = '';
        foreach ($fields as $field) {
            if ($field->name == self::mobility) {
                $value = array();
                foreach ($user->getMobility() as $mobility){
                    $value[] = $mobility;
                }
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
        return $candidate;
    }

    public function deleteCandidate($id)
    {
        $data = $this->getClient()->request(
            'DELETE', 'candidates/' . $id, [
                'headers' => [
                    'Authorization' => 'Token ' . $this->getApiKey()
                ]
            ]
        );
        return json_decode($data->getBody()->getContents());
    }


    public function sendResume($file, $id)
    {
        $resume = $this->getClient()->request(
            'POST', 'candidates/' . $id . '/resumes?filename=cv.pdf', [
                'headers' => [
                    'Authorization' => 'Token ' . $this->getApiKey(),
                    'content-type' => 'application/octet-stream'
                ],

                'body' => fopen(realpath($file), 'r')
            ]
        );
        return $resume;
    }

    public function updateCandidate(User $user, $catsUser)
    {
        $fields = $this->candidateCustomFields();
        $customFields = [];
        $value = '';
        foreach ($fields as $field) {
            if ($field->name == self::mobility) {
                $value = array();
                foreach ($user->getMobility() as $mobility){
                    $value[] = $mobility;
                }
            } else if ($field->name == self::wanted_job) {
                $value = $user->getWantedJob();
            } else if ($field->name == self::experience) {
                $value = $user->getExperience();
            }
            $customFields[] = ['id' => $field->id, 'value' => $value];
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

    public function downloadImg($job)
    {
        $list = glob("img/jobPicture/$job.*");
        if (!isset($list[0])) {
            $download = $this->getClient()->request(
                'GET', 'attachments/' . $job . '/download',
                [
                    'headers' => [
                        'Authorization' => 'Token ' . $this->getApiKey(),
                    ],
                ]
            );
            $img = file_put_contents('img/jobPicture/' . $job, $download->getBody()->getContents());
            $mime = mime_content_type('img/jobPicture/' . $job);


            $val = [
                'image/jpeg',
                'image/gif',
                'image/png',
                'image/jpg',
            ];

            if (in_array($mime, $val)) {

                $ext = str_replace('image/', '.', $mime);
                $fileName = $job . $ext;
                rename('img/jobPicture/' . $job, 'img/jobPicture/' . $fileName);
                return $fileName;

            } else {
                unlink('img/jobPicture/' . $job);
            }

        } else {
            return basename($list[0]);
        }
    }


    public function tagCandidate($candidate, $tag)
    {
        $tag = $this->getClient()->request(
            'PUT', 'candidates/' . $candidate . '/tags', [
                'headers' => [
                    'Authorization' => 'Token ' . $this->getApiKey(),
                    'Content-Type' => 'application/json'
                ],
                'json' => [
                    "tags" => [
                        ["id" => $tag]
                    ]
                ]
            ]
        );
        return $tag;
    }

    public function getTag($name)
    {
        $tags = $this->getClient()->request(
            'GET', 'tags', [
                'headers' => [
                    'Authorization' => 'Token ' . $this->getApiKey(),
                    'Content-Type' => 'application/json'
                ]
            ]
        );
        $tags = json_decode($tags->getBody()->getContents());
        $id = 0;
        foreach ($tags->_embedded->tags as $tag) {
            if ($tag->title == $this->getTagCandidate()) {
                $id = $tag->id;
            }
        }
        return $id;
    }

    public function hasResume($id)
    {
        $data = $this->getClient()->request(
            'GET', 'candidates/' . $id . '/attachments', [
                'headers' => [
                    'Authorization' => 'Token ' . $this->getApiKey(),
                    'Content-Type' => 'application/json'
                ]
            ]
        );
        $hasResume = false;
        $attachments = json_decode($data->getBody()->getContents());
        if ($attachments->count > 0) {
            foreach ($attachments->_embedded->attachments as $attachment) {
                if ($attachment->is_resume === true) {
                    $hasResume = true;
                }
            }
        }
        return $hasResume;
    }
}

