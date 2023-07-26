<?php get_header();

$content = [];

while (have_posts()) {
    the_post();
    $content[] = apply_filters('the_content', get_the_content());
} ?>

<div id="app">
<?php echo implode($content); ?>
</div>

<?php get_footer(); ?>
