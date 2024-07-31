<?php if (!defined('ABSPATH')) { exit; } ?>
<?php if (have_rows('slides')): ?>
  <div class="slider">
    <div class="swiper slider__swiper">
      <div class="swiper-wrapper slider__wrapper">
        <?php while (have_rows('slides')) : the_row(); 
              $image_id = get_sub_field('image');
        ?>
          <div class="swiper-slide slider__slide">
            <?php echo wp_get_attachment_image($image_id, 'slider'); ?>
          </div>
        <?php endwhile; ?>
      </div>
      <div class="swiper-pagination slider__pagination"></div>
      <div class="swiper-button-prev slider__prev"></div>
      <div class="swiper-button-next slider__next"></div>
      <div class="swiper-scrollbar slider__scrollbar"></div>
    </div>
  </div>
<?php endif; ?>