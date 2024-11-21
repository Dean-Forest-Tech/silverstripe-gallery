<?php

namespace DFT\SilverStripe\Gallery\Extensions;

use ilateral\SilverStripe\Gallery\Model\Gallery;
use SilverStripe\ORM\DataExtension;
use DFT\SilverStripe\Gallery\Model\Gallery;

class GalleryImageExtension extends DataExtension
{
    private static $belongs_many_many = [
        'Galleries' => Gallery::class . 'Images'
    ];
}
