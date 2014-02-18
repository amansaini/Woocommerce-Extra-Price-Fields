<?php
/*
  Plugin Name: Woocoomerce Extra Price Fields
  Description: Add Extra Fields to Price required to show in certain countries/region
  Author: Aman Saini
  Author URI: https://amansaini.me
  Plugin URI: http://amansaini.me/plugins/woocommerce-extra-price-fields/
  Version: 1.0
  Requires at least: 3.0.0
  Tested up to: 3.5.1

 */

/*
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */



  function add_custom_price_box() {

  	woocommerce_wp_text_input(array('id' => 'pro_price_extra_info', 'class' => 'wc_input_price_extra_info short', 'label' => __('Price Extra Info', 'woocommerce') . ' (' . get_woocommerce_currency_symbol() . ')', 'type' => 'number', 'custom_attributes' => array(
  	                          'step' => 'any',
  	                          'min' => '0'
  	                          )));


  }

  add_action('woocommerce_product_options_pricing', 'add_custom_price_box');

  function custom_woocommerce_process_product_meta($post_id, $post) {

  	update_post_meta($post_id, 'pro_price_extra_info', stripslashes($_POST['pro_price_extra_info']));
  }

  add_action('woocommerce_process_product_meta', 'custom_woocommerce_process_product_meta', 2, 2);

  function add_custom_price_front($p, $obj) {

  	$post_id = $obj->post->ID;

  	$pro_price_extra_info = get_post_meta($post_id, 'pro_price_extra_info', true);

  	if (is_admin()) {
  			//show in new line
  		$tag = 'div';
  	} else {
  		$tag = 'span';
  	}

  	if (!empty($pro_price_extra_info)) {
  		$additional_price= "<$tag style='font-size:80%' class='pro_price_extra_info'> $pro_price_extra_info</$tag>";
  	}


  	if( !empty($additional_price)	 )
  		return  $p . $additional_price ;
  	else
  		return  $p ;



  }

  add_filter('woocommerce_get_price_html', 'add_custom_price_front', 10, 2);

  ?>