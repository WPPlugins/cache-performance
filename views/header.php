<div class="wrap wp-cache">
<h2><!--Wordpress notices here --></h2>
 <header>
  <div class="col-left">
    <h2>Cache and CDN Performance</h2>
    <small>Simple, effective Caching Plugin</small>
  </div>

  <div class="col-right"><strong>Help us build a better product</strong>
    <p><a target="blank" href="https://en-gb.wordpress.org/plugins/cache-performance/">Rate us on WordPress.org</a></p>
    <!-- <div class="stars">

    </div> -->
  </div>
</header>

<div class="container">
    <div class="tab-wrap">
      <ul class="tabs">
      <?php $page =  sanitize_text_field($_GET['page']); ?>
      <li><a class="tab-link <?php if($page == 'optimisationio')echo 'current';?>" href="?page=optimisationio"> Caching </a></li>
      <li><a class="tab-link <?php if($page == 'optimisationio-cdn-enabler')echo 'current';?>"  href="tools.php?page=optimisationio-cdn-enabler"> CDN Rewrite </a> </li>
      <li><a class="tab-link <?php if($page == 'optimisationio-db-optimise')echo 'current';?>"  href="tools.php?page=optimisationio-db-optimise"> Optimise DB </a> </li>
      </ul>
