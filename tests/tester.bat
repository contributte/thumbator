@echo off
%CD%\..\vendor\bin\tester.bat -w %CD%\Thumbator -s -j 40 -log %CD%\thumbator.log
rmdir %CD%\tmp /Q /S