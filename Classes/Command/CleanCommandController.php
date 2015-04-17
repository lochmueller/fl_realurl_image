<?php
/**
 * Clean command controller
 *
 * @package FlRealurlImage\Command
 * @author  Tim Lochmüller
 */

namespace FRUIT\FlRealurlImage\Command;

use TYPO3\CMS\Core\Database\DatabaseConnection;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageQueue;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\CommandController;

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
		$sql = "SELECT COUNT(*) c, image_path FROM  tx_flrealurlimage_cache GROUP BY image_path ORDER BY c DESC LIMIT 0, 20";
		$res = $database->sql_query($sql);

		while ($row = $database->sql_fetch_assoc($res)) {
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
				FlashMessageQueue::addMessage($message);
			}
		}
	}

	/**
	 * Chek the Image Path
	 */
	protected function checkImagePath() {
		$database = $this->getDatabase();
		$sql = "SELECT uid,image_path FROM tx_flrealurlimage_cache";
		$res = $database->sql_query($sql);
		while ($row = $database->sql_fetch_assoc($res)) {
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