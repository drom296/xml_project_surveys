/**
 * @author tuxedo
 */

var ie7 = (document.all && !window.opera && window.XMLHttpRequest) ? true : false;

function deleteItem(which) {
	which.parentNode.removeChild(which);
}

function addChoice(where) {
	// build choice
	var choice = "<div class='choiceDiv'>";
	choice += "<img class='deleteCImg' onclick='deleteItem(this.parentNode)' src='img/DeleteRed.png' />";
	choice += "<input type='text' class='choiceInput' />";
	choice += "</div>";

	// add choice before where
	$(where).before(choice);
}

function addQuestion() {
	// add the question div before the submit button

	var question = "";
	// create the div for the question block
	question += "<div class='questionBlock'>";

	// add the question as an input
	// first the label
	question += "<label class='questionLabel'>Question:</label>";
	question += "<br />";
	
	// start the question div
	question += '<div class="questionDiv">';
	// add the delete image
	question += "<img class='deleteQImg' onclick='deleteItem(this.parentNode.parentNode)' src='img/DeleteRed.png' />";
	// add the question input
	question += "<input type='text' class='questionInput' value='Question' />";
	// close the question div
	question += '</div>';
	
	
	// add a choice input
	// first the label
	question += "<label class='choiceLabel'>Choices:</label>";
	question += "<br />";
	// then the container
	question += "<div class='choiceDiv'>";
	// followed by the image delet
	question += "<img class='deleteCImg' onclick='deleteItem(this.parentNode)' src='img/DeleteRed.png' />";
	// input time
	question += "<input type='text' class='choiceInput' value='choice' />";
	// finally we close the choice div
	question += "</div>";
	
	// Add link to add choice
	question += "<button type='button' onclick='addChoice(this)'>Add a Choice</button>";
	
	// add link to add question
	question += "<button type='button' onclick='addQuestion()'>Add a Question</button>";
	
	
	// end the question Div
	question += "</div>";

	$('input[type="submit"]').before(question);
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
	var qDivs = document.getElementsByClassName("questionBlock");

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

			console.log(choice);

			//for each choice
			// create the choice node
			result += '<answer count="0" text="'+choice+'" />';
		}

		// close the question
		result += '</question>';
	}

	// close the questions node
	result += '</questions>';
	// close the root node : <survey name="survey1">
	result += '</survey>';
	
	console.log("result:");
	console.log(result);

	// change the xml DOM to a string and set equal to the hidden xml field
	var xml = document.getElementById('xml');
	xml.setAttribute("value", result);
	console.log(xml);

	return true;
}