<?php

namespace ilateral\SilverStripe\Gallery\Model;

use SilverStripe\Dev\Deprecation;
use SilverStripe\Core\Config\Config;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\DropdownField;
use SilverShop\HasOneField\HasOneButtonField;
use Bummzack\SortableFile\Forms\SortableUploadField;
use SilverShop\HasOneField\GridFieldHasOneUnlinkButton;
use ilateral\SilverStripe\Gallery\Helpers\GalleryHelper;
use ilateral\SilverStripe\Gallery\Control\GalleryPageController;

/**
 * A single page that can display many images as thumbnails.
 * 
 * @property int ImageWidth
 * @property int ImageHeight
 * @property string ImageResizeType
 * 
 * @method Gallery Gallery
 */
class GalleryPage extends GalleryHub
{
    private static $description = 'Display a "gallery" of images';

    private static $icon_class = 'font-icon-p-gallery-alt';

    private static $table_name = "GalleryPage";

    private static $db = [
        'ImageWidth' => 'Int',
        'ImageHeight' => 'Int',
        'ImageResizeType' => 'Varchar'
    ];

    private static $has_one = [
        'Gallery' => Gallery::class
    ];

    private static $owns = [
        'Gallery'
    ];

    private static $cascade_deletes = [
        'Gallery'
    ];

    private static $defaults = [
        "ShowSideBar" => 1
    ];

    public function getControllerName() {
        return GalleryPageController::class;
    }

    /**
     * Is there a gallery embeded in the content area
     * rather than allowing it to render seperartly
     * 
     * @return bool
     */
    public function isGalleryEmbeded(): bool
    {
        return stristr($this->Content, '$Gallery');
    }

    public function Images()
    {
        Deprecation::notice('3.0');
        return $this->getImages();
    }

    public function getImages()
    {
        return $this->Gallery()->Images();
    }

    public function SortedImages()
    {
        return $this->Gallery()->getSortedImages();
    }

    public function getCMSFields()
    {
        $self =& $this;

        $this->beforeUpdateCMSFields(function ($fields) use ($self) {
            $fields->removeByName([
                "ImageWidth",
                "ImageHeight",
                "ImageResizeType"
            ]);

            if (!$self->canEdit()) {
                return;
            }

            $gallery = HasOneButtonField::create($this, 'Gallery');
            $gallery
                ->getConfig()
                ->removeComponentsByType(GridFieldHasOneUnlinkButton::class);

            $fields->insertBefore(
                'Content',
                $gallery
            );

            $fields->removeByName('HideDescription');
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
                NumericField::create("ImageWidth"),
                NumericField::create("ImageHeight"),
                DropdownField::create("ImageResizeType")
                    ->setSource($adjust_methods)
            ]
        );

        return $fields;
    }

    public function getFullWidth()
    {
        $width = (int)$this->ImageWidth;

        if ($width > 0) {
            return $width;
        }

        $default = Config::inst()->get(
            Gallery::class,
            'image_width'
        );

        return (int)$default;
    }

    public function getFullHeight()
    {
        $height = (int)$this->ImageHeight;

        if ($height > 0) {
            return $height;
        }

        $default = Config::inst()->get(
            Gallery::class,
            'image_height'
        );

        return (int)$default;
    }

    public function getFullResize()
    {
        $method = $this->ImageResizeType;

        if (!empty($method)) {
            return $method;
        }

        $default = Config::inst()->get(
            Gallery::class,
            'image_resize_method'
        );

        return $default;
    }

    public function onBeforeWrite()
    {
        parent::onBeforeWrite();

        // default settings (if not set)
        $defaults = $this->config()->defaults;
        $this->ImageWidth = ($this->getFullWidth()) ? $this->getFullWidth() : $defaults["ImageWidth"];
        $this->ImageHeight = ($this->getFullHeight()) ? $this->getFullHeight() : $defaults["ImageHeight"];
    
        if (!$this->Gallery()->exists()) {
            $gallery = Gallery::create([
                'Name' => $this->Title
            ]);
            $gallery->write();
            $this->GalleryID = $gallery->ID;
        } else {
            $this->Gallery()->Name = $this->Title;
            $this->Gallery()->write();
        }
    }
}
