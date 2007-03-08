<?php
/// Copyright (c) 2004-2007, Tatter & Company / Tatter & Friends.
/// All rights reserved. Licensed under the GPL.
/// See the GNU General Public License for more details. (/doc/LICENSE, /doc/COPYRIGHT)
define('ROOT', '../../../../../..');
$IV = array(
	'POST' => array(
		'group' => array('int', 0),
		'feed' => array('int', 0, 'default' => 0),
		'entry' => array('int', 0, 'default' => 0),
		'unread' => array(array('0', '1')),
		'starred' => array(array('0', '1')),
		'keyword' => array('string', 'default' => '')
	)
);
require ROOT . '/lib/includeForBlogOwner.php';
$result = array('error' => '0');
$entry = getFeedEntry($owner, $_POST['group'], $_POST['feed'], $_POST['entry'], $_POST['unread'] == '1', $_POST['starred'] == '1', $_POST['keyword'] == '' ? null : $_POST['keyword'], 'before', 'unread');
$result['id'] = $entry['id'];
printRespond($result);
?>