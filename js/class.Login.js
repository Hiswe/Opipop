var Login =
{

    submit : function()
    {
        Form.disable($('#login_form'));

        Form.cleanInput($('#login_login'));
        Form.cleanInput($('#login_password'));

        var login = $('#login_login').val();
        var password = $('#login_password').val();

        if (login.lenght == 0 || password.length == 0)
        {
            alert('You must fill all the form\'s field to login !');
            return;
        }
        else
        {
            var params =
            {
                'login'    : login,
                'password' : password
            };

            $.post(ROOT_PATH + 'remote/login/submit', params, Login.submitCallback);
        }
    },

    submitCallback : function(data)
    {
        if (data == '1')
        {
            window.location = window.location.toString().replace(/(#)/g, '');
        }
        else
        {
            alert('Error: wrond login or password');
            Form.clean($('#login_password'));
            Form.enable($('#login_form'));
        }
    }

};

