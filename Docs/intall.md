🚀 Laravel Developer Guide – Custospark/Custosell Edition
📦 1. Project Setup
✅ Requirements
PHP 8.2+

Composer 2.x

Laravel 12

MySQL 8+

Node.js + NPM

Redis (optional but recommended)

⚙️ Installation
bash
Copy
Edit
git clone <project-repo>
cd <project>
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install && npm run dev
🧠 2. Project Structure (High-Level)
Folder	Purpose
app/Models	Eloquent models
app/Http/Controllers	API logic lives here
app/Services	Business logic abstraction
app/Repositories	Data interaction abstraction
app/Traits	Shared reusable logic (like HasRoles, HasFiles, etc.)
routes/web.php	Web routes
routes/api.php	API routes
resources/views	Blade templates
resources/js	Vue/React/Vanilla frontend
database/migrations	DB schema
tests/	Test cases
📚 3. Key Packages You’ll See
🖼 Spatie Media Library (HasMedia, InteractsWithMedia)
Handles file uploads, conversions, storage, and retrieval.

bash
Copy
Edit
composer require spatie/laravel-medialibrary
php artisan vendor:publish --tag="media-library-config"
php
Copy
Edit
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Project extends Model implements HasMedia {
    use InteractsWithMedia;
}
🔍 Laravel Scout + Elasticsearch
Full-text searching, indexed with Elasticsearch.

bash
Copy
Edit
composer require laravel/scout
composer require elasticsearch/elasticsearch

php artisan vendor:publish --provider="Laravel\Scout\ScoutServiceProvider"
.env

env
Copy
Edit
SCOUT_DRIVER=elasticsearch
ELASTICSEARCH_HOST=localhost
🔐 Spatie Laravel-Permission
Handles roles and permissions easily.

bash
Copy
Edit
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate
php
Copy
Edit
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
    use HasRoles;
}
⚒️ 4. Developer Workflow
✅ Git Workflow
Use feature branches: feature/user-profile

Always pull before push: git pull origin main

Create meaningful commits.

🔁 Common Artisan Commands
bash
Copy
Edit
php artisan migrate
php artisan db:seed
php artisan make:model Project -mcr
php artisan queue:work
php artisan storage:link
🧪 Testing
bash
Copy
Edit
php artisan test
🧩 5. Tips for Working with AI-Generated Code
Don’t blindly copy-paste. Understand first.

Ask “why” when AI uses a package — then read the docs.

Refactor & organize AI code to match your app structure.

AI can scaffold fast — you bring the logic and architecture!

🚀 Want to Contribute?
Clone repo

Make a branch

Build something cool

Create a pull request

composer require maatwebsite/excel:^3.1 dompdf/dompdf:^2.0
composer require mpdf/mpdf
composer update
require_once __DIR__ . '/vendor/autoload.php';
use Mpdf\Mpdf;

$mpdf = new Mpdf();