<?php
/* === Developer Notes ======================================================== *
 * Copyright (c) 2017-2018 Mootly Obviate - See /LICENSE.md
 * --- Revision History ------------------------------------------------------- *
 * 2018-05-09 | Copied over from test page.
 * ---------------------------------------------------------------------------- */
                    # Call config to init the application
require_once( $_SERVER['DOCUMENT_ROOT'].'/config.php' );
                    # Build the page ------------------------------------------ *
                    # Content developers shouldn't touch anything above here.
                    # ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓ EDIT BELOW ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
                    # page_name should equal your H1 title.
$mpo_parts->h1_title          = 'Contents';
$mpo_parts->link_title        = 'Developer Notes';
$mpo_parts->page_name         = $mpo_parts->h1_title;
$mpo_parts->section_name      = 'Documentation: CMS Dev Notes';
$mpo_parts->section_base      = $mpo_paths->docs;
$mpo_parts->bodyclasses       = 'final tech-notes';
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
      <th colspan="2">CMS Developer Notes</th>
    </tr>
    <tr>
      <td><a href="<?=CURR_PATH?>/organization.php">Code Organization</a></td>
      <td>How the code has been structured.</td>
    </tr>
    <tr>
      <td><a href="<?=CURR_PATH?>/comments.php">Comments</a></td>
      <td>Guidelines on using comments in the code.</td>
    </tr>
    <tr>
      <td><a href="<?=CURR_PATH?>/comments.php">Constants</a></td>
      <td>Constants defined in the code.</td>
    </tr>
    <tr>
      <td><a href="<?=CURR_PATH?>/naming.php">Naming Conventions</a></td>
      <td>Naming conventions used throughout the project.</td>
    </tr>
    <tr>
      <td><a href="<?=CURR_PATH?>/ckeditor.php">CKEditor Configuration</a></td>
      <td>Configuration information for CKEditor and the location of related scripts.</td>
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
