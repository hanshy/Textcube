<?
define('ROOT', '../../../..');
require ROOT . '/lib/includeForOwner.php';
$entry['id'] = $suri['id'];
$entry['draft'] = 1;
$entry['visibility'] = $_POST['visibility'];
$entry['category'] = empty($_POST['category']) ? 0 : $_POST['category'];
$entry['title'] = $_POST['title'];
$entry['content'] = $_POST['content'];
$entry['location'] = empty($_POST['location']) ? '/' : $_POST['location'];
$entry['tag'] = empty($_POST['tag']) ? '' : $_POST['tag'];
$entry['acceptComment'] = empty($_POST['acceptComment']) ? 0 : 1;
$entry['acceptTrackback'] = empty($_POST['acceptTrackback']) ? 0 : 1;
$entry['published'] = empty($_POST['published']) ? 0 : $_POST['published'];
if (saveDraftEntry($entry) !== false)
	respondResultPage(0);
else
	respondResultPage(1);
?>