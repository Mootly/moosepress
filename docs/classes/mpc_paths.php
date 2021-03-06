<?php
/* === Class Library - mpc_paths ============================================== *
 * Copyright (c) 2017-2020 Mootly Obviate - See /LICENSE.md
 * --- Revision History ------------------------------------------------------- *
 * 2019-05-29 | Add path grabber info.
 * 2018-05-09 | Copied over from test page.
 * ---------------------------------------------------------------------------- */
                    # Call config to init the application
require_once( $_SERVER['DOCUMENT_ROOT'].'/config.php' );
                    # Build the page ------------------------------------------ *
                    # Content developers shouldn't touch anything above here.
                    # ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓ EDIT BELOW ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
                    # page_name should equal your H1 title.
$mpo_parts->h1_title          = 'mpc_paths';
$mpo_parts->link_title        = 'mpc_paths';
$mpo_parts->page_name         = $mpo_parts->h1_title;
$mpo_parts->section_name      = 'Docs : Classes';
$mpo_parts->section_base      = $mpo_paths->docs;
$mpo_parts->pagemenu          = 'import';
$mpo_parts->bodyclasses       = 'final, tech-notes';
                    # import page components that are not generated by template.
ob_start();
require_once( MP_ROOT.'/docs/_assets/includes/menu.docs.php' );
$mpo_parts->page_menu = ob_get_clean();
ob_end_clean();
require_once( $mpo_paths->php_widgets.'/menus/simple_crumbs.php' );
                    # The main content body of the page is developed here.
                    # It can be built from pieces or written as a block,
                    # depending on the site.
ob_start();
?>
<!-- *** BEGIN CONTENT ******************************************************** -->

<p>The <cite>paths</cite> object stores internal paths for PHP use. This is to allow paths to be defined up front and then called from the object. This reduces typos and inconsistencies.</p>

<p>If a path is hard-coded in the process code instead of being defined in the config or init files, you did something wrong.</p>

<p>It uses magic functions to generate properties as needed. The properties defined on initialization and/or instantiation are:</p>

<ul>
  <li>core</li>
  <li>php_widgets</li>
  <li>mp_classlib</li>
  <li>template</li>
  <li>tp_classlib</li>
  <li>vendor</li>
</ul>

<h2>Methods</h2>

<dl class="clamshell">

  <dt>Constructor</dt>
  <dd>
    <pre><var>obj</var> = new mpc_paths( [<var>bool</var> is_locked=false] );</pre>

    <p>On instantiation, can be passed boolean to determine whether to protect existing values. When protected, you can add new paths, but not overwrite old.</p>
  </dd>

  <dt>Store or update a path</dt>
  <dd>
    <pre>$mpo_instance-&gt;<var>token</var> = <var>str</var>;</pre>

    <p>Where <b>token</b> is a label for identifying the path. This is a magic function to generate properties as needed.</p>
  </dd>

  <dt>Return a path</dt>
  <dd>
    <pre><var>str</var> = $mpo_instance-&gt;<var>token</var>;</pre>
    <p>Where <b>token</b> is a label for identifying the path. This is a magic function.</p>
  </dd>

  <dt>Return all paths in an array</dt>
  <dd>
    <pre><var>array</var> = $mpo_instance-&gt;build_list();</pre>
  </dd>

  <dt class="wrong-flag">Return the path to an asset <span class="red">(not complete)</span></dt>
  <dd>
    <pre><var>array</var> = $mpo_instance-&gt;get_asset( <var>string</var> type, <var>string</var> name [, <var>bool</var> embed=false] );</pre>
    <p>This method is used to determined where an asset lives for inclusion.Except as noted below, it checks paths in the following order:</p>
    <ul>
      <li><code><var>&lt;root&gt;</var>/<var>&lt;type&gt;</var>/<var>&lt;name&gt;</var></code></li>
      <li><code><var>&lt;template path&gt;</var>/assets/<var>&lt;type&gt;</var>/<var>&lt;name&gt;</var></code></li>
      <li><code><var>&lt;template path&gt;</var>/_assets/<var>&lt;type&gt;</var>/<var>&lt;name&gt;</var></code></li>
      <li><code><var>&lt;root&gt;</var>/assets/<var>&lt;type&gt;</var>/<var>&lt;name&gt;</var></code></li>
      <li><code><var>&lt;root&gt;</var>/_assets/<var>&lt;type&gt;</var>/<var>&lt;name&gt;</var></code></li>
    </ul>
    <p>These paths may be changed in the <b>init</b> process.</p>
    <p>On a successful hit it will stop searching. Templates always override root.</p>

    <table class="list-table">
      <thead>
        <th>parameter</th>
        <th>description</th>
      </thead>
      <tbody>
        <tr>
          <th>type</th>
          <td>
            <p>Determines the type of asset to be returned. It can be one of the following values:</p>
            <ul>
              <li><b>content</b> =&gt; 'htm,html,inc,php,txt'<br />
              Content type will do a deep search of the following folder:
                <ul>
                  <li><code><var>&lt;template path&gt;</var>/pages/</code></li>
                </ul>
              </li>
              <li><b>document</b> =&gt; 'doc,docx,dot,dotx,rtf,pdf,pps,ppt,pptx,xls,xlsm,xlsx,xlt,xltm,xltx'<br />
              Document type will do a deep searchof the following, in order:
                <ul>
                  <li><code><var>&lt;template path&gt;</var>/docs/</code></li>
                  <li><code><var>&lt;root&gt;</var>/docs/</code></li>
                  <li><code><var>&lt;root&gt;</var>/reports/</code></li>
                  <li><code><var>&lt;root&gt;</var>/forms/</code></li>
                </ul>
              </li>
              <li><b>image</b> => 'jpg,jpeg,gif,png,svg'<br />Image type will assume the <var>&lt;type&gt;</var> folder has one of the following names: <code>img</code>, <code>images</code>.</li>
              <li><b>script</b> => 'js'<br />Script type will assume the <var>&lt;type&gt;</var> folder has one of the following names: <code>js</code>, <code>scripts</code>.</li>
              <li><b>style</b> => 'css'<br />Style type will assume the <var>&lt;type&gt;</var> folder has one of the following names: <code>css</code>, <code>styles</code>.</li>
              <li><b>video</b> => 'avi,mov,mp4,mpg,mpeg,wmv,sbv,srt,sub,vtt'<br />Video type will assume the <var>&lt;type&gt;</var> folder has one of the following names: <code>vid</code>, <code>video</code>, <code>media</code>.</li>
              <li><b>widget</b> => 'inc,php,asp,aspx,cfm,cfml'<br />Widget type will assume the <var>&lt;type&gt;</var> folder has one of the following names: <code>widgets</code>, <code>php_widgets</code>.</li>
            </ul>
          </td>
        </tr>
        <tr>
          <th>name</th>
          <td>
            <p>The name of the file to be pathed. The suffix is optional, but recommended for images. If the suffix is included, it must match the type as above.</p>
          </td>
        </tr>
        <tr>
          <th>embed</th>
          <td>
            <p>Defaults to <b>false</b>.</p>
            <p>If <b>false</b>, return the full server-side directory path.</p>
            <p>If <b>true</b>, return the root-relative web path.</p>
          </td>
        </tr>
      </tbody>
    </table>
  </dd>

  <dt class="wrong-flag">Return the contents of a static widget <span class="red">(not complete)</span></dt>
  <dd>
    <pre><var>array</var> = $mpo_instance-&gt;get_widget( <var>name</var> );</pre>
    <p>This method accepts a file name and returns the content of a static widget. It checks the paths in the following order:</p>
    <ul>
      <li><code><var>&lt;template path&gt;</var>/_assets/widgets/<var>&lt;name&gt;</var></code></li>
      <li><code><var>&lt;template path&gt;</var>/_assets/php_widgets/<var>&lt;name&gt;</var></code></li>
      <li><code><var>&lt;root&gt;</var>/_assets/widgets/<var>&lt;name&gt;</var></code></li>
      <li><code><var>&lt;root&gt;</var>/_assets/php_widgets/<var>&lt;name&gt;</var></code></li>
    </ul>
    <p>These paths may be changed in the <b>init</b> process.</p>
    <p>On a successful hit it will stop searching. Templates always override root.</p>
    <p>A suffix is not required, but may be included for disabiguation in the case of poorly managed libraries. The method requires the suffix is a valid suffix for type <b>content</b> as noted under <code>$mpo_instance-&gt;get_asset( );</code> above.</p>
  </dd>
</dl>
<!-- *** end contents ********************************************************* -->
<?php
                    # ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑ EDIT ABOVE ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
                    # Content developers shouldn't touch anything below here.
$mpo_parts->main_content = ob_get_clean();
ob_end_clean();
                    // Submit to template generator --------------------------- *
mpf_renderPage($mpo_parts->template.$mpt_['default'].$mpt_['suffix'], $mpo_parts);
?>
