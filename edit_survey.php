<?php
require ("Lib_survey.php");

$title = "Choose a Survey";
$haveSurvey = isset($_GET[SURVEY_FIELD]) && !empty($_GET[SURVEY_FIELD]);

$survey = "";

if($haveSurvey){
	$survey = $_GET[SURVEY_FIELD];
	$title = "Taking Survey: $survey";
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

$showLinks = true;

// test to see if a survey was passed
if (!empty($survey)) {
	// check if it was submitted, by checking for fileName, and xml
	if (isset($_GET['xml']) && !empty($_GET['xml'])){
		$output .= submitSurvey($survey, $_GET['xml']);
		
	} else {
		// else display the form
		$output .= editSurvey($survey);
		$showLinks = false;
	}
}

// create list of available to edit
if ($showLinks) {
	$output .= addEditSurveyLinks();
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