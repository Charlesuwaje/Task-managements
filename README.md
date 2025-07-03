# 🧠 Team Task Manager API

This project is a RESTful backend API for managing tasks between Admins and Members.

## ✅ Features

-   Role-based Auth (Admin, Member)
-   Sanctum Token Authentication
-   Task CRUD (Admin), Status Update (Member)
-   Import tasks from Excel
-   Export tasks to Excel
-   Soft Delete (with Restore & Force Delete)
-   Clean MVC structure + Laravel standards

## 🔧 Setup Instructions

````bash
git clone https://github.com/Charlesuwaje/Task-managements.git

composer install

# Configure your DB in `.env`

php artisan migrate --seed

composer require maatwebsite/excel

php artisan serve
````
## Supported Module Commands

### Create controller in a module

```bash
php artisan make:controller TestController --module=user
````

### Create request in a module

```bash
php artisan make:request TestRequest --module=user
```

### Create event in a module

```bash
php artisan make:event TestEvent --module=user
```

### Create listener in a module

```bash
php artisan make:listener TestListener --module=user
```

### Create job in a module

```bash
php artisan make:job TestJob --module=user
```

### Create notification in a module

```bash
php artisan make:notification TestNotification --module=user
```

### Create mail in a module

```bash
php artisan make:mail TestMail --module=user
```

### Create resource in a module

```bash
php artisan make:resource TestResource --module=user
```
