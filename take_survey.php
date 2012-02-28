<?php
require ("Lib_survey.php");

$survey = "";
$title = "Choose a Survey";
$resultField = "showResults";

// check to see if a survey was passed
if (isset($_GET[SURVEY_FIELD]) && !empty($_GET[SURVEY_FIELD])) {
	$survey = $_GET[SURVEY_FIELD];
	$title = "Take Survey: $survey";

	// check the length of get
	if (count($_GET) > 1 && isset($_GET[$resultField]) && !empty($_GET[$resultField])) {
		// TODO: process the results of the form

		// setup the file name
		$fileName = XML_PATH . $survey . ".xml";

		// grab the file
		$dom = new DOMDocument();
		$dom -> load($fileName);

		// grab all the questions
		$questions = $dom -> getElementsByTagName("question");

		// loop thru the questions
		foreach ($questions as $question) {
			// grab the id
			$id = $question -> getAttribute("id");

			// check if that id exists in the GET array
			if (isset($_GET[$id]) && !empty($_GET[$id])) {
				// grab the answer they choose
				$userAnswer = $_GET[$id];

				// grab this questions answers
				$answers = $question -> getElementsByTagName("answer");

				// look for it in this questions answers
				foreach ($answers as $answer) {
					// grab the text
					$text = $answer -> getAttribute("text");

					// compare to our answer
					if ($userAnswer == $text) {
						echo "<p>incrementing counter for $userAnswer</p>";
						// if same, incrememnt counter
						// get count
						$count = $answer -> getAttribute("count");
						echo "<p>Old COunt: $count</p>";
						// set count +1
						$answer -> setAttribute("count", $count + 1);
						echo "<p>Old Count" . $answer -> getAttribute("count") . "</p>";
					} // if($userAnswer == $text)
				} // foreach($answers as $answer)
			}// if(isset($_GET[$id]) && !empty($_GET[$id]))
		}// foreach($questions as $question)

		// save the DOM
		$dom->save($fileName);
		
		// route to view results page
		header("Location: survey_results.php?".SURVEY_FIELD."=$fileName");

		var_dump($_GET);
		die();
	} // if (count($_GET) > 1 && isset($_GET[$resultField]) && !empty($_GET[$resultField]))
} // if (isset($_GET[SURVEY_FIELD]) && !empty($_GET[SURVEY_FIELD])

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