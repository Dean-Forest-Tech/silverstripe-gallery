<?php

namespace DFT\SilverStripe\Gallery\Control;

use PageController;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;
use SilverStripe\Dev\Deprecation;
use SilverStripe\ORM\PaginatedList;
use DFT\SilverStripe\Gallery\Helpers\GalleryHelper;

class GalleryHubController extends PageController
{
    /**
     * Get a custom list of children with resized gallery images
     * 
     * @return PaginatedList
     */
    public function PaginatedGalleries()
    {
        $children = $this->AllChildren();
        $limit = $this->ThumbnailsPerPage;
        $list = ArrayList::create();

        foreach ($children as $child) {
            $image = $child->SortedImages()->first();
            $child_data = $child->toMap();
            $child_data["Link"] = $child->Link();

            if (empty($image)) {
                $child_data["GalleryThumbnail"] = null;
            } else {
                $child_data["GalleryThumbnail"] = $this->generateGalleryThumbnail($image, true);
            }

            $list->add(ArrayData::create($child_data));
        }

        $pages = PaginatedList::create($list, $this->getRequest());
        $pages->setPageLength($limit);

        return $pages;
    }

    protected function generateGalleryThumbnail(Image $image)
    {
        $width = $this->getThumbWidth();
        $height = $this->getThumbHeight();
        $adjust_method = $this->getThumbResize();
        $background = $this->getPadBackground();

        $helper = GalleryHelper::create($image)
            ->setWidth($width)
            ->setHeight($height)
            ->setAdjustMethod($adjust_method)
            ->setBackground($background);

        return $helper->adjustImage();
    }

    /**
     * Generate an image based on the provided type
     * (either )
     */
    protected function ScaledImage(Image $image, $thumbnail = false)
    {
        Deprecation::notice('3.0');

        if ($thumbnail == true) {
            return $this->generateGalleryThumbnail($image);
        }

        $img = false;
        $background = $this->PaddedImageBackground;
        $resize_type = $this->getFullResize();
        $width = $this->getFullWidth();
        $height = $this->getFullHeight();

        switch ($resize_type) {
            case 'crop':
                $img = $image->Fill($width,$height);
                break;
            case 'pad':
                $img = $image->Pad($width,$height,$background);
                break;
            case 'ratio':
                $img = $image->Fit($width,$height);
                break;
            case 'width':
                $img = $image->ScaleWidth($width);
                break;
            case 'height':
                $img = $image->ScaleHeight($height);
                break;
        }

        $this->extend("augmentImageResize", $image, $thumbnail, $img);

        return $img;
    }
}
