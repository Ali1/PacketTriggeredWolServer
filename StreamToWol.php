<?php
echo "Starting PHP Wol on Stream\n";
$handle = fopen('php://stdin', 'r');
$lastWolTime = 0;
$mac = '60:45:cb:82:06:d0';
if ($handle) {
    while (($buffer = fgets($handle, 4096)) !== false) {
        echo $buffer;
	if ((time() - 10) > $lastWolTime) {
		exec("wakeonlan $mac");
		echo "==========\nWake on lan sent (ignoring stream for 10 seconds)\n==========\n";
		$lastWolTime = time();
	}
    }
    if (!feof($handle)) {
        echo "Error: unexpected fgets() fail\n";
    }
    fclose($handle);
}
