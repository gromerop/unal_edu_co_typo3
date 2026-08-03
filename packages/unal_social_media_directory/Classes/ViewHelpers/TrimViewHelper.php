<?php
namespace UNAL\UnalSocialMediaDirectory\ViewHelpers;

class TrimViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {
    
    /**
	 * Remove whitespace in a string but respect HTML Tags
	 * @param string $subject 
	 * @return \string
	 */
    function render($subject = NULL){
		return trim(trim($subject,chr(0xC2).chr(0xA0)));
    }
}
?>
