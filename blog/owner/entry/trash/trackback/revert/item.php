<?php
define('ROOT', '../../../../../..');

require ROOT . '/lib/includeForBlogOwner.php';

$isAjaxRequest = checkAjaxRequest();

if (revertTrackback($owner, $suri['id']) !== true)
	$isAjaxRequest ? respondResultPage(0) : header("Location: ".$_SERVER['HTTP_REFERER']);
else
	$isAjaxRequest ? respondResultPage(-1) : header("Location: ".$_SERVER['HTTP_REFERER']);
?>
