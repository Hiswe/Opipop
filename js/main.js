window.onload = function () {
};


///////////////////
// VIS
///////////////////

function vis_animate(vis, duration, ease)
{
    var t = 0;
    var clock = setInterval(function()
    {
        t += 1 / (duration / 33);
        vis.s = Transition[ease](0, t, 0, -1, 1);
        vis.render();
        if (t > 1)
        {
            clearInterval(clock);
        }
    }, 33);
}

function vis_colorList()
{
    //return pv.colors('CornflowerBlue', 'Fuchsia', 'AliceBlue', 'Lavender', 'PaleGreen');
    return pv.colors('red', 'yellow', 'green', 'blue', 'black');
}

function vis_simplePie(target, width, height, data)
{
    new pv.Panel()
        .canvas(target)
        .width(width)
        .height(height)
    .add(pv.Wedge)
        .data(pv.normalize(data))
        .left(width / 2)
        .bottom(height / 2)
        .innerRadius(width / 8)
        .outerRadius(width / 2)
        .angle(function(d){ return d * 2 * Math.PI; })
        .lineWidth(width / 40)
        .strokeStyle('white')
        .fillStyle(vis_colorList())
    .root.render();
}


///////////////////
// USER
///////////////////

function user_addToFriend(friendId, reload)
{
    var link = $('addToFriend_' + friendId);
    var action = link.readAttribute('class');
    var params = $H(
    {
        friendId : friendId,
        action   : action
    });

    if (action == 'remove' && !confirm('Are you sure you want to remove this user from your friends ?'))
    {
        return;
    }

    link.update();

    new Ajax.Request (ROOT_PATH + 'remote/user/addToFriend',
    {
        parameters: params.toQueryString(),
        onSuccess: function(xhr)
        {
            if (reload)
            {
                window.location.reload();
                return;
            }

            link.removeClassName(link.readAttribute('class'));
            if (action == 'add')
            {
                link.addClassName('cancel');
                link.update('Cancle friend request');
            }
            else if (action == 'cancel' || action == 'remove')
            {
                link.addClassName('add');
                link.update('Add to friends');
            }
        }
    });
}

function user_requestFriend(friendId, accept)
{
    if (accept)
    {
        $('request_' + friendId).update(new Element('span').update('accepted'));
    }
    else
    {
        $('request_' + friendId).update(new Element('span').update('rejected'));
    }

    var params = $H(
    {
        friendId : friendId,
        action   : (accept) ? 'accept' : 'cancel'
    });

    new Ajax.Request (ROOT_PATH + 'remote/user/addToFriend',
    {
        parameters: params.toQueryString()
    });
}


///////////////////
// QUESTION LIST
///////////////////

var question_archivePage = 1;

function question_initList()
{
    $('morePollsButton').observe('mousedown', question_showArchive);
}

function removeMorePollButton()
{
    $('morePollsButton').remove();
}

function question_showArchive()
{
    $('morePollsButton').hide();

    var params =
    {
        'page' : question_archivePage,
    };

    new Ajax.Request (ROOT_PATH + 'remote/question/archive',
    {
        parameters: $H(params).toQueryString(),
        onSuccess: function(xhr)
        {
            if ($('morePollsButton'))
            {
                $('morePollsButton').show();
            }
            $('questionArchiveContainer').insert(xhr.responseText);
            question_archivePage ++;
        }
    });
}


///////////////////
// QUESTION
///////////////////

var question_data =
{
    vote : {},
    guess : {}
};

function question_selectAnswer(button, questionId, answerId, action)
{
    var answerButtons = $$('#question_' + questionId + ' button.answer');
    var saveButton    = $$('#question_' + questionId + ' button.save')[0];

    answerButtons.each(function(item)
    {
        item.removeClassName('selected');
    });

    button.addClassName('selected');
    saveButton.removeClassName('hide');
    question_data[action][questionId] = answerId;
}

function question_save(button, questionId, action)
{
    if (!question_data[action][questionId])
    {
        return false;
    }

    button.remove();

    var params =
    {
        'question_id' : questionId,
        'answer_id'   : question_data[action][questionId],
    };

    new Ajax.Request (ROOT_PATH + 'remote/question/active/' + action,
    {
        parameters: $H(params).toQueryString(),
        onSuccess: function(xhr)
        {
            if (xhr.responseText == 'register')
            {
                window.location = ROOT_PATH + 'register';
                return;
            }
            else
            {
                $$('#question_' + questionId + ' .content')[0].update(xhr.responseText);
            }
        }
    });
}

function question_guessFriend(button, questionId)
{
    var params =
    {
        'question_id' : questionId
    };
    var guesses = $$('#question_' + questionId + ' .friends input.guess');
    var data    = null;

    button.remove();

    guesses.each(function(item)
    {
        if (item.checked && !item.disabled)
        {
            data = item.value.split('-');
            params['guess[' + data[0] + ']'] = data[1];
        }
    });

    new Ajax.Request (ROOT_PATH + 'remote/question/active/friends',
    {
        parameters: $H(params).toQueryString(),
        onSuccess: function(xhr)
        {
            if (xhr.responseText == 'register')
            {
                window.location = ROOT_PATH + 'register';
                return;
            }
            else
            {
                $$('#question_' + questionId + ' .friends')[0].update(xhr.responseText);
            }
        }
    });
}

///////////////////
// LOGIN
///////////////////

function login_init()
{
    $('login_link').observe('click', login_show);
    login_hide();
}

function login_show()
{
    $('login').show();
    $('login_link').hide();
}

function login_hide()
{
    $('login').hide();
    $('login_link').show();
}

function login_submit()
{
    form_disable($('login'));

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

        new Ajax.Request (ROOT_PATH + 'remote/login/submit',
        {
            parameters: params.toQueryString(),
            onSuccess: function(xhr)
            {
                if (xhr.responseText == '1')
                {
                    window.location = ROOT_PATH + login;
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
// USER EDIT
///////////////////

function user_edit_init()
{
}

function user_edit_submit()
{
    var gender = $('user_edit_gender').value.stripScripts().stripTags().strip();
    var zip = $('user_edit_zip').value.stripScripts().stripTags().strip();

    if (zip.blank() || gender.blank())
    {
        alert('You must fill all the form\'s field !');
        return false;
    }
    else
    {
        form_disable($('user_edit'));
        return true;
    }
}


///////////////////
// USER PASSWORD
///////////////////

var user_password_checkPasswordTimeout = 0;

function user_password_init()
{
    $('user_password_password_1').observe('keydown', user_password_scheduleCheckPassword);
    $('user_password_password_1').observe('change', user_password_scheduleCheckPassword);
    $('user_password_password_2').observe('keydown', user_password_scheduleCheckPassword);
    $('user_password_password_2').observe('change', user_password_scheduleCheckPassword);
}

function user_password_scheduleCheckPassword()
{
    clearTimeout(user_password_checkPasswordTimeout);
    user_password_checkPasswordTimeout = setTimeout(user_password_checkPassword, 500);
}

function user_password_checkPassword()
{
    var input_1 = $('user_password_password_1');
    var input_2 = $('user_password_password_2');

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

function user_password_submit()
{
    var old_password = $('user_password_password_0').value;
    var new_password = $('user_password_password_1').value;

    if (old_password.blank() || new_password.blank())
    {
        alert('You must fill all the form\'s field !');
        return false;
    }
    else
    {
        form_disable($('user_password'));
        return true;
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
        if (value.match(/([^a-zA-Z0-9_])/g))
        {
            form_setError(input, 'username must contain only alpha or digit characters or underscores');
            return;
        }

        var params = $H(
        {
            login: input.value
        });

        new Ajax.Request (ROOT_PATH + 'remote/register/checkLogin',
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

            new Ajax.Request (ROOT_PATH + 'remote/register/checkEmail',
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
    form_disable($('register'));

    var login = $('register_login').value.stripScripts().stripTags().strip();
    var gender = $('register_gender').value.stripScripts().stripTags().strip();
    var zip = $('register_zip').value.stripScripts().stripTags().strip();
    var email = $('register_email').value.stripScripts().stripTags().strip();
    var password = $('register_password_1').value;

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

        new Ajax.Request (ROOT_PATH + 'remote/register/submit',
        {
            parameters: params.toQueryString(),
            onSuccess: function(xhr)
            {
                if (xhr.responseText == '0')
                {
                    alert('Error while registerging, this login is not allowed !');
                }
                else
                {
                    window.location = ROOT_PATH + 'login/confirm';
                }
            }
        });
    }
}


///////////////////
// FORM
///////////////////

function form_disable(form)
{
    form.down('input[type=submit]').writeAttribute('disabled');
}

function form_enable(form)
{
    form.down('input[type=submit]').writeAttribute('disabled', false);
}

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

