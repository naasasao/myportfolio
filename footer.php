<?php
$home = esc_url(home_url('/'));
$about = esc_url(home_url('/about/'));
$works = esc_url(home_url('/works/'));
$concept = esc_url(home_url('/concept/'));
$contact = esc_url(home_url('/contact/'));
?>


<footer class="footer">
  <div class="footer__inner">

    <ul class="footer__nav">
        <li class="footer__nav-item">
            <a href="<?php echo esc_url( home_url('/')); ?>" class="footer__logo-link">
            <img src="<?php echo get_template_directory_uri(); ?>/images/sitelogo.png" alt="フッターロゴ">
          </a>
        </li>
        <li class="footer__nav-item"><a href="<?php echo $about ?>">ABOUT ME</a></li>
        <li class="footer__nav-item"><a href="<?php echo $works ?>">WORKS</a></li>
        <!-- <li class="footer__nav-item"><a href="<?php echo $about ?>">concept</a></li> -->
        <li class="footer__nav-item"><a href="<?php echo $contact ?>">CONTACT</a></li>
        <li class="footer__nav-item"><a href="#">Page Top</a></li>
    </ul>


  </div>
</footer>

<?php wp_footer(); ?>

</body>
</html>


