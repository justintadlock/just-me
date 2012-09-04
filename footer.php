<?php
/**
 * Footer Template
 *
 * The footer template is generally used on every page of your site. Nearly all other
 * templates call it somewhere near the bottom of the file. It is used mostly as a closing
 * wrapper, which is opened with the header.php file. It also executes key functions needed
 * by the theme, child themes, and plugins. 
 *
 * @package MyLife
 * @subpackage Template
 * @since 0.1.0
 * @author Justin Tadlock <justin@justintadlock.com>
 * @copyright Copyright (c) 2011, Justin Tadlock
 * @link http://themehybrid.com/themes/my-life
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */
?>

				<?php do_atomic( 'close_main' ); // my-life_close_main ?>

			</div><!-- .wrap -->

		</div><!-- #main -->

		<?php do_atomic( 'after_main' ); // my-life_after_main ?>

		<?php do_atomic( 'before_footer' ); // my-life_before_footer ?>

		<footer id="footer">

			<?php do_atomic( 'open_footer' ); // my-life_open_footer ?>

			<div class="wrap">

				<?php get_template_part( 'menu', 'subsidiary' ); // Loads the menu-subsidiary.php template. ?>

				<div class="footer-content">
					<?php hybrid_footer_content(); ?>
				</div><!-- .footer-content -->

				<?php do_atomic( 'footer' ); // my-life_footer ?>

			</div><!-- .wrap -->

			<?php do_atomic( 'close_footer' ); // my-life_close_footer ?>

		</footer><!-- #footer -->

		<?php do_atomic( 'after_footer' ); // my-life_after_footer ?>

	</div><!-- #container -->

	<?php do_atomic( 'close_body' ); // my-life_close_body ?>

	<?php wp_footer(); // wp_footer ?>

</body>
</html>