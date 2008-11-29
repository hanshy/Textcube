<?php
/// Copyright (c) 2004-2008, Needlworks / Tatter Network Foundation
/// All rights reserved. Licensed under the GPL.
/// See the GNU General Public License for more details. (/doc/LICENSE, /doc/COPYRIGHT)

define('NO_SESSION', true);
define('__TEXTCUBE_LOGIN__',true);
require ROOT . '/library/preprocessor.php';
requireModel("blog.feed");
requireModel("blog.entry");

requireStrictBlogURL();
if (false) {
	fetchConfigVal();
}
publishEntries();
if (!file_exists(ROOT . "/cache/atom/$blogid.xml"))
	refreshFeed($blogid,'atom');
header('Content-Type: text/xml; charset=utf-8');
$fileHandle = fopen(ROOT . "/cache/atom/$blogid.xml", 'r+');
$result = fread($fileHandle, filesize(ROOT . "/cache/atom/$blogid.xml"));
fclose($fileHandle);
fireEvent('FeedOBStart');
echo fireEvent('ViewATOM', $result);
fireEvent('FeedOBEnd');
?>
