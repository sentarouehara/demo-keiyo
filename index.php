<?php
/**
 * Fallback template.
 *
 * @package Demo_Keiyo
 */

get_header();
?>
<main class="site-main">
	<div class="school-demo__container">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article <?php post_class( 'school-demo__article' ); ?>>
					<h1 class="school-demo__page-title"><?php the_title(); ?></h1>
					<div class="school-demo__content">
						<?php the_content(); ?>
					</div>
				</article>
			<?php endwhile; ?>
		<?php else : ?>
			<p><?php esc_html_e( 'No content found.', 'demo-keiyo' ); ?></p>
		<?php endif; ?>
	</div>
</main>
<?php
get_footer();
