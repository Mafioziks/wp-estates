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
			$text = esc_attr($instance['text']);
			$textarea = esc_textarea($instance['textarea']);
		} else {
			$title = '';
			$text = '';
			$textarea = '';
		}
		?>
		
		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'wp_widget_plugin'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Text:', 'wp_widget_plugin'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" type="text" value="<?php echo $text; ?>" />
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id('textarea'); ?>"><?php _e('Textarea:', 'wp_widget_plugin'); ?></label>
		<textarea class="widefat" id="<?php echo $this->get_field_id('textarea'); ?>" name="<?php echo $this->get_field_name('textarea'); ?>"><?php echo $textarea; ?></textarea>
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
		$instance['text'] = strip_tags($new_instance['text']);
		$instance['textarea'] = strip_tags($new_instance['textarea']);
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
		$text = $instance['text'];
		$textarea = $instance['textarea'];
		echo $before_widget;
		// Display the widget
		echo '<div class="widget-text wp_widget_plugin_box">';
		
		// Check if title is set
		if ( $title ) {
			echo $before_title . $title . $after_title;
		}
		
		$estateType = get_terms( array(
		    'taxonomy' => 'estate_type',
		    'hide_empty' => false,
		) );
		
		$estateSerie = get_terms( array(
				'taxonomy' => 'estate_serie',
				'hide_empty' => false
		) );
		
		?>
		<form id="estate-search" role="search" method="get" id="searchform" action="/">
			<input type="hidden" value="estate" name="post_type" />
			<div>
				<h2><?php echo $text; ?></h2>
				<div>
					<label for="s"><?php echo __('Meklēt: ', 'textdomain'); ?></label>
					<input type="text" value="" name="s" id="s" />
					<input type="submit" id="searchsubmit" value="<?php echo __('Meklēt', 'textdomain'); ?>" />
					<div class="clear"></div>
				</div>
				<div>
					<div class="column">
						<div>
							<label class="field-title">Īpašuma veids:</label>
							<select>
								<?php foreach ($estateType as $type): ?>
								<option><?php echo $type->name; ?></option>
								<?php endforeach;?>
							</select>
						</div>
						<div>
							<label class="field-title">Platība</label>
							<input type="number" min="0" placeholder="Min"/><label> - </label><input type="number" min="0" placeholder="Max"/>
						</div>
					</div>
					<div class="column">
						<div>
							<label class="field-title">Sērija:</label>
							<select>
								<?php foreach ($estateSerie as $serie): ?>
								<option><?php echo $serie->name; ?></option>
								<?php endforeach;?>
							</select>
						</div>
						<div>
							<label class="field-title">Cena:</label>
							<input type="number" min="0"  placeholder="Min"/><label> - </label><input type="number" min="0" placeholder="Max"/><label>EUR</label>
						</div>
					</div>
					<div class="column">
						<div>
							<label class="field-title">Izstabu skaits:</label>
							<input type="number" min="0"  placeholder="Min"/><label> - </label><input type="number" min="0" placeholder="Max"/>
						</div>
						<div>
							<label class="field-title">Stāvs</label>
							<input type="number" id="floor" min="0" max="16"  placeholder="Min"/><label> - </label><input type="number" min="0" placeholder="Max"/>
						</div>
					</div>
				</div>
			</div>
		</form>
		<?php
		
		echo $after_widget;
	}
	
	function get_meta_values( $key = '', $type = 'estate', $status = 'publish' ) {
	
		global $wpdb;
	
		if( empty( $key ) )
			return;
	
			$r = $wpdb->get_col( $wpdb->prepare( "
					SELECT pm.meta_value FROM {$wpdb->postmeta} pm
					LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
					WHERE pm.meta_key = '%s'
					AND p.post_status = '%s'
					AND p.post_type = '%s'
					", $key, $status, $type ) );
	
			return array_unique($r);
	}
	
	/* Meta keys to query
	 * 
	 * $query->set(
  'meta_query', 
  array(
    array(
      'key' => 'shru_price',
      'value' => $_GET['minPrice'],
      'compare' => '>=',
      'type' => 'NUMERIC'
    )
  )
);
	 * */
}