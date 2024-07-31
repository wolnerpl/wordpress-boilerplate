<?php if (!defined('ABSPATH')) { exit; } ?>
<?php
function include_part($part_name) {
    echo get_template_part('parts/'. $part_name . '/' . $part_name);
    $style_path = get_template_directory() . '/parts/' . $part_name .'/style.min.css';
    if (file_exists($style_path)) {
        ?>
            <style><?php echo file_get_contents($style_path); ?></style>
        <?php
    }
    $script_path = get_template_directory() . '/parts/' . $part_name .'/script.min.js';
    if (file_exists($script_path)) {
        ?>
            <script><?php echo file_get_contents($script_path); ?></script>
        <?php
    }
}