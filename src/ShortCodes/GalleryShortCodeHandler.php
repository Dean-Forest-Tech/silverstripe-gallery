<?php

namespace ilateral\SilverStripe\Gallery\ShortCodes;

use SilverStripe\View\Parsers\ShortcodeParser;
use SilverStripe\View\Parsers\ShortcodeHandler;
use ilateral\SilverStripe\Gallery\Model\Gallery;

/**
 * Allow embeding shortcodes in a content area.
 * Currently this shortcode supports the format:
 * 
 * [gallery,code="gallery-code"]
 */
class GalleryShortCodeHandler implements ShortcodeHandler
{
    const SHORTCODE_GALLERY = 'gallery';

	public static function get_shortcodes(): array
	{
		return [self::SHORTCODE_GALLERY];
	}

    public static function generateShortCode(Gallery $gallery)
    {
        return '[' . self::SHORTCODE_GALLERY . ' code=' . $gallery->Code . ']'; 
    }

	/**
	 *
	 * @param array $arguments
	 * @param string $content
	 * @param ShortcodeParser $parser
	 * @param string $shortcode
	 * @param array $extra
	 *
	 * @return string
	 */
	public static function handle_shortcode(
        $arguments,
        $content,
        $parser,
        $shortcode,
        $extra = array()
    ) {
        // Ensure we are calling a specific gallery
        if (empty($arguments['code'])) {
            return;
        }

        $code = $arguments['code'];
        /** @var Gallery */
        $gallery = Gallery::get()->find('Code', $code);

        if (empty($gallery)) {
            return;
        }

        return $gallery->forTemplate();
    }
}
