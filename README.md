# Video Gate
Media content manager and video player. 

![Screenshot_16](https://user-images.githubusercontent.com/796136/58380420-79c2d600-7fb9-11e9-8ede-5320c732480f.png)

## Requirements
* PHP 7.1+ (CLI)
* MbString
* FFMpeg

## Installation
To install download the repo content and run following sequence:

```
$ composer update
$ php app.php configure && ./vendor/bin/spiral get 
$ php app.php migrate:init && php app.php migrate && php app.php update
```

To run database migrations:


Configure the location of downloads directory (NSF and Samba drives are supported) by
copying `.env.sample` and setting `DOWNLOADS_DIR` value.

```dotenv
DOWNLOADS_DIR = /mnt/nas/video-downloads/
```

To start server:

``` 
$ ./spiral serve -v -d
```

You can access media catalog using `http://localhost:8080` (port can be changed in `.rr.yaml`).
Server will start indexation job of your downloads directory on first run. Refresh page
again to view the list of available videos.

License:
--------
MIT License (MIT). Please see [`LICENSE`](./LICENSE) for more information.
