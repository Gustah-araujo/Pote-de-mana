<?php
/**
 * Header-v12 template.
 *
 * @author     Sapid
 * @copyright  (c) Copyright by Sapid
 * @package    Sapid
 * @subpackage Core
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}
?>
<?php
$content_1 = sapid_get_theme_option( 'header-plain-text');
$content_2 = sapid_header_social();
$content_3 = sapid_contact_info();
$container_class = 'container ';
?>
<header class="header14 common-header position-relative">
    <!-- Topbar  -->
    <?php
    /*
    <div class="h14-topbar bg-sec">
      <div class="<?php echo $container_class; ?>">
        <nav class="navbar navbar-expand-lg font-14">
          <a class="navbar-brand d-lg-none" href="#">Top Menu</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#header14a" aria-controls="header14a" aria-expanded="false" aria-label="Toggle navigation">
            <span class="mdi mdi-dots-vertical"></span>
          </button>
          <div class="collapse navbar-collapse" id="header14a">
            <?php echo $content_1; ?>
            <div class="ml-auto">
              <?php echo $content_2; ?>
            </div>
          </div>
        </nav>
      </div>
    </div> */ ?>
    <!-- Infobar  -->
    <div class="h14-infobar">
      <div class="<?php echo $container_class; ?>">
        <nav class="navbar navbar-expand-lg h14-info-bar">
          <?php sapid_logo(); ?>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#h14-info" aria-controls="h14-info" aria-expanded="false" aria-label="Toggle navigation">
            <span class="mdi mdi-dots-vertical"></span>
          </button>
          <div class="collapse navbar-collapse" id="h14-info">
            <div class="ml-auto">
              <?php echo $content_3; ?>
            </div>
          </div>
        </nav>
      </div>
    </div>
    <!-- Navbar  -->
    <div class="h14-navbar pt-lg-0 pb-lg-0 pb-2 pt-2">
      <div class="<?php echo $container_class; ?>">
        <nav class="navbar navbar-expand-lg h14-nav">
          <span class="d-none">Navigation</span>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#header14" aria-expanded="false" aria-label="Toggle navigation">
            <span class="mdi mdi-menu-open"></span>
          </button>
          <div class="collapse navbar-collapse" id="header14">
            <div class="hover-dropdown">
              <?php  
              if ( has_nav_menu( 'primary-menu' ) ) {
                wp_nav_menu( 
                  array(
                    'theme_location' => 'primary-menu',
                    'menu' => 'ul',
                    'menu_class' => 'navbar-nav',
                    'container' => false,
                    'walker' => new sapid_menu_walker()
                  )
                ); 
              } 
              ?>
            </div>
            <ul class="navbar-nav ml-auto">
              <li class="nav-item search dropdown">
                <a class="nav-link " href="javascript:void(0)" id="h14-sdropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="mdi mdi-card-search fs-3"></i>
                </a>
                <div class="dropdown-menu b-none dropdown-menu-right animated fadeInDown" aria-labelledby="h14-sdropdown">
                  <?php get_search_form( true ); ?>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </div>
    </div>
  </header>