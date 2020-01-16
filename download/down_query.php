<?php


$path='malayam.txt';

header('Content-Type:application/octet-scream');
header('Content-Disposition:attachment;filename="leave_application.txt"');

header('Content-Length:'.filesize($path));

	readfile($path);




?>