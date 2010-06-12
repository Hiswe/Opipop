var Submit =
{

	checkQuestionTimeout  : 0,
	checkResponse1Timeout : 0,
	checkResponse2Timeout : 0,

	init : function()
	{
		$('#propose_question').bind('keydown', Submit.scheduleCheckQuestion);
		$('#propose_question').bind('change', Submit.scheduleCheckQuestion);
		$('#propose_response1').bind('keydown', Submit.scheduleCheckResponse1);
		$('#propose_response1').bind('change', Submit.scheduleCheckResponse1);
		$('#propose_response2').bind('keydown', Submit.scheduleCheckResponse2);
		$('#propose_response2').bind('change', Submit.scheduleCheckResponse2);
	},

	scheduleCheckQuestion : function()
	{
		clearTimeout(Submit.checkQuestionTimeout);
		Submit.checkQuestionTimeout = setTimeout(Submit.checkQuestion, 500);
	},

	scheduleCheckResponse1 : function()
	{
		clearTimeout(Submit.checkResponse1Timeout);
		Submit.checkResponse1Timeout = setTimeout(Submit.checkResponse1, 500);
	},

	scheduleCheckResponse2 : function()
	{
		clearTimeout(Submit.checkResponse2Timeout);
		Submit.checkResponse2Timeout = setTimeout(Submit.checkResponse2, 500);
	},

	checkQuestion : function()
	{
		var input = $('#propose_question');

		Form.cleanInput(input);

		var value = input.val();

		if (value.lenght == 0)
		{
			Form.setError(input, 'The question field is required');
		}
		else if (value.lenght > 32)
		{
			Form.setError(input, 'The question must be 32 chars long max');
		}
		else
		{
			Form.cleanError(input);
		}
	},

	checkResponse1 : function()
	{
		var input = $('#propose_response1');

		Form.cleanInput(input);

		var value = input.val();

		if (value.length == 0)
		{
			Form.setError(input, 'The response field is required');
		}
		else if (value.lenght > 32)
		{
			Form.setError(input, 'The response must be 32 chars long max');
		}
		else
		{
			Form.cleanError(input);
		}
	},

	checkResponse2 : function()
	{
		var input = $('#propose_response2');

		Form.cleanInput(input);

		var value = input.val();

		if (value.length == 0)
		{
			Form.setError(input, 'The response field is required');
		}
		else if (value.lenght > 32)
		{
			Form.setError(input, 'The response must be 32 chars long max');
		}
		else
		{
			Form.cleanError(input);
		}
	},

	submit : function()
	{
		Form.disable($('#propose'));

		Form.cleanInput($('#propose_question'));
		Form.cleanInput($('#propose_response1'));
		Form.cleanInput($('#propose_response2'));

		var question = $('#propose_question').val();
		var response1 = $('#propose_response1').val();
		var response2 = $('#propose_response2').val();

		if (question.length == 0 || response1.length == 0 || response2.length == 0)
		{
			alert('You must fill all the form\'s field to submit a survey !');
			return;
		}
		else
		{
			var params =
			{
				question  : question,
				response1 : response1,
				response2 : response2
			};

            $.post(ROOT_PATH + 'remote/propose/submit', params, Submit.submitCallback);
		}
	},

	submitCallback : function(data)
	{
		window.location = ROOT_PATH;
	}

};

