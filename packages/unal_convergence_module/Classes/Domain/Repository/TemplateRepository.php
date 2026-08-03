<?php
namespace UNAL\UnalConvergenceModule\Domain\Repository;


/***
 *
 * This file is part of the "UNAL Convergence Module" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2020 
 *
 ***/
/**
 * The repository for Templates
 */
class TemplateRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    public function findAllActive($iscontent=false)
    {
        $query = $this->createQuery();
        $query->matching(
        $query->logicalAnd(
        [
            $query->equals('iscontent', $iscontent), 
            $query->equals('deleted', 0), 
            $query->equals('hidden', 0)
        ]
        )
        );
        return $query->execute();
    }
    
    public function countByTemplateName($name)
    {
        $query = $this->createQuery();
        $query->matching($query->like('name', $name. '%'))->count();
        return $query->matching($query->like('name', $name. '%'))->count();
    }
}
