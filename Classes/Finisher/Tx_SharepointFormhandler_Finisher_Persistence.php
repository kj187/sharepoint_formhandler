<?php

/***************************************************************
*  Copyright notice
*
*  (c) 2013 Julian Kleinhans <julian.kleinhans@aijko.de>, aijko GmbH
 *  Erik Frister <ef@aijko.de>, aijko GmbH
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
 ***************************************************************/

/**
 * Sharepoint persistence finisher
 *
 * @package sharepoint_formhandler
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Tx_SharepointFormhandler_Finisher_Persistence extends Tx_Formhandler_AbstractFinisher {

	/**
	 * @var \Aijko\SharepointConnector\Sharepoint\SharepointInterface
	 */
	protected $sharepointApi;

	/**
	 * The main method called by the controller
	 *
	 * @return void
	 */
	public function process() {

		// Get values from flexform
		$piObject = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('tslib_pibase');
		$listMappingUid = $piObject->pi_getFFvalue($this->cObj->data['pi_flexform'], 'list', 'sSHAREPOINT');

		$typoscriptConfiguration = $GLOBALS['TSFE']->tmpl->setup['module.']['tx_sharepointconnector.']['settings.']['sharepointServer.'];
		$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');

		$sharepointRESTApi = $objectManager->create('Aijko\\SharepointConnector\\Sharepoint\\Rest\\Sharepoint');
		$this->sharepointApi = $objectManager->create('Aijko\\SharepointConnector\\Sharepoint\\SharepointFacade', $sharepointRESTApi, $typoscriptConfiguration);
		if (!$this->sharepointApi->addToList($listMappingUid, $this->gp)) {
			// TODO error handling

		}

		return $this->gp;
	}


}

?>