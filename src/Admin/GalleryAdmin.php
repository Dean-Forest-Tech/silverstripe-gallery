<?php

namespace DFT\SilverStripe\Gallery\Admin;

use DFT\SilverStripe\Gallery\Model\Gallery;
use ilateral\SilverStripe\ModelAdminPlus\ModelAdminPlus;

class GalleryAdmin extends ModelAdminPlus
{
    private static $managed_models = [
        Gallery::class
    ];

    private static $url_segment = 'galleries';

    private static $menu_title = 'Galleries';

    private static $menu_icon_class = 'font-icon-thumbnails';
}
