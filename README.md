# Laravel Parents-Children Patch (Beginner-friendly)

This ZIP contains the custom application files (migrations, models, controllers, middleware, job, mail, routes, and blade views)
that you can add to a **fresh Laravel 10+ project** created locally (without Docker). It is *not* a full Laravel vendor bundle.

## Steps to setup (simple, local)

1. Install Composer and PHP (>=8.1), and a database (MySQL/Postgres).
2. Create a fresh Laravel project:

   ```bash
   composer create-project laravel/laravel parents_children_app
   cd parents_children_app
   ```

3. Copy the contents of this ZIP (`laravel_parents_children_patch`) into the project root, **merging** folders (do not overwrite `.env`, `composer.json`, `vendor/`).
   - On Linux/Mac you can run (from inside project root):
     ```bash
     unzip /path/to/laravel_parents_children_patch.zip -d .
     ```
4. Install any composer dependencies:
   ```bash
   composer install
   ```
5. Create `.env` or update `.env` with DB credentials and mail (Mailtrap recommended):
   ```
   APP_NAME=ParentsChildren
   APP_URL=http://localhost
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=parents_children
   DB_USERNAME=root
   DB_PASSWORD=secret

   MAIL_MAILER=smtp
   MAIL_HOST=smtp.mailtrap.io
   MAIL_PORT=2525
   MAIL_USERNAME=your_mailtrap_user
   MAIL_PASSWORD=your_mailtrap_pass
   MAIL_FROM_ADDRESS=admin@example.com
   MAIL_FROM_NAME="Admin"
   QUEUE_CONNECTION=database
   ```
6. Generate app key:
   ```bash
   php artisan key:generate
   ```
7. Create DB and run migrations:
   ```bash
   php artisan migrate
   php artisan queue:table
   php artisan migrate
   ```
8. Create storage symlink:
   ```bash
   php artisan storage:link
   ```
9. Create an admin user (example using tinker):
   ```bash
   php artisan tinker
   >>> \App\Models\User::create([
   >>> 'name'=>'Admin','email'=>'admin@example.com','password'=>bcrypt('password'), 'is_admin'=>true, 'profile_completed'=>false
   >>> ]);
   ```
10. Run the app:
   ```bash
   php artisan serve
   ```
   Visit http://127.0.0.1:8000/login

11. Run queue worker in another terminal (to deliver delayed emails):
   ```bash
   php artisan queue:work
   ```

## What's inside this patch
- migrations/ : migrations for parents, children, pivot, add profile fields to users
- app/Models/ : ParentModel.php, Child.php (and instructions to update User.php)
- app/Http/Controllers/ : AuthController, ProfileController, ParentController, ChildController
- app/Http/Middleware/ : EnsureProfileComplete.php
- app/Jobs/NotifyParentJob.php
- app/Mail/ChildLinkedMail.php and markdown email view
- resources/views/ : blade views (layout, auth/login, admin profile, parents and children CRUD)
- routes/web.php (replace or merge with your existing routes)

## Notes
- This is a patch intended to be copied into a fresh Laravel project. It avoids shipping the whole vendor or framework.
- If you prefer, I can instead provide **full file-by-file contents** in the chat for direct copy/paste.

Good luck — ask me if you get any errors while applying the patch and I'll help debug step-by-step.
