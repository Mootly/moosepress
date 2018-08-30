<?php
class mpc_filefinder {
/**
  * A library of file finding tools for redirects and 404s.
  *
  * The search functions will only return hits for specified file types.
  *
  * This library does not do database searches, but can be extended to do so.
  *
  * Public Properties:
  * @var    array   $status             The status of the redirect with longdesc.
  * @var    string  $queryStr           The value of the query string.
  * @var    string  $requestStr         The value of the requesting URL.
  * Methods:
  * @method string  __construct()       Returns current state of redirect from $status
  * @method array   explainStatus()     Returns a description of status codes.
  * @copyright 2018 Mootly Obviate
  * @package   moosepress
  * --------------------------------------------------------------------------- */
  public    $targetCategory;  # The category of the file.
  public    $status;          # Current search status (see $statusTypes).
  protected $mode = '';       # Whether to automate redirects.
  protected $seachType;       # The type of search to be performed.
  protected $targetURI;       # The raw url to find.
  protected $uriArray;        # The url to find exploded.
  protected $pathArray;       # The path to find exploded.
  protected $targetPath;      # The cleaned up verson of the url to find.
  protected $globTarget;      # The url as being served to PHP glob().
  protected $globResult;      # The result of a PHP glob search.
                    # $statusTypes includes descriptions and suggestions.       *
                    # There are three types of status: process, final, error.   *
                    # When a process status is returned, keep looking.          *
                    # Once a final status has been returned, stop looking.      *
                    # The key / first item redundancy it to self-document       *
                    # without extra hoop jumping to return a key / value pair   *
  protected $statusTypes = array(
                    # Process states                                            *
    'not found'     => [ 'not found', 'process',
      'The requested page, document, or asset was not found. Check for redirect. This is the default value and should never be returned as a final status except by the constructor.'
      ],
    'mismatch'      => [ 'mismatch', 'process',
      'A possible match was found but the file types are not consistent. The application should check the database or other resource for clarifying matches.'
      ],
    'multiple'      => [ 'multiple', 'process',
      'Multiple possible file matches were found. The application should check the database or other resource for refining matches.'
      ],
    'search'        => [ 'search', 'process',
      'No simple matches found in the directory containing the target URL. The application should check the database or other resource for matches.'
      ],
                    # Final states                                              *
    '404 success'   => [ '404 success', 'final',
      'The address being searched for matches the current URL. If it is the 404 page, let the user know they successfully found the 404 page.'
      ],
    'confirm'       => [ 'confirm', 'final',
      'A potentional match was found, but there were problems that could not be programmatically resolved, for instance a file type mismatch or multiple results. Ask the user to confirm the result.'
      ],
    'no match'      => [ 'no match', 'final',
      'No matches were found. Refer user to a search page or other search resource.'
      ],
    'no search'     => [ 'no search', 'final',
      'No information was provided to search against. fF this is a 404 page, redirect to root.'
      ],
    'success'       => ['success', 'final',
      'Successful match found. Redirect user.'
      ],
                    # Error states                                              *
    'invalid status'=> [ 'invalid status', 'error',
      'The status code provided does not exists. Run explain with no argument for a complete list of status codes.'
      ],
  );
                    # our list of valid extensions                              *
                    # redirects only allowed to these types                     *
                    # this was built while migrating a site off .Net            *
                    # you may want to extend this list                          *
                    # note that glob() stops working with too many              *
  protected $validExtStr;
  protected $validExtTypes = array(
    'webpage'       => 'asp,aspx,cfm,htm,html,php',
    'document'      => 'doc,docx,dot,dotx,rtf',             # odt,ott,
    'pdf'           => 'pdf',
    'slideshow'     => 'pps,ppt,pptx',                      # odp,odt,
    'spreadsheet'   => 'xls,xlsm,xlsx,xlt,xltm,xltx',       # ods,ots,
    'images'        => 'jpg,jpeg,gif,png,svg',
    'video'         => 'avi,mov,mp4,mpg,mpeg,wmv',          # asx,flv,wvx,
    'subtitles'     => 'sbv,srt,sub,vtt',
  );
# *** END - property declarations --------------------------------------------- *
#
# *** BEGIN __construct ------------------------------------------------------- *
/**
  * Constructor
  *
  * Init our values and grab our server variables.

  * If the redirect type is '404', make sure the current page is not searching
  * for itself.
  *
  * If the page query value is provided
  *
  * Parameters
  * @param  string  $find_type          The type of redirect. Currently only sees 404.
  * @param  string  $page_query         A string representing the URL to be processed.
  * @return string
  */
  public function __construct($auto_mode=false, $find_type='404', $page_query='') {
                    # init our properties
    if ($auto_mode) { $this->mode = 'auto'; }
    $this->status                 = $this->statusTypes['not found'][0];
    $this->seachType              = $find_type;
    $this->validExtStr            = implode(',', $this->validExtTypes);
                    # *** get our search URL ---------------------------------- *
                    # cascade order:                                            *
                    # - 1 - $page_query                                         *
                    # - 2 - $_SERVER['QUERY_STRING']                            *
                    # - 3 - $_SERVER['REQUEST_URI']                             *
                    # - 4 - none - set status to 'no search' and exit           *
                    #       this should never happen                            *
    if (!empty($page_query)) {
      $this->targetURI                  = $page_query;
    } elseif (!empty($_SERVER['QUERY_STRING'])) {
                    # epxlode returns array of query string components          *
                    #   0 - error code, 1 - url                                 *
                    # only return two in case there are semicolons in url       *
      $this->targetURI                  = (explode( ';', $_SERVER['QUERY_STRING'], 2 ))[1];
    } elseif (!empty($_SERVER['REQUEST_URI'])) {
      $this->targetURI                  = $_SERVER['REQUEST_URI'];
    } else {
      $this->status                     = $this->statusTypes['no search'][0];
    }
                    # return array of URL components                            *
                    #   scheme, host, port, path                                *
    $this->uriArray                     = parse_url($this->targetURI);
                    # return array of filename components                       *
                    # dirname, basename, extension, filename                    *
    $this->pathArray                    = pathinfo($this->uriArray['path']);
    $this->pathArray['dirname']         = ltrim($this->pathArray['dirname'],'\\');
    $this->targetPath = $this->pathArray['dirname'].MP_PSEP.$this->pathArray['filename'];
                    # get the category of our file extension                    *
                    # directory, invalid, one of the $mpv_404_vExt keys         *
    if ($this->pathArray['extension'] == '') {
      $this->pathArray['category']      = 'directory';
    } else {
      $this->pathArray['category']      = preg_grep(
        '/(^|\W)'.$this->pathArray['extension'].'($|\W)/',
        $this->validExtTypes
      );
      if (is_array($this->pathArray['category'])) {
        reset($this->pathArray['category']);
        $this->pathArray['category']    = key($this->pathArray['category']);
      } else {
        $this->pathArray['category']    = 'invalid';
      }
    }
    $this->targetCategory               = $this->pathArray['category'];

                    # *** SPECIAL CASE ---------------------------------------- *
                    # if looking for current page on 404 call, abort now
    if ($_SERVER['REQUEST_URI'] == $_SERVER['PHP_SELF']) {
      if ($this->seachType == '404') {
        $this->status                   = $this->statusTypes['404 success'][0];
      } else {

        $this->status                   = $this->statusTypes['no search'][0];
      }
    }
  }
# *** END - __construct ------------------------------------------------------- *
#
# *** BEGIN explainStatus ----------------------------------------------------- *
/**
  * Explain the returned status.
  *
  * Returns the description of the requested status.
  * If none requested, returns the entire status array.
  *
  * Parameters
  * @param  string  $status_code        The status to be explained.
  * @return array
  */
  public function explainStatus($status_code='') {
    if (empty($status_code)) {
      return $this->statusTypes;
    } elseif(array_key_exists($status_code,$this->statusTypes)) {
      return $this->statusTypes[$status_code];
    } else {
      return $this->statusTypes['invalid status'];
    }
  }
# *** END - explainStatus ----------------------------------------------------- *
#
# *** BEGIN getMatches -------------------------------------------------------- *
/**
  * Returns result set from a PHP glob()..
  *
  * Using a get to ensure these values are only set through the constructor.
  *
  * Parameters
  * @return array
  */
  public function getMatches() {
    return $this->globResult;
  }
# *** END - getMatches -------------------------------------------------------- *
#
# *** BEGIN getTarget --------------------------------------------------------- *
/**
  * Returns the string being searched for.
  *
  * Using a get to ensure these values are only set through the constructor.
  * Defaults to the cleaned up path, but can also return the raw URI.
  *
  * Parameters
  * @param  string  $version            The value to be returned (path | url).
  * @return string
  */
  public function getTarget($version='path') {
    if (($version == 'url') || ($version == 'uri')) {
      return $this->targetURI;
    } else {
      return $this->targetPath;
    }
  }
# *** END - getTarget --------------------------------------------------------- *
#
# *** BEGIN listValidExtensions ----------------------------------------------- *
/**
  * List valid extensions allowed in search by category.
  *
  * Returns a list of extensions by requested category.
  * If none requested, returns the entire extension array.
  *
  * Parameters
  * @param  string  $ext_cat            The extention category to be listed.
  * @return mixed
  */
  public function listValidExtensions($ext_cat='') {
    if (empty($ext_cat)) {
      return $this->validExtTypes;
    } elseif(array_key_exists($ext_cat,$this->validExtTypes)) {
      return $this->validExtTypes[$ext_cat];
    } else {
      return 'The extension requested is not a valid extension to search on.';
    }
  }
# *** END - listValidExtensions ----------------------------------------------- *
#
# *** BEGIN try_suffixMismatch ------------------------------------------------ *
/**
  * Test whether the problem is jsut a suffix mismatch.
  *
  * If auto, redirect.
  * If none requested, returns the entire extension array.
  *
  * Parameters
  * @param  string  $ext_cat            The extention category to be listed.
  * @return mixed
  */
  public function try_suffixMistmatch() {
                    # special case for index files                              *
    if (($this->pathArray['filename'] == 'default') || ($this->pathArray['filename'] == 'index')) {
      $this->globTarget = ltrim($this->pathArray['dirname'], '/').MP_PSEP.'{default,index}';
    } else {
      $this->globTarget = ltrim($this->targetPath, '/');
    }
                    # check directory for file matches with allowed suffixes    *
    $this->globTarget  = MP_ROOT.$this->globTarget .'.{'.$this->validExtStr.'}';
    $this->globResult  = glob( $this->globTarget, GLOB_BRACE );
                    # review our results                             *
    // if (!$mpv_404_results || (count($mpv_404_results) == 0 )) {   # still not found
    //   $mpv_404_status = 'search';
    // } elseif (count($mpv_404_results) == 1) {                   # only one match
    //   $mpv_404_status = 'success';
    //   $mpv_404_redPath= str_replace(MP_ROOT,'',$mpv_404_results[0]);
    //                   # *** REDIRECT to found page ------------------------------ #
    //   header('Location: '.MP_PSEP.$mpv_404_redPath);                              #
    //                   # *** REDIRECT to found page ------------------------------ #
    // } else {                                                  # multi-matches
    //   $mpv_404_status = 'multiple';
    // }
  }
# *** END - listValidExtensions ----------------------------------------------- *
}
// End mpc_filefinder --------------------------------------------------------- *
