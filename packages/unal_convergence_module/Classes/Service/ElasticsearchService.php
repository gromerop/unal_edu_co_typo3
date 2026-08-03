<?php
namespace UNAL\UnalConvergenceModule\Service;


use Elasticsearch\ClientBuilder;

class ElasticsearchService
{

    /**
     * domain
     * @var string
     */
    private $domain = null;
    
    /**
     * port
     * @var string
     */
    private $port = null;
    
    /**
     * user
     * @var string
     */
    private $user = null;

    /**
     * password
     * @var string
     */
    private $password = null;


    /**
     * @param string $domain
     * @return $this ElasticsearchService
     */
    public function setDomain($domain){
        $this->domain = $domain;

        return $this;
    }
    
    
    /**
     * @param string $user
     * @return $this ElasticsearchService
     */
    public function setUser($user){
        $this->user = $user;

        return $this;
    }
    
    /**
     * @param string $password
     * @return $this ElasticsearchService
     */
    public function setPassword($password){
        $this->password = $password;

        return $this;
    }
    
    
    /**
     * @param string $port
     * @return $this ElasticsearchService
     */
    public function setPort($port){
        $this->port = $port;

        return $this;
    }

    public function __construct()
    {
        
    }


    /**
     * Build connection
     * @return string the url
     * @throws \Exception
     */
    public function build(){

        $domain = explode("://", $this->domain);

        $hosts = [
            [
                'scheme' => $domain[0],
                'host'   => $domain[1],
                'port'   => $this->port,
                'user'   => $this->user,
                'pass'   => $this->password
            ]
        ];

        $client = ClientBuilder::create()
                    ->setHosts($hosts)
                    ->build();

        return $client;
    }

}