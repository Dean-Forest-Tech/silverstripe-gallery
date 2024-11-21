<% require css("dft/silverstripe-gallery: client/dist/css/gallery.min.css") %>

<% if $ShowSideBar && $Menu(2).exists %>
	<% include SideBar %>
<% end_if %>

<div class="content-container unit col-12 <% if $ShowSideBar && $Menu(2).exists %>col-md-9 size3of4 lastUnit<% end_if %>">
	<article class="gallery-hub">
		<h1>$Title</h1>

		<div class="content">
			$Content
		</div>

		<% if $PaginatedGalleries.exists %>
			<div class="gallery-thumbnails">
				<div class="row line">
					<% loop $PaginatedGalleries %>
						<% include ilateral\SilverStripe\Gallery\Includes\GalleryImage Thumbnail=$GalleryThumbnail,ShowTitles=$Top.ShowImageTitles %>
					<% end_loop %>
				</div>
			</div>

			<% with $PaginatedGalleries %>
				<% include DFT\SilverStripe\Gallery\Includes\Pagination %>
			<% end_with %>
		<% end_if %>
	</article>
</div>
