/**
 * @author tuxedo
 */

var ie7 = (document.all && !window.opera && window.XMLHttpRequest) ? true : false;

// This should happen on $(document).ready();
$(document).ready(function() {
	// check to see if the form is showing
	if($("#editSurveyForm").length > 0) {
		// add action to the delete images
		
	}
});

function deleteItem(which){
	which.parentNode.removeChild(which);
}

function addChoice(where){
	// build choice
	var choice = "<div class='choiceDiv'>"; 
	choice += "<img class='deleteCImg' onclick='deleteItem(this.parentNode)' src='img/DeleteRed.png' />";
	choice += "<input type='text' class='choiceInput' />";
	choice += "</div>";
	
	// add choice before where
	$(where).before(choice);
}

// for each question div
// add a link to add more choices
// create a function to facilitate.
// onclick add a single choice right before the link
// (might not be needed)incrememt hidden field for number of choices for this question 7

// add a link to add another question
// create a function to facilitate.
// onclick add a question div to the end of the question div list

// --------------------------------------------
// This should be the function that the form calls onsubmit

// Processing
//
// JavaScript

// build the xml document based the questions and the choices as text and set
// to the hidden xml field
//
// was going to use the DOM, but couldnt figure out how to go from DOM to string
function buildXML() {
	// grab  the form
	var form = document.forms[0];

	// create the root node : <survey name="survey1">

	var result = "";
	result += '<?xml version="1.0" encoding="utf-8"?>';
	result += '<survey name="' + form['fileName']['value'] + '">';
	result += '<questions>';

	// grab all the question divs
	var qDivs = document.getElementsByClassName("questionDiv");

	// for each question div
	for( i = 0, len = qDivs.length; i < len; i++) {
		// build the question node
		var one = qDivs.item(i);

		// grab the question
		var question = one.getElementsByClassName('questionInput')[0].value;

		// build the question
		result += '<question id="' + i + '" text="' + question + '">';

		// grab all the choices within this div
		var choices = one.getElementsByClassName('choiceInput');
		for( j = 0, len2 = choices.length; j < len2; j++) {
			var choice = choices.item(j).value;

			//for each choice
			// create the choice node
			result += '<answer count="0">';
			result += '<answer_text>' + choice + '</answer_text>'

			// create the choice node
			result += '</answer>';
		}

		// close the question
		result += '</question>';
	}

	// close the questions node
	result += '</questions>';
	// close the root node : <survey name="survey1">
	result += '</survey>';

	// change the xml DOM to a string and set equal to the hidden xml field
	var xml = document.getElementById('xml');
	xml.setAttribute("value", result);
	console.log(xml);

	return true;
}