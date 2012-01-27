<?php
require("Lib_survey.php");

$survey = $_GET[SURVEY_FIELD];

// check to see if a survey was passed
if(empty($survey)){
	header('Location: '.CHOOSE_SURVEY_PAGE);
}

// create header tags
$output = html_header("$survey", $styles);

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

// add the survey form
$output .= displaySurveyForm($survey);

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