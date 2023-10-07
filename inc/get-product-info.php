<?php

// directly access denied
defined('ABSPATH') || exit;

echo '<ul class="wc-product-info">';
    while( $qry->have_posts() ): $qry->the_post();

        $get_title   = get_the_title();
        $short_title = mb_strimwidth( $get_title, 0, 30) . '...';
        $get_link    = esc_url( get_permalink( get_the_ID() ) );
        $categories  = get_the_terms( get_the_ID(), 'product_cat' );
        ?>
        <li class="wc-product-item">
                <div class="product-thumb">
                    <?php the_post_thumbnail();?>
                </div>
                <h2 class="wc-product-title">
                    <a href="<?php echo $get_link; ?>" target="_blank">
                        <?php echo $short_title; ?>
                    </a>
                </h2>
                <h5>
                    <?php
                        foreach ( $categories as $category ) {
                            $link = get_term_link( $category );
                            echo "<a href=\"{$link}\">{$category->name}</a>";
                        }
                    ?>
                </h5>
                <div class="wc-product-ratting">
                    <?php
                        woocommerce_template_single_rating( [ 'id' => get_the_ID() ] );
                    ?>
                </div>
                <div class="wc-product-button">
                    <?php
                        woocommerce_template_loop_add_to_cart(
                            [
                                'class' => 'button product_type_simple add_to_cart_button ajax_add_to_cart'
                            ]
                        );
                    ?>
                </div>
        </li>

        <?php
    endwhile;
echo '</ul>';
wp_reset_postdata();