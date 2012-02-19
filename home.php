<?php
require ("Lib_survey.php");

$title = "Welcome";

// create header tags
$output = html_header($title, $styles);

// HEADER Section *****************************************

// start the header section
$output .= startDiv("header");

// create banner div
$output .= addBanner();

// create the nav
$output .= addNav();

// end the header section
$output .= endDiv("header");

// CONTENT Section *****************************************

// start the content section
$output .= startDiv("content", "roundBox");

// grab the report.txt and place in a pre tag
$report = file_get_contents("report.txt");

// start the content section
$output .= startDiv("", "marginCenter width70 roundBox");

$output .= "<p class='reportLabel'>A report on design and implementation considerations, system architecture, <br />and design choices for the 
final XML project</p>";
// add to the output
$output .= "<pre class='report'>$report</pre>";
$output .= endDiv("");

// end the content section
$output .= endDiv("content");

// FOOTER Section *****************************************

// start the footer section
$output .= startDiv("footer");

// end the footer section
$output .= endDiv("footer");

// create footer
$output .= html_footer("");

echo $output;
?>