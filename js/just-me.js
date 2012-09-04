
var $j = jQuery.noConflict();

$j( document ).ready(

	function() {

		/* Responsive videos. */
		$j( 'object, embed, iframe' ).removeAttr( 'width height' ).wrap( '<div class="embed-wrap" />' );

		/* Search form in a menu on focus. */
		$j( '.menu-container .search-text ' ).focus(
			function() { 
				$j( this ).animate(
					{
						width: '140px'
					}, 
					300, 
					function() {
						// Animation complete.
					}
				);
			}
		);

		/* Close search form. */
		$j( '.menu-container .search-text ' ).blur(
			function() { 
				$j( this ).animate(
					{
						width: '0px'
					}, 
					300, 
					function() {
						// Animation complete.
					}
				);
			}
		);

	}
);