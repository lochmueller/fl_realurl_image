Options in the constant editor
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

1) conf_enable:
enable or disable the fl_realurl_image rewriting of the image path
default: 1

2) conf_data:
define where fl_realurl_image gets its information from to generate a meaningful filename. In a hierarchy you can give more options separate by “//”. fl_realur_image will use the first that gives a result. For using a fixed text, just insert it:
my_image_standard_file_name
for using a information from the file info, use e.g.:
file:origFile
for using another TS value in the image object, e.g. the alt attribut, use:
ts:altText // ts:titleText
for using a information from the page use:
page:title // page:description // page:keywords
default: dam:title // file:origFile // ts:altText // page:title // image

3) conf_case:
Transform the file name in either “upper” or “lower” case.
default: lower

4) conf_trim:
trim white spaces before generating the file name
default: 1

5) conf_crop:
limit the file name to a maximum lenth.
Default: 210| |1

6) conf_spaceCharacter
The charakter for space in the file name
default: -

7) conf_smartEncoding
use the smartEncoding option to get nice ASCII file names
default: 1

8) conf_folder
The folder where the fl_realurl_images are stored, either as link or only as DB simulation (see extension manager config: linkStatic).
default: typo3temp/fl_realurl_image

9) conf_hashLength
To keep file names unique a short hash at the end of each image is recommended. fl_realurl_image will extend the hash length automatically if it comes to a collision. But collisions always mean that the image might change its file name after a complete cache clear. So it is recommended to keep the chance of collisions low with a short hash at the end of any image.
default: 2