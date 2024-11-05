<?php
session_start();
session_destroy();
header('Location: ../../pages/shared/login.php');
exit();