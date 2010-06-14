var Login =
{

    init : function()
    {
        $('#login_link').bind('click', Login.toggle);
        Login.hide();
    },

    toggle : function()
    {
        $('#login').toggle('normal');
    },

    hide : function()
    {
        $('#login').hide();
    },

    submit : function()
    {
        Form.disable($('#login'));

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
            window.location = ROOT_PATH;
        }
        else
        {
            alert('Error: wrond login or password');
        }
    }

};

