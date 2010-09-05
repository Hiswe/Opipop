var Register =
{

    checkLoginTimeout    : 0,
    checkPasswordTimeout : 0,
    checkEmailTimeout    : 0,

    init : function()
    {
        $('#register_login').bind('keydown', Register.scheduleCheckLogin);
        $('#register_login').bind('change', Register.scheduleCheckLogin);
        $('#register_email').bind('keydown', Register.scheduleCheckEmail);
        $('#register_email').bind('change', Register.scheduleCheckEmail);
        $('#register_password_1').bind('keydown', Register.scheduleCheckPassword);
        $('#register_password_1').bind('change', Register.scheduleCheckPassword);
        $('#register_password_2').bind('keydown', Register.scheduleCheckPassword);
        $('#register_password_2').bind('change', Register.scheduleCheckPassword);
    },

    scheduleCheckLogin : function()
    {
        clearTimeout(Register.checkLoginTimeout);
        Register.checkLoginTimeout = setTimeout(Register.checkLogin, 500);
    },

    scheduleCheckPassword : function()
    {
        clearTimeout(Register.checkPasswordTimeout);
        Register.checkPasswordTimeout = setTimeout(Register.checkPassword, 500);
    },

    scheduleCheckEmail : function()
    {
        clearTimeout(Register.checkEmailTimeout);
        Register.checkEmailTimeout = setTimeout(Register.checkEmail, 500);
    },

    checkLogin : function()
    {
        var value = Form.getCleanInputValue($('#register_login'));

        if (value.length != 0)
        {
            if (value.match(/([^a-zA-Z0-9_-])/g))
            {
                Form.setError($('#register_login'), 'votre identifiant ne doit contenir que des lettres des chiffres ou des tirés');
            }
            else
            {
                var params =
                {
                    login: value
                };
                $.post(ROOT_PATH + 'remote/register/checkLogin', params, Register.checkLoginCallback);
            }
        }
        else
        {
            Form.cleanError($('#register_login'));
        }
    },

    checkLoginCallback : function(data)
    {
        if (data == '1')
        {
            Form.cleanError($('#register_login'));
        }
        else if (data == '0')
        {
            Form.setError($('#register_login'), 'cet identifiant est déjà utilisé');
        }
    },

    checkEmail : function()
    {
        var value = Form.getCleanInputValue($('#register_email'));

        if (value.length != 0)
        {
            if (Form.emailFilter.test(value))
            {
                Form.cleanError($('#register_email'));

                var params =
                {
                    email : value
                };
                $.post(ROOT_PATH + 'remote/register/checkEmail', params, Register.checkEmailCallback);
            }
            else
            {
                Form.setError($('#register_email'), 'wrong email');
            }
        }
        else
        {
            Form.cleanError($('#register_email'));
        }
    },

    checkEmailCallback : function(data)
    {
        if (data == '1')
        {
            Form.cleanError($('#register_email'));
        }
        else if (data == '0')
        {
            Form.setError($('#register_email'), 'cet email est déjà utilisé');
        }
    },

    checkPassword : function()
    {
        var input_1_value = Form.getCleanInputValue($('#register_password_1'));
        var input_2_value = Form.getCleanInputValue($('#register_password_2'));

        if (input_1_value.length == 0)
        {
            $('#register_password_2').val('');
            Form.cleanError($('#register_password_1'));
            Form.cleanError($('#register_password_1'));
        }
        else if (input_1_value.length < 6)
        {
            Form.setError($('#register_password_1'), 'le mot de passe doit contenir au moins 6 charatecters');
        }
        else
        {
            Form.cleanError($('#register_password_1'));

            if (input_1_value.length != 0 && input_2_value.length != 0 && input_1_value != input_2_value)
            {
                Form.setError($('#register_password_1'), 'erreur en confirmant le mot de passe');
            }
            else
            {
                Form.cleanError($('#register_password_1'));
            }
        }
    },

    submit : function()
    {
        Form.disable($('#register_form'));

        var login    = Form.getCleanInputValue($('#register_login'));
        var gender   = Form.getCleanInputValue($('#register_gender'));
        var zip      = Form.getCleanInputValue($('#register_zip'));
        var email    = Form.getCleanInputValue($('#register_email'));
        var password = Form.getCleanInputValue($('#register_password_1'));

        if (login.length == 0 || email.length == 0 || password.length == 0 || zip.length == 0 || gender.length == 0)
        {
            alert('Vous devez remplir tous les champs du formulaire pour créer un compte !');
            Form.enable($('#register_form'));
            return;
        }
        else
        {
            var params =
            {
                login    : login,
                gender   : gender,
                zip      : zip,
                email    : email,
                password : password
            };
            $.post(ROOT_PATH + 'remote/register/submit', params, Register.submitCallback);
        }
    },

    submitCallback : function(data)
    {
        //window.location = ROOT_PATH + 'login/confirm';
    }

};

