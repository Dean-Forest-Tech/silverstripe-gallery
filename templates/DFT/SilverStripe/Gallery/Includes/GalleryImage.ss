<div class="unit size1of4 col-md-3 col-6 <% if $MultipleOf(4) %>lastUnit<% end_if %>">
    <figure>
        <% if $Modal %>
        <span data-url="{$Join.GalleryImage.Link}">
        <% else %>
        <a href="{$Link}" title="{$Title}">
        <% end_if %>
            <img
                class="gallery-thumbnail img-fluid img-responsive"
                src="{$Thumbnail.Link}"
                alt="{$Thumbnail.Title}"
            />
        <% if $Modal %>
        </span>
        <% else %>
        </a>
        <% end_if %>

        <% if $ShowImageTitles %>
            <figcaption>$Title</figcaption>
        <% end_if %>
    </figure>
</div>