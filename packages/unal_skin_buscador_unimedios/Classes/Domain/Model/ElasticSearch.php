<?php

namespace UNAL\UnalSkinBuscadorUnimedios\Domain\Model;


/**
 * ElasticSearch model
 */
class ElasticSearch extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    
    /**
     * @var string
     */
    protected $domain;

    /**
     * @var string
     */
    protected $port;

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var string
     */
    protected $user;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $auth;

    /**
     * @var string
     */
    protected $newIndex;

    /**
     * @var string
     */
    protected $imageIndex;

    /**
     * @var string
     */
    protected $videoIndex;

    /**
     * @var string
     */
    protected $audioIndex;



    /**
     * Get domain
     *
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }
    
    /**
     * Set domain
     *
     * @param string $domain domain
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
    }
    
    
    /**
     * Get port
     *
     * @return string
     */
    public function getPort()
    {
        return $this->port;
    }
    
    /**
     * Set port
     *
     * @param string $port port
     */
    public function setPort($port)
    {
        $this->port = $port;
    }


    /**
     * Get baseUrl
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return "{$this->getDomain()}:{$this->getPort()}/";
    }


    /**
     * Get user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }
    
    /**
     * Set user
     *
     * @param string $user user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }


    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
    
    /**
     * Set password
     *
     * @param string $password password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }



    /**
     * Get auth
     *
     * @return string
     */
    public function getAuth()
    {
        return "{$this->getUser()}:{$this->getPassword()}";
    }



    /**
     * Get newIndex
     *
     * @return string
     */
    public function getNewIndex()
    {
        return $this->newIndex;
    }
    
    /**
     * Set newIndex
     *
     * @param string $newIndex newIndex
     */
    public function setNewIndex($newIndex)
    {
        $this->newIndex = $newIndex;
    }


    /**
     * Get imagenIndex
     *
     * @return string
     */
    public function getImageIndex()
    {
        return $this->imagenIndex;
    }
    
    /**
     * Set imagenIndex
     *
     * @param string $imagenIndex imagenIndex
     */
    public function setImageIndex($imagenIndex)
    {
        $this->imagenIndex = $imagenIndex;
    }


    /**
     * Get videoIndex
     *
     * @return string
     */
    public function getVideoIndex()
    {
        return $this->videoIndex;
    }
    
    /**
     * Set videoIndex
     *
     * @param string $videoIndex videoIndex
     */
    public function setVideoIndex($videoIndex)
    {
        $this->videoIndex = $videoIndex;
    }


    /**
     * Get audioIndex
     *
     * @return string
     */
    public function getAudioIndex()
    {
        return $this->audioIndex;
    }
    
    /**
     * Set audioIndex
     *
     * @param string $audioIndex audioIndex
     */
    public function setAudioIndex($audioIndex)
    {
        $this->audioIndex = $audioIndex;
    }

}