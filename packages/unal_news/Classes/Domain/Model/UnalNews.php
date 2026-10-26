<?php
namespace UNAL\UnalNews\Domain\Model;

use UNAL\UnalNews\Utility\VideoFile;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use UNAL\UnalNews\Utility\FirstMediaImage;
use TYPO3\CMS\Core\Utility\DebugUtility;

/***
 *
 * This file is part of the "UNAL News extension" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2020 Oficina de Medios DIgitales - Unimedios <mediosdigitales@unal.edu.co>, Universidad Nacional de Colombia
 *           Martha Lucía Chaves Muñoz <mlchavezm@unal.edu.co>, Universidad Nacional de Colombia
 *           César Hansy Dueñas Barragán <chduenasba@unal.edu.co>, Universidad Nacional de Colombia
 *
 ***/
/**
 * Entidad que extiende de la clase News de tx_news
 */
class UnalNews extends \GeorgRinger\News\Domain\Model\News
{

    /**
     * Es el total de visitas que ha tenido una noticia
     * 
     * @var int
     */
    protected $counter = 0;

    /**
     * Es la ciudad del News
     * 
     * @var \UNAL\UnalNews\Domain\Model\City
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $city = null;

    /**
     * Corresponde a la identificación de la nota publicada brindada por la Oficina
     * propietaria del contenido.
     * 
     * @var string
     */
    protected $identificator = '';

    /**
     * Es el registro de visitas a cada una de las noticias
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\UNAL\UnalNews\Domain\Model\VisitCounter>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $visitorCounter = null;

    /**
     * Returns the identificator
     * 
     * @return string $identificator
     */
    public function getIdentificator()
    {
        return $this->identificator;
    }

    /**
     * Sets the identificator
     * 
     * @param string $identificator
     * @return void
     */
    public function setIdentificator($identificator)
    {
        $this->identificator = $identificator;
    }

    /**
     * __construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->initStorageObjects();
    }

    public function initializeObject(): void
    {
        if (!isset($this->categories)) {
            $this->categories = new ObjectStorage();
        }
        if (!isset($this->contentElements)) {
            $this->contentElements = new ObjectStorage();
        }
        if (!isset($this->falRelatedFiles)) {
            $this->falRelatedFiles = new ObjectStorage();
        }
        if (!isset($this->relatedLinks)) {
            $this->relatedLinks = new ObjectStorage();
        }
        if (!isset($this->tags)) {
            $this->tags = new ObjectStorage();
        }
        if (!$this->visitorCounter instanceof ObjectStorage) {
            $this->visitorCounter = new ObjectStorage();
        }
    }

    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     * 
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->visitorCounter = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Adds a VisitCounter
     * 
     * @param \UNAL\UnalNews\Domain\Model\VisitCounter $visitorCounter
     * @return void
     */
    public function addVisitorCounter(\UNAL\UnalNews\Domain\Model\VisitCounter $visitorCounter)
    {
        $this->visitorCounter->attach($visitorCounter);
    }

    /**
     * Removes a VisitCounter
     * 
     * @param \UNAL\UnalNews\Domain\Model\VisitCounter $visitorCounterToRemove The VisitCounter to be removed
     * @return void
     */
    public function removeVisitorCounter(\UNAL\UnalNews\Domain\Model\VisitCounter $visitorCounterToRemove)
    {
        $this->visitorCounter->detach($visitorCounterToRemove);
    }

    /**
     * Returns the visitorCounter
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\UNAL\UnalNews\Domain\Model\VisitCounter> $visitorCounter
     */
    public function getVisitorCounter()
    {
        return $this->visitorCounter;
    }

    /**
     * Sets the visitorCounter
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\UNAL\UnalNews\Domain\Model\VisitCounter> $visitorCounter
     * @return void
     */
    public function setVisitorCounter(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $visitorCounter)
    {
        $this->visitorCounter = $visitorCounter;
    }

    /**
     * Returns the counter
     * 
     * @return int $counter
     */
    public function getCounter()
    {
        return $this->counter;
    }

    /**
     * Sets the counter
     * 
     * @param int $counter
     * @return void
     */
    public function setCounter($counter)
    {
        $this->counter = $counter;
    }

    /**
     * @param $filePath
     */
    public function getDuration($filePath)
    {
        $videofile = new VideoFile($filePath);
        $duration = $videofile->getDurationEstimate();
        return $duration;
    }

    /*
     * Function for Buscador de convergencia
     */
    /**
     * @param $detailed
     * @param $tipo
     */
    public function parsedArrayElastic($detailed, $tipo)
    {
        if ($tipo == "new") {
            $summary_data = array();
            $baseUrl = GeneralUtility::getIndpEnv('TYPO3_SITE_URL');
            $summary_data['id'] = $this->getUid();
            $summary_data['title'] = $this->getTitle();
            $summary_data['alternativeTitle'] = $this->getAlternativeTitle();
            $summary_data['teaser'] = $this->getTeaser();
            $summary_data['date'] = $this->getDatetime();
            $summary_data['recordDate'] = $this->getDatetime();
            $summary_data['imagen'] = $baseUrl . FirstMediaImage::getPath($this->getFalMedia());

            #Views
            $summary_data['vistas'] = $this->getCounter();
            $summary_data['media']['imagesCount'] = 0;
            $summary_data['media']['audioCount'] = 0;
            $summary_data['media']['videoCount'] = 0;
            $summary_data['media']['images'] = [];
            $summary_data['media']['audio'] = [];
            $summary_data['media']['video'] = [];
            foreach ($this->getFalMedia() as $media) {
                $exte = $media->getOriginalResource()->getOriginalFile()->getProperties();
                $url = $media->getOriginalResource()->getPublicUrl();

                //DebugUtility::debug($exte,"chao");
                if ($exte['extension'] == 'jpg' || $exte['extension'] == 'png' || $exte['extension'] == 'jpeg') {
                    $summary_data['media']['images'][] = $baseUrl . $url;
                    $summary_data['media']['imagesCount'] += 1;
                }
                if ($exte['extension'] == "mp3" || $exte['extension'] == "ogg") {
                    $summary_data['media']['audio'][] = $baseUrl . $url;
                    $summary_data['media']['audioCount'] += 1;
                }
                if ($exte['extension'] == "mp4") {
                    $summary_data['media']['video'][] = $baseUrl . $url;
                    $summary_data['media']['videoCount'] += 1;
                }
            }
            if ($this->getFalRelatedFiles()) {
                if ($this->getFalRelatedFiles()->current()) {
                    $summary_data['media']['videoCount'] += 1;
                    $summary_data['media']['video'][] = $baseUrl . $this->getFalRelatedFiles()->current()->getOriginalResource()->getPublicUrl();
                    $summary_data['media']['video']['duration'] = $this->getDuration($baseUrl . $this->getFalRelatedFiles()->current()->getOriginalResource()->getOriginalFile()->getPublicUrl());
                } else {
                    $summary_data['media']['video'] = [];
                    $summary_data['media']['video']['duration'] = '';
                }
            }

            #Create detail url
            $uri = $this->createDetailedUrl($this->getUid());
            if (substr($uri, 0, 1) === '/') {
                $uri = ltrim($uri, '/');
                $uri = $baseUrl . $uri;
            }
            //$summary_data['url'] = $uri;
            $summary_data['url'] = $baseUrl;
            $summary_data['domain'] = $baseUrl;
            $summary_data['categories'] = array();
            $summary_data['recordCategory'] = array();

            //Campo utilizado por elasticSearch en el buscador de convergencia
            foreach ($this->getCategories() as $category) {
                $parent_category = $category->getParentCategory();
                if ($parent_category) {
                    switch ($parent_category->getUid()) {
                        case 2:

                            //Areas de convergencia
                            $summary_data['categories']['areaConvergencia'][] = array('uid' => $category->getUid(), 'name' => $category->getTitle());
                            $summary_data['recordCategory'][] = $category->getTitle();
                            break;
                        case 11:

                            //Buscador convergencia
                            $summary_data['recordCategory'][] = $category->getTitle();
                            break;
                    }
                }
            }
            return $summary_data;
        } else {
            if ($tipo == "image") {
                $summary_data = array();
                $baseUrl = GeneralUtility::getIndpEnv('TYPO3_SITE_URL');
                $id = $this->getUid();
                $title = $this->getTitle();
                $alternativeTitle = $this->getAlternativeTitle();
                $teaser = $this->getTeaser();
                $date = $this->getDatetime();
                $recordDate = $this->getDatetime();
                $uri = $this->createDetailedUrl($this->getUid());
                $recordCategory = array();

                //Campo utilizado por elasticSearch en el buscador de convergencia
                foreach ($this->getCategories() as $category) {
                    $parent_category = $category->getParentCategory();
                    if ($parent_category) {
                        switch ($parent_category->getUid()) {
                            case 2:

                                //Areas de convergencia
                                $recordCategory[] = $category->getTitle();
                                break;
                            case 11:

                                //Buscador convergencia
                                $recordCategory[] = $category->getTitle();
                                break;
                        }
                    }
                }
                $i = 0;
                foreach ($this->getFalMedia() as $media) {
                    $exte = $media->getOriginalResource()->getOriginalFile()->getProperties();
                    $url = $media->getOriginalResource()->getPublicUrl();

                    //DebugUtility::debug($exte,"chao");
                    if ($exte['extension'] == 'jpg' || $exte['extension'] == 'png' || $exte['extension'] == 'jpeg') {
                        $idImage = $media->getUid();
                        $idstring = $idImage . $id . "television";

                        //DebugUtility::debug($idstring,"chao");
                        $summary_data[$i]['id'] = $idstring;
                        $summary_data[$i]['id_new'] = $id;
                        $summary_data[$i]['title'] = $title;
                        $summary_data[$i]['product'] = "television_unal";
                        $summary_data[$i]['recordCategory'] = $recordCategory;
                        $summary_data[$i]['alternativeTitle'] = $alternativeTitle;
                        $summary_data[$i]['teaser'] = $teaser;
                        $summary_data[$i]['date'] = $date;
                        $summary_data[$i]['recordDate'] = $recordDate;

                        #Views
                        $summary_data[$i]['vistas'] = $this->getCounter();
                        $summary_data[$i]['url'] = $uri;
                        $summary_data[$i]['baseUrl'] = $baseUrl;
                        $summary_data[$i]['file'] = $baseUrl . $this->getFalMedia()->current()->getOriginalResource()->getPublicUrl();
                        $i++;
                    }
                }
                return $summary_data;
            } else {
                if ($tipo == "video") {
                    $summary_data = array();
                    $baseUrl = GeneralUtility::getIndpEnv('TYPO3_SITE_URL');
                    $id = $this->getUid();
                    $title = $this->getTitle();
                    $alternativeTitle = $this->getAlternativeTitle();
                    $teaser = $this->getTeaser();
                    $date = $this->getDatetime();
                    $recordDate = $this->getDatetime();
                    $uri = $this->createDetailedUrl($this->getUid());
                    $recordCategory = array();

                    #Views
                    $summary_data['vistas'] = $this->getCounter();

                    //Campo utilizado por elasticSearch en el buscador de convergencia
                    foreach ($this->getCategories() as $category) {
                        $parent_category = $category->getParentCategory();
                        if ($parent_category) {
                            switch ($parent_category->getUid()) {
                                case 2:

                                    //Areas de convergencia
                                    $recordCategory[] = $category->getTitle();
                                    break;
                                case 11:

                                    //Buscador convergencia
                                    $recordCategory[] = $category->getTitle();
                                    break;
                            }
                        }
                    }
                    $i = 0;
                    if ($this->getFalRelatedFiles()) {
                        foreach ($this->getFalRelatedFiles() as $media) {
                            $exte = $media->getOriginalResource()->getOriginalFile()->getProperties();
                            $url = $media->getOriginalResource()->getPublicUrl();
    
                            //DebugUtility::debug($exte,"chao");
                            if ($exte['extension'] == 'mp4') {
                                $idImage = $media->getUid();
                                $idstring = $idImage . $id . "television";
                                $summary_data[$i]['id'] = $idstring;
                                $summary_data[$i]['id_new'] = $id;
                                $summary_data[$i]['title'] = $title;
                                $summary_data[$i]['product'] = "television_unal";
                                $summary_data[$i]['recordCategory'] = $recordCategory;
                                $summary_data[$i]['alternativeTitle'] = $alternativeTitle;
    
                                #Views
                                $summary_data[$i]['vistas'] = $this->getCounter();
                                $summary_data[$i]['teaser'] = $teaser;
                                $summary_data[$i]['date'] = $date;
                                $summary_data[$i]['recordDate'] = $recordDate;
                                $summary_data[$i]['url'] = $uri;
                                $summary_data[$i]['baseUrl'] = $baseUrl;
                                $summary_data[$i]['file'] = $baseUrl . $this->getFalRelatedFiles()->current()->getOriginalResource()->getPublicUrl();
                                $i++;
                            }
                        }
                    }
                    return $summary_data;
                } else {
                    if ($tipo == "audio") {
                        $summary_data = array();
                        $baseUrl = GeneralUtility::getIndpEnv('TYPO3_SITE_URL');
                        $id = $this->getUid();
                        $title = $this->getTitle();
                        $alternativeTitle = $this->getAlternativeTitle();
                        $teaser = $this->getTeaser();
                        $date = $this->getDatetime();
                        $recordDate = $this->getDatetime();
                        $uri = $this->createDetailedUrl($this->getUid());
                        $recordCategory = array();

                        //Campo utilizado por elasticSearch en el buscador de convergencia
                        foreach ($this->getCategories() as $category) {
                            $parent_category = $category->getParentCategory();
                            if ($parent_category) {
                                switch ($parent_category->getUid()) {
                                    case 2:

                                        //Areas de convergencia
                                        $recordCategory[] = $category->getTitle();
                                        break;
                                    case 11:

                                        //Buscador convergencia
                                        $recordCategory[] = $category->getTitle();
                                        break;
                                }
                            }
                        }
                        $i = 0;
                        foreach ($this->getFalMedia() as $media) {
                            $exte = $media->getOriginalResource()->getOriginalFile()->getProperties();
                            $url = $media->getOriginalResource()->getPublicUrl();

                            //DebugUtility::debug($exte,"chao");
                            if ($exte['extension'] == 'mp3' || $exte['extension'] == 'ogg') {
                                $idImage = $media->getUid();
                                $idstring = $idImage . $id . "television";
                                $summary_data[$i]['id'] = $idstring;
                                $summary_data[$i]['id_new'] = $id;
                                $summary_data[$i]['title'] = $title;
                                $summary_data[$i]['product'] = "television_unal";
                                $summary_data[$i]['recordCategory'] = $recordCategory;
                                $summary_data[$i]['alternativeTitle'] = $alternativeTitle;

                                #Views
                                $summary_data[$i]['vistas'] = $this->getCounter();
                                $summary_data[$i]['teaser'] = $teaser;
                                $summary_data[$i]['date'] = $date;
                                $summary_data[$i]['recordDate'] = $recordDate;
                                $summary_data[$i]['url'] = $uri;
                                $summary_data[$i]['baseUrl'] = $baseUrl;
                                $summary_data[$i]['file'] = $baseUrl . $this->getFalMedia()->current()->getOriginalResource()->getPublicUrl();
                                $i++;
                            }
                        }
                        return $summary_data;
                    }
                }
            }
        }
    }

    /**
     * @param $detailed
     */
    public function parsedArray($detailed = false)
    {
        $summary_data = array();
        $baseUrl = GeneralUtility::getIndpEnv('TYPO3_SITE_URL');
        $summary_data['id'] = $this->getUid();
        $summary_data['title'] = $this->getTitle();
        $summary_data['alternativeTitle'] = $this->getAlternativeTitle();
        $summary_data['teaser'] = $this->getTeaser();
        $summary_data['date'] = $this->getDatetime();
        $summary_data['imagen'] = $baseUrl . FirstMediaImage::getPath($this->getFalMedia());
        if ($this->getFalRelatedFiles()) {
            if ($this->getFalRelatedFiles()->current()) {
                $summary_data['video'] = $baseUrl . $this->getFalRelatedFiles()->current()->getOriginalResource()->getPublicUrl();
                $summary_data['duration'] = $this->getDuration($baseUrl . $this->getFalRelatedFiles()->current()->getOriginalResource()->getOriginalFile()->getPublicUrl());
            } else {
                $summary_data['video'] = '';
                $summary_data['duration'] = '';
            }
        }

        #Views
        $summary_data['vistas'] = $this->getCounter();

        #Create detail url
        $uri = $this->createDetailedUrl($this->getUid());
        //$summary_data['url'] = $uri;
        $summary_data['url'] = $baseUrl;
        $summary_data['domain'] = $baseUrl;
        $summary_data['categories'] = array();
        foreach ($this->getCategories() as $category) {
            $parent_category = $category->getParentCategory();
            if ($parent_category) {
                switch ($parent_category->getUid()) {
                    case 1:

                        //Sedes
                        $summary_data['categories']['sede'][] = array('uid' => $category->getUid(), 'name' => $category->getTitle());
                        break;
                    case 2:

                        //Areas de convergencia
                        $summary_data['categories']['areaConvergencia'][] = array('uid' => $category->getUid(), 'name' => $category->getTitle());
                        break;
                    case 3:

                        //Especiales
                        $summary_data['categories']['especial'][] = array('uid' => $category->getUid(), 'name' => $category->getTitle());
                        break;
                }
            }
        }
        return $summary_data;
    }

    /**
     * @param $uid
     */
    public function createDetailedUrl($uid)
    {
        return sprintf(
            '/index.php?id=4&tx_news_pi1[action]=detail&tx_news_pi1[controller]=News&tx_news_pi1[news]=%d',
            (int)$uid
        );
    }
    public function actualizarVisita()
    {
        $today = new \DateTime();
        $registered_visit = false;
        $visitas_diarias = $this->getVisitorCounter();

        #Verify if exist registers of visitation today
        foreach ($visitas_diarias as $visitas_dia) {
            if ($visitas_dia->sameDay($today)) {

                #Exist registers today
                $visitas_dia->addVisitation();
                $registered_visit = true;
            }
        }

        #Validate if the visit was register
        if (!$registered_visit) {
            $visita = new \UNAL\UnalNews\Domain\Model\VisitCounter($today);
            $this->addVisitorCounter($visita);
        }

        #Increase general counter
        $this->setCounter($this->getCounter() + 1);
    }

    /**
     * @param $time
     */
    public function totalViews($time = 'week')
    {
        $vistas = $this->getVisitorCounter();
        switch ($time) {
            case 'day':
                break;
            case 'week':
                break;
            case 'month':
                break;
            case 'year':
                break;
        }
    }

    /**
     * Returns the views
     * 
     * @return int $views
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * Sets the views
     * 
     * @param int $views
     * @return void
     */
    public function setViews($views)
    {
        $this->views = $views;
    }

    /**
     * Sets the views
     * 
     * @param int $views
     * @return void
     */
    public function addViews()
    {
        $this->views = $this->views + 1;
    }

    /**
     * Returns the city
     * 
     * @return \UNAL\UnalNews\Domain\Model\City $city
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Sets the city
     * 
     * @param \UNAL\UnalNews\Domain\Model\City $city
     * @return void
     */
    public function setCity(\UNAL\UnalNews\Domain\Model\City $city)
    {
        $this->city = $city;
    }
}
