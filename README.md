# Hermes

> Index and archive all of your scanned paper documents.

I'm a mess at keeping paperwork tidy. I hate searching for papers.
This is an attempt to make my life easier and more organized.

Hermes is a [Laravel](https://laravel.com/) application that is currently in a very early development stage.
It only lists files from a Google Drive folder but future versions it may support other filesystems.

There is also an implementation to OCR the files but it's not fully functional.

## Installation

#### 1. Clone the repository

```bash
    git clone https://github.com/nckg/hermes.git
```

#### 2. Setup the database

Log in with the root account to configure the database.

    mysql -uroot -p

Create a database called 'hermes'.

    CREATE DATABASE hermes;

Create a user called 'hermes' and its password 'strongpassword'.

    CREATE USER 'hermes'@'localhost' IDENTIFIED BY 'strongpassword';

We have to authorize the new user on the `hermes` db so that he is allowed to change the database.

    GRANT ALL ON hermes.* TO 'hermes'@'localhost';

And finally we apply the changes and exit the database.

    FLUSH PRIVILEGES;
    exit

#### 3. Configure Hermes

`cd ~/hermes` then run these steps:

1. `cp .env.example .env` to create your own version of all the environment variables needed for the project to work.
2. Update `.env` to your specific needs. Don't forget to set `DB_USERNAME` and `DB_PASSWORD` with the settings used behind.
3. Create a Google Drive Client ID, Secret & Token - [How to enable Google Drive API](https://www.iperiusbackup.net/en/how-to-enable-google-drive-api-and-get-client-credentials/) - and set `GOOGLE_DRIVE_CLIENT_ID`, `GOOGLE_DRIVE_CLIENT_SECRET` & `GOOGLE_DRIVE_REFRESH_TOKEN`
4. Find your folder ID in Google Drive `https://drive.google.com/drive/u/0/folders/THIS_IS_YOUR_FOLDER_ID` and the `GOOGLE_DRIVE_FOLDER_ID`
5. Run `composer install --no-interaction --prefer-dist --no-suggest --optimize-autoloader --no-dev` to install all packages.
6. Run `php artisan key:generate` to generate an application key. This will set `APP_KEY` with the right value automatically.
7. Run `php artisan migrate` to run the migrations, seed the database and symlink folders.
8. Run `php artisan make:user YOUR_EMAIL`
9. Finally, Hermes requires some background processes to continuously run. To do this, setup a cron that runs every minute and triggers the following command `php artisan schedule:run`.

### Testing

``` bash
composer test
```

## Similar Projects

* [Paperless](https://github.com/danielquinn/paperless)
* [Mayan EDMS](https://mayan.readthedocs.org/en/latest/)
* [Open paperless](https://github.com/zhoubear/open-paperless)

## Colofon

## License

The MIT License (MIT).
