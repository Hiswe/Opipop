var User =
{

    searchTimeout       : 0,
    previousSearchQuery : '',

    initSearch : function()
    {
        $('#user_search').bind('submit', Form.noAction);
        $('#user_search_query').bind('keydown', User.scheduleSearch);
        $('#user_search_query').bind('change', User.scheduleSearch);
    },

    scheduleSearch : function()
    {
        clearTimeout(User.searchTimeout);
        User.searchTimeout = setTimeout(User.search, 500);
    },

    search : function(event)
    {
        var query = Form.getCleanInputValue($('#user_search_query'));
        if (query.length == 0)
        {
            User.cleanSearch();
            return;
        }
        else if (query == User.previousSearchQuery)
        {
            return;
        }
        User.previousSearchQuery = query;

        var params =
        {
            query : query
        };
        $.post(ROOT_PATH + 'remote/user/search', params, User.searchCallback);
    },

    cleanSearch : function()
    {
        $('#user_search_result').html('');
    },

    searchCallback : function(data)
    {
        if (data == 'register')
        {
            window.location = ROOT_PATH + 'register';
        }

        User.cleanSearch();

        var i = 0;
        var container = $('#user_search_result');
        for (i = 0; i < data.length; i ++)
        {
            container.append
            (
                '<li class="box">' +
                    '<ul class="edit">' +
                        '<li><a href="#" id="friend_' + data[i].id + '" class="button" title="ask">ajouter a mes amis</a></li>' +
                    '</ul>' +
                    '<a href="' + ROOT_PATH + data[i].login + '">' +
                        '<img class="avatar" src=' + ROOT_PATH + data[i].avatar + ' />' +
                        '<strong class="login">' + data[i].login + '</strong>' +
                    '</a>' +
                '</li>'
            );
        }

        $('#user_search_result a[title="ask"]').bind('click', User.addToFriend);
    },

    initFriends : function()
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

        if (data.action == 'ask')
        {
            link.replaceWith('<span class="message">Requette envoyée !</span>');
        }
        else if (data.action == 'add')
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
        $.post(ROOT_PATH + 'remote/user/addToFriend', params, User.requestFriendCallback);
    },

    requestFriendCallback : function(data)
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

