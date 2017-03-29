<?php

namespace ip\SlugifyNamer;

use Cocur\Slugify\Slugify;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\NamerInterface;

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

        $fileNameWithoutExtension = basename(
            $file->getClientOriginalName(),
            $fileExtension
        );

        $slugify = new Slugify();
        $slugifiedFileName = $slugify->slugify($fileNameWithoutExtension) . '.' . $fileExtension;

        return $slugifiedFileName;
    }
}