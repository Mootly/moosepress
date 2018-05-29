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
$mpo_parts->h1_title          = 'Commenting the Code';
$mpo_parts->link_title        = 'Comments';
$mpo_parts->page_name         = $mpo_parts->h1_title;
$mpo_parts->section_name      = 'Documentation: Developer Notes';
$mpo_parts->section_base      = '/docs';
$mpo_parts->accessibility     = 'standard';
$mpo_parts->pagemenu          = 'perm';
$mpo_parts->bodyclasses       = 'final';
$page_path                    = $mpo_parts->page_path;
                    # import page components that are not generated by template.
require_once( $mpo_paths->php_widgets.'/menus/simple_crumbs.php' );
                    # The main content body of the page is developed here.
                    # It can be built from pieces or written as a block,
                    # depending on the site.
ob_start();
?>
<!-- *** BEGIN CONTENT ******************************************************** -->
<p>MoosePress uses multiple types of commments, depending on function.</p>
<p>All comments in the code should be written to be stripped out by the parser unless otherwise noted.</p>
<dl class="inline-terms">
  <dt id="dfn-comments-block">simple block</dt>
  <dd>
    A basic block or multiline comment uses slashterisk notation.
    <pre>/*<br /> * Some long decription<br /> */</pre>
  </dd>
  <dt id="dfn-comments-block">PHPDoc</dt>
  <dd>
    A comment block that documents how functions or objects work, or catalogs the contents of the current file, uses the modified slashterisk format to conform to PHPDoc standard. This allows PHPDoc-aware editors to color code keywords in the comments, as well as allowing a PHPDoc parser to generate documentation from the comments.
    <pre>/**<br />  * Some long decription<br />  */</pre>
  </dd>
  <dt id="dfn-comments-block">inline</dt>
  <dd>
    Where possible, inline comments beign with a hash mark: <code>#</code>. This is to differentiate it from commented-out code.
    <pre># inline comment</pre>
    For section breaks, or to call out a comment, use one or more asterisks at the end to make it easier to scan for comments.
    <pre># Do some new stuff -------------------------------------------------- ***</pre>
  </dd>
  <dt id="dfn-comments-block">inactive code</dt>
  <dd>
    Code is commented out with a double slash <code>//</code>. This is the default in PHP, so if you use hot keys to comment out blocks of code, it is what you will get.
    <pre>// echo testvar;</pre>
  </dd>
  <dt id="dfn-comments-block">template</dt>
  <dd>
    Twig uses the following syntax for comments in its templates.
    <pre>{# Your comment here #}</pre>
  </dd>
  <dt id="dfn-comments-block">important</dt>
  <dd>
    For important comments that need to be preserved when minifying CSS and JavaScript, most parsers follow the system of including an exclamation mark after the opening tag of the comment. It is most commonly used to preserve copyright information or attributions.
    <pre>/*! Keep this comment intact! */</pre>
  </dd>
</dl>
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
