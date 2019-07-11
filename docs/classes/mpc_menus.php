<?php
/* === mpc_menus ============================================================== *
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
$mpo_parts->h1_title          = 'Classes: mpc_menus';
$mpo_parts->link_title        = 'mpc_menus';
$mpo_parts->page_name         = $mpo_parts->h1_title;
$mpo_parts->section_name      = 'Documentation: Class Library';
// $mpo_parts->section_base      = $mpo_parts->site_base .'/docs'
$mpo_parts->section_base      = $mpo_paths->docs;
$mpo_parts->accessibility     = 'standard';
$mpo_parts->pagemenu          = 'perm';
$mpo_parts->bodyclasses       = 'final, tech-notes';
                    # import page components that are not generated by template.
require_once( $mpo_paths->php_widgets.'/menus/simple_crumbs.php' );
                    # The main content body of the page is developed here.
                    # It can be built from pieces or written as a block,
                    # depending on the site.
ob_start();
?>
<!-- *** BEGIN CONTENT ******************************************************** -->

<p>The <cite>menu</cite> object stores the menu sets for a page.</p>

<p>Except for instantiation, method calls to the menus object always return arrays. The return array will have the following stucture:</p>

<dl>
  <dt><code>results['success'] bool</code></dt>
  <dd>
    <p>Returns true on success, false on an error.</p>
  </dd>
  <dt><code>results['content'] string | array</code></dt>
  <dd>
    <p>If there was an error, this will contain the error message associated with the reference code above. Otherwise it will return the string or array containing the returned values.</p>
  </dd>
</dl>

<p>At present, there is no functionality to:</p>
<ul>
  <li>remove menus or links from the menus object</li>
  <li>edit individual menu or link properties</li>
</ul>

<p>These are beyond the scope of the minimum viable product.</p>

<h2>Methods</h2>

<dl class="clamshell">

<dt>Constructor</dt>
  <dd>
    <pre><var>obj</var> = new mpc_menus( [<var>bool</var> is_locked=true] );</pre>

    <p>Use <code>is_locked</code> to specify existing values as immutable. This allows later scripts to add new menus and add new links to menus, but not change the attributes of existing links or menus.</p>

    <p>It is set to <code>true</code> by default.</p>
  </dd>
<dt>Create or edit menu</dt>
  <dd>
    <p>If a menu and its menu set is not locked, this method can be used to reset a menu.</p>

    <pre>$mpo_instance-&gt;setmenu( <var>str</var> name  [, <var>array</var> settings] );</pre>

    <p>Settings:</p>

    <dl>
    <dt><code>$settings['is_locked'] <var>bool</var> = false</code></dt>
      <dd><p>A menu can be locked spearately from the menu set. Setting this to false will not override a parent setting of true.</p></dd>
    <dt><code>$settings['permissions'] <var>str</var> = 'public'</code></dt>
      <dd>
        <p>A space separated string of permission levels for this menu. These are restrictive values. The string must be provided when generating the menu or the menu is blocked. The value of 'public' is a placeholder and is ignored by the code. Current permission levels are:</p>
        <ul>
          <li>public</li>
          <li>internal</li>
          <li>editor</li>
          <li>pio</li>
          <li>admin</li>
        </ul>
      </dd>
    <dt><code>$settings['type'] <var>str</var> = 'left-sidebar'</code></dt>
      <dd>
        <p>A template specific description of the function this menu serves. Most commonly, its location on the page.</p>
      </dd>
    <dt><code>$settings['classes'] <var>str</var> = ''</code></dt>
      <dd>
        <p>A space separated list of classes to be added to the container element when generating the menu.</p>
      </dd>
    </dl>
  </dd>
<dt>Create or edit a link</dt>
  <dd>
    <pre>$mpo_instance-&gt;setlink( str $menu, string $text, str $url [, array $settings] );</pre>
  </dd>
<dt>Return a menu as an HTML list</dt>
  <dd>
    <pre><var>str</var> = $mpo_menus-&gt;getmenu( str $name [, array $settings ] );</pre>
  </dd>
<dt>Return a menu as an array</dt>
  <dd>
    <pre><var>array</var> = $mpo_menus-&gt;getlist( str $name [, array $settings ] );</pre>
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
