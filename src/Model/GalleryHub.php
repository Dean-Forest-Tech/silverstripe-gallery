<?php

namespace ilateral\SilverStripe\Gallery\Model;

use Page;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DropdownField;
use ilateral\SilverStripe\Gallery\Control\GalleryHubController;
use ilateral\SilverStripe\Gallery\Helpers\GalleryHelper;
use SilverStripe\Core\Config\Config;
use SilverStripe\ORM\ArrayList;

/**
 * Generate a page that can display it's children as a grid of thumbnails
 * 
 * @package gallery
 */
class GalleryHub extends Page
{
    private static $description = 'Display child galleries as a thumbnail grid';

    private static $icon_class = 'font-icon-p-gallery';

    private static $table_name = "GalleryHub";

    private static $allowed_children = [
        GalleryPage::class,
    ];

    private static $db = [
        'ShowSideBar' => 'Boolean',
        'ShowImageTitles' => 'Boolean',
        'ThumbnailWidth' => 'Int',
        'ThumbnailHeight' => 'Int',
        'ThumbnailResizeType' => 'Varchar',
        'ThumbnailsPerPage' => 'Int',
        'PaddedImageBackground' => 'Varchar'
    ];

    public function getControllerName() {
        return GalleryHubController::class;
    }

    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function ($fields) {
            $fields->removeByName([
                "ShowSideBar",
                "ShowImageTitles",
                "ThumbnailWidth",
                "ThumbnailHeight",
                "ThumbnailResizeType",
                "ThumbnailsPerPage",
                "PaddedImageBackground"
            ]);
        });

        return parent::getCMSFields();
    }

    public function getSettingsFields()
    {
        $fields = parent::getSettingsFields();

        $adjust_methods = GalleryHelper::getAdjustmentMethods(true);

        $fields->addFieldsToTab(
            "Root.Settings",
            [
                CheckboxField::create('ShowSideBar'),
                CheckboxField::create('ShowImageTitles'),
                NumericField::create("ThumbnailWidth"),
                NumericField::create("ThumbnailHeight"),
                DropdownField::create("ThumbnailResizeType")
                    ->setSource($adjust_methods),
                NumericField::create('ThumbnailsPerPage'),
                TextField::create("PaddedImageBackground")
            ]
        );

        return $fields;
    }

    public function getThumbWidth(): int
    {
        $width = (int)$this->ThumbnailWidth;

        if ($width > 0) {
            return $width;
        }

        $default = Config::inst()->get(
            Gallery::class,
            'thumbnail_width'
        );

        return (int)$default;
    }

    public function getThumbHeight()
    {
        $height = (int)$this->ThumbnailHeight;

        if ($height > 0) {
            return $height;
        }

        $default = Config::inst()->get(
            Gallery::class,
            'thumbnail_height'
        );

        return (int)$default;
    }

    public function getThumbResize()
    {
        $type = $this->ThumbnailResizeType;

        if (!empty($type)) {
            return $type;
        }

        $default = Config::inst()->get(
            Gallery::class,
            'thumbnail_resize_method'
        );

        return $default;
    }

    public function getPadBackground()
    {
        $hex = $this->PaddedImageBackground;

        if (!empty($hex)) {
            return $hex;
        }

        $default = Config::inst()->get(
            Gallery::class,
            'thumbnail_padding_background'
        );

        return $default;
    }

    public function getPageLength()
    {
        $length = (int)$this->ThumbnailsPerPage;

        if ($length > 0) {
            return $length;
        }

        $default = Config::inst()->get(
            Gallery::class,
            'thumbnails_per_page'
        );

        return (int)$default;
    }
}
