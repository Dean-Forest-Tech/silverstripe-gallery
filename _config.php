<?php

use ilateral\SilverStripe\Gallery\ShortCodes\GalleryShortCodeHandler;
use SilverStripe\View\Parsers\ShortcodeParser;

ShortcodeParser::get('default')->register(
    GalleryShortCodeHandler::SHORTCODE_GALLERY,
    [
        GalleryShortCodeHandler::class,
        'handle_shortcode'
    ]
);