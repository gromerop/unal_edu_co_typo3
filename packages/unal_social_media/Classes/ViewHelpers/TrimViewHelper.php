<?php
namespace UNAL\UnalSocialMedia\ViewHelpers;

class TrimViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper {
    
	public function initializeArguments(){
    parent::initializeArguments();

    $this->registerArgument('subject', 'string', '', true);
	}
    /**
	 * Remove whitespace in a string but respect HTML Tags
	 * @param string $subject 
	 * @return \string
	 */
    function render($subject){
		\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($subject);
exit;

		return trim(trim($subject,chr(0xC2).chr(0xA0)));
    }
}
?>
