php getsimbrief.php > temp.prn
./senddat.exe -t -b9600 temp.prn 192.168.178.212:9100
rm temp.prn