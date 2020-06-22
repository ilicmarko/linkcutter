# Rešenje

Način na koji je problem rešen je prilično jednostavan. Uzme se originalan link i za njega se korisniku da neki *heš*, koji korisnik kasnije može da podeli. Otvaranjem *heš* linka korisnik će biti preusmeren (redirektovan) na originalan link.

![tok generator](images\solution_flow.png)

**Link generator** treba da ima što manje kolizija (istih vrednosti), takođe to NE treba da bude hash funkcija koja će za isti string da vrati isti heš, već za isti string treba da vrati uvek različiti heš.

Prilikom pisanja ovog generatora treba obratiti pažnju na brzinu generisanja stringa. Postoji više načina da se reši ovaj problem i oni su opisani u nastavku.

## Spor i siguran način

Ovaj način koristi funkcije koje generišu kriptografski sigurne vrednosti ([CSPRNG](https://en.wikipedia.org/wiki/Cryptographically_secure_pseudorandom_number_generator)). Ovakva funkcija u PHP-u je `random_int()`.

Random int ima drugačiju implementaciju na svakom operativnom sistemu i time pruža mogućnost da se iskoristi sistem za generisanje jedinstvenog broja.

Velika mana ove funkcije je što je vidljivo spora.

## Brz i nesiguran način

Za razliku od `random_int()` funckije, `rand()` je dosta brža funkcija, ali nije kriptografski sigurna i u našem slučaju ima česta ponavljanja. Zato je potreban treći način.

## Najbrži i siguran način

U trenutku pisanja, PHP verzija *7.2.6* ima tri CSPRNG funkcije, od kojih je jedna već prethodno pomenuta, i pokazala se kao spora, ali funkcija koja pokazuje bolje performanse od nje je `random_bytes()`.

`random_bytes()` funkcija, takođe, ima zasebnu implementaciju za svaki operativni sistem, ali zbog toga što radi direktno sa bajtovima dosta je brža, pa čak i od `rand()`.

**Napomena: Funkcija ``random_bytes() ` dolazi uz PHP 7.0 pa na gore.

## Statistika

Rezultati testiranja navedenih funkcija se nalaze u tabeli ispod.

| Ponavljanja         | random_bytes    | rand            |
| ---------------------- | --------------- | --------------- |
| Korak 1                | 1.7273991107941 | 5.7265629768372 |
| Korak 2                | 1.8290400505066 | 5.5975389480591 |
| Korak 3                | 1.7188358306885 | 5.4669740200043 |
| Korak 4                | 1.8076210021973 | 5.666111946106  |
| Korak 5                | 1.796245098114  | 5.5624511241913 |
| Korak 6                | 1.8754560947418 | 5.5897090435028 |
| Korak 7                | 1.6866478919983 | 5.5180299282074 |
| Korak 8                | 1.7576761245728 | 5.5145440101624 |
| Korak 9                | 1.7203500270844 | 5.5683920383453 |
| Korak 10               | 1.682667016983  | 5.5527658462524 |

**Broj heševa po koraku:**  1 000 000