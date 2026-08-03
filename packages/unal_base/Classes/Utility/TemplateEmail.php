<?php
namespace UNAL\UnalBase\Utility;

/* * *************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 Martha Janeth Angarita Reyes <mjangaritar@unal.edu.co>, Universidad Nacional de Colombia
 *           Giovanni Romero Pérez <gromerop@unal.edu.co>, Universidad Nacional de Colombia
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */

/**
 * Utilidad para los mensajes de correo electrónico
 */

class TemplateEmail {
	/**
	 * 
	 * @param array $recipient Destinatarios. Ej: array('email1@domain1.edu' => 'Destinatario 1', 'email2@domain2.com' => 'Destinatario 2')
	 * @param array $cc Copia. Tiene la misma estructura que los destinatarios.
	 * @param array $sender Remitentes. Tiene la misma estructura que los destinatarios.
	 * @param array $replyTo Responder a... Tiene la misma estructura que los destinatarios.
	 * @param array $readReceiptTo Receptores del acuse de recibo. Tiene la misma estructura que los destinatarios.
	 * @param type $subject Asunto
	 * @param type $templatePath Ruta relativa del directorio donde está la plantilla; depende de la extensión donde se use. Ej: 'EXT:unal_concursosprofesorales/Resources/Private/Templates/Email/Template.html'
	 * @param array $variables Variables enviadas a la plantilla
	 * @param array $attachments Rutas y nuevos nombres de los archivos adjuntos, organizados de la siguiente manera: array(array('path' => $rutaDelArchivo, 'newName' => 'Nuevo nombre del adjunto sin extensión'))
	 * @return boolean Indica si el mensaje pudo enviarse.
	 */
	static function send (array $recipient, array $cc, array $sender, array $replyTo, array $readReceiptTo, $subject, $templatePath, array $variables = array(), array $attachments = array()) {
		$emailView = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Fluid\View\StandaloneView');
		$templatePathAndFilename = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($templatePath);
		$emailView->setTemplatePathAndFilename($templatePathAndFilename);
		$emailView->assignMultiple($variables);
		$emailBody = $emailView->render();
		$message = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Core\Mail\MailMessage');
		$message->setTo($recipient)
				  ->setCc($cc)
				  ->setFrom($sender)
				  ->setSubject($subject)
				  ->setReplyTo($replyTo)
				  ->setReadReceiptTo($readReceiptTo);
		$message->setBody($emailBody, 'text/html');
		foreach ($attachments as $attachment) {
			$file = \Swift_Attachment::fromPath($attachment['path']);
			$file->setFilename($attachment['newName'] . '.' . pathinfo($attachment['path'])['extension']);
			$message->attach($file);
		}
		$message->send();
		return $message->isSent();
	}
	
}
