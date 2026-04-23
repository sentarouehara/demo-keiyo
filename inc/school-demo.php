<?php
/**
 * School demo custom post type, meta box, and rendering helpers.
 *
 * @package Demo_Keiyo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns the list of supported school demo fields.
 *
 * @return array<string, array<string, string>>
 */
function demo_keiyo_school_demo_fields() {
	return array(
		'department'          => array(
			'label' => '学科名',
			'type'  => 'text',
		),
		'subtitle'            => array(
			'label' => 'サブタイトル',
			'type'  => 'text',
		),
		'gt80'                => array(
			'label' => 'GT80偏差値',
			'type'  => 'text',
		),
		'gs80'                => array(
			'label' => 'GS80偏差値',
			'type'  => 'text',
		),
		'recruitment_count'   => array(
			'label' => '募集人数',
			'type'  => 'text',
		),
		'application_deadline' => array(
			'label' => '出願締切',
			'type'  => 'text',
		),
		'exam_date'           => array(
			'label' => '試験日',
			'type'  => 'text',
		),
		'result_date'         => array(
			'label' => '合格発表日',
			'type'  => 'text',
		),
		'procedure_deadline'  => array(
			'label' => '手続締切',
			'type'  => 'text',
		),
		'exam_fee'            => array(
			'label' => '受験料',
			'type'  => 'text',
		),
		'tuition'             => array(
			'label' => '学費',
			'type'  => 'text',
		),
		'dual_application'    => array(
			'label' => '併願延納',
			'type'  => 'text',
		),
		'career_path'         => array(
			'label' => '卒業生の進路',
			'type'  => 'textarea',
		),
		'recommendation_slots' => array(
			'label' => '指定校推薦枠',
			'type'  => 'textarea',
		),
		'notes'               => array(
			'label' => '備考',
			'type'  => 'textarea',
		),
		'yearly_table_id'     => array(
			'label' => '年度比較表ID',
			'type'  => 'text',
		),
		'concurrent_table_id' => array(
			'label' => '併願校表ID',
			'type'  => 'text',
		),
	);
}

/**
 * Registers the school demo custom post type.
 */
function demo_keiyo_register_school_demo_post_type() {
	$labels = array(
		'name'               => '学校デモ',
		'singular_name'      => '学校デモ',
		'menu_name'          => '学校デモ',
		'name_admin_bar'     => '学校デモ',
		'add_new'            => '新規追加',
		'add_new_item'       => '学校デモを追加',
		'edit_item'          => '学校デモを編集',
		'new_item'           => '新しい学校デモ',
		'view_item'          => '学校デモを表示',
		'search_items'       => '学校デモを検索',
		'not_found'          => '学校デモが見つかりません',
		'not_found_in_trash' => 'ゴミ箱に学校デモはありません',
		'all_items'          => '学校デモ一覧',
	);

	register_post_type(
		'school_demo',
		array(
			'labels'          => $labels,
			'public'          => true,
			'show_in_rest'    => true,
			'menu_icon'       => 'dashicons-welcome-learn-more',
			'supports'        => array( 'title', 'editor', 'thumbnail' ),
			'has_archive'     => true,
			'rewrite'         => array( 'slug' => 'school-demo' ),
			'show_in_menu'    => true,
			'publicly_queryable' => true,
		)
	);
}
add_action( 'init', 'demo_keiyo_register_school_demo_post_type' );

/**
 * Adds the school demo meta box.
 */
function demo_keiyo_add_school_demo_meta_box() {
	add_meta_box(
		'demo-keiyo-school-demo-meta',
		'学校デモ情報',
		'demo_keiyo_render_school_demo_meta_box',
		'school_demo',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'demo_keiyo_add_school_demo_meta_box' );

/**
 * Renders the school demo meta box.
 *
 * @param WP_Post $post Current post object.
 */
function demo_keiyo_render_school_demo_meta_box( $post ) {
	wp_nonce_field( 'demo_keiyo_save_school_demo', 'demo_keiyo_school_demo_nonce' );

	$fields             = demo_keiyo_school_demo_fields();
	$basic_field_keys   = array(
		'department',
		'subtitle',
		'gt80',
		'gs80',
		'recruitment_count',
		'application_deadline',
		'exam_date',
		'result_date',
		'procedure_deadline',
		'exam_fee',
		'tuition',
		'dual_application',
		'career_path',
		'recommendation_slots',
		'notes',
	);
	$table_field_keys   = array( 'yearly_table_id', 'concurrent_table_id' );
	$tablepress_active  = shortcode_exists( 'table' );
	$tablepress_edit_url = admin_url( 'admin.php?page=tablepress&action=edit&table_id=%s' );
	?>
	<p>提案用の最小デモです。学校情報と TablePress の関連表IDをここで紐付けます。</p>

	<h3>基本情報</h3>
	<table class="form-table" role="presentation">
		<tbody>
			<?php foreach ( $basic_field_keys as $field_key ) : ?>
				<?php
				$field = $fields[ $field_key ];
				$value = get_post_meta( $post->ID, '_school_demo_' . $field_key, true );
				?>
				<tr>
					<th scope="row">
						<label for="school-demo-<?php echo esc_attr( $field_key ); ?>"><?php echo esc_html( $field['label'] ); ?></label>
					</th>
					<td>
						<?php if ( 'textarea' === $field['type'] ) : ?>
							<textarea
								id="school-demo-<?php echo esc_attr( $field_key ); ?>"
								name="school_demo_meta[<?php echo esc_attr( $field_key ); ?>]"
								class="large-text"
								rows="3"
							><?php echo esc_textarea( $value ); ?></textarea>
						<?php else : ?>
							<input
								type="text"
								id="school-demo-<?php echo esc_attr( $field_key ); ?>"
								name="school_demo_meta[<?php echo esc_attr( $field_key ); ?>]"
								class="regular-text"
								value="<?php echo esc_attr( $value ); ?>"
							/>
						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<h3>関連表</h3>
	<table class="form-table" role="presentation">
		<tbody>
			<?php foreach ( $table_field_keys as $field_key ) : ?>
				<?php
				$field    = $fields[ $field_key ];
				$value    = get_post_meta( $post->ID, '_school_demo_' . $field_key, true );
				$link_map = array(
					'yearly_table_id'     => '年度比較表を編集',
					'concurrent_table_id' => '併願校表を編集',
				);
				?>
				<tr>
					<th scope="row">
						<label for="school-demo-<?php echo esc_attr( $field_key ); ?>"><?php echo esc_html( $field['label'] ); ?></label>
					</th>
					<td>
						<input
							type="text"
							id="school-demo-<?php echo esc_attr( $field_key ); ?>"
							name="school_demo_meta[<?php echo esc_attr( $field_key ); ?>]"
							class="regular-text"
							value="<?php echo esc_attr( $value ); ?>"
						/>
						<?php if ( $tablepress_active && '' !== trim( (string) $value ) ) : ?>
							<p>
								<a href="<?php echo esc_url( sprintf( $tablepress_edit_url, rawurlencode( (string) $value ) ) ); ?>">
									<?php echo esc_html( $link_map[ $field_key ] ); ?>
								</a>
							</p>
						<?php elseif ( ! $tablepress_active ) : ?>
							<p class="description">TablePress を有効化すると編集リンクを表示できます。</p>
						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php
}

/**
 * Persists school demo meta box values.
 *
 * @param int $post_id Post ID.
 */
function demo_keiyo_save_school_demo_meta( $post_id ) {
	if ( ! isset( $_POST['demo_keiyo_school_demo_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['demo_keiyo_school_demo_nonce'] ) ), 'demo_keiyo_save_school_demo' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! isset( $_POST['post_type'] ) || 'school_demo' !== $_POST['post_type'] ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$posted_fields = isset( $_POST['school_demo_meta'] ) && is_array( $_POST['school_demo_meta'] )
		? wp_unslash( $_POST['school_demo_meta'] )
		: array();

	foreach ( demo_keiyo_school_demo_fields() as $field_key => $field ) {
		$meta_key = '_school_demo_' . $field_key;
		$value    = isset( $posted_fields[ $field_key ] ) ? $posted_fields[ $field_key ] : '';
		$value    = is_string( $value ) ? $value : '';

		if ( 'textarea' === $field['type'] ) {
			$value = sanitize_textarea_field( $value );
		} else {
			$value = sanitize_text_field( $value );
		}

		if ( '' === $value ) {
			delete_post_meta( $post_id, $meta_key );
			continue;
		}

		update_post_meta( $post_id, $meta_key, $value );
	}
}
add_action( 'save_post_school_demo', 'demo_keiyo_save_school_demo_meta' );

/**
 * Gets a school demo meta value.
 *
 * @param int    $post_id   Post ID.
 * @param string $field_key Field key.
 * @return string
 */
function demo_keiyo_get_school_demo_meta( $post_id, $field_key ) {
	$value = get_post_meta( $post_id, '_school_demo_' . $field_key, true );

	return is_string( $value ) ? $value : '';
}

/**
 * Renders a TablePress table or a safe placeholder.
 *
 * @param string $table_id     Table ID.
 * @param string $placeholder  Placeholder text.
 * @return string
 */
function demo_keiyo_render_tablepress_block( $table_id, $placeholder ) {
	$table_id = trim( $table_id );

	if ( '' === $table_id ) {
		return '<div class="school-demo__placeholder"><p>' . esc_html( $placeholder ) . '</p></div>';
	}

	if ( ! shortcode_exists( 'table' ) ) {
		return '<div class="school-demo__placeholder"><p>TablePress を有効化するとここに表が表示されます。</p></div>';
	}

	$output = do_shortcode( sprintf( '[table id="%s" /]', esc_attr( $table_id ) ) );

	if ( '' === trim( wp_strip_all_tags( $output ) ) ) {
		return '<div class="school-demo__placeholder"><p>' . esc_html( $placeholder ) . '</p></div>';
	}

	return '<div class="school-demo__table-wrap">' . $output . '</div>';
}
