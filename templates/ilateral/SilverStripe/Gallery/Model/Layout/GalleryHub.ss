<% require css("dft/silverstripe-gallery: client/dist/css/gallery.min.css") %>

<% if $ShowSideBar && $Menu(2).exists %>
	<% include SideBar %>
<% end_if %>

<div class="content-container unit col-12 <% if $ShowSideBar && $Menu(2).exists %>col-md-9 size3of4 lastUnit<% end_if %>">
	<article class="gallery-hub">
		<h1>$Title</h1>
		<div class="content">$Content</div>

		<% if $PaginatedGalleries.exists %>
			<div class="gallery-thumbnails">
				<div class="row line">
					<% loop $PaginatedGalleries %>
						<div class="unit size1of4 col-lg-2 col-md-3 col-6 <% if $MultipleOf(4) %>lastUnit<% end_if %>">
							<figure>
								<a href="{$Link}" title="{$Title}">
									<img
										class="gallery-thumbnail img-fluid img-responsive"
										src="{$GalleryThumbnail.Link}"
										alt="{$GalleryThumbnail.Title}"
									/>
									<% if $Top.ShowImageTitles %>
										<figcaption>$Title</figcaption>
									<% end_if %>
								</a>
							</figure>
						</div>
					<% end_loop %>
				</div>
			</div>

			<% with $PaginatedGalleries %>
				<% include DFT\SilverStripe\Gallery\Includes\Pagination %>
			<% end_with %>
		<% end_if %>
	</article>
</div>
