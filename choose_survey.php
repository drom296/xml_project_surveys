<?php
require("Lib_survey.php");

$styles = array("css/nav.css", "css/main.css");

// create header tags
$output = html_header("Choose a Survey", $styles);

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

// create list of available to take
$output .= addTakeSurveyLinks();

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