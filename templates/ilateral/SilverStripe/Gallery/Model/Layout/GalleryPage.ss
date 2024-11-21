<% require css("dft/silverstripe-gallery: node_modules/tingle.js/dist/tingle.min.css") %>
<% require css("dft/silverstripe-gallery: client/dist/css/gallery.min.css") %>
<% require javascript("dft/silverstripe-gallery: node_modules/tingle.js/dist/tingle.min.js") %>
<% require javascript("dft/silverstripe-gallery: client/dist/javascript/gallery.min.js") %>

<% if $ShowSideBar && $Menu(2).exists %>
	<% include SideBar %>
<% end_if %>

<div class="content-container col-12 <% if $ShowSideBar && $Menu(2).exists %>col-md-9 size3of4 lastUnit<% end_if %>">
    <article class="gallery-page">
        <h1>$Title</h1>
        <div class="content">$Content</div>
        $Gallery
    </article>

    $Form
    $PageComments
</div>
