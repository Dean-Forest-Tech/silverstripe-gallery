<?php

namespace DFT\SilverStripe\Gallery\Model;

use Page;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\TextField;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\FieldType\DBHTMLText;
use Bummzack\SortableFile\Forms\SortableUploadField;
use DFT\SilverStripe\Gallery\Control\GalleryPageController;

/**
 * A single page that can display many images as thumbnails.
 * 
 * @package gallery
 */
class GalleryPage extends GalleryHub
{
    /**
     * sets the width to force full images to
     * 
     * @var int
     * @config
     */
    private static $force_image_width = null;

    /**
     * sets the height to force full images to
     *
     * @var int
     * @config
     */
    private static $force_image_height = null;

    /**
     * forces the resize type to a fixed type
     * options: crop, pad, ratio, width, height
     * 
     * @var string
     * @config
     */
    private static $force_image_resize_type = null;

    /**
     * @var string
     */
    private static $description = 'Display a "gallery" of images';

    private static $icon = "resources/dft/silverstripe-gallery/client/dist/images/gallery.png";

    private static $table_name = "GalleryPage";

    private static $db = [
        "ImageWidth" => "Int",
        "ImageHeight" => "Int",
        "ImageResizeType" => "Enum(array('crop','pad','ratio','width','height'), 'ratio')"
    ];

    private static $defaults = [
        "ImageWidth" => 950,
        "ImageHeight" => 500,
        "ImageResizeType" => 'ratio',
        "ShowSideBar" => 1
    ];

    private static $many_many = [
        'Images' => Image::class
    ];

    private static $many_many_extraFields = [
        'Images' => ['SortOrder' => 'Int']
    ];

    private static $owns = [
        'Images'
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

    /**
     * Return sorted images
     *
     * @return SSList
     */
    public function SortedImages()
    {
        return $this->Images()->Sort('SortOrder');
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
            
            $fields->removeByName('HideDescription');
            
            $upload_folder = Controller::join_links(
                "gallery",
                $self->ID
            );
            
            $fields->addFieldToTab(
                "Root.Gallery",
                SortableUploadField::create(
                    'Images',
                    $this->fieldLabel('Images')
                )->setFolderName($upload_folder)
            );
        });
            
        return parent::getCMSFields();
    }

    public function getSettingsFields() {
        $fields = parent::getSettingsFields();
        $fwidth = $this->config()->get('force_image_width');
        $fheight = $this->config()->get('force_image_height');
        $fresize = $this->config()->get('force_image_resize_type');

        $new_fields = [];

        if ($fwidth == null) {
            $new_fields[] = NumericField::create("ImageWidth");
        }
        if ($fheight == null) {
            $new_fields[] = NumericField::create("ImageHeight");
        }
        if ($fresize == null) {
            $new_fields[] = DropdownField::create("ImageResizeType")
                ->setSource($this->dbObject("ImageResizeType")->enumValues());
        }

        $fields->addFieldsToTab(
            'Root.Settings',
            $new_fields
        );

        return $fields;
    }

    public function onBeforeWrite()
    {
        parent::onBeforeWrite();

        // default settings (if not set)
        $defaults = $this->config()->defaults;
        $this->ImageWidth = ($this->getFullWidth()) ? $this->getFullWidth() : $defaults["ImageWidth"];
        $this->ImageHeight = ($this->getFullHeight()) ? $this->getFullHeight() : $defaults["ImageHeight"];
    }

    public function getFullWidth()
    {
        $forced = $this->config()->get('force_image_width');
        if ($forced != null) {
            return $forced;
        }

        return $this->ImageWidth;
    }

    public function getFullHeight()
    {
        $forced = $this->config()->get('force_image_height');
        if ($forced != null) {
            return $forced;
        }

        return $this->ImageHeight;
    }

    public function getFullResize()
    {
        $forced = $this->config()->get('force_image_resize_type');
        if ($forced != null) {
            return $forced;
        }

        return $this->ImageResizeType;
    }

}
