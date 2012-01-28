<?php

$styles = array("css/nav.css", "css/main.css", "css/valign.css", "css/form.css", array("ie", "css/valign_ie7.css"));

define("CHOOSE_SURVEY_PAGE", "choose_survey.php");

define("XML_PATH", "xml/");
define("XML_SCHEMA", "xsd/survey.xsd");

define("TAKE_SURVEY_TITLE", "Choose a Survey to Take");
define("TAKE_SURVEY_CLASS", "noBullet");
define("TAKE_SURVEY_DIV_CLASS", "marginCenter surveyList textCenter");
define("TAKE_SURVEY_PAGE", "take_survey.php");

define("DELETE_SURVEY_TITLE", "Choose a Survey to Delete");
define("DELETE_SURVEY_CLASS", "noBullet");
define("DELETE_SURVEY_DIV_CLASS", "marginCenter surveyList textCenter");
define("DELETE_SURVEY_PAGE", "delete_survey.php");

define("EDIT_SURVEY_TITLE", "Choose a Survey to Edit");
define("EDIT_SURVEY_CLASS", "noBullet");
define("EDIT_SURVEY_DIV_CLASS", "marginCenter surveyList textCenter");
define("EDIT_SURVEY_PAGE", "edit_survey.php");

define("VIEW_SURVEY_TITLE", "Choose a Survey to View");
define("VIEW_SURVEY_CLASS", "noBullet");
define("VIEW_SURVEY_DIV_CLASS", "marginCenter surveyList textCenter");
define("VIEW_SURVEY_PAGE", "survey_results.php");

define("SURVEY_FIELD", "survey");
define("SURVEY_FORM_XSLT", "xsl/take_survey.xsl");
define("SURVEY_FORM_CLASS", "width70 marginCenter surveyForm");

define("SURVEY_RESULTS_XSLT", "xsl/review_survey.xsl");
define("SURVEY_RESULTS_CLASS", "width70 marginCenter surveyForm");

function html_header($title = "Untitled", $styles = null, $scripts = null) {
	$string = <<<END
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<title>$title</title>
END;
	$string .= "\n";
	if (is_array($styles)) {
		foreach ($styles as $style) {
			$ie = false;
			if (is_array($style) && $style[0] == "ie") {
				$ie = true;
				$string .= "<!--[if lte IE 7]>";
				$style = $style[1];
			}

			$string .= "<link type='text/css' rel='stylesheet' href='$style' />\n";

			if ($ie) {
				$string .= "<![endif]-->";
			}
		}
	} else if (is_string($styles)) {
		$string .= "<link type='text/css' rel='stylesheet' href='$styles' />\n";
	}

	if (is_array($scripts)) {
		foreach ($scripts as $script) {
			$string .= "<script type='text/javascript' src='$script'></script>\n";
		}
	} else if (is_string($scripts)) {
		$string .= "<script type='text/javascript' src='$scripts'></script>\n";
	}

	$string .= <<<END
</head>
<body>\n
<div id="outterDIV">\n
<div id="middleDIV">\n
	<div id="page">\n
END;

	return $string;
}

function html_footer($text = "") {
	$string = <<<END
		<p><em>$text</em></p>
	</div> <!-- id=page -->
</div> <!-- id=middleDIV -->
</div> <!-- id=outterDIV -->
</body>
</html>
END;

	return $string;
}

function startDiv($id = "", $class = "") {
	$idPart = "";
	$classPart = "";

	if (!empty($id)) {
		$idPart = "id='$id'";
	}

	if (!empty($class)) {
		$classPart = "class='$class'";
	}

	return "<div $idPart $classPart>" . "\n";
}

function endDiv($id = "") {
	$idPart = "";

	if (!empty($id)) {
		$idPart = "id='$id'";
	}

	return "</div> <!-- $idPart -->" . "\n";
}

// create the banner div
function addBanner() {
	// start div
	$string = "\t" . "\t" . '<div id="banner">' . "\n";

	$string .= "\t" . "\t" . '<h1>Banner</h1>' . "\n";

	// end div
	$string .= "\t" . "\t" . '</div> <!-- id=banner -->' . "\n";

	return $string;
}

function addNav() {
	$result = "\t" . file_get_contents("nav.html");

	if (!$result) {
		$result = "";
	}

	return $result;
}

function addTakeSurveyLinks() {
	return addSurveyLinks(TAKE_SURVEY_TITLE, TAKE_SURVEY_PAGE, TAKE_SURVEY_DIV_CLASS, TAKE_SURVEY_CLASS);
}

function addDeleteSurveyLinks() {
	return addSurveyLinks(DELETE_SURVEY_TITLE, DELETE_SURVEY_PAGE, DELETE_SURVEY_DIV_CLASS, DELETE_SURVEY_CLASS);
}

function addEditSurveyLinks() {
	return addSurveyLinks(EDIT_SURVEY_TITLE, EDIT_SURVEY_PAGE, EDIT_SURVEY_DIV_CLASS, EDIT_SURVEY_CLASS);
}

function addViewSurveyResultsLinks() {
	return addSurveyLinks(VIEW_SURVEY_TITLE, VIEW_SURVEY_PAGE, VIEW_SURVEY_DIV_CLASS, VIEW_SURVEY_CLASS);
}

function addSurveyLinks($title = "Surveys", $page = "", $divClass = "", $class = "") {
	if (!empty($class)) {
		$class = " class='$class'";
	}

	if (!empty($divClass)) {
		$divClass = " class='$divClass'";
	}

	if (!empty($page)) {
		$page = " href='$page";
	}

	$result = "";

	// setup the container div
	$result .= "<div$divClass>" . "\n";

	// Setup the title
	$result .= "\t<h1>$title</h1>" . "\n";

	// grab all the available surveys
	$path = XML_PATH;
	$surveys = getSurveys($path);

	// setup the List
	$result .= "\t<ul" . $class . ">" . "\n";

	// display each as a list item
	foreach ($surveys as $survey) {
		$result .= "\t\t<li><a" . $page . "?" . SURVEY_FIELD . "=" . $path . $survey . "'>$survey</a></li>" . "\n";
	}

	// close the List
	$result .= "\t</ul>" . "\n";
	// <!-- $class -->";

	// close the container div
	$result .= "</div>" . "\n";

	// return
	return $result;
}

function getSurveys($dir = XML_PATH) {
	$result = array();

	if ($handle = opendir($dir)) {
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				$result[] = $entry;
			}
		}
		closedir($handle);
	}

	return $result;
}

function displaySurveyForm($survey) {
	return xml_transform($survey, SURVEY_FORM_XSLT, SURVEY_FORM_CLASS);
}

function displaySurveyResults($survey) {
	return xml_transform($survey, SURVEY_RESULTS_XSLT, SURVEY_RESULTS_CLASS);
}

function xml_transform($xml, $xslt, $divClass = "") {
	$result = "";
	if (!empty($divClass)) {
		$divClass = " class='$divClass'";
	}

	// setup the container div
	$result .= "<div$divClass>" . "\n";

	// load the xml
	$xmlDom = new DomDocument();
	// load XML File into DOM
	@$xmlDom -> load($xml);

	// load the xslt
	$xslDom = new DomDocument();
	// load XSL File into DOM
	@$xslDom -> load($xslt);

	// create XSLT Processor
	$processor = new XSLTProcessor();
	// import XSL DOM Object
	$processor -> importStyleSheet($xslDom);

	// Apply XSL to XML and get HTML to append to result
	$result .= $processor -> transformToXML($xmlDom);

	// close the container div
	$result .= "</div>" . "\n";

	// return the result
	return $result;
}

function deleteSurvey($survey) {
	$result = "";

	// delete the file
	$success = deleteFile($survey);

	// create container
	$result .= startDiv("", "acknowledgeDiv");

	$result .= "<p>";
	if ($success) {
		$result .= "You have successfully deleted: <span>$survey</span>";
	} else {
		$result .= "Could not delete: <span>$survey</span>";
	}
	$result .= "</p>";

	// close container
	$result .= endDiv();

	return $result;
}

function deleteFile($fileName) {
	$result = false;

	if (file_exists($fileName)) {
		$result = unlink($fileName);
	}

	return $result;
}

function addEditSurveyForm($fileName) {
	$result = "";
	// create the form to display the file
	$result .= "<form>" . "\n";

	$result .= "<h1>Edit Tutorial: $fileName</h1>";

	// load the file
	$xmlDom = new DOMDocument();

	@$xmlDom -> load($fileName);

	// get it as XML
	@$xmlString = $xmlDom -> saveXML() . "\n";

	// create the hidden input for the filename
	$result .= "<input name='survey' type='hidden' value='$fileName' />";
	
	// create the label for the input
	$result .= "<label for='fileName'>Name: </label>\n";
	
	// create the input for the fileName, get only the filename without the .xml
	$result .= "<input name='fileName' type='text' value='".basename($fileName,".xml")."' /><br />\n";

	// create the textarea
	$result .= "<textarea name='xml' class='marginCenter roundBox surveyXML'>" . htmlspecialchars($xmlString) . "</textarea>";

	// add reset button
	$result .= "<input type='reset' name='reset' value='reset'/>" . "\n";

	// add submit button
	$result .= "<input type='submit' name='submit' value='submit'/>" . "\n";

	// create the form to display the file
	$result .= "</form>";

	return $result;
}

/**
 * Tries to submit the xml, by checking if it is valid, and writing it to the file
 * 
 * @param $fileName - file to write to
 * @param $xml - XML as a string to submit
 */
function submitSurvey($origSurveyName, $newSurveyName, $xml, $overwrite) {
	$result = "";

	// get rid of start-end whitespace
	$xml = trim($xml);

	// start boolean to track success
	$success = false;

	// create container
	$result .= startDiv("", "acknowledgeDiv");
	$result .= "<p>";

	// check if it is valid against our schema
	if (isValidXMLSource($xml, XML_SCHEMA)) {
		// overwrite the file
		if($overwrite && ($origSurveyName != $newSurveyName)){
			// delete the original survey
			deleteFile($origSurveyName);
		}
		// open file
		// TODO: suppress warning
		$file = fopen($newSurveyName, "w") or die("Cannot open　" . $newSurveyName);

		// write only if it has data
		if (!empty($xml)) {
			$success = fwrite($file, $xml) > 0;
		}

		// close file
		fclose($file);
	}

	// check if we were able to write the file
	if ($success) {
		// build the positive acknowledgement
		$result .= "You have successfully edited: <span>$newSurveyName</span>";
	} else {
		// build the negative acknowledgement
		$result .= "Could not edit: <span>$newSurveyName</span>";
	}
	$result .= "</p>";

	// close container
	$result .= endDiv();

	return $result;
}

/**
 * Checks to see if the XML (passed as a string) is valid against a 
 * schema (fileName of the schema)
 * 
 * @param $xml - xml in string format
 * @param $xmlSchema - name of schema file 
 * 
 */
function isValidXMLSource($xml, $xmlSchema) {
	$result = false;

	// check if they are both files, can be read/written appropriately
	if (is_file($xmlSchema) && is_readable($xmlSchema)) {
		// create a dom from the XML
		$xmlDom = new DOMDocument();
		@$xmlDom -> loadXML($xml);
		@$result = $xmlDom -> schemaValidate($xmlSchema);
	}

	return $result;
}
?>