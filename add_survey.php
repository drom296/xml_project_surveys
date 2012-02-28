<?php
require ("Lib_survey.php");

$title = "Add a Survey";
$haveSurvey = isset($_GET[SURVEY_FIELD]) && !empty($_GET[SURVEY_FIELD]);

$survey = "";

if ($haveSurvey) {
	$survey = $_GET[SURVEY_FIELD];
	$title = "Saved Survey: $survey";
}

// add script
$scripts = array("http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js","js/guidedEdit.js");

// create header tags
$output = html_header($title, $styles, $scripts);

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

$showForm = true;

// test to see if a survey was passed
if (!empty($survey)) {
	// check if it was submitted, by checking for fileName, and xml
	if (isset($_GET['xml']) && !empty($_GET['xml']) && isset($_GET['fileName']) && !empty($_GET['fileName'])) {

		// submitSurvey($origSurveyName, $newSurveyName, $xml, $overwrite)
		$output .= submitSurvey($survey, XML_PATH . $_GET['fileName'] . ".xml", $_GET['xml'], false);
		$showForm = false;
	}
}

if ($showForm) {
	// editSurveyForm($fileName, $fileToLoad);
	$output .= addEditSurveyForm(XML_TEMPLATE, XML_TEMPLATE);
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