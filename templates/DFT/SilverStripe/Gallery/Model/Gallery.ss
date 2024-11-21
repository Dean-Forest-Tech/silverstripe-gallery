<% require css("i-lateral/silverstripe-gallery: node_modules/tingle.js/dist/tingle.min.css") %>
<% require css("i-lateral/silverstripe-gallery: client/dist/css/gallery.min.css") %>
<% require javascript("i-lateral/silverstripe-gallery: node_modules/tingle.js/dist/tingle.min.js") %>
<% require javascript("i-lateral/silverstripe-gallery: client/dist/javascript/gallery.min.js") %>

<% if $Images.exists %>
    <div class="gallery-thumbnails">
        <div class="row line">
            <% loop $PaginatedImages %>
                <% include ilateral\SilverStripe\Gallery\Includes\GalleryImage Thumbnail=$Join.GalleryThumbnail,Image=$Join.GalleryImage,ShowTitles=$ShowImageTitles,Modal=true %>
            <% end_loop %>
        </div>
    </div>

    <% with $PaginatedImages %>
        <% include ilateral\SilverStripe\Gallery\Includes\Pagination %>
    <% end_with %>
<% end_if %>
