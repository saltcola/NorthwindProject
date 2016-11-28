@echo off

set "JAVA_DIR=%JAVA_HOME%"

if exist "%JAVA_DIR%\bin\javaw.exe" (
  set "LOCAL_JAVA=%JAVA_DIR%\bin\javaw.exe"
) else (
  set LOCAL_JAVA=javaw.exe
)

start %LOCAL_JAVA% -jar -Xmx256m "%~dp0\JSqlBeans.jar"