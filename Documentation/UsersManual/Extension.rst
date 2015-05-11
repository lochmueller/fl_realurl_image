Option in the extension manager configuration
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

2) cacheControl (Default: 1)
Enable the Cache Control Feature to get a better performance. If a file has already been loaded by a client it wont be sent again. The browser cache is used. Speeds things up a lot and reduces server load.

3) linkStatic (Default: 1)
This option will create file links for the images. This will reduce server load dramatically as the files are “physically” available. Also loading time for the user is dramatically reduced.

4) virtualPathRemove (Default: empty)
This option removes a path segment from the image path. If you want to remove the “typo3tem/fl_realurl_image/” folder, just insert:
typo3temp/fl_realurl_image/
Notice, this option will only work if you redirect the now wrong image paths to the true path per .htaccess via RewriteEngine. To get the above example running, insert this lines in your .htaccess file:

.. code-block:: bash

   RewriteCond %{REQUEST_URI} !^/(fileadmin|typo3temp) [NC]
   RewriteCond %{REQUEST_URI} !^/typo3temp/fl_realurl_image [NC]
   RewriteCond %{REQUEST_URI} ^/[^/]+\.(gif|png|jpg|jpeg) [NC]
   RewriteRule (.+) /typo3temp/fl_realurl_image/$1 [L,NC,E=FLREALURL_REDIRECT:1]

And to stop the old typo3 images to be visable add one of this lines:

.. code-block:: bash

   # produce a 403 "forbiddden"  for fl_realurl_image protection
   RewriteRule ^(typo3temp|uploads)/.*\.(jpg|png|gif)$ - [F]
   # produce a 404 "not found"
   #RewriteRule ^(typo3temp|uploads)/.*\.(jpg|png|gif)$ not-found [L]
   # produce a 410 "gone"
   #RewriteRule ^(typo3temp|uploads)/.*\.(jpg|png|gif)$ - [G]

Best place to insert this lines in your .htaccess file is quite at the end just before the “# Stop rewrite processing if we are in the typo3/ directory” line.
