<pre>
<?php

// Start Monitor
$mtime = microtime();
$mtime = explode(" ",$mtime);
$mtime = $mtime[1] + $mtime[0];
$starttime = $mtime; 

// Load Helper Function
require_once 'imagecreatefrombmpstring.php';

// Config
$item_icons_path = 'input/item/*.bmp';
$save_icons = 'output/icons/';
$item_images_path = 'input/collection/*.bmp';
$save_images = 'output/images/';

// Disable Script Execution Time Limit
set_time_limit(0);

// Parse idnum2itemresnametable.txt
$lines = file('idnum2itemresnametable.txt');
$file2idlist = array();
foreach ($lines as $line) {
	$line = trim($line);
	if (strlen($line)) {
		list($item_id, $file_name) = explode('#', $line);
		$file2idlist[] = array(
			'file'    => trim($file_name),
			'item_id' => intval($item_id)
		);
	}
}

// Function To Get ItemId From FileName
function GetItemId($file_name) {
	global $file2idlist;
	foreach ($file2idlist as $file2id) {
		if ($file2id['file'] == $file_name) {
			return $file2id['item_id'];
		}
	}
	return false;
}

// Process All Item Icons
$item_icons = glob($item_icons_path);
if (is_array($item_icons) && sizeof($item_icons))
{
	$done = 0;
	foreach ($item_icons as $item_icon)
	{
		list($file_name) = explode('.', basename($item_icon));
		$item_id = GetItemId($file_name);
		if ($item_id !== false)
		{
			$im = imagecreatefrombmpstring(file_get_contents($item_icon));
			imagepng($im, $save_icons.$item_id.'.png');
			imagedestroy($im);
			$done++;
		}
	}
	echo "Done Converting <strong>$done</strong> Icons\r\n";
}

// Process All Item Images
$item_images = glob($item_images_path);
if (is_array($item_images) && sizeof($item_images))
{
	$done = 0;
	foreach ($item_images as $item_image)
	{
		list($file_name) = explode('.', basename($item_image));
		$item_id = GetItemId($file_name);
		if ($item_id !== false)
		{
			$im = imagecreatefrombmpstring(file_get_contents($item_image));
			imagepng($im, $save_images.$item_id.'.png');
			imagedestroy($im);
			$done++;
		}
	}
	echo "Done Converting <strong>$done</strong> Images\r\n";
}

// End Monitor
$mtime = microtime();
$mtime = explode(" ",$mtime);
$mtime = $mtime[1] + $mtime[0];
$endtime = $mtime;
$totaltime = ($endtime - $starttime);
echo "<hr noshade size='1' />\r\n";
echo "Job copmpleted in <strong>". number_format($totaltime, 2) ."</strong> seconds.";

// Resource Clean-up
unset($lines); $lines = null;
unset($file2idlist); $file2idlist = null;
unset($item_icons); $item_icons = null;
unset($item_images); $item_images = null;