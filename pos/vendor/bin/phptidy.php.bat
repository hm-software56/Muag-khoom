@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../cmrcx/phptidy/phptidy.php
php "%BIN_TARGET%" %*
