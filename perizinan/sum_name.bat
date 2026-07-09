@echo off
setlocal EnableExtensions EnableDelayedExpansion
rem === SUM UKURAN FOLDER BERDASARKAN NAMA (ANY DEPTH), UNIT: MB ===

rem Loop semua subfolder (rekursif)
for /r /d %%D in (*) do (
  rem Ambil total bytes folder itu via DIR summary
  for /f "tokens=3" %%S in ('dir /s /-c "%%D" ^| find "File(s)"') do (
    set "name=%%~nxD"
    rem Sanitisasi nama utk dipakai sebagai nama variabel
    set "key=!name: =_!"
    set "key=!key:.=_!"
    set "key=!key:(=_!"
    set "key=!key:)=_!"
    set "key=!key:&=_!"
    rem Konversi ke MB biar nggak overflow 32-bit
    set /a mb=%%S/1048576
    set /a SUM_!key!+=!mb!
  )
)

echo Name,SizeMB
for /f "tokens=1,2 delims==" %%A in ('set SUM_') do (
  set "n=%%A"
  set "n=!n:~4!"  rem buang prefix "SUM_"
  echo !n!,%%B
)
endlocal
