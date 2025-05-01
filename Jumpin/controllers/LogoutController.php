<?php
session_start();
session_destroy();
header('Location: ../views/index.php?message=Logged out successfully');
exit();
?>