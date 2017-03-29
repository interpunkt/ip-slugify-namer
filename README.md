ip/slugify-namer
=============

> Namer for the VichUploaderBundle which slugifies the filename of the uploaded file

Installation
------------

You can install SlugifyNamer through [Composer](https://getcomposer.org):

```shell
$ composer require ip/slugify-namer
```

To use it in a Symfony2 project add it as a service in services.yml:
```
services:
...
    ip.slugify_namer:
          class: ip\SlugifyNamer\SlugifyNamer
```

Then add the service to your VichUploader mapping in config.yml
```
vich_uploader:
    ...
    mappings:
        example_upload:
            uri_prefix:         /upload/directory/
            upload_destination: %kernel.root_dir%/../web/upload/directory
            namer:              ip.slugify_namer
    ...
```