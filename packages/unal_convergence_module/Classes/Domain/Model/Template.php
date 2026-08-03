<?php
namespace UNAL\UnalConvergenceModule\Domain\Model;


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
 * Template
 */
class Template extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * @var bool
     */
    protected $iscontent;

    /**
     * Get is content flag
     *
     * @return bool
     */
    public function getIscontent()
    {
        return $this->iscontent;
    }

    /**
     * Set is content flag
     *
     * @param bool $iscontent flag
     */
    public function setIscontent($iscontent)
    {
        $this->iscontent = $iscontent;
    }

    /**
     * Template Name
     * 
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $name = '';

    /**
     * Returns the template name
     * 
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the template name
     * 
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Template layout
     * 
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $layout = '';

    /**
     * Returns the template layout
     * 
     * @return string $layout
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * Sets the template layout
     * 
     * @param string $layout
     * @return void
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }
}
