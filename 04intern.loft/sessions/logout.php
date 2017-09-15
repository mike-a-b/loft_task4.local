<?php

session_start();

session_destroy();
setcookie(session_name(), '');

header("HTTP/1.1 307 Temporary Redirect");
header("Location: advance.php");
exit;