ChangeLog
---------

x.x.x

- Cleanup ext_* files

3.4.0  May 30, 2015

- Overwrite ViewHelper to get image names from the given alt attribute of f:image

3.3.1 May 20, 2015

- Fix Bug https://forge.typo3.org/issues/67054

3.3.0 May 18, 2015

- Remove removeDoubleEntriesCommand, because the CF do not allow double entries
- Introduce the Caching Framework
- Prepare configuration handling
- Code cleanups
- Fix Caching bug
- Fix generation of the text base
- cleanups

3.2.0 May 03, 2015

- First TYPO3 6.2/7.2.x Release
- Remove DAM Support
- Remove the obsolte media Support
- Migration of all class names
- Change class structure
- Migration of the documentation
- Cleanup the PHP classes
- This Release is supported by bolius.dk! ThankYou!

3.1.2 November 01, 2014

- Fix #62581 and #60114

3.1.1 October 13, 2014

- Fix #62172, #61763 and #60279. Should works with 4.5 and 4.7 again.

3.1.0 June 27, 2014

- Compatibility Update for TYPO3 CMS 6.2. Last Update for TYPO3 CMS < 6.2. Also add the new data source "falref" to get access to the file reference.

3.0.1 September 30, 2013

- Merge absRefPrefix logic in addAbsRefPrefix to support easy debugging...

3.0.0 September 04, 2013

- First 4.5.x-6.1.x release. Add new keywords: "fal" for access the file abstraction layer and "media" for the access to the media assets (respect LLL). Many code style compliance fixes.

2.1.14 May 14, 2013

- Fix image paths with more than one dot. Thanks Sebastian

2.1.13 February 05, 2013
- bugfix: missing class include in ux_tslib_content_ImageResource

2.1.12 January 23, 2013

- Bugfix: hashLength0 is possible now small code cleanups

2.1.11 August 28, 2012

- Add TCA crtl rootLevel 1, so the records arent listet by the orphan lowlevel cleaner.

2.1.10 July 10, 2012

- Fix configuration label and add a better error message, for the folder creation

2.1.9 July 03, 2012

- Move locallang and cleanup files.

2.1.8 June 07, 2012

- Add Xclass to all php classes 	 Download ZIP Archive

2.1.7 April 26, 2012

- Add stdWrap to params for cObj images. Thx Christian Hennecke 	 Download ZIP Archive

2.1.6 April 26, 2012

- stdWrap bug in the ImageResource XClass. Thx to Eric Chavaillaz

2.1.5 March 24, 2012

- Fix the cleanup scheduler task for deleteing duplicates. Fix the base class. No real image url is generate, if there is no base image 	 Download ZIP Archive

2.1.4 January 21, 2012

- fix lastImgResourceInfo check in ux_tslib_content_ImageResource

2.1.3 January 15, 2012

- Do not create symlinks to empty targets...

2.1.2 December 07, 2011

- Fix getDAMinfo. Thx to Victor

2.1.1 October 27, 2011

- First improvments for 4.6 - move IMG_RESOURCE logic to ux_tslib_content_ImageResource ...

2.1.0 October 14, 2011

- Attention! Reinclude the static extension template! Fix scheduler bug, structure changes, Fix stdWrap bug

2.0.9 May 24, 2011

- small bugfix

2.0.8 May 21, 2011

- Bugfixes, thanks to Krystian Szymukowicz, Felix Nagel, Attila Glck

2.0.7 May 07, 2011

- bugfixes thanks to Stefan Galinski and Tim LochmÃƒÂ¼ller

2.0.6 April 27, 2011

- some small bugfixes

2.0.5 April 26, 2011

- complete reprogramming the extension. Make it faster and cleaner.

2.0.4 March 29, 2011

- Update manual. Thx ronald

2.0.3 November 10, 2009

- small bugfix

2.0.2 October 27, 2009

- Some bugfix. Thanks to Mihovil Bubnjar

2.0.1 August 02, 2009
- small bugfix

2.0.0 July 21, 2009

- The new version is a big boost in speed and flexibility.

1.0.9 December 30, 2008

- Fix a bug in the getInfo4Image function releated to file_name and file_dl_name information. Thx Martin

1.0.8 December 10, 2008

- Change the xclass from TYPO3_MODE to 'FE' because the RealURL Images only needed for the frontend. This will also fix problems with commerce in the backend!

1.0.7 July 04, 2008

- Short Update. Set static image cache default = off 

1.0.6 June 26, 2008

- new: static file cache

1.0.5 May 05, 2008

- bugfix: minor issues.

1.0.4 April 28, 2008

- bugfix: class optimization

1.0.3 April 22, 2008

- bugfix: small bugfixes
- bugfix: Optimization of the php classes
- new: optional switch of if no basis text is available
- new: fully configurable via TS
- new: Requested feature to exclude words and restrict the maximal length of a file name realised by giving stdWrap properties to fileText and altText

1.0.2 March 30, 2008

- bugfix: changing file names when cache is cleared or random file names depending on order of image view.
- bugfix: most file names came out as “pic-xx.jpg”
- bugfix: some minor problems
- change: update of manual
- change: major redesign of the extension class
- new: global configuration and for each IMAGE-Object individual
- new: if DAM is installed it will help to generate meaningful file names.
- new: meaningful file names much more often cause extended search for meaningful text to the image.
- new: file name and alt attribute will be generated according to a configurable hierarchy list.
- new: file name and alt attribute generation can be switched of and on independently.
- new: optional with hitting “clear fe cache” the Typo3 image file cache, or any files in “typo3temp” folder that are specified will be deleted also.

1.0.1 March 25, 2008

- bugfix: Fix Small Bug - BE Extensionsmanager;
- bugfix: Fix Bug: Max 250 char filenames;
- change: description

1.0.0 December 20, 2007

- bugfix: Stable release

0.1.4 December 11, 2007

- new: Add CacheControl Feature (must be enable in ext conf) to get a better performance.

0.1.3  November 23, 2007

- change: change one Label;
- change: Code cleanup (move functions to the main class);
- new: simulateStaticFolder

0.1.2  October 16, 2007

- bugfix: Small Bugfix for PHP5. Solve.... Fatal error: Cannot re-assign $this in class.tx_flrealurlimage.php on line 43

0.1.1  September 30, 2007

- new: Extension configuration Enable and disable the extension;
- new: Enable Clear Cache in BE-Admin and BE pages; Default im title, record sotrage, image delimiter
- new: Add Database field page_id for Page Cache Clear;
- change: TCA Upate (more info in the list view); Fix th

0.1.0 September 26, 2007

- change: RealURL is no longer a requirement; optimization of the class structure; change of the table name (attention all Updater ;-); Test with Perfect Lightbox;
- new: a TCA is written;
- change: more Coding Guides e.g. Tabs instead Spaces;
- new: Header Codes added to the Images;
- comment: no longer a Alpha Extension; more features in the next days;

0.0.6 March 26, 2007

- change: code cleaning,
- new: documentation,
- new: dependencies

0.0.5 February 07, 2007

- new: clear of table with “clear FE cache”

0.0.4 February 04, 2007

- new: the produced <img>-tag always contains an alternative text for the image

0.0.3

- new: if the altText for the image is not set, an altText is generated from the title of the page where the pic is on
- new: the IMAGE object now has a “fileName” attribute to set the file name for the realurl_image path

0.0.2 January 10, 2007

- bugfix: avoidance of complications when two different images use the same alternative text
- bugfix: avoidance of complications when the same image uses different alternative text

0.0.1

- new: altText or titleText of the image are used to generate a readable path for the image
- comment: initial release