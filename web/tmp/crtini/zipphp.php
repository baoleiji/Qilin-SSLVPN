<?php
session_start();
exec("zip -q -r -D ".$_SESSION['ADMIN_USERNAME'].".zip ".$_SESSION['ADMIN_USERNAME']);
Header('Location: '.$_SESSION['ADMIN_USERNAME'].'.zip');
exit();
?>
