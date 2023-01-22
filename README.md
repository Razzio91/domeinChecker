

## Beroepstaak Software - Realiseren domein checker:

add een remote van deze git:

https://github.com/Razzio91/domeinChecker.git

Maak een database met de naam domainCheckResults in je command terminal (maak gebruik van mysql of mariadb).

Gebruik checkDomain.sql en importeer die in je command terminal.

Vervolgens zorg ervoor dat je de pad naar de directory als volgt navigeert: website/
Eenmaal in dit pad start je de symfony server op: symonfy serve -d of symfony server:start

klik op het linkje met je ip adres.

Op de website:

Type een of meer domeinnamen in en start een zoekopdracht.

Het resultaat moet de gezochte domeinnaam weergeven met beschikbaarheid en een whoIs link.

klik op de link voor whoIs informatie of klik op geschiedenis om je gezochte domeinnamen terug te vinden in de database.


Alle keys staan statisch in de .env files wegens security, mocht het nodig zijn zal ik kijken als er een alternatief aanwezig is (LET ME KNOW PLEASE). 


Zie voor instructies die ik moest volgen voor het opzetten van de LAMP server de volgende readme: 

Step 1: Git&API_Connection & SymfonySetup & VPS

## Beroepstaak Software - Realiseren toDo tool:

Maak een database met de naam toDo in je command terminal (maak gebruik van mysql of mariadb).

importeer de doit.sql in je command terminal

Voeg een item op de lijst toe:
php todo.php add-item "submit hours" "2022-08-23 12:00:00"

Lees een item(s) op de lijst:
php todo.php display (key)

Update een item status:

php todo.php update-item (id) "setDeadlineOnADateBeforeToday"

Verwijder item:
php todo.php remove 1


Zie voor instructies die ik moest volgen:
Step 2 Databases: MySQL & toDoTool
