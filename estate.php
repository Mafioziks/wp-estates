<?php

/**
 * Plugin Name: Estates
 * Author: Toms Teteris
 * Author email: toms.teteris@inbox.eu
 * Description: Used by millions, Akismet is quite possibly the best way in the world to <strong>protect your blog from spam</strong>. It keeps your site protected even while you sleep. To get started: activate the Akismet plugin and then go to your Akismet Settings page to set up your API key.
 * Version: 3.3
 * Author URI: http://tomsteteris.id.lv/
 * Text Domain: estates
 */

function addEstatePostType() {
	register_post_type('tt_estate',
                       [
                           'labels'      => [
                               'name'          => __('Estates'),
                               'singular_name' => __('Estate'),
                           ],
                           'public'      => true,
                           'has_archive' => true,
                           'rewrite'     => ['slug' => 'estates'],
                           'supports'    => array( 'title', 'thumbnail', 'editor' ),
                           'menu_icon'   => 'dashicons-store',
                       ]
    );
}

// register_activation_hook( __FILE__, 'addEstatePostType' );

add_action('init', 'addEstatePostType');
 
function admin_init(){
  add_meta_box("price-meta", "Price", "price", "tt_estate", "side", "low");
  add_meta_box("address_meta", "Location", "address_meta", "tt_estate", "normal", "low");
}
 
function price(){
  global $post;
  $custom = get_post_custom($post->ID);
  $year_completed = $custom["price"][0];
  ?>
  <label>Price:</label>
  <input name="price" value="<?php echo $price; ?>" />
  <?php
}
 
function address_meta() {
  global $post;
  $custom = get_post_custom($post->ID);
  $country = $custom["country"][0];
  $city = $custom["city"][0];
  $street = $custom["street"][0];
?>
  <p><label>Country:</label><br />
  <textarea cols="50" rows="5" name="country"><?php echo $country; ?></textarea></p>
  <p><label>City:</label><br />
  <textarea cols="50" rows="5" name="city"><?php echo $city; ?></textarea></p>
  <p><label>Street:</label><br />
  <textarea cols="50" rows="5" name="street"><?php echo $street; ?></textarea></p>
  <?php
}

add_action("admin_init", "admin_init");