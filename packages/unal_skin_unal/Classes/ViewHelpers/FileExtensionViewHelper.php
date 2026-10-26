<?php
namespace UNAL\UnalSkinUnal\ViewHelpers;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

class FileExtensionViewHelper extends AbstractViewHelper {
    
    use CompileWithRenderStatic;
    
    public function initializeArguments() {
        $this->registerArgument('file', 'string', 'Ruta del archivo del cual se desea conocer su extensión.');
    }

    public static function renderStatic(
            array $arguments, 
            \Closure $renderChildrenClosure, 
            RenderingContextInterface $renderingContext
    ) {
        $file = $arguments['file'];

        if (null === $file) {
            return '';
        }

        $parts = explode('.', basename($file));

        // file has no extension
        if (1 === count($parts)) {
            return '';
        }

        $extension = strtolower(array_pop($parts));

        return $extension;  
    }
}