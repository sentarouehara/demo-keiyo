<?php
/**
 * Single template for the school demo post type.
 *
 * @package Demo_Keiyo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	$post_id      = get_the_ID();
	$meta_items   = array(
		'学科名'   => demo_keiyo_get_school_demo_meta( $post_id, 'department' ),
		'募集人数' => demo_keiyo_get_school_demo_meta( $post_id, 'recruitment_count' ),
		'出願締切' => demo_keiyo_get_school_demo_meta( $post_id, 'application_deadline' ),
		'試験日'   => demo_keiyo_get_school_demo_meta( $post_id, 'exam_date' ),
		'合格発表日' => demo_keiyo_get_school_demo_meta( $post_id, 'result_date' ),
		'手続締切' => demo_keiyo_get_school_demo_meta( $post_id, 'procedure_deadline' ),
		'受験料'   => demo_keiyo_get_school_demo_meta( $post_id, 'exam_fee' ),
		'学費'     => demo_keiyo_get_school_demo_meta( $post_id, 'tuition' ),
		'併願延納' => demo_keiyo_get_school_demo_meta( $post_id, 'dual_application' ),
	);
	$subtitle     = demo_keiyo_get_school_demo_meta( $post_id, 'subtitle' );
	$gt80         = demo_keiyo_get_school_demo_meta( $post_id, 'gt80' );
	$gs80         = demo_keiyo_get_school_demo_meta( $post_id, 'gs80' );
	$career_path  = demo_keiyo_get_school_demo_meta( $post_id, 'career_path' );
	$recommend    = demo_keiyo_get_school_demo_meta( $post_id, 'recommendation_slots' );
	$notes        = demo_keiyo_get_school_demo_meta( $post_id, 'notes' );
	$yearly_table = demo_keiyo_get_school_demo_meta( $post_id, 'yearly_table_id' );
	$other_table  = demo_keiyo_get_school_demo_meta( $post_id, 'concurrent_table_id' );
	?>
	<main class="school-demo">
		<div class="school-demo__container">
			<article <?php post_class( 'school-demo__article' ); ?>>
				<header class="school-demo__header">
					<h1 class="school-demo__page-title"><?php the_title(); ?></h1>
					<?php if ( '' !== $subtitle ) : ?>
						<p class="school-demo__subtitle"><?php echo esc_html( $subtitle ); ?></p>
					<?php endif; ?>
				</header>

				<section class="school-demo__section">
					<h2 class="school-demo__section-title">基本情報</h2>
					<dl class="school-demo__meta">
						<?php foreach ( $meta_items as $label => $value ) : ?>
							<?php if ( '' !== $value ) : ?>
								<div class="school-demo__meta-row">
									<dt class="school-demo__meta-label"><?php echo esc_html( $label ); ?></dt>
									<dd class="school-demo__meta-value"><?php echo esc_html( $value ); ?></dd>
								</div>
							<?php endif; ?>
						<?php endforeach; ?>
					</dl>
				</section>

				<section class="school-demo__section">
					<h2 class="school-demo__section-title">偏差値</h2>
					<div class="school-demo__scores">
						<div class="school-demo__score-card">
							<span class="school-demo__score-label">GT80</span>
							<span class="school-demo__score-value"><?php echo '' !== $gt80 ? esc_html( $gt80 ) : '未設定'; ?></span>
						</div>
						<div class="school-demo__score-card">
							<span class="school-demo__score-label">GS80</span>
							<span class="school-demo__score-value"><?php echo '' !== $gs80 ? esc_html( $gs80 ) : '未設定'; ?></span>
						</div>
					</div>
				</section>

				<section class="school-demo__section">
					<h2 class="school-demo__section-title">年度比較表</h2>
					<?php echo wp_kses_post( demo_keiyo_render_tablepress_block( $yearly_table, 'ここに年度比較表が表示されます。' ) ); ?>
				</section>

				<section class="school-demo__section">
					<h2 class="school-demo__section-title">併願校表</h2>
					<?php echo wp_kses_post( demo_keiyo_render_tablepress_block( $other_table, 'ここに併願校表が表示されます。' ) ); ?>
				</section>

				<?php if ( '' !== $career_path ) : ?>
					<section class="school-demo__section">
						<h2 class="school-demo__section-title">卒業生の進路</h2>
						<div class="school-demo__rich-text">
							<?php echo wpautop( esc_html( $career_path ) ); ?>
						</div>
					</section>
				<?php endif; ?>

				<?php if ( '' !== $recommend ) : ?>
					<section class="school-demo__section">
						<h2 class="school-demo__section-title">指定校推薦枠</h2>
						<div class="school-demo__rich-text">
							<?php echo wpautop( esc_html( $recommend ) ); ?>
						</div>
					</section>
				<?php endif; ?>

				<?php if ( '' !== $notes ) : ?>
					<section class="school-demo__section">
						<h2 class="school-demo__section-title">備考</h2>
						<div class="school-demo__rich-text">
							<?php echo wpautop( esc_html( $notes ) ); ?>
						</div>
					</section>
				<?php endif; ?>

				<?php if ( '' !== trim( get_the_content() ) ) : ?>
					<section class="school-demo__section">
						<h2 class="school-demo__section-title">補足情報</h2>
						<div class="school-demo__rich-text">
							<?php the_content(); ?>
						</div>
					</section>
				<?php endif; ?>
			</article>
		</div>
	</main>
	<?php
endwhile;

get_footer();
