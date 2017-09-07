<?php
/**
 * The template for displaying the home page.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Curio_Concept
 */

get_header(); ?>

<!--STORY-->
<section id="story" class="section section-story" aria-label="Story">
    <div class="container center-block">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 col-md-10 col-md-offset-1">
                <div class="vertical-center text-center">
                    <h2 class="story-text font-book text-gotham text-uppercase"><?php the_content(); ?></h2>
                </div>
            </div>
        </div>
    </div>
</section>
<!--END STORY-->

<?php
    $shop_args = array(
        'post_type' => 'cc_shop_category',
        'orderby'=>'menu_order',
        'order' => 'ASC',
        'posts_per_page' => 8
    );
    // NOT ACTUALLY A WP CATEGORY, ITS A CUSTOM POST TYPE
    $shop_categories = new WP_Query( $shop_args );
    if ( $shop_categories->have_posts() ) :
?>

<!--BRAND DISPLAY-->
<section id="shop" class="section section-shop">
    <div class="section-banner section-banner-shadow">
        <div class="bg-red">
            <div class="container center-block text-center">
                <a href="#" title="Shop Curio">
                    <img src="/wp-content/themes/curio-concept/img/shop-banner.png" alt="Shop Curio" title="Shop Curio" />
                </a>
            </div>
        </div>
    </div>
    <div class="container center-block">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="list-shop-category">
                    <?php $index = 1; while ( $shop_categories->have_posts() ) : $shop_categories->the_post(); ?>
                    <div class="item-shop-category shop-category-<?php echo $index; ?>">
                        <a href="<?php if ( get_field('ecom_link') ) : the_field('ecom_link'); endif; ?>">
                            <div class="shop-category-thumb">
                                <?php
                                    switch ($index) :
                                        case 1: the_post_thumbnail( array(320, 480), array( 'class' => 'shop-category-shadow' ) ); break;
                                        case 2: the_post_thumbnail( array(260, 330), array( 'class' => 'shop-category-shadow' ) ); break;
                                        case 3: the_post_thumbnail( array(300, 390), array( 'class' => 'shop-category-shadow' ) ); break;
                                        case 4: the_post_thumbnail( array(385, 595), array( 'class' => 'shop-category-shadow' ) ); break;
                                        case 5: the_post_thumbnail( array(375, 515), array( 'class' => 'shop-category-shadow' ) ); break;
                                        case 6: the_post_thumbnail( array(235, 310), array( 'class' => 'shop-category-shadow' ) ); break;
                                        case 7: the_post_thumbnail( array(240, 340), array( 'class' => 'shop-category-shadow' ) ); break;
                                        case 8: the_post_thumbnail( array(280, 425), array( 'class' => 'shop-category-shadow' ) ); break;
                                    endswitch;
                                ?>
                            </div>
                            <div class="shop-category-title">
                                <h3 class="text-black text-uppercase text-knockout text-xl no-margin">Shop <?php the_title(); ?></h3>
                            </div>
                        </a>
                    </div>
                    <?php $index++; endwhile; unset($index); wp_reset_postdata(); ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php endif; ?>

<!--INSTAGRAM--> 
<section id="social" class="section section-social">
	<div class="section-banner section-banner-shadow">
		<div class="bg-red">
			<div class="container center-block text-center">
				<a href="https://www.instagram.com/curioconceptstore/" title="Curio's Instagram" target="_blank">
					<img src="/wp-content/themes/curio-concept/img/instagram-banner.png" alt="Curio's Instagram" title="Curio's Instagram" />
				</a>
			</div>
		</div>
	</div>
	<?php
		$userid = "1073690021";
		$accessToken = "1073690021.1677ed0.12d46c22d5604e3cb65cbfa0fbeecaa6";
		$url = "https://api.instagram.com/v1/users/{$userid}/media/recent/?count=12&access_token={$accessToken}";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 20);
		$result = curl_exec($ch);
		curl_close($ch); 
		$result = json_decode($result);
		// remove potential null, false, empty array elems
		$ig_posts = array_filter($result->data);
	?>
	<div class="section-content">
		<div class="container center-block text-center">
			<div class="list-social">
				<div class="row">
					<?php foreach ( $ig_posts as $ig_post ) :  ?>
					<div class="col-xs-6 col-sm-6 col-md-3">
						<a class="social-item" href="<?php echo $ig_post->link; ?>" <?php if ( isset( $ig_post->caption->text ) ) { echo 'title="' . $ig_post->caption->text . '"'; } ?>>
							<img src="<?php echo $ig_post->images->low_resolution->url; ?>" width="200" height="200" />
						</a>
					</div>
					<?php endforeach; unset ($userid, $accessToken, $result, $ig_posts); ?>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
//get_sidebar();
get_footer();
