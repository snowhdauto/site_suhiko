function dElementsRender(el) {
	label = $(el).attr('data-de-label');
	maxLength = $(el).attr('data-de-maxlength');
	errorMessage = $(el).attr('data-de-error-massage');
	if ( label == undefined ) { label = false; }
	if ( maxLength == undefined ) { maxLength = false; } else { maxLength = Number(maxLength); }
	if ( errorMessage == undefined ) { errorMessage = false; }
	if ( maxLength ) {
		if ( $(el).val().length > maxLength ) {
			$(el).val(
				$(el).val().substring(0, maxLength)
			);
		}
	}
	
	var tag = $(el).prop("tagName").toLowerCase();
	if(tag == 'input') {
		$(el).attr('value', $(el).val());
	}
	html = '';
	html += '<label class="dolphron-elements form-input-label ' + ( (errorMessage) ? 'input-error' : '' ) + '">';
		html += '<div class="dolphron-elements form-input-text">';
		if ( label ) { html += '<p>' + label + '</p>'; } else { html += '<p></p>'; }
		if ( maxLength ) { html += '<p><span data-de-curentLength>' + $(el).val().length + '</span> / <span data-de-maxLength>' + maxLength + '</span></p>'; }
		html += '</div>';
		html += el.outerHTML;
		if ( errorMessage ) { html += '<p class="dolphron-elements error-message">' + errorMessage + '</p>'; }
	html += '</label>';
	$(el).after(html);
	$(el).remove();
}

function checkLength(el) {
	maxLength = el.attr('data-de-maxlength');
	if ( maxLength == undefined ) { maxLength = false; } else { maxLength = Number(maxLength); }
	if ( maxLength ) {
		if ( el.val().length > maxLength ) {
			el.val(el.val().substring(0, maxLength));
		}
		el.parent().find('[data-de-curentLength]')[0].innerHTML = el.val().length;
		el.parent().find('[data-de-maxLength]')[0].innerHTML = maxLength;
	}
}
function checkErrorMessage(el) {
	errorMessage = el.attr('data-de-error-massage');
	if ( errorMessage == undefined ) { errorMessage = false; }
	if ( errorMessage ) {
		el.parent().removeClass('input-error');
	}
}

$(document).ready(function(){
	var inputs = $('input.dolphron-elements');
	for ( var i = 0; i < inputs.length; i++ ) {
		if ($(inputs[i]).attr('type') != 'hidden') {
			dElementsRender(inputs[i]);
		}
	}
	var textareas = $('textarea.dolphron-elements');
	for ( var i = 0; i < textareas.length; i++ ) {
		dElementsRender(textareas[i]);
	}
	var selects = $('select.dolphron-elements');
	for ( var i = 0; i < selects.length; i++ ) {
		dElementsRender(selects[i]);
	}

	$('body').on('input', 'input.dolphron-elements', function(){
		checkErrorMessage($(this));
		checkLength($(this));
	})

	$('body').on('input', 'select.dolphron-elements', function(){
		checkErrorMessage($(this));
	})

	$('body').on('input', 'textarea.dolphron-elements', function(){
		checkErrorMessage($(this));
		checkLength($(this));
	})
});