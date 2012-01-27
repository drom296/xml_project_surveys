<?php
require ("Lib_survey.php");

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

$showLinks = true;

// test to see if a survey was passed
if (isset($_GET[SURVEY_FIELD]) && !empty($_GET[SURVEY_FIELD])) {
	$survey = $_GET[SURVEY_FIELD];
	// check if it was submitted
	
	if (false) {

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