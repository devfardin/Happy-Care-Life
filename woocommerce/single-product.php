<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
get_header();
wp_enqueue_style('happy_care_single_product');
?>
<main id="custom-product-page">
    <?php while (have_posts()):
        the_post();
        ?>
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
                <div>
                    <h1 <?php
                    global $product;
                    ?> class="product-details__status">Status: <span>
                            <?php echo $product->get_stock_status() ?> </span></h1>
                </div>
                <div class="product-description"><?php echo $product->get_short_description(); ?></div>

                <!-- Custom Add to Cart Button -->
                <div class="happy_product_action_button_wrapper">
                    <?php
                    global $product;
                    $pid = $product->get_id();
                    $product = wc_get_product(get_the_ID());
                    $regular_price = $product->get_regular_price();
                    $sale_price = $product->get_sale_price();
                    $stock_status = $product->get_stock_status();
                    ?>
                    <?php if (!empty($regular_price || $sale_price) & $stock_status == 'instock') { ?>
                        <?php
                        global $product;
                        $pid = $product->get_id();
                        ?>
                        <a href="<?php
                        echo do_shortcode('[add_to_cart_url id=' . $pid . ']') ?>" class="primary_btn">
                            অর্ডার করুন
                        </a>
                    <?php } else if ($stock_status == 'outofstock') { ?>
                            <a class="primary_btn">
                                স্টক আউট
                            </a>
                        <?php
                        } else { ?>
                            <a class="primary_btn">
                            <?php echo $stock_status ?>
                            </a>
                        <?php
                        } ?>

                    <a href="tel:+8801846038819" class="primary_btn">
                        অর্ডার করতে কল করুন +8801846038819
                    </a>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
    <!-- Product description and review section -->
    <div>
        <?php get_template_part('/includes/template-parts/product', 'detailsreviews') ?>          
    </div>
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

const accordionHeaders = document.querySelectorAll('.accordion-header');
accordionHeaders.forEach(header => {
  header.addEventListener('click', () => {
    const content = header.nextElementSibling; // Get the content panel
    if (content.classList.contains('active')) {
      content.classList.remove('active'); // Hide the content
    } else {
      content.classList.add('active'); // Show the content
    }
  });
});
</script>
<?php get_footer(); ?>