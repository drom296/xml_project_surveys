<?php
require ("Lib_survey.php");

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

// test to see if a survey was passed
if (!empty($_GET[SURVEY_FIELD])) {
	$output .= deleteSurvey($_GET[SURVEY_FIELD]);
}

// create list of available to delete
	$output .= addDeleteSurveyLinks();
	
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