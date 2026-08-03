<?php

namespace UNAL\UnalSkinBuscadorUnimedios\Hooks;

/**
 * This file is part of the "news" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
use TYPO3\CMS\Backend\Utility\BackendUtility as BackendUtilityCore;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

use UNAL\UnalSkinBuscadorUnimedios\Utility\ConvergenciaUtility;


/**
 * Hook into tcemain which is used to show preview of news item
 *
 */
class DataHandler
{

    private $convergenciaUtility = NULL;

    /**
     * DataHandler constructor.
     */
    public function __construct()
    {
        $this->convergenciaUtility = new ConvergenciaUtility();
    }


    /**
     * Generate a different preview link *
     *
     * @param string $status status
     * @param string $table table name
     * @param int $recordUid id of the record
     * @param array $fields fieldArray
     * @param \TYPO3\CMS\Core\DataHandling\DataHandler $parentObject parent Object
     */
    public function processDatamap_afterDatabaseOperations(
        $status,
        $table,
        $recordUid,
        array $fields,
        \TYPO3\CMS\Core\DataHandling\DataHandler $parentObject
    ) {

        if ($table === 'tx_news_domain_model_news') {
            
            if (GeneralUtility::isFirstPartOfStr($recordUid, 'NEW')) {
                $recordUid = $parentObject->substNEWwithIDs[$recordUid];
            }
            
            $newsRecord = BackendUtilityCore::getRecord($table, $recordUid);
            if ($newsRecord["type"] == "Tx_UnalNews_UnalNews") {
                
                $datetime   = $newsRecord['datetime'];
                $starttime  = $newsRecord['starttime'];
                $endtime    = $newsRecord['endtime'];
                $actualTime = time();

                $isValidDatetime = $isValidStarttime = $isValidEndtime = false;

                // If $datetime is lower or equal than $actualTime
                if($datetime>0 && $actualTime>=$datetime ){
                    $isValidDatetime = true;
                }
                // If $actualTime is greater or equal than $starttime
                if($starttime>0 && $starttime <= $actualTime){
                    $isValidStarttime = true;
                }elseif($starttime==0){
                    $isValidStarttime = true;
                }
                // If $actualTime is lower or equal than $endtime
                if($endtime>0 && $endtime >= $actualTime){
                    $isValidEndtime = true;
                }elseif($endtime==0){
                    $isValidEndtime = true;
                }
                
                if($isValidDatetime && $isValidStarttime && $isValidEndtime){
                    
                    if($status === 'new' && $newsRecord['pid'] !== -1){
                        //Insert in elastic
                        $this->convergenciaUtility->insertElasticElements($newsRecord);
                    }elseif($status === 'update'){

                        $isHidden =  $newsRecord['hidden'];

                        if($isHidden){
                            //Delete in elastic
                            $this->convergenciaUtility->deleteElasticElements($newsRecord);
                        }elseif($newsRecord['pid'] !== -1){
                            //Update in elastic
                            $this->convergenciaUtility->insertElasticElements($newsRecord);
                        }
                    }
                }else{
                    //Delete in elastic
                    $this->convergenciaUtility->deleteElasticElements($newsRecord);
                }
            }

        }
    }


    /**
     * Prevent deleting/moving of a news record if the editor doesn't have access to all categories of the news record
     *
     * @param string $command
     * @param string $table
     * @param int $id
     * @param string $value
     * @param $parentObject \TYPO3\CMS\Core\DataHandling\DataHandler
     */
    public function processCmdmap_preProcess($command, &$table, $id, $value, $parentObject)
    {

        if ($table === 'tx_news_domain_model_news' && $command === 'delete') {

            $newsRecord = BackendUtilityCore::getRecord($table, $id);
            //Delete in elastic
            $this->convergenciaUtility->deleteElasticElements($newsRecord);
        }
    }



    /**
     * Returns the current BE user.
     *
     * @return \TYPO3\CMS\Core\Authentication\BackendUserAuthentication
     */
    protected function getBackendUser()
    {
        return $GLOBALS['BE_USER'];
    }



}
