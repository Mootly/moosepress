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
$mpo_parts->h1_title          = 'CKEditor Configuration';
$mpo_parts->link_title        = 'CKEditor';
$mpo_parts->page_name         = $mpo_parts->h1_title;
$mpo_parts->section_name      = 'Documentation: CMS Developer Notes';
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

<p>Ths CMS has been built to use <a href="https://ckeditor.com" taraget="-blank">CKEditor</a>. This resource is not included in this repository because of licensing issues and because configuration may include confidential information.</p>

<p>These are the notes on how CKEditor was configured during the initial build.</p>

<p> For reasons of compatibility with older systems, <a href="https://ckeditor.com/ckeditor-4/" target="_blank">version 4</a> of the editor was used.</p>

<h2 id="toc-links">Contents</h2>

<h2>Included Add-ons</h2>

<p>CKEditor was configured using the CKEditor-provided <a href="https://ckeditor.com/cke4/builder" target="_blank">Builder</a> tool. The <b>Basic</b> preset was used as a base to ensure only necessary items were incldued.</p>

<p>The following add-ons were included. This does not include any dependencies.</p>

<ul>
   <li><a href="https://ckeditor.com/cke4/addon/divarea" target="_blank">Dev Editing Area</a></li>
   <li><a href="https://ckeditor.com/cke4/addon/resize" target="_blank">Editor Resize</a></li>
   <li><a href="https://ckeditor.com/cke4/addon/image2" target="_blank">Enhanced Image</a></li>
   <li><a href="https://ckeditor.com/cke4/addon/filebrowser" target="_blank">File Browser</a></li>
   <li><a href="https://ckeditor.com/cke4/addon/maximize" target="_blank">Maximize</a></li>
   <li><a href="https://ckeditor.com/cke4/addon/uploadfile" target="_blank">Upload File</a></li>
   <li><a href="https://ckeditor.com/cke4/addon/uploadimage" target="_blank">Upload Image</a></li>
</ul>

<h2>Changes to <code>config.js</code></h2>

<p>Using the builder hides most of the code that would normally be in <code>config.js</code> in the main body of the application, but there are still some required edits.</p>

<h3 class="add-toc">Enable disabled buttons</h3>

<p>The basic build disables some basic editor functionality. They sohuld be re-enabled. The relevant assignments should read:</p>
<pre class="cc-js">
config.removeButtons = '';
config.removeDialogTabs = '';
</pre>

<h3 class="add-toc">Add resource paths</h3>
<p>CKEditor needs to talk to things on the back end. The following resource paths need to be defined.</p>
<pre class="cc-js">
<span class="cc-comment">// Paths to server resources</span>
config.baseHref = '';
config.uploadUrl = '';
config.imageUploadUrl = '';
config.filebrowserBrowseUrl = '/_assets/php_widgets/browse-file.php';
config.filebrowserUploadUrl = '/_assets/php_widgets/upload-image.php';
config.filebrowserImageBrowseUrl = '/_assets/php_widgets/browse-image.php';
config.filebrowserImageUploadUrl = '/_assets/php_widgets/upload-file.php';
</pre>

<h3 class="add-toc">Editor configuration</h3>
<p>Making sure the interface works the way we want it to.</p>
<pre class="cc-js">
<span class="cc-comment">// interface settings</span>
config.basicEntities = true;
config.bodyClass = 'editbox';
config.bodyID = 'editor-editbox';
config.contentsCss = '/_templates/ocfs_intra/_assets/css/core.min.css';
config.height = '25em';
config.image2_altRequired = true;
config.image2_disableResizer = false;
config.resize_enabled = true;
</pre>

<h2>Related Scripts</h2>

<h3 class="add-toc"><code>browse-file</code></h3>
<h3 class="add-toc"><code>browse-image</code></h3>
<h3 class="add-toc"><code>upload-file</code></h3>
<h3 class="add-toc"><code>upload-image</code></h3>

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