var User_password =
{

    checkPasswordTimeout : 0,

    init : function()
    {
        $('#user_password_password_1').bind('keydown', User_password.scheduleCheckPassword);
        $('#user_password_password_1').bind('change', User_password.scheduleCheckPassword);
        $('#user_password_password_2').bind('keydown', User_password.scheduleCheckPassword);
        $('#user_password_password_2').bind('change', User_password.scheduleCheckPassword);
    },

    scheduleCheckPassword : function()
    {
        clearTimeout(User_password.checkPasswordTimeout);
        User_password.checkPasswordTimeout = setTimeout(User_password.checkPassword, 500);
    },

    checkPassword : function()
    {
        var input_1_value = Form.getCleanInputValue($('#user_password_password_1'));
        var input_2_value = Form.getCleanInputValue($('#user_password_password_2'));

        if (input_1_value.length == 0)
        {
            $('#user_password_password_2').val('');
            Form.cleanError($('#user_password_password_1'));
            Form.cleanError($('#user_password_password_2'));
        }
        else if (input_1_value.length < 6)
        {
            Form.setError($('#user_password_password_1'), 'password must be at least 6 character long');
        }
        else
        {
            Form.cleanError($('#user_password_password_1'));

            if (input_1_value.length != 0 && input_2_value.length != 0 && input_1_value !=  input_2_value)
            {
                Form.setError($('#user_password_password_2'), 'error confirming passord');
            }
            else
            {
                Form.cleanError($('#user_password_password_2'));
            }
        }
    },

    submit : function()
    {
        var old_password = Form.getCleanInputValue($('#user_password_password_0'));
        var new_password = Form.getCleanInputValue($('#user_password_password_1'));

        if (old_password.length == 0 || new_password.length == 0)
        {
            alert('You must fill all the form\'s field !');
            return false;
        }
        else
        {
            Form.disable($('user_password'));
            return true;
        }
    }

};

