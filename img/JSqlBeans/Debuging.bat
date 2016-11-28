@echo off
ECHO THIS BATCH IS FOR DEBUGGING THE EXECUTABLE JAR ONLY
set "JAVA_DIR=%JAVA_HOME%"

if exist "%JAVA_DIR%\bin\java.exe" (
  set "LOCAL_JAVA=%JAVA_DIR%\bin\java.exe"
) else (
  set LOCAL_JAVA=java.exe
)

%LOCAL_JAVA% -jar "%~dp0\JSqlBeans.jar"