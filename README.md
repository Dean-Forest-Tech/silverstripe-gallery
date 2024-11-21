# Silverstripe Image Gallery

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/i-lateral/silverstripe-gallery/badges/quality-score.png?b=2)](https://scrutinizer-ci.com/g/i-lateral/silverstripe-gallery/?branch=2)

[![Build Status](https://scrutinizer-ci.com/g/i-lateral/silverstripe-gallery/badges/build.png?b=2)](https://scrutinizer-ci.com/g/i-lateral/silverstripe-gallery/build-status/2)

Adds image galleries to your SilverStripe website.

## Author

This module was created by [Dean Forest Tech](https://dean-forest-tech.uk).

## Installation

The prefered method is via composer:

    composer require dft/silverstripe-gallery

Alternativley download and add to:

[silverstripe-root]/gallery

Then run a `dev/build` (eithe from the browser of the command line).

## Usage

Once installed, you can add either a `Gallery Hub` or a `Gallery Page` to your site.

### Gallery Hub

Hub pages generate a thumbnail for each child `GalleryPage` with a link to view that gallery.

The thumbnail is generated based on the first image in the list

### Gallery Page

A gallery page allows you to upload images and then generates them as a thumbnail
gallery. Clicking on the thumbnail opens a modal/lightbox.

You can add a gallery to your site by creating a `GalleryPage` from within the CMS.

Under the `Gallery` tab, you can then upload as many images as needed.

#### Changing the width and height of images

If you wish to change the width and height of the gallery images (or thumbnails) loaded,
you can do this under the `Settings` tab on your `GalleryPage`.

You can set the following options:

* **Image Width** (default: 950): Width in PX of images loaded in the modal
* **Image Height** (default: 500): Height in PX of images loaded in the modal
* **Image Resize Type** (default: ratio): Type of resize to use on images
* **Background** (default: ffffff): If we use a padded image, set the background colour
* **Thumbnail Width** (default: 150): Width in PX of thumbnail images
* **Thumbnail Height** (default: 150): Height in PX of thumbnail images
* **Thumbnail Resize Type** (default: pad): Type of resize to use on thumbnails

Resize options are as follows:

* crop: Crop image to exact size
* pad: Pad image to size and add whitespace
* ratio: Perform a ratio resize of images

#### Forcing the widths and heights ####

If you want all galleries to be restriced to set sizes, you can set some config variables.
Setting these configs will remove the relevent fields from the CMS.

```
DFT\SilverStripe\Gallery\Model\GalleryHub:
  force_thumbnail_width: 350
  force_thumbnail_height: 350
  force_thumbnail_resize_type: crop
DFT\SilverStripe\Gallery\Model\GalleryPage:
  force_image_width: 1200
  force_image_height: 600
  force_image_resize_type: ratio
```