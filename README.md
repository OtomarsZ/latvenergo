# Latvenergo E-veikala Prototips (Laravel 12)

Šis ir e-komercijas sistēmas prototips, kas izstrādāts, izmantojot jaunāko **Laravel 12** ietvaru. Projekts demonstrē darbu ar datubāzēm, modeļiem un kontrolieriem, nodrošinot pamata funkcionalitāti preču iegādei.

## Galvenās funkcijas
- **Produktu pārvaldība:** Iespēja apskatīt produktus un pievienot jaunus caur tīmekļa formu.
- **Noliktavas kontrole:** Sistēma automātiski pārbauda atlikumu pirms pasūtījuma veikšanas un neļauj nopirkt vairāk kā pieejams.
- **Datu integritāte:** Izmantotas datubāzes transakcijas (`DB::transaction`), nodrošinot, ka pasūtījums tiek izveidots tikai tad, ja noliktavas atlikums ir veiksmīgi samazināts.
- **Datu bāzes aizpilde:** Izveidots `ProductSeeder` ērtai testa datu ģenerēšanai.

## Tehnoloģijas
- PHP 8.2+
- **Laravel 12.x**
- MySQL
- Tailwind CSS (frontend dizainam)

## Uzstādīšana

1. **Klonēt projektu:**
   git clone https://github.com/OtomarsZ/latvenergo.git
   cd latvenergo