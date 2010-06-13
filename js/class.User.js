var User =
{

	addToFriend : function(friendId)
	{
		var link   = $('#addToFriend_' + friendId);
		var action = link.attr('class');
		var params =
		{
			friendId : friendId,
			action   : action
		};

		if (action == 'remove' && !confirm('Are you sure you want to remove this user from your friends ?'))
		{
			return;
		}

		link.html('');

		$.post(ROOT_PATH + 'remote/user/addToFriend', params, User.addToFriendCallback);
	},

	addToFriendCallback : function(data)
	{
		if (data == 'register')
		{
			window.location = ROOT_PATH + 'register';
		}
		else if (data == 'reload')
		{
			window.location = window.location;
		}
		else
		{
			data = $.parseJSON(data);
		}

		var link = $('#addToFriend_' + data.friendId);
		link.attr('class', '');

		if (data.action == 'add')
		{
			link.addClass('cancel');
			link.html('Cancle friend request');
		}
		else if (data.action == 'cancel' || data.action == 'remove')
		{
			link.addClass('add');
			link.html('Add to friends');
		}
	},

	requestFriend : function(friendId, accept)
	{
		if (accept)
		{
			$('#request_' + friendId).html('<span>accepted</span>');
		}
		else
		{
			$('#request_' + friendId).html('<span>rejected</span>');
		}

		var params =
		{
			friendId : friendId,
			action   : (accept) ? 'accept' : 'cancel'
		};
		$.post(ROOT_PATH + 'remote/user/addToFriend', params);
	}

};

