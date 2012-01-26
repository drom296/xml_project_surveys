<?php

define("CHOOSE_SURVEY_PAGE", "choose_survey.php");

define("XML_PATH", "xml/");

define("TAKE_SURVEY_TITLE", "Choose a Survey");
define("TAKE_SURVEY_CLASS", "noBullet");
define("TAKE_SURVEY_DIV_CLASS", "marginCenter surveyList textCenter");
define("TAKE_SURVEY_PAGE", "take_survey.php");

define("DELETE_SURVEY_TITLE", "Choose a Survey to Delete");
define("DELETE_SURVEY_CLASS", "noBullet");
define("DELETE_SURVEY_DIV_CLASS", "marginCenter surveyList textCenter");
define("DELETE_SURVEY_PAGE", "delete_survey.php");

define("SURVEY_FIELD", "survey");
define("SURVEY_FORM_XSLT", "xsl/survey.xslt");
define("SURVEY_FORM_CLASS", "width70 marginCenter surveyForm");

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
			$string .= "<link type='text/css' rel='stylesheet' href='$style' />\n";
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
	<div id="page">\n
END;

	return $string;
}

function html_footer($text = "") {
	$string = <<<END
		<p><em>$text</em></p>
	</div> <!-- id=page -->
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
	$surveys = getSurveys();

	// setup the List
	$result .= "\t<ul" . $class . ">" . "\n";

	// print_r($surveys);

	// display each as a list item
	foreach ($surveys as $survey) {
		// echo "<br />".$survey."<br />";
		$result .= "\t\t<li><a" . $page . "?" . SURVEY_FIELD . "=$survey'>$survey</a></li>" . "\n";

		// echo htmlspecialchars($result)."\n";
	}

	// close the List
	$result .= "\t</ul>" . "\n";
	// <!-- $class -->";

	// close the container div
	$result .= "</div>" . "\n";

	// echo htmlspecialchars($result)."\n";

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

function addSurveyForm($survey) {
	return xml_transform(XML_PATH . $survey, SURVEY_FORM_XSLT, SURVEY_FORM_CLASS);
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
	$xmlDom -> load($xml);

	// load the xslt
	$xslDom = new DomDocument();
	// load XSL File into DOM
	$xslDom -> load($xslt);

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
	$success = deleteFile(XML_PATH . $survey);

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
?>