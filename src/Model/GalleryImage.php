<?php

namespace ilateral\SilverStripe\Gallery\Model;

use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;
use SilverStripe\Core\Config\Config;
use SilverStripe\Versioned\Versioned;
use ilateral\SilverStripe\Gallery\Helpers\GalleryHelper;

/**
 * @property int SortOrder
 * 
 * @method Image Image
 * @method Gallery Gallery
 */
class GalleryImage extends DataObject
{
    private static $table_name = 'GalleryImage';

    private static $db = [
        'SortOrder' => 'Int'
    ];

    private static $has_one = [
        'Image' => Image::class,
        'Gallery' => Gallery::class
    ];

    private static $default_sort = 'SortOrder';

    private static $extensions = [
        Versioned::class
    ];

    public function getThumbnailWidth()
    {
        $page = $this->Gallery()->Page();

        if ($page->exists()) {
            return $page->getThumbWidth();
        }

        return Config::inst()->get(
            Gallery::class,
            'thumbnail_width'
        );
    }

    public function getThumbnailHeight()
    {
        $page = $this->Gallery()->Page();

        if ($page->exists()) {
            return $page->getThumbHeight();
        }

        return Config::inst()->get(
            Gallery::class,
            'thumbnail_height'
        );
    }

    public function getThumbnailAdjust()
    {
        $page = $this->Gallery()->Page();

        if ($page->exists()) {
            return $page->getThumbResize();
        }

        return Config::inst()->get(
            Gallery::class,
            'thumbnail_resize_method'
        );
    }

    public function getThumbnailBackground()
    {
        $page = $this->Gallery()->Page();

        if ($page->exists()) {
            return $page->getPadBackground();
        }

        return Config::inst()->get(
            Gallery::class,
            'thumbnail_padding_background'
        );
    }

    public function getImageWidth()
    {
        $page = $this->Gallery()->Page();

        if ($page->exists()) {
            return $page->getFullWidth();
        }

        return Config::inst()->get(
            Gallery::class,
            'image_width'
        );
    }

    public function getImageHeight()
    {
        $page = $this->Gallery()->Page();

        if ($page->exists()) {
            return $page->getFullHeight();
        }

        return Config::inst()->get(
            Gallery::class,
            'image_height'
        );
    }

    public function getImageAdjust()
    {
        $page = $this->Gallery()->Page();

        if ($page->exists()) {
            return $page->getFullResize();
        }

        return Config::inst()->get(
            Gallery::class,
            'image_resize_method'
        );
    }

    public function getImageBackground()
    {
        $page = $this->Gallery()->Page();

        if ($page->exists()) {
            return $page->getPadBackground();
        }

        return Config::inst()->get(
            Gallery::class,
            'image_padding_background'
        );
    }

    public function getGalleryThumbnail()
    {
        $helper = GalleryHelper::create($this->Image())
            ->setWidth($this->getThumbnailWidth())
            ->setHeight($this->getThumbnailHeight())
            ->setAdjustMethod($this->getThumbnailAdjust())
            ->setBackground($this->getThumbnailBackground());

        return $helper->adjustImage();
    }

    public function getGalleryImage()
    {
        $helper = GalleryHelper::create($this->Image())
            ->setWidth($this->getImageWidth())
            ->setHeight($this->getImageHeight())
            ->setAdjustMethod($this->getImageAdjust())
            ->setBackground($this->getImageBackground());

        return $helper->adjustImage();
    }
}
