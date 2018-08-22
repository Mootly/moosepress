<?php
/* === Style Guide ============================================================ *
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
$mpo_parts->h1_title          = 'Classes: mpc_parts';
$mpo_parts->link_title        = 'mpc_parts';
$mpo_parts->page_name         = $mpo_parts->h1_title;
$mpo_parts->section_name      = 'Documentation: Class Library';
// $mpo_parts->section_base      = $mpo_parts->site_base .'/docs'
$mpo_parts->section_base      = $mpo_paths->docs;
$mpo_parts->accessibility     = 'standard';
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

<p>The <cite>parts</cite> object contains information fields for a page as well as a content blob.</p>

<p>It can also be used recursively for page components.</p>

<h3>Properties</h3>

<p>It uses magic functions to generate properties as needed. The properties defined on initialization, instantiation or otherwise used by the default page templates are:</p>

<dl class="inline-terms">
  <dt>accessibility</dt>
  <dd><p>Flag to set accessibility features on the page.</p></dd>
  <dt>alt_template</dt>
  <dd><p>A template override. Should only be used if sharing between templates is allowed.</p></dd>
  <dt>bodyclasses</dt>
  <dd><p>Space separated list of classes to add to <b>body</b> element.</p></dd>
  <dt>crumbs</dt>
  <dd><p>Used by the breadcrumb widget for a breadcrumb element.</p></dd>
  <dt>link_title</dt>
  <dd><p>Not currently used.</p></dd>
  <dt>main_content</dt>
  <dd><p>The body of the page.</p></dd>
  <dt>pagemenu</dt>
  <dd><p>A flag or name indicating what menu to use for the primary local menu.</p></dd>
  <dt>page_name</dt>
  <dd><p>The name of the current page. Should equal the H1 title.</p></dd>
  <dt>page_path</dt>
  <dd><p>The path to the current page.</p></dd>
  <dt>page_title</dt>
  <dd><p>The title of the current page as it will appear in the title bar.</p></dd>
  <dt>perm_template</dt>
  <dd><p>A template override. Should always be <code>mp_basic</code>. Should only be used if sharing between templates is allowed.</p></dd>
  <dt>section_base</dt>
  <dd><p>The path to the root of the current site section.</p></dd>
  <dt>section_name</dt>
  <dd><p>The name of the current site section.</p></dd>
  <dt>separator</dt>
  <dd><p>Separator for <b>title</b> elements. Not part of the final component array.</p></dd>
  <dt>site_abbr</dt>
  <dd><p>An abbreviation for the name of the site. Useful for namespacing and the like.</p></dd>
  <dt>site_name</dt>
  <dd><p>The name of the site. Should appear in the masthead and be the last item in the <b>title</b> attribute.</p></dd>
  <dt>template</dt>
  <dd><p>The path to the template to be used by this page. For shared templates, this should be <code>/_templates/</code>. Otherwise it should be <code>/_templates/<var>templatename</var>/</code></p></dd>
  <dt>title_struct</dt>
  <dd><p>Pattern for generating page title. Not part of the final component array.</p></dd>
</dl>

<h3>Methods</h3>

<dl class="clamshell">

  <dt>Constructor</dt>
  <dd>
    <pre>$mpo_parts = new $mpc_parts( [bool $is_locked=false] );</pre>

    <p>On instantiation, can be passed boolean to determine whether to protect existing values. When protected, you can add new page components, but not overwrite old.</p>
  </dd>

  <dt>Store or update a page component</dt>
  <dd>
    <pre>$mpo_parts-&gt;<var>component</var> = <var>value</var>;</pre>

    <p>Uses magic functions to generate properties as needed.</p>
  </dd>

  <dt>Return a page component</dt>
  <dd>
    <pre>$result = $mpo_parts-&gt;<var>component</var>;</pre>
  </dd>

  <dt>Set the page title</dt>
  <dd>
    <p>There are two parts to setting the page title:</p>
    <ul>
      <li>specifying the format, and</li>
      <li>specifying the values.</li>
    </ul>
    <p>The format consists of an array of the names of the property to be concatenated, in order of appearance, and the separator to use between them, including spaces.</p>
    <p>The default format and values are as follows:</p>
    <pre>
// set the structure
$mpo_parts-&gt;title_struct  = ['page_name','section_name','site_name'];
$mpo_parts-&gt;separator     = ' | ';
// set the parts
$mpo_parts-&gt;page_name     = <var>value</var>;
$mpo_parts-&gt;section_name  = <var>value</var>;
$mpo_parts-&gt;site_name     = <var>value</var>;</pre>
  <p>A simple title including just the page name would be formatted as follows:</p>
  <pre>
$mpo_parts-&gt;title_struct  = ['page_name'];
$mpo_parts-&gt;separator     = '';
$mpo_parts-&gt;page_name     = <var>value</var>;</pre>
  </dd>

  <dt>Return the complete page title for the title bar</dt>
  <dd>
    <pre>$result = $mpo_parts-&gt;build_title();</pre>

    <p>This action is performed automatically when you build the page.</p>
    <p>The default title has the format of: <b><var>page name</var> | <var>section name</var> | <var>site name</var></b>. Empty components will be omitted from the string.</p>
  </dd>

  <dt>Return an array of all page components</dt>
  <dd>
    <pre>$result = $mpo_parts-&gt;build_page();</pre>

    <p>The results include an arry of all page components added by the name of the property to which they were assigned.</p>
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
