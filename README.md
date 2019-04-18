# fablabSimple
Project is done for NU ABC Fablab for free for anyone to use and with ability to update/upgrade

## Arduino
The code lies in a */ARDUINO CODE* folder. The *setup* inits display, dhcp and the rc522. The loop, searches for compatable RFID Magic Card and reads out its unique identity number with 2kHz beep and turns *status* LED on. The ID then gets displayed on the display and send to a server as a POST request. If the servers replyes with "Success", green LED gets on and 3kHz beep is produced.

## Server side
The server stores all user data but no passwords. The stored data is not secured, but can be, on request from clients.

## Pseudo MVC
Done just on .htaccess file with simple route via index.php. Models are stored in /api and return both JSON and php object depending on argument (obj by default). /pages stores all the usefull views. The are no actual controllers, but there are some main files that exists on every page (like config and helpers).

## Issues
* Sometimes it is hard to track origin of the function and you have to dig though the /api files.
