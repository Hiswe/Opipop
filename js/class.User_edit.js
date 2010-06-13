var User_edit =
{

	init : function()
	{
	},

	submit : function()
	{
        var gender = Form.getCleanInputValue($('#user_edit_gender'));
        var zip    = Form.getCleanInputValue($('#user_edit_zip'));

		if (zip.lenght == 0 || gender.length == 0)
		{
			alert('You must fill all the form\'s field !');
			return false;
		}
		else
		{
			Form.disable($('user_edit'));
			return true;
		}
	}

};

