<?php
/**
 * Plugin Name: Bestseller Book Block
 * Description: A custom block to display best-selling books by genre using the Biblio API.
 * Version: 1.0.0
 * Author: Rajeev Vishwakarma
 */


function biblio_bestsellers_enqueue_scripts() {
    wp_enqueue_style('biblio-bestsellers-style', plugins_url('style.css', __FILE__));
    wp_enqueue_script('biblio-bestsellers-script', plugins_url('script.js', __FILE__), array('jquery'), null, true);
    wp_localize_script('biblio-bestsellers-script', 'biblio_bestsellers_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'api_key' => 'qx4hfd2x6r4re89tbkxga2hy',
    ));
}
add_action('wp_enqueue_scripts', 'biblio_bestsellers_enqueue_scripts');


function biblio_bestsellers_shortcode() {
    ob_start(); ?>

    <div class="biblio-bestseller-block">
        <p class="main-heading">Choose a genre...</p>
        <select class="genre-select"></select>
        <div id="book-details">
			<div class="left-section">
				<div class="left-section-inner">
					<p class="title">Bestsellers</p>
					<div class="book-cover">
						<img src="<?php echo plugins_url('img/9780241552636-jacket-large 1.png', __FILE__); ?>" />
					</div>
					<p class="book-title">Ulysses</p>
					<p class="book-authors">James Joyce, Declan Kiberd (Introducer)</p>
					<a class="buy-now-button" href="#" target="_blank">BUY FROM AMAZON</a>
					<div class="penguine-img-section">
						<img class="penguine-img" src="<?php echo plugins_url('img/logo.svg', __FILE__); ?>" />
					</div>
				</div>
			</div>
			<div class="sidebar">
				<div class="custom-tabs">

				  <div class="tab-titles">
					<button class="tab-title" data-tab="post">Post</button>
					<button class="tab-title active" data-tab="block">Block</button>
				  </div>

				  <div class="tab-contents">
					<div id="post" class="tab-content">
					  <p>Not Found</p>
					</div>
					<div id="block" class="tab-content active">
					  <p class="main-heading">GENRE</p>
					  <select class="genre-select"></select>
					</div>
				  </div>
			    </div>
			</div>
            
        </div>
    </div>

    <?php return ob_get_clean();
}
add_shortcode('biblio_bestsellers', 'biblio_bestsellers_shortcode');


function biblio_get_genres() {
    $api_key = 'qx4hfd2x6r4re89tbkxga2hy';
    $response = wp_remote_get("https://api-test.penguinrandomhouse.com/resources/v2/title/domains/PRH.UK/categories?rows=10&api_key=$api_key", array('timeout' => 120));

    if (is_wp_error($response)) {
        wp_send_json_error('Unable to fetch genres');
    }

    $data = json_decode(wp_remote_retrieve_body($response), true);
    wp_send_json_success($data);
}
add_action('wp_ajax_biblio_get_genres', 'biblio_get_genres');
add_action('wp_ajax_nopriv_biblio_get_genres', 'biblio_get_genres');


function biblio_get_best_selling_book() {
    $api_key = 'qx4hfd2x6r4re89tbkxga2hy';
    $genre_id = sanitize_text_field($_POST['genre']);
    $response = wp_remote_get("https://api-test.penguinrandomhouse.com/resources/v2/title/domains/PRH.UK/works/views/uklist-display?catUri=$genre_id&sort=weeklySales&dir=desc&rows=1&api_key=$api_key", array('timeout' => 120));
	print_r($response);
    if (is_wp_error($response)) {
        wp_send_json_error('Unable to fetch book details');
    }

    $data = json_decode(wp_remote_retrieve_body($response), true);
    wp_send_json_success($data);
}
add_action('wp_ajax_biblio_get_best_selling_book', 'biblio_get_best_selling_book');
add_action('wp_ajax_nopriv_biblio_get_best_selling_book', 'biblio_get_best_selling_book');
