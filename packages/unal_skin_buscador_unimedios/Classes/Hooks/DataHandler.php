<?php

namespace UNAL\UnalSkinBuscadorUnimedios\Hooks;

/**
 * This file is part of the "unal_skin_buscador_unimedios" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
use TYPO3\CMS\Backend\Utility\BackendUtility as BackendUtilityCore;

use UNAL\UnalSkinBuscadorUnimedios\Utility\ConvergenciaUtility;
use TYPO3\CMS\Core\DataHandling\DataHandler as CoreDataHandler;


/**
 * Hook into tcemain which is used to show preview of news item
 *
 */
class DataHandler
{

    public function __construct(
        private readonly ConvergenciaUtility $convergenciaUtility,
    ) {
    }


    /**
     * Generate a different preview link *
     *
     * @param string $status status
     * @param string $table table name
     * @param int $recordUid id of the record
     * @param array $fields fieldArray
     * @param CoreDataHandler $parentObject parent Object
     */
    public function processDatamap_afterDatabaseOperations(
        string $status,
        string $table,
        string|int $recordUid,
        array $fields,
        CoreDataHandler $parentObject
    ): void {
        
        if ($table !== 'tx_news_domain_model_news') {
            return;
        }

        if (
            is_string($recordUid)
            && str_starts_with($recordUid, 'NEW')
        ) {
            $recordUid = $parentObject->substNEWwithIDs[$recordUid]
                ?? $recordUid;
        }

        $newsRecord = BackendUtilityCore::getRecord(
            $table,
            (int)$recordUid
        );
        if (!$newsRecord || $newsRecord['type'] !== 'Tx_UnalNews_UnalNews') {
            return;
        }
        
        
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


    public function processCmdmap_preProcess(
        string $command,
        string &$table,
        string|int $id,
        mixed $value,
        CoreDataHandler $parentObject,
        ?array $pasteUpdate = null,
    ): void {
        if (
            $command !== 'delete'
            || $table !== 'tx_news_domain_model_news'
            || !is_numeric($id)
        ) {
            return;
        }

        $newsRecord = BackendUtilityCore::getRecord(
            $table,
            (int)$id
        );

        if (
            !$newsRecord
            || ($newsRecord['type'] ?? '') !== 'Tx_UnalNews_UnalNews'
        ) {
            return;
        }

        $this->convergenciaUtility->deleteElasticElements($newsRecord);
    }
}
