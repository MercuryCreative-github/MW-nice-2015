<?php
/**
 * Display the popup settings page.
 */

$loading_methods = IncPopupDatabase::get_loading_methods();


$settings = IncPopupDatabase::get_settings();
$cur_method = $settings['loadingmethod'];
$form_url = esc_url_raw(
	remove_query_arg( array( 'message', 'action', '_wpnonce' ) )
);


// Theme compatibility.
$theme_compat = IncPopupAddon_HeaderFooter::check();
$theme_class = $theme_compat->okay ? 'msg-ok' : 'msg-err';


// START: Geo Lookup
$geo_service = IncPopupDatabase::get_geo_services();

$no_ip_cache = false;
$custom_geo = false;
$geo_msg = '';
if ( ! IncPopupAddon_GeoDB::table_exists() ) {
	$no_ip_cache = true;
	$settings['geo_db'] = false;
	$geo_msg .= '<p class="locked-msg">' .
		sprintf(
			__(
				'<strong>Local IP Lookup Table</strong>: This is unavailable because ' .
				'no geo-data table was found in your database. For details, ' .
				'read the "Using a Local Geo-Database" in the ' .
				'<a href="%1$s" target="_blank">PopUp usage guide</a>.',
				PO_LANG
			),
			'http://premium.wpmudev.org/project/the-pop-over-plugin/#usage'
		).
	'</p>';
}
if ( defined( 'PO_REMOTE_IP_URL' ) && strlen( PO_REMOTE_IP_URL ) > 5 ) {
	$custom_geo = true;
	$settings['geo_lookup'] = '';
	$geo_msg .= '<p class="locked-msg">' .
		__(
			'<strong>Custom Webservice</strong>: You have configured a custom ' .
			'lookup service in <tt>wp-config.php</tt> via the constant ' .
			'"<tt>PO_REMOTE_IP_URL</tt>". To use one of the default services ' .
			'you have to remove that constant from wp-config.php.',
			PO_LANG
		).
	'</p>';
}
// ----- END: Geo Lookup


$rules = IncPopup::get_rules();
$rule_headers = array(
	'name'  => 'Name',
	'desc'  => 'Description',
	'rules' => 'Rules',
	'limit' => 'Limit',
);
$ordered_rules = array();

?>
<div class="wrap nosubsub">

	<h2><?php _e( 'PopUp Settings', PO_LANG ); ?></h2>

	<div id="poststuff" class="metabox-holder m-settings">
	<form method="post" action="<?php echo esc_url( $form_url ); ?>">

		<input type="hidden" name="action" value="updatesettings" />

		<?php wp_nonce_field( 'update-popup-settings' ); ?>

		<div class="wpmui-box static">
			<h3>
				<span><?php _e( 'PopUp Loading Method', PO_LANG ); ?></span>
			</h3>

			<div class="inside">
				<p><?php
				_e(
					'Select how you would like to load PopUp.', PO_LANG
				);
				?></p>

				<table class="form-table">
				<tbody>

					<?php /* === LOADING METHOD === */ ?>
					<tr valign="top">
						<th scope="row">
							<?php _e( 'Load PopUp using', PO_LANG ); ?>
						</th>
						<td>
							<select name="po_option[loadingmethod]" id="loadingmethod">
								<?php foreach ( $loading_methods as $item ) : ?>
									<option
										value="<?php echo esc_attr( $item->id ); ?>"
										<?php selected( $cur_method, $item->id ); ?>>
										<?php _e( $item->label, PO_LANG ); ?>
									</option>
								<?php endforeach; ?>
							</select>

							<ul>
								<?php foreach ( $loading_methods as $item ) : ?>
									<li>
										<?php if ( $cur_method == $item->id ) : ?>
											<strong><i class="dashicons dashicons-yes"
											style="margin-left:-20px">
											</i><?php _e( $item->label, PO_LANG ); ?></strong>:
										<?php else : ?>
											<?php _e( $item->label, PO_LANG ); ?>:
										<?php endif; ?>
										<em><?php echo '' . $item->info; ?>
									</em></li>
								<?php endforeach; ?>
							</ul>
						</td>
					</tr>

					<?php /* === GEO DB SETTING === */ ?>
					<tr>
						<th><?php _e( 'Country Lookup', PO_LANG ); ?></th>
						<td>
							<select
								name="po_option[geo_lookup]"
								class="po-option-geo-lookup" >
								<?php if ( $custom_geo ) : ?>
								<optgroup label="<?php _e( 'Custom Webservice', PO_LANG ); ?>">
									<option value="" selected="selected">
										wp-config.php
									</option>
								</optgroup>
								<?php endif; ?>
								<optgroup label="<?php _e( 'Webservices', PO_LANG ); ?>">
									<?php foreach ( $geo_service as $key => $service ) : ?>
										<option value="<?php echo esc_attr( $key ); ?>"
											<?php if ( $custom_geo ) : ?>disabled<?php endif; ?>
											<?php selected( $key, $settings['geo_lookup'] ); ?>>
											<?php echo esc_html( $service->label ); ?>
										</option>
									<?php endforeach; ?>
								</optgroup>
								<optgroup label="<?php _e( 'Local Database', PO_LANG ); ?>">
									<option value="geo_db"
										<?php if ( $no_ip_cache ) : ?>disabled<?php endif; ?>
										<?php selected( $settings['geo_db'] ); ?>>
										<?php _e( 'Local IP Lookup Table', PO_LANG ); ?>
									</option>
								</optgroup>
							</select>
							<button type="button" class="button test-location">
								<?php _e( 'Test my location', PO_LANG ); ?>
							</button>
							<script>
							jQuery(function() {
								function show_result(res, okay) {
									alert( res );
								}

								function test_geo() {
									wpmUi.ajax( null, 'po-ajax' )
										.data({
											'do': 'test-geo',
											'type': jQuery('.po-option-geo-lookup').val()
										})
										.ondone( show_result )
										.load_text();
								}

								jQuery('.test-location').click( test_geo );
							});
							</script>

							<p><em><?php
							_e(
								'This option is relevant for the ' .
								'"Visitor Location" condition.',
								PO_LANG
							);
							?></em></p>
							<?php echo '' . $geo_msg; ?>
						</td>
					</tr>
				</tbody>
				</table>
			</div>
		</div>

		<?php if ( 'footer' == $cur_method ) : ?>
		<div class="wpmui-box <?php echo esc_attr( $theme_compat->okay ? 'closed' : '' ); ?>">
			<h3>
				<a href="#" class="toggle" title="<?php _e( 'Click to toggle' ); ?>"><br></a>
				<span><?php _e( 'Theme compatibility', PO_LANG ); ?></span>
			</h3>

			<div class="inside">
				<?php
				_e(
					'Here you can see if your theme is compatible with the ' .
					'"Page Footer" loading method.', PO_LANG
				);
				?>
				<div class="<?php echo esc_attr( $theme_class ); ?>">
					<?php foreach ( $theme_compat->msg as $row ) {
						echo '<p>' . $row . '</p>';
					} ?>
				</div>
			</div>
		</div>
		<?php endif; ?>

		<div class="wpmui-box closed">
			<h3>
				<a href="#" class="toggle" title="<?php _e( 'Click to toggle' ); ?>"><br></a>
				<span><?php _e( 'Supported Shortcodes', PO_LANG ); ?></span>
			</h3>

			<div class="inside">
				<?php include PO_VIEWS_DIR . 'info-shortcodes.php'; ?>
			</div>
		</div>

		<p class="submit">
			<button class="button-primary">
				<?php _e( 'Save All Changes', PO_LANG ) ?>
			</button>
		</p>

		<h2><?php _e( 'Available Conditions', PO_LANG ); ?></h2>

		<?php /* === ACTIVE RULES === */ ?>
		<table class="widefat tbl-addons">
			<?php foreach ( array( 'thead', 'tfoot' ) as $tag ) : ?>
				<<?php echo esc_attr( $tag ); ?>>
				<tr>
					<th class="manage-column column-cb check-column" id="cb" scope="col">
						<input type="checkbox" />
					</th>
					<th class="manage-column column-name" scope="col">
						<?php _e( 'Name', PO_LANG ); ?>
					</th>
					<th class="manage-column column-items" scope="col">
						<?php _e( 'Activated Rules', PO_LANG ); ?>
					</th>
				</tr>
				</<?php echo esc_attr( $tag ); ?>>
			<?php endforeach; ?>

			<?php foreach ( $rules as $rule ) {
				$data = get_file_data(
					PO_INC_DIR . 'rules/' . $rule,
					$rule_headers,
					'popup-rule'
				);
				$is_active = ( in_array( $rule, $settings['rules'] ) );
				if ( empty( $data['name'] ) ) { continue; }
				$data['limit'] = explode( ',', $data['limit'] );
				$data['limit'] = array_map( 'trim', $data['limit'] );

				$name = __( trim( $data['name'] ), PO_LANG );

				$ordered_rules[ $name ] = $data;
				$ordered_rules[ $name ]['key'] = $rule;
				$ordered_rules[ $name ]['name'] = $name;
				$ordered_rules[ $name ]['active'] = $is_active;
				$ordered_rules[ $name ]['desc'] = __( trim( $data['desc'] ), PO_LANG );

				if ( 'pro' != PO_VERSION && in_array( 'pro', $data['limit'] ) ) {
					$ordered_rules[ $name ]['disabled'] = sprintf(
						__( 'Available in the <a href="%s" target="_blank">PRO version</a>', PO_LANG ),
						'http://premium.wpmudev.org/project/the-pop-over-plugin/'
					);
				} else if ( IncPopup::use_global() && in_array( 'no global', $data['limit'] ) ) {
					$ordered_rules[ $name ]['disabled'] = __( 'Not available for global PopUps', PO_LANG );
				} else if ( ! IncPopup::use_global() && in_array( 'global', $data['limit'] ) ) {
					$ordered_rules[ $name ]['disabled'] = true;
				} else {
					$ordered_rules[ $name ]['disabled'] = false;
				}
			} ?>
			<?php ksort( $ordered_rules ); ?>

			<?php foreach ( $ordered_rules as $data ) {
				// Ignore Addons that have no name.
				$data['rules'] = explode( ',', $data['rules'] );
				$rule_id = 'po-rule-' . sanitize_html_class( $data['key'] );
				if ( true === $data['disabled'] ) { continue; }
				?>
				<tr valign="top" class="<?php echo esc_attr( $data['disabled'] ? 'locked' : '' ); ?>">
					<th class="check-column" scope="row">
						<?php if ( false == $data['disabled'] ) : ?>
						<input type="checkbox"
							id="<?php echo esc_attr( $rule_id ); ?>"
							name="po_option[rules][<?php echo esc_attr( $data['key'] ); ?>]"
							<?php checked( $data['active'] ); ?>
							/>
						<?php endif; ?>
					</th>
					<td class="column-name">
						<label for="<?php echo esc_attr( $rule_id ); ?>">
							<strong><?php echo esc_html( $data['name'] ); ?></strong>
						</label>
						<div><em><?php echo '' . $data['desc']; ?></em></div>
						<?php if ( $data['disabled'] ) : ?>
							<div class="locked-msg">
								<?php echo '' . $data['disabled']; ?>
							</div>
						<?php endif; ?>
					</td>
					<td class="column-items">
					<?php foreach ( $data['rules'] as $rule_name ) : ?>
						<?php $rule_name = trim( $rule_name ); ?>
						<?php if ( empty( $rule_name ) ) { continue; } ?>
						<code><?php _e( trim( $rule_name ), PO_LANG ); ?></code><br />
					<?php endforeach; ?>
					</td>
				</tr>
			<?php } ?>
		</table>

		<p class="submit">
			<button class="button-primary">
				<?php _e( 'Save All Changes', PO_LANG ) ?>
			</button>
		</p>

	</form>
	</div>

</div> <!-- wrap -->