<?php
/** --------------------------------------------------------------------------- *
  * This is the init script for the Minor Key application.
  *
  * @copyright 2017 Mootly Obviate
  * @package   minor_key
  * --------------------------------------------------------------------------- */

/** --------------------------------------------------------------------------- *
  * Application presets.
  */
  define('MK_PSEP', '/');
  define('MK__DIR__', dirname(__FILE__,2));
  define('MK__CLASSLIB__', MK__DIR__ . MK_CLASSLIB );
  require_once( MK__CLASSLIB__ . '/mkc_paths.php');

  if (!isset($mko_paths)) { $mko_paths = new mkc_paths(true); }
  $mko_paths->mk_classlib   = MK__CLASSLIB__;
  $mko_paths->core          = MK__DIR__ . '/m_core';
  $mko_paths->vendor        = MK__DIR__ . '/vendor';
  if(defined('DEF_TEMPLATE')) {
    $mko_paths->template    = MK__DIR__ . DEF_TEMPLATE .'/' ;
    $mko_paths->tp_classlib = MK__DIR__ . DEF_TEMPLATE .'/classlib';
  } elseif (defined('DEF_PREFIX')) {
    $mko_paths->template    = MK__DIR__ . '/templates/'. DEF_PREFIX .'/' ;
    $mko_paths->tp_classlib = MK__DIR__ . '/templates/'. DEF_PREFIX .'/classlib';

  } else {
    $mko_paths->template    = MK__DIR__ . '/templates/minorkey/' ;
    $mko_paths->tp_classlib = MK__DIR__ . '/templates/minorkey/class_lib';
  }
  /** --------------------------------------------------------------------------- *
  * Tell PHP where the template class library is.
  */
  // function __autoload($classname) {
  //   include $mko_paths->mk_classlib . MK_PSEP . strtolower($classname) . '.php';
  // }
  spl_autoload_register(function ($classname) {
    if(preg_match('/^mkc_/', $classname)) {
      global $mko_paths;
      require_once $mko_paths->mk_classlib . MK_PSEP . strtolower($classname) . '.php';
    } else {
      require_once $mko_paths->tp_classlib . MK_PSEP . strtolower($classname) . '.php';
    }
  });
  if (!isset($mko_demo)) { $mko_demo = new mkc_demo(true); }
/** --------------------------------------------------------------------------- *
  *Load any components needed by third party modules.
  */
  require_once( $mko_paths->vendor . '/autoload.php' );

/** --------------------------------------------------------------------------- *
  *Load the Minor Key processing environment.
  */
  require_once( $mko_paths->core   . '/grab.php' );
  require_once( $mko_paths->core   . '/proc.php' );

/** --------------------------------------------------------------------------- *
  *Load the master templating module.
  */
  if ( (isset($_REQUEST['async'])) AND ($_REQUEST['async'] == true) ) {
   require_once( $mko_paths->core . '/async_prep.php' );
  } else {
   require_once( $mko_paths->core . '/prep.php' );
  }
?>
