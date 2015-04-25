<?php
/**
 * Clean command controller
 *
 * @package FlRealurlImage\Command
 * @author  Tim Lochmüller
 */

namespace FRUIT\FlRealurlImage\Command;

use TYPO3\CMS\Core\Database\DatabaseConnection;use TYPO3\CMS\Core\Messaging\FlashMessage;use TYPO3\CMS\Core\Utility\GeneralUtility;use TYPO3\CMS\Extbase\Mvc\Controller\CommandController;

/**
 * Clean command controller
 *
 * @author Tim Lochmüller
 */
class CleanCommandController extends CommandController {

	/**
	 * Remove double entries
	 */
	public function removeDoubleEntriesCommand() {
		$database = $this->getDatabase();
		$rows = $database->exec_SELECTgetRows('COUNT(*) c, image_path', 'tx_flrealurlimage_cache', '1=1', 'image_path', 'c', '0, 20');

		foreach ($rows as $row) {
			if ($row['c'] > 1) {
				$rows = $database->exec_SELECTgetRows('*', 'tx_flrealurlimage_cache', 'image_path="' . $row['image_path'] . '"', '', 'crdate ASC', $row['c'] - 1);
				$ids = array();
				foreach ($rows as $r) {
					$ids[] = $r['uid'];
				}

				$database->exec_DELETEquery('tx_flrealurlimage_cache', 'uid IN (' . implode(',', $ids) . ')');

				$msg = 'Found ' . $row['c'] . ' of "' . $row['image_path'] . '"-path and delete ' . sizeof($ids) . ' entries.';
				/** @var FlashMessage $message */
				$message = GeneralUtility::makeInstance('t3lib_FlashMessage', '', $msg, FlashMessage::INFO);
				/** @var $flashMessageService \TYPO3\CMS\Core\Messaging\FlashMessageService */
				$flashMessageService = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Messaging\\FlashMessageService');
				$flashMessageService->getMessageQueueByIdentifier()
					->addMessage($message);
			}
		}
	}

	/**
	 * Chek the Image Path
	 */
	protected function checkImagePath() {
		$database = $this->getDatabase();
		$rows = $database->exec_SELECTgetRows(' uid,image_path', 'tx_flrealurlimage_cache', '1=1');
		foreach ($rows as $row) {
			if (!is_file(PATH_site . $row['image_path'])) {
				echo $row['image_path'] . ' -- ' . $row['uid'] . '<br />';
			}
		}
	}

	/**
	 * Get the database connection
	 *
	 * @return DatabaseConnection
	 */
	protected function getDatabase() {
		return $GLOBALS['TYPO3_DB'];
	}

}