<?php
date_default_timezone_set('Asia/Shanghai');
require 'Zaly/ZalyApplication.php';

$application =  \Zaly\ZalyApplication::init();

$configs  = $application->getConfig();
$hostName = $configs['base']['host_name'];
$version  = $configs['base']['static_file_version'];

putenv("HOST_NAME=$hostName");
putenv("STATIC_VERSION=$version");

$application->run();
