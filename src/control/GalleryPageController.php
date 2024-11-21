<?php

namespace DFT\SilverStripe\Gallery\Control;

use SilverStripe\Assets\Image;
use SilverStripe\Dev\Deprecation;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;
use SilverStripe\ORM\PaginatedList;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\ORM\FieldType\DBHTMLText;

class GalleryPageController extends GalleryHubController
{
    private static $casting = [
        'Gallery' => 'HTMLText'
    ];

    protected function GalleryImage(Image $image)
    {
        return $this->ScaledImage($image);
    }

    protected function GalleryThumbnail(Image $image)
    {
        return $this->ScaledImage($image, true);
    }

    public function init() {
        parent::init();
    }

    public function PaginatedImages()
    {
        $list = $this->SortedImages();
        $limit = $this->ThumbnailsPerPage;

        $pages = PaginatedList::create($list, $this->getRequest());
        $pages->setpageLength($limit);

        return $pages;
    }

    /**
     * Overwrite content and render gallery
     * embeded into content area
     *
     * @return DBHTMLText
     */
    public function getContent(): DBHTMLText
    {
        $gallery = $this->getRenderedGallery();
        $embeded = $this->isGalleryEmbeded();
        $content = $this->dbObject('Content');

        if ($embeded && !empty($gallery)) {
            /** @see Requirements_Backend::escapeReplacement */
            $galleryEscapedForRegex = addcslashes($gallery, '\\$');
            $content = preg_replace(
                '/(<p[^>]*>)?\\$Gallery(<\\/p>)?/i',
                $galleryEscapedForRegex,
                $content
            );
        }

        return DBField::create_field(
            'HTMLText',
            $content
        );
    }

    /**
     * Render an image gallery from the Gallery template,
     * if no images are available, then return an empty string.
     *
     * @return string
     */
    protected function getRenderedGallery(): string
    {
        if ($this->Images()->exists()) {

            // Create a list of images with generated gallery image and thumbnail
            $images = ArrayList::create();
            $pages = $this->PaginatedImages();
            foreach ($this->PaginatedImages() as $image) {
                $image_data = $image->toMap();
                $image_data["GalleryImage"] = $this->GalleryImage($image);
                $image_data["GalleryThumbnail"] = $this->GalleryThumbnail($image);
                $images->add(ArrayData::create($image_data));
            }
            
            $vars = [
                'PaginatedImages' => $pages,
                'Images' => $images,
                'Width' => $this->getFullWidth(),
                'Height' => $this->getFullHeight()
            ];

            return $this->renderWith(
                [
                    'Gallery',
                    'DFT\SilverStripe\Gallery\Includes\Gallery'
                ],
                $vars
            );
        } else {
            return "";
        }
    }

    /**
     * Generate an image gallery from the Gallery template, if no images are
     * available, then return an empty string.
     *
     * @return string
     */
    public function getGallery(): string
    {
        $embeded = $this->isGalleryEmbeded();

        if ($embeded === false && $this->Images()->exists()) {
            return $this->getRenderedGallery();
        } else {
            return "";
        }
    }

    public function Gallery()
    {
        return $this->getGallery();
    }
}
