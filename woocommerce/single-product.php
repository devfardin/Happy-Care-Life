<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

get_header();
wp_enqueue_style('happy_care_single_product');
?>

<main id="custom-product-page">
    <?php while (have_posts()):
        the_post(); ?>

        <div class="happy_product_single_container">
            <!-- Product Image -->
            <!-- Product Images (Feature Image & Gallery) -->
            <div class="product-images">

                <!-- Product Gallery Feature Start -->
                <div class="vrmedia-gallery">
                    <ul class="ecommerce-gallery">
                        <?php
                        global $product;
                        // Get the featured image (main product image)
                        $featured_image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
                        $featured_thumb_url = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
                        if ($featured_image_url) {
                            echo '<li data-fancybox="gallery" data-src="' . esc_url($featured_image_url) . '" data-thumb="' . esc_url($featured_thumb_url) . '">
                            <img src="' . esc_url($featured_thumb_url) . '">
                            </li>';
                        }

                        // Get gallery images
                        $attachment_ids = $product->get_gallery_image_ids();
                        if ($attachment_ids) {
                            foreach ($attachment_ids as $attachment_id) {
                                $image_url = wp_get_attachment_url($attachment_id);
                                $image_thumb = wp_get_attachment_image_url($attachment_id, 'thumbnail');
                                echo '<li data-fancybox="gallery" data-src="' . esc_url($image_url) . '" data-thumb="' . esc_url($image_thumb) . '">
                                <img src="' . esc_url($image_thumb) . '">
                                </li>';
                            }
                        }
                        ?>
                    </ul>
                </div>
                <!-- Product Gallery Feature End -->
            </div>

            <!-- Product Summary -->
            <div class="product-details">
                <h1 class="product-title"><?php the_title(); ?></h1>
                <div class="product-price"><?php wc_get_template('single-product/price.php'); ?></div>
                <div class="product-description"><?php the_excerpt(); ?></div>

                <!-- Custom Add to Cart Button -->
                <div class="custom-add-to-cart">
                    <?php
                    global $product;
                    $pid = $product->get_id();
                    ?>
                    <a href="<?php
                    echo do_shortcode('[add_to_cart_url id=' . $pid . ']') ?>" class="primary_btn">
                        অর্ডার করুন
                    </a>
                </div>

                <!-- Product Meta (Categories, Tags) -->
                <div class="product-meta">
                    <?php woocommerce_template_single_meta(); ?>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
</main>

<script>
    jQuery(document).ready(function ($) {
        $(".ecommerce-gallery").lightSlider({
            gallery: true,
            item: 1,
            loop: true,
            thumbItem: 4,
            thumbMargin: 10,
            slideMargin: 0
        });
    });
</script>
<?php get_footer(); ?>