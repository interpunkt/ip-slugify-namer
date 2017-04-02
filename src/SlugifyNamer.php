<?php

namespace Ip\SlugifyNamer;

use Cocur\Slugify\Slugify;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\NamerInterface;
use Vich\UploaderBundle\Naming\UniqidNamer;

class SlugifyNamer implements NamerInterface
{
    /**
     * Creates a name for the file being uploaded.
     *
     * @param object $object The object the upload is attached to.
     * @param PropertyMapping $mapping The mapping to use to manipulate the given object.
     *
     * @return string The file name.
     */
    public function name($object, PropertyMapping $mapping)
    {
        $file = $mapping->getFile($object);
        $fileExtension = $file->getClientOriginalExtension();
        $uploadDestination = $mapping->getUploadDestination();

        $fileNameWithoutExtension = basename(
            $file->getClientOriginalName(),
            $fileExtension
        );

        $slugify = new Slugify();
        $slugifiedFileNameWithoutExtension = $slugify->slugify($fileNameWithoutExtension);
        $slugifiedFileName = $slugifiedFileNameWithoutExtension . '.' . $fileExtension;

        // return slugified file name, if the file doesn't exist yet
        if (!file_exists($uploadDestination . DIRECTORY_SEPARATOR . $slugifiedFileName)) {
            return $slugifiedFileName;
        }

        // try to add a counter up to 100 to the filename and check if it already exists
        for ($i = 1; $i <= 100; ++$i) {
            $fileNameWithCounter = $slugifiedFileNameWithoutExtension . "_$i." . $fileExtension;

            if (!file_exists($fileNameWithCounter)) {
                return $fileNameWithCounter;
            }
        }

        // fallback to Vich Uploader unique id namer
        $vichUniqidNamer = new UniqidNamer();

        return $vichUniqidNamer->name($object, $mapping);
    }
}