<?php

namespace ilateral\SilverStripe\Gallery\Control;

use SilverStripe\Dev\Deprecation;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\ORM\FieldType\DBHTMLText;

class GalleryPageController extends GalleryHubController
{
    public function PaginatedImages()
    {
        return $this
            ->Gallery()
            ->PaginatedImages();
    }

    /**
     * Overwrite content and render gallery
     * embeded into content area
     *
     * @return DBHTMLText
     */
    public function getContent(): DBHTMLText
    {
        $gallery = $this->Gallery()->forTemplate();
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
     * Depreciated method, can now call a gallery directly
     * inside templates
     *
     * @return string
     */
    protected function getRenderedGallery(): string
    {
        Deprecation::notice('3.0');
        return $this->Gallery()->forTemplate();
    }
}
