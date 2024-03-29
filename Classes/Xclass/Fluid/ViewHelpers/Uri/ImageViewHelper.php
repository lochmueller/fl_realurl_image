<?php
/**
 * Overwrite Uri/ImageViewHelper
 *
 * @author  Dennis Geldmacher
 */

namespace FRUIT\FlRealurlImage\Xclass\Fluid\ViewHelpers\Uri;

use TYPO3Fluid\Fluid\Core\ViewHelper\Exception;
use TYPO3\CMS\Core\Imaging\ImageManipulation\CropVariantCollection;
use FRUIT\FlRealurlImage\Service\ImageService;
use TYPO3\CMS\Core\Resource\Exception\ResourceDoesNotExistException;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;

/**
 * Overwrite Image ViewHelper
 *
 * @author Dennis Geldmacher
 */
class ImageViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Uri\ImageViewHelper
{

    /**
     * @param array                     $arguments
     * @param callable|\Closure         $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     *
     * @return string
     * @throws Exception
     */
    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {
        $src = $arguments['src'];
        $image = $arguments['image'];
        $treatIdAsReference = $arguments['treatIdAsReference'];
        $cropString = $arguments['crop'];
        $absolute = $arguments['absolute'];

        if (($src === null && $image === null) || ($src !== null && $image !== null)) {
            throw new Exception('You must either specify a string src or a File object.', 1460976233);
        }

        // A URL was given as src, this is kept as is
        if ($src !== '' && preg_match('/^(https?:)?\/\//', $src)) {
            return $src;
        }

		try {
			$imageService = self::getImageService();
			$image = $imageService->getImage($src, $image, $treatIdAsReference);

			if ($cropString === null && $image->hasProperty('crop') && $image->getProperty('crop')) {
				$cropString = $image->getProperty('crop');
			}

			$cropVariantCollection = CropVariantCollection::create((string)$cropString);
			$cropVariant = $arguments['cropVariant'] ?: 'default';
			$cropArea = $cropVariantCollection->getCropArea($cropVariant);
			$processingInstructions = [
				'width' => $arguments['width'],
				'height' => $arguments['height'],
				'minWidth' => $arguments['minWidth'],
				'minHeight' => $arguments['minHeight'],
				'maxWidth' => $arguments['maxWidth'],
				'maxHeight' => $arguments['maxHeight'],
				'crop' => $cropArea->isEmpty() ? null : $cropArea->makeAbsoluteBasedOnFile($image),
			];

			$processedImage = $imageService->applyProcessingInstructions($image, $processingInstructions);
			return $imageService->getImageUri($processedImage, $absolute);
		} catch (ResourceDoesNotExistException $e) {
			// thrown if file does not exist
			throw new Exception($e->getMessage(), 1509741907, $e);
		} catch (\UnexpectedValueException $e) {
			// thrown if a file has been replaced with a folder
			throw new Exception($e->getMessage(), 1509741908, $e);
		} catch (\RuntimeException $e) {
			// RuntimeException thrown if a file is outside of a storage
			throw new Exception($e->getMessage(), 1509741909, $e);
		} catch (\InvalidArgumentException $e) {
			// thrown if file storage does not exist
			throw new Exception($e->getMessage(), 1509741910, $e);
		}
    }

    /**
     * Return an instance of ImageService using object manager
     *
     * @return ImageService
     */
    protected static function getImageService()
    {
		/** @var ObjectManager $objectManager */
		$objectManager = GeneralUtility::makeInstance(ObjectManager::class);
		return $objectManager->get(ImageService::class);
    }
}
