<?php
class Elementor_Products_widget extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'Products';
    }
    public function get_title()
    {
        return esc_html__('Products', 'happy_care');
    }
    public function get_icon()
    {
        return 'eicon-post-list';
    }
    public function get_categories()
    {
        return ['basic'];
    }
    public function get_keywords()
    {
        return ['Products', 'happy_care'];
    }
    protected function register_controls()
    {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Products', 'happy_care'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'category',
            [
                'label' => esc_html__('Product Category', 'happy_care'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('Medicine', 'happy_care'),
            ]
        );
        $this->add_control(
            'numberProducts',
            [
                'label' => esc_html__('Number of products', 'happy_care'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 6,
                'step' => 1,
                'min' => 6,
            ]
        );
        $this->end_controls_section();


        //********************
        // Style Tab Start
        // ******************
        $this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__('Title', 'elementor-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Text Color', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .hello-world' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();
        // Style Tab End
    }
    protected function render()
    {
        wp_enqueue_style("happy_care_products_style");
        $settings = $this->get_settings_for_display();
        $categoryItems = explode(",", $settings['category']);
        $items = $settings['numberProducts'];
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => $items,
            'orderby' => 'date',
            'order' => 'DESC',
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => $categoryItems,
                ),
            ),
        );
        $products = new WP_Query($args);

        if ($products->have_posts()) {
            echo '<div class="products_wrapper">';
            while ($products->have_posts()) {
                $products->the_post();
                $product = wc_get_product(get_the_ID());
                $regular_price = $product->get_regular_price();
                $sale_price = $product->get_sale_price();
                $stock_status = $product->get_stock_status();
                ?>
                <!-- Products Information here -->
                <div class="products_inner_wrapper">
                    <a href="<?php echo get_permalink(); ?>">
                        <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'medium'); ?>" alt="<?php the_title(); ?>">
                    </a>
                    <div class="products_inner__info">
                        <a href="<?php echo get_permalink(); ?>" class="product_inner_title"><?php the_title(); ?></a>
                        <!-- Price Wrapper -->
                        <div class="products_inner_price_wrapper">

                            <?php if ($regular_price && $sale_price) {
                                ?>
                                <h3 class="offer__price"><?php echo wc_price($regular_price) ?></h3>
                            <?php } else { ?>
                                <h3 class="regular__price"><?php echo wc_price($regular_price) ?></h3>
                            <?php } ?>

                            <?php if (!empty($sale_price)) { ?>
                                <h3 class="sele_price"><?php echo wc_price($sale_price) ?></h3>
                            <?php }
                            ?>
                        </div>
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
                    </div>
                </div>
                <?php
            }
            echo '</div>';
            wp_reset_postdata();
        } else {
            echo 'No products found.';
        }
    }
}
;