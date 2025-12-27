Latvenergo E-veikala Prototips (Laravel 12)

Šis ir e-komercijas sistēmas prototips, kas izstrādāts, izmantojot jaunāko **Laravel 12** ietvaru. Projekts demonstrē darbu ar datubāzēm, modeļiem un kontrolieriem, nodrošinot pamata funkcionalitāti preču iegādei.

## Galvenās funkcijas
- **Produktu pārvaldība:** Iespēja apskatīt produktus un pievienot jaunus caur tīmekļa formu.
- **Noliktavas kontrole:** Sistēma automātiski pārbauda atlikumu pirms pasūtījuma veikšanas un neļauj nopirkt vairāk kā pieejams.
- **Datu integritāte:** Izmantotas datubāzes transakcijas (`DB::transaction`), nodrošinot, ka pasūtījums tiek izveidots tikai tad, ja noliktavas atlikums ir veiksmīgi samazināts.
- **Datu bāzes aizpilde:** Izveidots `ProductSeeder` ērtai testa datu ģenerēšanai.


## Uzstādīšana

1. Latvenergo E-veikala Prototips (Laravel 12)

Šis ir e-komercijas sistēmas prototips, kas izstrādāts, izmantojot jaunāko **Laravel 12** ietvaru. Projekts demonstrē darbu ar datubāzēm, modeļiem un kontrolieriem, nodrošinot pamata funkcionalitāti preču iegādei.

## Galvenās funkcijas
- **Produktu pārvaldība:** Iespēja apskatīt produktus un pievienot jaunus caur tīmekļa formu.
- **Noliktavas kontrole:** Sistēma automātiski pārbauda atlikumu pirms pasūtījuma veikšanas un neļauj nopirkt vairāk kā pieejams.
- **Datu integritāte:** Izmantotas datubāzes transakcijas (`DB::transaction`), nodrošinot, ka pasūtījums tiek izveidots tikai tad, ja noliktavas atlikums ir veiksmīgi samazināts.
- **Datu bāzes aizpilde:** Izveidots `ProductSeeder` ērtai testa datu ģenerēšanai.

## Noliktavas web servera prasības
- Composer
- GIT
- PHP 8.2+
- Laravel 12.x

## Uzstādīšana

1. Klonēt projektu mapē kurā glabāsies projekt faili:
   Ar CMD aizejam uz mapi kurā tiks izvietoti prototipa faili (piemēram C:/projekti).
   Kad mape atvērta tajā izpildam komandas ar CMD vai termināli
   git clone https://github.com/OtomarsZ/latvenergo.git
   cd latvenergo

2. Laravel faili netiek glabāti Gitā, tāpēc tie ir jāuzstāda no jauna ar komandu:
   composer install

3. Konfigurācijas faila (.env) izveide:
    copy .env.example .env

4. Noģenerējam unikālu aplikācijas atslēgu:
    php artisan key:generate

5. Tabulu izveide un parauga datu "iebarošana" tajā (Seeder):
    php artisan migrate --seed

6. Pārbaudam vai .env failā parametri SESSION_DRIVER=file un CACHE_STORE=file
    
7. Kad visas komandas izpildītas tad mēs proojektu varam palaist ar komandu:
   php artisan serve
