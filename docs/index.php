<?php
/* === Main help page ========================================================= *
 * Copyright (c) 2019-2020 Mootly Obviate - See /LICENSE.md
* ---------------------------------------------------------------------------- */
                    # Call config to init the application
require_once( $_SERVER['DOCUMENT_ROOT'].'/config.php' );
                    # Build the page ------------------------------------------ *
                    # Content developers shouldn't touch anything above here.
                    # ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓ EDIT BELOW ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
                    # page_name should equal your H1 title.
$mpo_parts->h1_title          = 'Contents';
$mpo_parts->link_title        = 'Documentation';
$mpo_parts->page_name         = $mpo_parts->h1_title;
$mpo_parts->section_name      = 'Documentation';
$mpo_parts->section_base      = $mpo_paths->docs;
$mpo_parts->pagemenu          = 'perm';
$mpo_parts->bodyclasses       = 'final';
                    # import page components that are not generated by template.
require_once( $mpo_paths->php_widgets.'/menus/simple_crumbs.php' );
                    # The main content body of the page is developed here.
                    # It can be built from pieces or written as a block,
                    # depending on the site.
ob_start();
?>
<!-- *** BEGIN CONTENT ******************************************************** -->

<h2>What's Here</h2>

<table class="list-table" title="List of section contents">
  <thead>
    <tr>
      <th scope="col">Page</th>
      <th scope="col">Description</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th colspan="2">List of Topics</th>
    </tr>
    <tr>
      <td><a href="<?=CURR_PATH?>/blank.php">Blank Page</a></td>
      <td>Blank page template for development use.</td>
    </tr>
    <tr>
      <td><a href="<?=CURR_PATH?>/styles/">Style Guide</a></td>
      <td>Examples of most of the content style fules for the site.</td>
    </tr>
    <tr>
      <td><a href="<?=CURR_PATH?>/dev-notes/">CMS Developer Notes</a></td>
      <td>Details on the site and code structure.</td>
    </tr>
    <tr>
      <td><a href="<?=CURR_PATH?>/classes/">Class Library</a></td>
      <td>Definitions of the classes used in MoosePress.</td>
    </tr>
  </tbody>
</table>

<!-- *** end contents ********************************************************* -->
<?php
                    # ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑ EDIT ABOVE ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
                    # Content developers shouldn't touch anything below here.
$mpo_parts->main_content = ob_get_clean();
ob_end_clean();
                    // Submit to template generator --------------------------- *
mpf_renderPage($mpo_parts->template.$mpt_['default'].$mpt_['suffix'], $mpo_parts);
?>
