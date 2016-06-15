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
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3\CMS\Fluid\Core\ViewHelper\Exception;

/**
 * Overwrite Image ViewHelper
 *
 * @author Dennis Geldmacher
 */
class ImageViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Uri\ImageViewHelper
{

    /**
     * Resizes the image (if required) and returns its path. If the image was not resized, the path will be equal to $src
     *
     * @see https://docs.typo3.org/typo3cms/TyposcriptReference/ContentObjects/ImgResource/
     *
     * @param string                           $src
     * @param FileInterface|AbstractFileFolder $image
     * @param string                           $width              width of the image. This can be a numeric value representing the fixed width of the image in pixels. But you can also perform simple calculations by adding "m" or "c" to the value. See imgResource.width for possible options.
     * @param string                           $height             height of the image. This can be a numeric value representing the fixed height of the image in pixels. But you can also perform simple calculations by adding "m" or "c" to the value. See imgResource.width for possible options.
     * @param int                              $minWidth           minimum width of the image
     * @param int                              $minHeight          minimum height of the image
     * @param int                              $maxWidth           maximum width of the image
     * @param int                              $maxHeight          maximum height of the image
     * @param bool                             $treatIdAsReference given src argument is a sys_file_reference record
     * @param string|bool                      $crop               overrule cropping of image (setting to FALSE disables the cropping set in FileReference)
     * @param bool                             $absolute           Force absolute URL
     *
     * @return string
     * @throws Exception
     * @throws \Exception
     */
    public function render(
        $src = null,
        $image = null,
        $width = null,
        $height = null,
        $minWidth = null,
        $minHeight = null,
        $maxWidth = null,
        $maxHeight = null,
        $treatIdAsReference = false,
        $crop = null,
        $absolute = false
    ) {
        if (GeneralUtility::compat_version('7.6')) {
            return self::renderStatic([
                'src'                => $src,
                'image'              => $image,
                'width'              => $width,
                'height'             => $height,
                'minWidth'           => $minWidth,
                'minHeight'          => $minHeight,
                'maxWidth'           => $maxWidth,
                'maxHeight'          => $maxHeight,
                'treatIdAsReference' => $treatIdAsReference,
                'crop'               => $crop,
                'absolute'           => $absolute,
            ], $this->buildRenderChildrenClosure(), $this->renderingContext);
        } else {
            $this->imageService = $this->objectManager->get(ImageService::class);
            try {
                $return = parent::render(
                    $src,
                    $image,
                    $width,
                    $height,
                    $minWidth,
                    $minHeight,
                    $maxWidth,
                    $maxHeight,
                    $treatIdAsReference
                );
            } catch (\Exception $ex) {
                throw $ex;
            }
            return $return;
        }
    }

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
