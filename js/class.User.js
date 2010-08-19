var User =
{

    initFriendList : function()
    {
        $(
            '#user_friends a[title="add"],' +
            '#user_friends a[title="cancel"],' +
            '#user_friends a[title="remove"],' +
            '#user_card a[title="add"],' +
            '#user_card a[title="cancel"],' +
            '#user_card a[title="remove"]'
        )
        .bind('click', User.addToFriend);

        $(
            '#user_friends a[title="accept"],' +
            '#user_friends a[title="reject"]'
        )
        .bind('click', User.requestFriend);
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

        if ((action == 'cancel' && !confirm('Êtes vous sur de vouloir annuler cette demande ?'))
        || (action == 'remove' && !confirm('Êtes vous sur de vouloir retirer cette personne de vos amis ?'))
        || (action == 'reject' && !confirm('Êtes vous sur de vouloir refuser cette personne ?')))
        {
            return;
        }
        if (action == 'remove' || action == 'cancel' || action == 'reject')
        {
            link.parent().parent().addClass('loading');
            link.remove();
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
            window.location = window.location.toString().replace(/(#)/g, '');
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

    requestFriend : function(event)
    {
        event.preventDefault();

        var link     = $(this);
        var friendId = link.attr('id').split('_')[1];
        var action   = link.attr('title');

        if (action == 'reject' && !confirm('Êtes vous sur de vouloir refuser cette personne ?'))
        {
            return;
        }

        link.parent().parent().addClass('loading');
        link.parent().siblings().remove();
        link.remove();

        var params =
        {
            friendId : friendId,
            action   : action
        };
        $.post(ROOT_PATH + 'remote/user/addToFriend', params, User.addToFriendCallback);
    },

    addToFriendCallback : function(data)
    {
        if (data == 'register')
        {
            window.location = ROOT_PATH + 'register';
        }
        else
        {
            window.location = window.location.toString().replace(/(#)/g, '');
        }
    }

};

