# FileServer

## About FileServer

FileServer is a free, open source, self-hosted Laravel application for uploading and serving your own files. It is intended to be hosted on a PHP/MySQL server or a VPS such as AWS EC2, Linode, DigitalOcean, Vultr, etc.

It uses the local disk for storage, with cloud providers to follow.

## Features

* Upload any type of file
* Download a file via a link that follows this pattern: `<server.url>/f/<uuid>/<original-file-name>` 
    * Copy the download link to the clipboard
* Delete files with confirmation
* Set file visibility to public (default) or private
* Private files can only be downloaded by the owner (when signed in)
* Track individual file download stats, including client IP 
* **WIP** Throttle downloads from the same IP
* **WIP** Block downloads for designated client IPs
* **WIP** Cloud storage providers
* **WIP** Upload to specific folders
* **WIP** Sorting, searching, and filtering of the file list

## Installation

```bash
# Clone the project
git clone https://github.com/breadthe/laravel-fileserver.git

cd laravel-fileserver

# Run Composer
composer install

# Create an .env file from the example
cp .env.example .env

# Generate the app key
php artisan key:generate
```

Configure the values in `.env` to match your setup. In particular, the following should be set:

```yaml
APP_NAME=
APP_ENV=production # or local if running locally
APP_DEBUG=false # false in production
APP_URL=

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

SESSION_LIFETIME= # how long should the user stay signed in, in minutes
```

```bash
# Run the database migrations
php artisan migrate

# (optional) Seed the database with a test user (email: test@example.com; password: password)
php artisan db:seed
```

## Extras

The project contains several packages in addition to the default Laravel installation. These packages help my with development, but if you wish to remove them, here's a list:

- [spatie/laravel-ray]()
- [barryvdh/laravel-debugbar]()

## Troubleshooting

### 413 Request Entity Too Large

You get this error when uploading a large file.

**Explanation:** The server is configured to accept a maximum file size lower than what you are trying to upload.

**Solution:**

If using `nginx`, edit the site configuration typically found in `/etc/nginx/sites-enabled/sub.domain.tld`, and either increase or add `client_max_body_size 64M;`. Mine looks like this:

```
root /home/webuser/sub.domain.tld/public;
client_max_body_size 200M;
```

Also adjust `post_max_size` and `upload_max_filesize` in your PHP config, typically found at `/etc/php/7.4/fpm/php.ini`, and/or `/etc/php/7.4/cli/php.ini`, accordingly.

```
post_max_size = 200M
...
upload_max_filesize = 200M
```

Then restart nginx & PHP:

```
sudo service php7.4-fpm restart
sudo service nginx restart
```

### Failed to load resource: net::ERR_CONNECTION_CLOSED

The initial (temporary) file upload request to `upload-file` times out with a `HTTP Error 401 Unauthorized` in the developer console.

**Explanation:** File upload limits on the server are configured too low, OR the Livewire request is invalidated before the file finishes uploading. 

**Solution 1:** Before trying the next 2 solutions, check out the issue above on `413 Request Entity Too Large`. 

**Solution 2:** Increase `max_upload_time` in `config/livewire.php`. By default, it is set to 5 minutes. It should suffice, but depending on the size of your uploads, and your connection speed, it might not be enough. 

**Solution 3:** The problem might be deeper than at first glance. [See this post](https://forum.laravel-livewire.com/t/file-upload-over-https-fails-signature-verification/1242) for more insight. You can try to comment out the `abort_unless(request()->hasValidSignature(), 401);` line in `vendor/livewire/livewire/src/Controllers/FileUploadHandler.php` to see if that helps.

## License

FileServer is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
