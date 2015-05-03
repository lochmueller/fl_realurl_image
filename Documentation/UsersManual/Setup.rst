TypoScript Setup
^^^^^^^^^^^^^^^^

If you want to go even deeper, you get access to even more functionality with TypoScript. This is the default configuration:
config.fl_realurl_image = 1
config.fl_realurl_image {

	# generation of a text basis for a speaking file name
	data = file:origFile // ts:altText // page:title // image

	## stdWrap
	case = lower
	trim = 1
	crop =210| |1

	# additional encoding (optional, stdWrap could potentially do it all, but much work)
	spaceCharacter = -
	smartEncoding = 1
	folder = typo3tem/fl_realurl_image/
	hashLength = 2
}
You can set this configuration for each image. See this examples:
or you can change the behavior of fl_realurl_image directly in the TS definition of an specific IMAGE object:
    lib.myImage = IMAGE
    lib.myImage {
        file = fileadmin/myfilder/myimage.jpg
        XY = 50x50
        altText = myImage [50x50]
        # switching fl_realurl_image completely of
        fl_realurl_image = 0
        # using “my Image” as a basis for the file name
        fl_realurl_image = my Image
    }
