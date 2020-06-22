# Instalacija

Pokretanje projekta je prilično jednostavno, zato što je upotrebljen **Homestead** koji koristi Vagrant za pravljenje virtuelne mašine. Više o Homestead-u na Laravelom [sajtu](https://laravel.com/docs/5.6/homestead#installation-and-setup).

Moguće je pokrenuti projekat na dva načina.

Prvi i jednostavniji način:

1. Pokrenuti `composer install`.
2. Napraviti tabelu u bazi.
3. Napraviti kopiju `.env.example` fajla, promeniti mu ime u `.env` i podesiti vrednosti.
4. Pokrenuti `php artisan migrate --seed`, kako bi pokrenuli migraciju i popunjavanje tabela.
5. Pokrenuti `php artisan key:generate` kako bi generisali kripto ključeve.
6. Pokrenuti `php artisan server` kako bi podigli projekat.
7. Pristupiti projektu preko `127.0.0.1:8000`.

Takođe projekat je moguće pokrenuti preko virtuelne mašine:

1. Pokrenuti `composer install`.
2. Napraviti kopiju `.env.example` fajla, i promeniti mu ime u `.env`.
3. Pokrenuti `vendor\\bin\\homestead make` , ovo će generisati Homestead instancu.
4. Izmeniti`Homestead.yaml ` fajl, postaviti željeni URL projekta
5. Izmeniti `hosts` fajl operativnog sistema, tako da URL projekta pokazuje na `192.168.10.10`.
6. Pokrenuti ``vagrant up` kako bi se pokrenula virtualna mašina.
7. Pokrenuti `vagrant ssh` kako bi pristupili mašini.
8. Pokrenuti `cd /vagrant` kako bi promenili direktorijum.
9. Pokrenuti `php artisan key:generate`.
10. Pokrenuti `php artisan storage:link`.
11. Pokrenuti `php artisan migrate --seed`, kako bi pokrenuli migraciju i popunjavanje tabela.
12. Pristupiti projektu preko podešenog URL-a.
