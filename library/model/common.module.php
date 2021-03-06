<?php
/// Copyright (c) 2004-2012, Needlworks  / Tatter Network Foundation
/// All rights reserved. Licensed under the GPL.
/// See the GNU General Public License for more details. (/documents/LICENSE, /documents/COPYRIGHT)

/***** Modules *****/

/* Editor */
function getDefaultEditor() {
	global $editorMappings;
	reset($editorMappings);
	return Setting::getBlogSettingGlobal('defaultEditor', key($editorMappings));
}

function& getAllEditors() { global $editorMappings; return $editorMappings; }

function getEditorInfo($editor) {
	global $editorMappings, $configMappings, $pluginURL, $pluginName, $configVal;
	$context = Model_Context::getInstance();
	if (!isset($editorMappings[$editor])) {
		reset($editorMappings);
		$editor = key($editorMappings); // gives first declared (thought to be default) editor
	}
	if (isset($editorMappings[$editor]['plugin'])) {
		$pluginURL = $context->getProperty('service.path').'/plugins/'.$editorMappings[$editor]['plugin'];
		$pluginName = $editorMappings[$editor]['plugin'];
		if( !empty( $configMappings[$pluginName]['config'] ) )
			$configVal = getCurrentSetting($pluginName);
		else
			$configVal = null;
		include_once ROOT . "/plugins/{$editorMappings[$editor]['plugin']}/index.php";
	}
	return $editorMappings[$editor];
}


/* Formatter */
// default formatter functions.
function getDefaultFormatter() {
	global $formatterMappings;
	reset($formatterMappings);
	return Setting::getBlogSettingGlobal('defaultFormatter', key($formatterMappings));
}

function& getAllFormatters() { global $formatterMappings; return $formatterMappings; }
function getFormatterInfo($formatter) {
	global $formatterMappings;
	if (!isset($formatterMappings[$formatter])) {
		reset($formatterMappings);
		$formatter = key($formatterMappings); // gives first declared (thought to be default) formatter
	}
	if (isset($formatterMappings[$formatter]['plugin'])) {
		include_once ROOT . "/plugins/{$formatterMappings[$formatter]['plugin']}/index.php";
	}
	return $formatterMappings[$formatter];
}

function getEntryFormatterInfo($id) {
	static $info;
	$context = Model_Context::getInstance();
	$blogid = intval($context->getProperty('blog.id'));
	
	if (!Validator::id($id)) {
		return NULL;
	} else if (!isset($info[$blogid][$id])) {
		$context = Model_Context::getInstance();
		$pool = DBModel::getInstance();
		$pool->reset('Entries');
		$pool->setQualifier('blogid','equals',$blogid);
		$pool->setQualifier('id','equals',$id);
		$info[$blogid][$id] = $pool->getCell('contentformatter');
	}
	
	return $info[$blogid][$id];
}

function formatContent($blogid, $id, $content, $formatter, $keywords = array(), $useAbsolutePath = false) {
	$info = getFormatterInfo($formatter);
	$func = (isset($info['formatfunc']) ? $info['formatfunc'] : 'FM_default_format');
	return $func($blogid, $id, $content, $keywords, $useAbsolutePath);
}

function summarizeContent($blogid, $id, $content, $formatter, $keywords = array(), $useAbsolutePath = false) {
	$info = getFormatterInfo($formatter);
	$func = (isset($info['summaryfunc']) ? $info['summaryfunc'] : 'FM_default_summary');
	// summary function is responsible for shortening the content if needed
	return $func($blogid, $id, $content, $keywords, $useAbsolutePath);
}

function FM_default_format($blogid, $id, $content, $keywords = array(), $useAbsolutePath = false) {
	global $service, $hostURL;
	$basepath = ($useAbsolutePath ? $hostURL : '');
	return str_replace('[##_ATTACH_PATH_##]', "$basepath{$service['path']}/attach/$blogid", $content);
}

function FM_default_summary($blogid, $id, $content, $keywords = array(), $useAbsolutePath = false) {
	if (!$blog['publishWholeOnRSS']) $content = Utils_Unicode::lessen(removeAllTags(stripHTML($content)), 255);
	return $content;
}
?>
