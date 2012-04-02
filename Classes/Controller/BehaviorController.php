<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Thomas Allmer <thomas.allmer@webteam.at>, WEBTEAM GmbH
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
 *
 *
 * @package mootools_essentials
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_MootoolsEssentials_Controller_BehaviorController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * behaviorRepository
	 *
	 * @var Tx_MootoolsEssentials_Domain_Repository_BehaviorRepository
	 */
	protected $behaviorRepository;

	/**
	 * injectBehaviorRepository
	 *
	 * @param Tx_MootoolsEssentials_Domain_Repository_BehaviorRepository $behaviorRepository
	 * @return void
	 */
	public function injectBehaviorRepository(Tx_MootoolsEssentials_Domain_Repository_BehaviorRepository $behaviorRepository) {
		$this->behaviorRepository = $behaviorRepository;
	}

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$behaviors = $this->behaviorRepository->findAll();
		$this->view->assign('behaviors', $behaviors);
	}

}
?>