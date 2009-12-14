window.onload = function () {
};


///////////////////
// POLL
///////////////////

var poll_parameters = {};

function poll_init(params)
{
    poll_parameters = params;

    var recievers = new Array();

    $$('#result li.answer').each(function(item)
    {
        recievers.push(item);
    });
    recievers.push($('farm'));

    $$('#farm li.user, #result li.user').each(function(item)
    {
        item.observe('mousedown', function(e)
        {
            dragdrop.grab(e, this, recievers, poll_userDropCallback);
        });
        item.setStyle(
        {
            cursor : 'pointer'
        });
    });
}

function poll_userDropCallback(user, reciever)
{
    reciever.down('ul').insert(user);

    var answer_id = 0;

    if (reciever.readAttribute('id') != 'farm')
    {
        answer_id = reciever.readAttribute('id').split('_')[1];
    }

    var params = $H(
    {
        answer_id   : answer_id,
        question_id : poll_parameters['question_id'],
        user_id     : user.readAttribute('id').split('_')[1]
    });

    new Ajax.Request (ROOT_PATH + 'remote/poll_saveResult.php',
    {
        parameters: params.toQueryString(),
        onSuccess: function(xhr)
        {
        }
    });
}


///////////////////
// FORM
///////////////////

function form_setError(input, message)
{
    var form = input.up('form');

    form.error = (form.error) ? form.error + 1 : 0;

    if (!form.hasClassName('error'))
    {
        form.addClassName('error');
        form.down('input[type=submit]').writeAttribute('disabled');
    }
    if (!input.hasClassName('error'))
    {
        var warning = new Element('span').update(message);
        input.addClassName('error');
        input.warning = warning;
        input.up('div').insert(warning);
    }
}

function form_cleanError(input)
{
    var form = input.up('form');

    form.error = (form.error) ? form.error - 1 : 0;

    if (form.error == 0 && form.hasClassName('error'))
    {
        form.removeClassName('error');
        form.down('input[type=submit]').removeAttribute('disabled');
    }
    if (form.error != 0 && !form.hasClassName('error'))
    {
        form.addClassName('error');
    }
    if (input.hasClassName('error'))
    {
        input.removeClassName('error');
        input.warning.remove();
    }
}


///////////////////
// REGISTER
///////////////////

function login_init()
{
}

function login_submit()
{
    var login = $('login_login').value.stripScripts().stripTags().strip();
    var password = $('login_password').value.stripScripts().stripTags().strip();

    if (login.blank() || password.blank())
    {
        alert('You must fill all the form\'s field to login !');
        return;
    }
    else
    {
        var params = $H(
        {
            login: login,
            password: password
        });

        new Ajax.Request (ROOT_PATH + 'remote/login_submit.php',
        {
            parameters: params.toQueryString(),
            onSuccess: function(xhr)
            {
                if (xhr.responseText == '1')
                {
                    window.location = ROOT_PATH;
                }
                else
                {
                    alert('Error: wrond login or password');
                }
            }
        });
    }
}

///////////////////
// REGISTER
///////////////////

var register_checkLoginTimeout = 0;
var register_checkPasswordTimeout = 0;
var register_checkEmailTimeout = 0;

function register_init()
{
    $('register_login').observe('keydown', register_scheduleCheckLogin);
    $('register_email').observe('keydown', register_scheduleCheckEmail);
    $('register_password_1').observe('keydown', register_scheduleCheckPassword);
    $('register_password_2').observe('keydown', register_scheduleCheckPassword);
}

function register_scheduleCheckLogin()
{
    clearTimeout(register_checkLoginTimeout);
    register_checkLoginTimeout = setTimeout(register_checkLogin, 500);
}

function register_scheduleCheckPassword()
{
    clearTimeout(register_checkPasswordTimeout);
    register_checkPasswordTimeout = setTimeout(register_checkPassword, 500);
}

function register_scheduleCheckEmail()
{
    clearTimeout(register_checkEmailTimeout);
    register_checkEmailTimeout = setTimeout(register_checkEmail, 500);
}

function register_checkLogin()
{
    var input = $('register_login');
    var value = input.value.strip().stripScripts().stripTags();

    if (!value.blank())
    {
        var params = $H(
        {
            login: input.value
        });

        new Ajax.Request (ROOT_PATH + 'remote/register_checkLogin.php',
        {
            parameters: params.toQueryString(),
            onSuccess: function(xhr)
            {
                if (xhr.responseText == '1')
                {
                    form_cleanError(input);
                }
                else if (xhr.responseText == '0')
                {
                    form_setError(input, 'this user name is already in use');
                }
            }
        });
    }
}

function register_checkEmail()
{
    var input = $('register_email');
    var value = input.value.strip().stripScripts().stripTags();

    if (!value.blank())
    {
        if (checkEmail(input.value))
        {
            form_cleanError(input);
        }
        else
        {
            form_setError(input, 'wrong email');
        }
    }
}

function register_checkPassword()
{
    var input_1 = $('register_password_1');
    var input_2 = $('register_password_2');

    if (input_1.value.length == 0)
    {
        input_2.value = '';
        form_cleanError(input_1);
        form_cleanError(input_2);
    }
    else if (input_1.value.length < 6)
    {
        form_setError(input_1, 'password must be at least 6 character long');
    }
    else
    {
        form_cleanError(input_1);

        if (input_1.value.length != 0 && input_2.value.length != 0 && input_1.value !=  input_2.value)
        {
            form_setError(input_2, 'error confirming passord');
        }
        else
        {
            form_cleanError(input_2);
        }
    }
}

function register_submit()
{
    var login = $('register_login').value.stripScripts().stripTags().strip();
    var email = $('register_email').value.stripScripts().stripTags().strip();
    var password = $('register_password_1').value.stripScripts().stripTags().strip();

    if (login.blank() || email.blank() || password.blank())
    {
        alert('You must fill all the form\'s field to register !');
        return;
    }
    else
    {
        var params = $H(
        {
            login: login,
            email: email,
            password: password
        });

        new Ajax.Request (ROOT_PATH + 'remote/register_submit.php',
        {
            parameters: params.toQueryString(),
            onSuccess: function(xhr)
            {
                window.location = ROOT_PATH + 'login/confirm';
            }
        });
    }
}
