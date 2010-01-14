window.onload = function () {
};


///////////////////
// POLL
///////////////////

var poll_parameters = {};

function poll_initResult()
{
    $$('#result div.progress').each(function(item)
    {
        var fx = new FX.Element(item);
        fx.setOptions(
        {
           'duration': 2500,
           'transition': FX.Transition.easeOutBounce
        });
        fx.animate(
        {
            'width': item.readAttribute('name') + '%'
        });
        setTimeout(function()
        {
            fx.play();
        }, Math.floor(Math.random() * 800));
    });
}

function poll_initVote(params)
{
    poll_parameters = params;

    $('saveButton').hide();
    $('saveButton').observe('click', poll_saveResult);

    if (poll_parameters['mode'] == 'vote')
    {
        $$('#result li.user.guessed').each(function(item)
        {
            item.hide();
        });
    }
    if (poll_parameters['mode'] == 'prognostic')
    {
        $$('#result li.user.voted').each(function(item)
        {
            item.hide();
        });
    }

    var recievers = new Array();

    $$('#result li.answer').each(function(item)
    {
        recievers.push(item);
    });
    recievers.push($('farm'));

    $$('#farm li.user').each(function(item)
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

    if ($$('#result li.answer li.user.unregistered').length === 0)
    {
        $('saveButton').hide();
    }
    else
    {
        $('saveButton').show();
    }
}

function poll_saveResult()
{
    $('saveButton').hide();

    var i = 0;
    var users = [];
    var params =
    {
        'mode' : poll_parameters['mode'],
        'question_id' : poll_parameters['question_id']
    };
    $$('#result li.answer').each(function(answer)
    {
        answer.select('li.user.unregistered').each(function(user)
        {
            users.push(user);
            params['user[' + i + ']'] = user.readAttribute('id').split('_')[1];
            params['answer[' + i + ']'] = answer.readAttribute('id').split('_')[1];
            i ++;
        });
    });

    console.log(params);
    console.log($H(params).toQueryString());

    if (i !== 0)
    {
        new Ajax.Request (ROOT_PATH + 'remote/poll_saveResult.php',
        {
            parameters: $H(params).toQueryString(),
            onSuccess: function(xhr)
            {
                if (poll_parameters['mode'] == 'vote')
                {
                    // put back users to farm
                    users.each(function(item)
                    {
                        $('farm').down('ul').insert(item);
                    });

                    // switch voted/guessed users display
                    $$('#result li.user.guessed').each(function(item)
                    {
                        item.show();
                    });
                    $$('#result li.user.voted').each(function(item)
                    {
                        item.hide();
                    });

                    poll_parameters['mode'] = 'prognostic';
                }
                else
                {
                    window.location = ROOT_PATH;
                }
            }
        });
    }
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
    $('register_login').observe('change', register_scheduleCheckLogin);
    $('register_email').observe('keydown', register_scheduleCheckEmail);
    $('register_email').observe('change', register_scheduleCheckEmail);
    $('register_password_1').observe('keydown', register_scheduleCheckPassword);
    $('register_password_1').observe('change', register_scheduleCheckPassword);
    $('register_password_2').observe('keydown', register_scheduleCheckPassword);
    $('register_password_2').observe('change', register_scheduleCheckPassword);
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
    else
    {
        form_cleanError(input);
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

            var params = $H(
            {
                email : input.value
            });

            new Ajax.Request (ROOT_PATH + 'remote/register_checkEmail.php',
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
                        form_setError(input, 'this email is already in use');
                    }
                }
            });
        }
        else
        {
            form_setError(input, 'wrong email');
        }
    }
    else
    {
        form_cleanError(input);
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
    var gender = $('register_gender').value.stripScripts().stripTags().strip();
    var zip = $('register_zip').value.stripScripts().stripTags().strip();
    var email = $('register_email').value.stripScripts().stripTags().strip();
    var password = $('register_password_1').value.stripScripts().stripTags().strip();

    return alert(zip);

    if (login.blank() || email.blank() || password.blank() || zip.blank() || gender.blank())
    {
        alert('You must fill all the form\'s field to register !');
        return;
    }
    else
    {
        var params = $H(
        {
            login    : login,
            gender   : gender,
            zip      : zip,
            email    : email,
            password : password
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
