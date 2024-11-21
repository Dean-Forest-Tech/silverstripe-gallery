# Log of Changes

This document logs changes by release for the SilverStripe gallery module.

## 1.0

Initial stable release

## 1.1

Switch to stable dependencies

## 1.2.0

* Add new "Gallery Hub" template that can display child "Galleries" in a grid of images.
* Switch to grid based default gallery with modal popup.
* Switch galleries to use in page config (over generic config class).

## 1.2.1

* Update docs.
* Tidy up codebase slightly.
* Add extra config/attributes files.
* Update config.

## 1.2.2

* Add ability to set width and height resize of images/thumbnails.

## 1.3.0

* Add ability to customise hub thumbnail sizes
* Add slightly nicer default html
* Add ability to show/hide gallery and image titles

## 1.3.1

* Minor code improvements

## 1.3.2

* Fix pagination issues

## 2.0.0

* SilverStripe 4 version (based on 1.2.1)

## 2.0.1

* Minor update to fix namespacing in config

## 2.0.2

* Add ability to set width and height resize of images/thumbnails.

## 2.1.0

* Add ability to customise hub thumbnail sizes
* Add slightly nicer default html
* Add ability to show/hide gallery and image titles
* Minor code improvements

## 2.1.1

* Fix pagination issues

## 2.1.2

* Fix scrutinizer support

## 2.1.3

* Add fix for Gallery Hub pagination include
* Force default thumbnail cropping

## 2.2.0

* added config for forcing gallery sizes.
* added ability to render the gallery inside the content field.

## 2.2.1

* added support for responsive images

## 2.2.2

* minor JS fixes

## 2.2.3

* update to newer version of tingle modal

## 2.2.4

* remove jquery requirement

## 2.2.5

* added legacy yml

## 2.2.6

* Use Bootstrap 4 col classes

## 2.2.7

* Remove reliance on using action method on controller to render gallery

## 3.0.0

* Migrate to DFT
* SS5 support
* Decouple `Gallery` from `GalleryPage`
* Allow tracking of galleries as seperate objects
* Allow embeding of gallery objects in content areas
* Migrate most gallery settings to the SS `Config` setup.
