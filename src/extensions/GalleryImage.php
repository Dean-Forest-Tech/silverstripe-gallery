<?php

namespace DFT\SilverStripe\Gallery\Extensions;

use SilverStripe\ORM\DataExtension;
use DFT\SilverStripe\Gallery\Model\GalleryPage;

class GalleryImage extends DataExtension
{
    private static $belongs_many_many = [
        'Gallery'   => GalleryPage::class
    ];
}
