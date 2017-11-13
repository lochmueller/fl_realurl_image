<?php
/**
 * Overwrite Uri/ImageViewHelper
 *
 * @author  Dennis Geldmacher
 */

namespace FRUIT\FlRealurlImage\Xclass\Fluid\ViewHelpers\Uri;

use FRUIT\FlRealurlImage\Service\ImageService;
use TYPO3\CMS\Core\Resource\Exception\ResourceDoesNotExistException;
use TYPO3\CMS\Core\Resource\FileInterface;
use TYPO3\CMS\Core\Resource\FileReference;
use TYPO3\CMS\Extbase\Domain\Model\AbstractFileFolder;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3\CMS\Fluid\Core\ViewHelper\Exception;

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
        $crop = $arguments['crop'];
        //$absolute = $arguments['absolute'];

        if (is_null($src) && is_null($image) || !is_null($src) && !is_null($image)) {
            throw new Exception('You must either specify a string src or a File object.', 1382284105);
        }

        try {
            $imageService = self::getImageService();
            $image = $imageService->getImage($src, $image, $treatIdAsReference);

            if ($crop === null) {
                $crop = $image instanceof FileReference ? $image->getProperty('crop') : null;
            }

            $processingInstructions = [
                'width'     => $arguments['width'],
                'height'    => $arguments['height'],
                'minWidth'  => $arguments['minWidth'],
                'minHeight' => $arguments['minHeight'],
                'maxWidth'  => $arguments['maxWidth'],
                'maxHeight' => $arguments['maxHeight'],
                'crop'      => $crop,
            ];
            $processedImage = $imageService->applyProcessingInstructions($image, $processingInstructions);
            return $imageService->getImageUri($processedImage);
        } catch (ResourceDoesNotExistException $e) {
            // thrown if file does not exist
        } catch (\UnexpectedValueException $e) {
            // thrown if a file has been replaced with a folder
        } catch (\RuntimeException $e) {
            // RuntimeException thrown if a file is outside of a storage
        } catch (\InvalidArgumentException $e) {
            // thrown if file storage does not exist
        }
        return '';
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
