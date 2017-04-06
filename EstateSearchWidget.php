<?php

class EstateSearchWidget extends WP_Widget {
	
	function __construct(){
		parent::WP_Widget(false, $name = __('Estate search', 'wp_widget_plugin') );		
	}
	
	/**
	 * Creates form
	 * 
	 * {@inheritDoc}
	 * @see WP_Widget::form()
	 */
	function form($instance) {
		// Check values
		if( $instance) {
			$title = esc_attr($instance['title']);
		} else {
			$title = '';
		}
		?>
		
		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'wp_widget_plugin'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		
		<?php
	}
	/**
	 * Updates widget
	 * 
	 * {@inheritDoc}
	 * @see WP_Widget::update()
	 */
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		// Fields
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}
	
	/**
	 * Displays widget
	 * 
	 * {@inheritDoc}
	 * @see WP_Widget::widget()
	 */
	function widget($args, $instance) {
		$query = get_search_query();
		extract( $args );
		// these are the widget options
		$title = apply_filters('widget_title', $instance['title']);
		echo $before_widget;
		// Display the widget
		echo '<div class="widget-text wp_widget_plugin_box">';
		
		// Check if title is set
// 		if ( $title ) {
// 			echo $before_title . $title . $after_title;
// 		}
		
		// Get estate types
		$estateType = get_terms( array(
		    'taxonomy' => 'estate_type',
		    'hide_empty' => false,
		) );
		$types = [];
		foreach ($estateType as $type) {
			$types[] = $type->name;
		}
		
		// Get estate series
		$estateSerie = get_terms( array(
				'taxonomy' => 'estate_serie',
				'hide_empty' => false
		) );
		$series = [];
		foreach ($estateSerie as $serie) {
			$series[] = $serie->name;
		}
		
		// Get estate actions
		$estateActions = get_terms( array(
		'taxonomy' => 'action',
		'hide_empty' => false
		) );
		$actions = [];
		foreach ($estateActions as $action) {
			$actions[] = $action->name;
		}
		
		// Get estate cities
		$estateRegions = get_terms( array(
		'taxonomy' => 'region',
		'hide_empty' => false
		) );
		$regions = [];
		foreach ($estateRegions as $region) {
			$regions[] = $region->name;
		}
		
		// Get estate residentals
		$estateResidentals = get_terms( array(
		'taxonomy' => 'residental',
		'hide_empty' => false
		) );
		$residentals = [];
		foreach ($estateResidentals as $residental) {
			$residentals[] = $residental->name;
		}
		
		?>
		<form id="estate-search" role="search" method="get" id="searchform" action="/">
			<input type="hidden" value="estate" name="post_type" />
			<div>
				<h2><?php echo $text; ?></h2>
				<div>
					<label for="s"><?php echo __($title . ': ', 'textdomain'); ?></label>
					<input type="text" value="<?php if (!empty($_GET['s'])) echo $_GET['s']; ?>" name="s" id="s" />
					<input type="submit" id="searchsubmit" value="<?php echo __('Meklēt', 'textdomain'); ?>" />
					<div class="clear"></div>
				</div>
				<div>
					<div class="column">
						<?php $this->createDropdown('action', __('Action', 'estate'), $actions, "Pārdod")?>
						<?php $this->createDropdown('estate_type', __('Type', 'estate'), $types, "Dzīvoklis")?>
						<?php $this->createMinMaxField('area', __('Area', 'estate'), 0); ?>
					</div>
					<div class="column">
						<?php $this->createDropdown('region', __('City/Region', 'estate'), $regions, "Rīga")?>
						<?php $this->createDropdown('estate_serie', __('Serie', 'estate'), $series, ($_GET['type'] == 'Dzīvoklis' || empty($_GET['type'])) ? 'display: block;' : 'display: none;')?>
						<?php $this->createMinMaxField('price', __('Price', 'estate'), 0); ?>
					</div>
					<div class="column">
						<?php $this->createDropdown('residental', __('Residental complex', 'estate'), $residentals, "", ($_GET['region'] == 'Riga' || empty($_GET['region'])) ? 'display: block;' : 'display: none;')?>
						<?php $this->createMinMaxField('rooms', __('Rooms', 'estate'), 0); ?>
						<?php $this->createMinMaxField('floor', __('Floor', 'estate'), 0); ?>
					</div>
				</div>
			</div>
		</form>
		<?php
		echo '</div>';
		echo $after_widget;
	}
	
	/**
	 * Create min - max field for form
	 * 
	 * @param string $name
	 * @param string $title
	 * @param int $min
	 * @param int $max
	 */
	public function createMinMaxField($name, $title, $min = "", $max = "") {
		$minVal = empty($_GET['min-' . $name]) ? '' : $_GET['min-' . $name];
		$maxVal = empty($_GET['max-' . $name]) ? '' : $_GET['max-' . $name];
		?>
		
		<div>
			<label class="field-title"><?= $title ?></label>
			<input type="number" step="any" id="min-<?= $name ?>" name="min-<?= $name ?>" min="<?= $min ?>" max="<?= $max ?>" value="<?= $minVal ?>" placeholder="<?= __('min', 'estate')?>" /> -
			<input type="number" step="any" id="max-<?= $name ?>" name="max-<?= $name ?>" min="<?= $min ?>" max="<?= $max ?>" value="<?= $maxVal ?>" placeholder="<?= __('max', 'estate')?>" />
		</div>
		
		<?php
	}

	public function createDropdown($name, $title, $values, $default , $style = "") {
		$selected = empty($_GET[$name]) ? '' : $_GET[$name];
		?>
		
		<div id="<?= $name ?>" style="<?= $style ?>">
			<label class="field-title"><?= $title ?></label>
			<select name="<?= $name ?>">
				<option value="all" <?= $selected == "all" ? 'selected' : '' ?>><?= __('Search all', 'estate') ?></option>
				<?php foreach ($values as $value): ?>
				<option value="<?= $value ?>" <?= ($value == $selected) || (empty($selected) && $value == $default) ? 'selected' : '' ?>><?= $value ?></option>
				<?php endforeach;?>
			</select>
		</div>
		
		<?php
	}
	
	/**
	 * Get values for meta key
	 * 
	 * @param string $key
	 * @param string $type
	 * @param string $status
	 * @return array
	 */
	function get_meta_values( $key = '', $type = 'estate', $status = 'publish' ) {
	
		global $wpdb;
	
		if( empty( $key ) )
			return [];
	
		$r = $wpdb->get_col( $wpdb->prepare( "
				SELECT pm.meta_value FROM {$wpdb->postmeta} pm
				LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
				WHERE pm.meta_key = '%s'
				AND p.post_status = '%s'
				AND p.post_type = '%s'
				", $key, $status, $type ) );

		return array_unique($r);
	}
	
	/**
	 * Set search query for estates
	 * 
	 * @param WP_Query $query
	 */
	public static function setSearchQuery($query) {
		if (empty($_GET['post_type']) || $_GET['post_type'] != 'estate') {
			return;
		}
		
		$meta = [];
		
		if (!empty($_GET['min-price'])) {
			$meta[] = array(
				'key' => 'price',
				'value' => $_GET['min-price'],
				'compare' => '>=',
				'type' => 'NUMERIC'
			);
		}
		
		if (!empty($_GET['max-price'])) {
			$meta[] = array(
				'key' => 'price',
				'value' => $_GET['max-price'],
				'compare' => '<=',
				'type' => 'NUMERIC'
			);
		}
		
		if (!empty($_GET['min-area'])) {
			$meta[] = array(
				'key' => 'area',
				'value' => $_GET['min-area'],
				'compare' => '>=',
				'type' => 'NUMERIC'
			);
		}
		
		if (!empty($_GET['max-area'])) {
			$meta[] = array(
				'key' => 'area',
				'value' => $_GET['max-area'],
				'compare' => '<=',
				'type' => 'NUMERIC'
			);
		}
		
		$metaQuery = [];
		
		if (count($meta) > 1) {
			$metaQuery = array_merge($metaQuery, ['relation' => 'AND']);
		}
		
		if (!empty($meta)) {
			$metaQuery = array_merge($metaQuery, $meta);
			
			error_log(print_r($metaQuery, true));
			
			$query->set(
				'meta_query',
				$metaQuery
			);
		}
		
	}
}