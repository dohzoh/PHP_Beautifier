@ECHO OFF
REM SET PHP="F:\local\php\php.exe"
REM SET BEAUTIFY=.\scripts\\php_beautifier
SET PHP="@php_bin@"
SET BEAUTIFY="@bin_dir@"\php_beautifier
%PHP% -d output_buffering=1 -f %BEAUTIFY% -- %1 %2 %3 %4 %5 %6 %7 %8 %9
@ECHO ON