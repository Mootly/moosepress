<?php

/*
Sample atoum configuration file to have code coverage in html format and the treemap.
Do "php path/to/test/file -c path/to/this/file" or "php path/to/atoum/scripts/runner.php -c path/to/this/file -f path/to/test/file" to use it.
*/

use atoum\atoum\report\fields\runner\coverage;

// HTML

/*
Please replace in next line /path/to/destination/directory by your destination directory path for html files.
*/
$coverageHtmlField = new atoum\report\fields\runner\coverage\html('Your project name', '/path/to/destination/directory');

/*
Please replace in next line http://url/of/web/site by the root url of your code coverage web site.
*/
$coverageHtmlField->setRootUrl('http://url/of/web/site');

// Treemap (not mandatory)

/*
Please replace in next line /path/to/destination/directory by your destination directory path for html files.
*/
$coverageTreemapField = new atoum\report\fields\runner\coverage\treemap('Your project name', '/path/to/destination/directory');

/*
Please replace in next line http://url/of/treemap by the root url of your treemap web site.
*/
$coverageTreemapField
    ->setTreemapUrl('http://url/of/treemap')
    ->setHtmlReportBaseUrl($coverageHtmlField->getRootUrl())
;

$script
    ->addDefaultReport()
        ->addField($coverageHtmlField)
        ->addField($coverageTreemapField)
;
