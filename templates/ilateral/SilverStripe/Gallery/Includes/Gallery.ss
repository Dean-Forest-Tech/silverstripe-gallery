<% if $Images %>
    <div class="gallery-thumbnails">
        <div class="row line">
            <% loop $Images %>
                <% with $GalleryThumbnail %>
                    <div class="col-lg-2 col-md-3 col-6 unit size1of5 <% if $MultipleOf(5) %>lastUnit<% end_if %>">
                        <figure>
                            <span data-url="{$Up.GalleryImage.Link}">
                                <img
                                    class="gallery-thumbnail img-fluid img-responsive"
                                    src="{$Link}"
                                    alt="{$Title}"
                                    
                                />
                            </span>
                            <% if $Top.ShowImageTitles %>
                                <figcaption>$Title</figcaption>
                            <% end_if %>
                        </figure>
                    </div>
                <% end_with %>
            <% end_loop %>
        </div>
    </div>

    <% with $PaginatedImages %>
        <% include DFT\SilverStripe\Gallery\Includes\Pagination %>
    <% end_with %>
<% end_if %>
