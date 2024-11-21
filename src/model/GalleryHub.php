<?php

namespace DFT\SilverStripe\Gallery\Model;

use Page;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DropdownField;
use DFT\SilverStripe\Gallery\Control\GalleryHubController;

/**
 * Generate a page that can display it's children as a grid of thumbnails
 * 
 * @package gallery
 */
class GalleryHub extends Page
{
    /**
     * sets the width to force thumbnails to
     * 
     * @var int
     * @config
     */
    private static $force_thumbnail_width = null;

    /**
     * sets the height to force thumbnails to
     *
     * @var int
     * @config
     */
    private static $force_thumbnail_height = null;

    /**
     * forces the resize type to a fixed type
     * options: crop, pad, ratio, width, height
     * 
     * @var string
     * @config
     */
    private static $force_thumbnail_resize_type = null;

    /**
     * @var string
     */
    private static $description = 'Display child galleries as a thumbnail grid';

    private static $icon = "resources/dft/silverstripe-gallery/client/dist/images/gallery-hub.png";

    private static $table_name = "GalleryHub";

    /**
     * @var array
     */
    private static $allowed_children = [
        GalleryPage::class,
    ];

    private static $db = [
        "ShowSideBar" => "Boolean",
        "ShowImageTitles" => "Boolean",
        "ThumbnailWidth" => "Int",
        "ThumbnailHeight" => "Int",
        "ThumbnailResizeType" => "Enum(array('crop','pad','ratio','width','height'), 'crop')",
        "PaddedImageBackground" => "Varchar",
        "ThumbnailsPerPage" => "Int"
    ];

    private static $defaults = [
        "ThumbnailWidth" => 150,
        "ThumbnailHeight" => 150,
        "ThumbnailsPerPage" => 18,
        "ThumbnailResizeType" => 'crop',
        "PaddedImageBackground" => "ffffff"
    ];

    public function getControllerName() {
        return GalleryHubController::class;
    }

    public function getCMSFields()
    {
        $self =& $this;
        $this->beforeUpdateCMSFields(function ($fields) use ($self) {
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
        $fwidth = $this->config()->get('force_thumbnail_width');
        $fheight = $this->config()->get('force_thumbnail_height');
        $fresize = $this->config()->get('force_thumbnail_resize_type');

        $new_fields = [
            CheckboxField::create('ShowSideBar'),
            CheckboxField::create('ShowImageTitles')
        ];

        if ($fwidth == null) {
            $new_fields[] = NumericField::create("ThumbnailWidth");
        }

        if ($fheight == null) {
            $new_fields[] = NumericField::create("ThumbnailHeight");
        }

        if ($fresize == null) {
            $new_fields[] = DropdownField::create("ThumbnailResizeType")
                ->setSource($this->dbObject("ThumbnailResizeType")->enumValues());
        }

        $new_fields[] = NumericField::create('ThumbnailsPerPage');
        $new_fields[] = TextField::create("PaddedImageBackground");

        $fields->addFieldsToTab(
            "Root.Settings",
            $new_fields
        );

        return $fields;
    }

    public function onBeforeWrite()
    {
        parent::onBeforeWrite();

        // default settings (if not set)
        $defaults = $this->config()->defaults;
        $this->ThumbnailWidth = ($this->getThumbWidth()) ? $this->getThumbWidth() : $defaults["ThumbnailWidth"];
        $this->ThumbnailHeight = ($this->getThumbHeight()) ? $this->getThumbHeight() : $defaults["ThumbnailHeight"];
        $this->ThumbnailsPerPage = ($this->ThumbnailsPerPage) ? $this->ThumbnailsPerPage : $defaults["ThumbnailsPerPage"];
        $this->PaddedImageBackground = ($this->PaddedImageBackground) ? $this->PaddedImageBackground : $defaults["PaddedImageBackground"];
    }

    public function getThumbWidth()
    {
        $forced = $this->config()->get('force_thumbnail_width');
        if ($forced != null) {
            return $forced;
        }

        return $this->ThumbnailWidth;
    }

    public function getThumbHeight()
    {
        $forced = $this->config()->get('force_thumbnail_height');
        if ($forced != null) {
            return $forced;
        }

        return $this->ThumbnailHeight;
    }

    public function getThumbResize()
    {
        $forced = $this->config()->get('force_thumbnail_resize_type');
        if ($forced != null) {
            return $forced;
        }

        return $this->ThumbnailResizeType;
    }
}
