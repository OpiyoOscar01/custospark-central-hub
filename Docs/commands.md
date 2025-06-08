To use HasMedia and InteractsWithMedia, you need to install Spatie Media Library — a powerful Laravel package for handling file uploads, associations, conversions, and more.

✅ Step-by-step Installation:
Install the package via Composer:


composer require spatie/laravel-medialibrary
Publish the configuration file:


php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="config"
Publish the migration and run it:

bash
Copy
Edit
php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="migrations"
php artisan migrate
In your model (like Project.php), make sure it looks like this:

php
Copy
Edit
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Project extends Model implements HasMedia
{
    use InteractsWithMedia;

    // your model logic
}
✅ HasMedia is an interface — it makes sure your model is "media aware".
✅ InteractsWithMedia is the trait that gives your model all the media-related methods.



 Solution: Install Laravel Scout
Run the following command to install Laravel Scout (compatible with Laravel 12):

bash
Copy
Edit
composer require laravel/scout
Once installed, Laravel will be able to resolve Laravel\Scout\Searchable.

🧠 Pro Tips After Installing
Optional: Publish the config

bash
Copy
Edit
php artisan vendor:publish --provider="Laravel\Scout\ScoutServiceProvider"
Choose a Driver
Scout supports several drivers: Algolia, Meilisearch, Elasticsearch, Database, etc.

If you're using Elasticsearch, make sure it's installed:


composer require elasticsearch/elasticsearch
Then update your .env:


SCOUT_DRIVER=elastic
ELASTICSEARCH_HOST=localhost:9200
Or for database driver (simple and local):


SCOUT_DRIVER=database
Then publish the migrations (for searchable models):


php artisan scout:table "App\\Models\\Project"
php artisan migrate
✅ Final Check
After installing, this line in your model should now work fine:

use Laravel\Scout\Searchable;