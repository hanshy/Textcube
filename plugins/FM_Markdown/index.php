<?php
// Markdown formatter for Textcube 1.6
// By Jeongkyu Shin. (inureyes@gmail.com)

if(!function_exists('Markdown')) require_once 'markdown.php';

function FM_Markdown_format($blogid, $id, $content, $keywords = array(), $useAbsolutePath = true, $bRssMode = false) {
	global $service;
	$path = __TEXTCUBE_ATTACH_DIR__."/$blogid";
	$url = "{$service['path']}/attach/$blogid";
	if(!function_exists('FM_TTML_bindAttachments')) { // To reduce the amount of loading code!
		require_once 'ttml.php';
	}
	$view = FM_TTML_bindAttachments($id, $path, $url, $content, $useAbsolutePath, $bRssMode);
	$view = Markdown($view, $id);
	$view = FM_TTML_bindTags($id, $view);
	return $view;
}

function FM_Markdown_summary($blogid, $id, $content, $keywords = array(), $useAbsolutePath = true) {
	global $blog;
	$view = FM_Markdown_format($blogid, $id, $content, $keywords, $useAbsolutePath, true);
    if (!$blog['publishWholeOnRSS']) $view = Utils_Unicode::lessen(removeAllTags(stripHTML($view)), 255);
		return $view;
}
?>
