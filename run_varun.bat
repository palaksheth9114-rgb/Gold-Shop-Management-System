@echo off
setlocal

REM Change to the directory of this script
cd /d "%~dp0"

REM Try with Python launcher (py) first
where py >nul 2>&1
if %errorlevel%==0 (
    echo Using Python launcher...
    py -3 -m pip install --upgrade pip pywebview >nul
    py -3 run.py
    goto :eof
)

REM Fall back to python
where python >nul 2>&1
if %errorlevel%==0 (
    echo Using python...
    python -m pip install --upgrade pip pywebview >nul
    python run.py
    goto :eof
)

echo Python not found. Please install Python 3 from https://www.python.org/ and try again.
pause

endlocal


