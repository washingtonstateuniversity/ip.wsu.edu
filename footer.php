<?php get_template_part( 'spine' ); ?>

<?php get_template_part('parts/after-main'); ?>
</div><!--/binder-->
<?php get_template_part('parts/after-binder'); ?>
</div><!--/jacket-->
<?php get_template_part('parts/after-jacket'); ?>

<?php get_template_part('parts/contact'); ?>

<?php wp_footer(); ?>

<script type="text/javascript">
jQuery(document).ready(function($) {
$(window).scroll(function() {
    if ($(this).scrollTop() > 1){  
        $('#binder > main > header > div.header-group').addClass("sticky");
    }
    else{
        $('#binder > main > header > div.header-group').removeClass("sticky");
    }
});	
});
</script>

</body>
</html>