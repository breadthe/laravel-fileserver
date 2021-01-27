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

## Troubleshooting

### Failed to load resource: net::ERR_CONNECTION_CLOSED

The initial (temporary) file upload request to `upload-file` times out with a `HTTP Error 401 Unauthorized` in the developer console.

**Explanation:** The Livewire request is invalidated before the file finishes uploading. 

**Solution:** Increase `max_upload_time` in `config/livewire.php`. By default, it is set to 5 minutes. It should suffice, but depending on the size of your uploads, and your connection speed, it might not be enough. 

## License

FileServer is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
