<pre>
<?php

/*
 * Copyright (C) 2013 by Latheesan.
 * www.GuardianRO.com
 */

// Start Monitor
$mtime = microtime();
$mtime = explode(" ",$mtime);
$mtime = $mtime[1] + $mtime[0];
$starttime = $mtime; 

// Load Helper Function
require_once 'imagecreatefrombmpstring.php';

// Config
$input_item = 'input/item/';
$output_icons = 'output/icons/';
$input_collection = 'input/collection/';
$output_images = 'output/images/';

// Disable Script Execution Time Limit
set_time_limit(0);

// Parse idnum2itemresnametable.txt
$done_item_icon = 0;
$done_item_image = 0;
$lines = file('idnum2itemresnametable.txt');
foreach ($lines as $line)
{
	$line = trim($line);
	if (strlen($line))
	{
		// Parse Info
		list($item_id, $file_name) = explode('#', $line);
		$item_id = intval(trim($item_id));
		$file_name = trim($file_name);

		// Generate Item Icon
		$item_icon = $input_item.'/'.$file_name.'.bmp';
		if (file_exists($item_icon))
		{
			$im = imagecreatefrombmpstring(file_get_contents($item_icon));
			imagepng($im, $output_icons.$item_id.'.png');
			imagedestroy($im);
			$done_item_icon++;
		}

		// Generate Item Image
		$item_image = $input_collection.'/'.$file_name.'.bmp';
		if (file_exists($item_image))
		{
			$im = imagecreatefrombmpstring(file_get_contents($item_image));
			imagepng($im, $output_images.$item_id.'.png');
			imagedestroy($im);
			$done_item_image++;
		}
	}
}

// End Monitor
$mtime = microtime();
$mtime = explode(" ",$mtime);
$mtime = $mtime[1] + $mtime[0];
$endtime = $mtime;
$totaltime = ($endtime - $starttime);
echo "Done converting <strong>$done_item_icon</strong> Item Icons & <strong>$done_item_image</strong> Item Images.\r\n";
echo "Job copmpleted in <strong>". number_format($totaltime, 2) ."</strong> seconds.";

// Resource Clean-up
unset($lines); $lines = null;
unset($file2idlist); $file2idlist = null;
unset($item_icons); $item_icons = null;
unset($item_images); $item_images = null;

?>
</pre>