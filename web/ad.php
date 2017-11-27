<?php
echo $url = "http://localhost/dep3/admin.php?controller=admin_config&action=synchronization_ad_users&id=".$argv[1];
$c=@file_get_contents($url);
echo $c;
?>
