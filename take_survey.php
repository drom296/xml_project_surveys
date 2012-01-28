<?php
require ("Lib_survey.php");

$survey = "";
$title = "Choose a Survey to Take";

// check to see if a survey was passed
if (isset($_GET[SURVEY_FIELD]) && !empty($_GET[SURVEY_FIELD])) {
	$survey = $_GET[SURVEY_FIELD];
	$title = "Take Survey: $survey";
}

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

// one or the other
if (empty($survey)) {
	// create list of available to take
	$output .= addTakeSurveyLinks();
} else {
	// add the survey form
	$output .= displaySurveyForm($survey);
}
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