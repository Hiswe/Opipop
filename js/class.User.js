var User =
{

    initFriendList : function()
    {
        $('#user_friends a[title="add"]').bind('click', User.addToFriend);
        $('#user_friends a[title="cancel"]').bind('click', User.addToFriend);
        $('#user_friends a[title="remove"]').bind('click', User.addToFriend);
    },

    addToFriend : function(event)
    {
        event.preventDefault();

        var link     = $(this);
        var friendId = link.attr('id').split('_')[1];
        var action   = link.attr('title');
        var params   =
        {
            friendId : friendId,
            action   : action
        };

        if (action == 'remove' && !confirm('Êtes vous sur de vouloir retirer cette personne de vos amis ?'))
        {
            return;
        }

        link.fadeTo(0, 0);
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

        var link = $('#friend_' + data.friendId);

        if (data.action == 'add')
        {
            link.attr('title', 'cancel');
            link.html('Annuler la demande');
            link.fadeTo(800, 1);
        }
        else if (data.action == 'cancel' || data.action == 'remove')
        {
            link.attr('title', 'add');
            link.html('Ajouter a mes amis');
            link.fadeTo(800, 1);
        }
    },

    //requestFriend : function(friendId, accept)
    //{
        //if (accept)
        //{
            //$('#request_' + friendId).html('<span>accepted</span>');
        //}
        //else
        //{
            //$('#request_' + friendId).html('<span>rejected</span>');
        //}

        //var params =
        //{
            //friendId : friendId,
            //action   : (accept) ? 'accept' : 'cancel'
        //};
        //$.post(ROOT_PATH + 'remote/user/addToFriend', params);
    //}

};

