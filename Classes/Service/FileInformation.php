<?php
/**
 * File information service
 *
 * @author Tim Lochmüller
 */

namespace FRUIT\FlRealurlImage\Service;

use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Resource\FileReference;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\MathUtility;

/**
 * File information service
 *
 * @author Tim Lochmüller
 */
class FileInformation
{

    /**
     * Get information from the fal record of the current rendering
     *
     * @param array $imageInformation
     * @param mixed $imageInformation
     *
     * @return array
     */
    public function getByFal($imageInformation, $fileTypeInformation)
    {
        if ($imageInformation['originalFile'] instanceof File) {
            return $imageInformation['originalFile']->getProperties();
        } elseif ($fileTypeInformation instanceof FileReference) {
            return $fileTypeInformation->getOriginalFile()
                ->getProperties();
        }
        return array();
    }

    /**
     * Get information from the fal record of the current rendering
     *
     * @param array                                                    $imageInformation
     *
     * @param                                                          $file
     * @param                                                          $conf
     * @param  ContentObjectRenderer                                   $cObj
     *
     * @return array
     */
    public function getByFalReference($imageInformation, $file, $conf, $cObj)
    {
        if ($file instanceof FileReference) {
            return $file->getProperties();
        }
        if (!($cObj instanceof ContentObjectRenderer)) {
            return array();
        }

        $fileReference = null;
        $fileArray = $conf['file.'];
        if ($file instanceof FileReference) {
            $fileReference = $file;
        } else {
            try {
                if ($fileArray['import.']) {
                    $importedFile = trim($cObj->stdWrap('', $fileArray['import.']));
                    if (!empty($importedFile)) {
                        $file = $importedFile;
                    }
                }

                if (MathUtility::canBeInterpretedAsInteger($file)) {
                    if (!empty($fileArray['treatIdAsReference'])) {
                        $fileReference = ResourceFactory::getInstance()
                            ->getFileReferenceObject($file);
                    }
                }
            } catch (\Exception $exception) {
                return array();
            }
        }

        if ($fileReference instanceof FileReference) {
            return $fileReference->getProperties();
        }

        return array();
    }

}
