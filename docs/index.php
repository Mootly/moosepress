<?php
/* === Main help page ========================================================= *
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
$mpo_parts->h1_title          = 'Documentation';
$mpo_parts->link_title        = 'Documentation';
$mpo_parts->page_name         = $mpo_parts->h1_title;
$mpo_parts->section_name      = 'Documentation';
$mpo_parts->section_base      = '/docs';
$mpo_parts->accessibility     = 'standard';
$mpo_parts->pagemenu          = 'import';
$mpo_parts->bodyclasses       = 'final';
$page_path                    = $mpo_parts->page_path;
                    # import page components that are not generated by template.
require_once( $mpo_paths->php_widgets.'/menus/simple_crumbs.php' );
require_once( MP_ROOT.'docs/_assets/includes/menu.docs.php' );
                    # The main content body of the page is developed here.
                    # It can be built from pieces or written as a block,
                    # depending on the site.
ob_start();
?>
<!-- *** BEGIN CONTENT ******************************************************** -->

<h3>What's Here</h3>

<table class="list-table">
  <thead>
    <tr>
      <th>Page</th>
      <th>Description</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th colspan="2">List of Objects</th>
    </tr>
    <tr>
      <td><a href="<?=CURR_PATH?>/styles/">Style Guide</a></td>
      <td>The <cite>menu</cite> object stores the menu sets for a page.</td>
    </tr>
    <tr>
      <td><a href="<?=CURR_PATH?>/dev-notes/">Developer Notes</a></td>
      <td>The <cite>parts</cite> object contains information fields for a page as well as a content blob.</td>
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
                    # Invoke the template ------------------------------------- *
$mpo_parts->main_content = ob_get_clean();
ob_end_clean();
$page_elements = $mpo_parts->build_page();
echo ($twig->render($mpo_parts->template.$mpt_full_template, array('page'=>$page_elements['content'])));
?>
