Latvenergo E-veikala Prototips (Laravel 12)

Šis ir e-komercijas sistēmas prototips, kas izstrādāts, izmantojot jaunāko **Laravel 12** ietvaru. Projekts demonstrē darbu ar datubāzēm, modeļiem un kontrolieriem, nodrošinot pamata funkcionalitāti preču iegādei.

## Galvenās funkcijas
- **Produktu pārvaldība:** Iespēja apskatīt produktus un pievienot jaunus caur tīmekļa formu.
- **Noliktavas kontrole:** Sistēma automātiski pārbauda atlikumu pirms pasūtījuma veikšanas un neļauj nopirkt vairāk kā pieejams.
- **Datu integritāte:** Izmantotas datubāzes transakcijas (`DB::transaction`), nodrošinot, ka pasūtījums tiek izveidots tikai tad, ja noliktavas atlikums ir veiksmīgi samazināts.
- **Datu bāzes aizpilde:** Izveidots `ProductSeeder` ērtai testa datu ģenerēšanai.

## Noliktavas web servera Tehnoloģijas
- PHP 8.2+
- Laravel 12.x
- MySQL

## Uzstādīšana

1. Klonēt projektu mapē kurā glabāsies projekt faili:
   Ar CMD aizejam uz mapi kurā tiks izvietoti prototipa faili (piemēram C:/projekti).
   Kad mape atvērta tajā izpildam komandas ar CMD vai termināli
   - git clone https://github.com/OtomarsZ/latvenergo.git
   - cd latvenergo

2. Laravel faili netiek glabāti Gitā, tāpēc tie ir jāuzstāda no jauna ar komandu:
   - composer install
    Tad ja noliktavas sistēma ir paredzēta slēktā tīklā bez piekļuves publiskaajam internetam, tad vietā kur pieeja ir izpildam komandu composer install --no-dev
un visus failus (mape vendor) iekopējam manuāli.

3. Konfigurācijas faila (.env) izveide
    - copy .env.example .env

4. Noģenerējam unikālu aplikācijas atslēgu:
    - php artisan key:generate

5. Izveidojm jaunu MySQL datubāzi un konfigurējam .env failu kas nodošinās projektam piekļuvi pie MySQL datubāzes (piemēram XAMPP ar MySQL datubāzi latvenergo_db).
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=latvenergo_db
    DB_USERNAME=root
    DB_PASSWORD=

6. Tabulu izveide un parauga datu "iebarošana" tajā (Seeder):
      - php artisan migrate --seed
     
7. Kad visas komandas izpildītas tad mēs proojektu varam palaist ar komandu:
   - php artisan serve

8. Tad ja mums seederis nav nostrādājis un nav redzami 3 piemēra pasūtāmie produkti, tad izpildam komandu:
   - php artisan db:seed --class=ProductSeeder
