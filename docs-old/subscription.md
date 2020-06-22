# Pretplata

Korisnik ima opciju pretplate, svaki paket za pretpatu nudi određeni broj opcija. Kada se korisnik pretplati odmah dobija pristup svim opcijama. Na kraju isteka pretplate korisniku se opet skida novac sa unete kartice, ako korisnik nema novac biće skinut sa pretplate.

Trajanje pretplate je potpuno dinamički realizovano, administrator može da izabere da pretplata traje `n` dana, nedelja, meseci ili godina.

Zbog sigurnosnih razloga u bazi se ne čuvaju informacije o kreditnim karticama, već je sve realizovano neko [Stipe](https://stripe.com)-a

Način na koji je realizovan način plaćanja je preko [Laravel Cashier](https://laravel.com/docs/5.6/billing)-a.