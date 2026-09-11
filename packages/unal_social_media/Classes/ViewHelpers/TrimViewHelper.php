<?php
namespace UNAL\UnalSocialMedia\ViewHelpers;

class TrimViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper {

	public function initializeArguments(){
		parent::initializeArguments();
		$this->registerArgument('subject', 'string', '', true);
	}
    /**
	 * Remove whitespace in a string but respect HTML Tags
	 * @return \string
	 */
	public function render(){
		$subject = $this->arguments['subject'];
		return trim(trim($subject,chr(0xC2).chr(0xA0)));
	}
}
