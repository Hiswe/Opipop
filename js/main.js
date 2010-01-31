window.onload = function () {
};


///////////////////
// USER
///////////////////

function user_search_submit()
{
	form_disable($('user_search'));

    var query = $('user_search_query').value.stripScripts().stripTags().strip();

    if (query.blank())
    {
		window.location = ROOT_PATH + 'users';
    }
	else
	{
		window.location = ROOT_PATH + 'users/search/' + escape(query);
	}
}

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

	new Ajax.Request (ROOT_PATH + 'remote/user_addToFriend.php',
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

	new Ajax.Request (ROOT_PATH + 'remote/user_addToFriend.php',
	{
		parameters: params.toQueryString()
	});
}


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

    var userRecievers = new Array();
    var friendRecievers = new Array();

    $$('#result li.answer').each(function(item)
    {
        userRecievers.push(item);
        friendRecievers.push(item);
    });
    userRecievers.push($('base_user'));
    friendRecievers.push($('base_friend'));

    $$('#base li.user').each(function(item)
    {
        item.observe('mousedown', function(e)
        {
            dragdrop.grab(e, this, userRecievers, poll_userDropCallback);
        });
        item.setStyle(
        {
            cursor : 'pointer'
        });
    });
    $$('#base li.friend').each(function(item)
    {
        item.observe('mousedown', function(e)
        {
            dragdrop.grab(e, this, friendRecievers, poll_userDropCallback);
        });
        item.setStyle(
        {
            cursor : 'pointer'
        });
    });
}

function poll_userDropCallback(user, reciever)
{
    reciever.insert(user);

    if ($$('#base_user li.user.unregistered').length === 0)
    {
        $('saveButton').show();
    }
    else
    {
        $('saveButton').hide();
    }
}

function poll_saveResult()
{
    $('saveButton').hide();

    var params =
    {
        'question_id' : poll_parameters['question_id']
    };
    $$('#result li.answer').each(function(answer)
    {
        answer.select('li.user.unregistered.voted').each(function(user)
        {
            params['user[' + user.readAttribute('name').split('_')[1] + '][vote]'] = answer.readAttribute('name').split('_')[1];
        });
        answer.select('li.user.unregistered.guessed').each(function(user)
        {
            params['user[' + user.readAttribute('name').split('_')[1] + '][guess]'] = answer.readAttribute('name').split('_')[1];
        });
        answer.select('li.friend.unregistered.guessed').each(function(friend)
        {
            params['friend[' + friend.readAttribute('name').split('_')[1] + '][guess]'] = answer.readAttribute('name').split('_')[1];
        });
    });

	new Ajax.Request (ROOT_PATH + 'remote/poll_saveResult.php',
	{
		parameters: $H(params).toQueryString(),
		onSuccess: function(xhr)
		{
            // TODO : the page is the same after reload, maybe we don't need to reload the page
            window.location.reload();
		}
	});
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


///////////////////
// LOGIN
///////////////////

function login_init()
{
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

        new Ajax.Request (ROOT_PATH + 'remote/login_submit.php',
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

        new Ajax.Request (ROOT_PATH + 'remote/register_submit.php',
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
