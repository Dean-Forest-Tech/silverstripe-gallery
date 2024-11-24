<?php

namespace DFT\SilverStripe\Gallery\Extensions;

use DFT\SilverStripe\Gallery\Model\Gallery;
use SilverStripe\ORM\DataExtension;

class GalleryImageExtension extends DataExtension
{
    private static $belongs_many_many = [
        'Galleries' => Gallery::class . 'Images'
    ];
}
