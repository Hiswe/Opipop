var Question =
{

    archivePage : 1,
    workin      : false,

    initList : function()
    {
        $('#morePollsButton').bind('click', Question.showArchive);
    },

    removeMorePollButton : function()
    {
        $('#morePollsButton').remove();
    },

    showArchive : function(event)
    {
        event.preventDefault();

        if (Question.working)
        {
            return;
        }
        Question.working = true;

        var params =
        {
            'page' : Question.archivePage
        };

        $.post(ROOT_PATH + 'remote/question/archive', params, Question.showArchiveCallback);
    },

    showArchiveCallback : function(data)
    {
        Question.working = false;
        Question.archivePage ++;
        $('#questionArchiveContainer').append(data);
    },

    save : function(button, questionId, answerId, action)
    {
        $('#question_' + questionId + ' .content').html('').addClass('loading');

        var params =
        {
            'question_id' : questionId,
            'answer_id'   : answerId
        };

        setTimeout(function()
        {
            $.post(ROOT_PATH + 'remote/question/active/' + action, params, Question.saveCallback);
        }, 800);
    },

    saveCallback : function(data)
    {
        if (data == 'register')
        {
            window.location = ROOT_PATH + 'register';
        }
        else
        {
            data = $.parseJSON(data);
            $('#question_' + data.questionId + ' .content').html(data.content).removeClass('loading');
        }
    },

    guessFriend : function(button, questionId)
    {
        var guesses = $('#question_' + questionId + ' .friends input.guess:checked:enabled');
        var data    = null;
        var params  =
        {
            'question_id' : questionId
        };

        button.remove();

        guesses.each(function(item)
        {
            data = $(this).val().split('-');
            params['guess[' + data[0] + ']'] = data[1];
        });

        $.post(ROOT_PATH + 'remote/question/active/friends', params, Question.guessFriendCallback);
    },

    guessFriendCallback : function(data)
    {
        if (data == 'register')
        {
            window.location = ROOT_PATH + 'register';
        }
        else
        {
            data = $.parseJSON(data);
            $('#question_' + data.questionId + ' .friends').html(data.content);
        }
    },

    initResults : function()
    {
        $('#questionResults ul.menu li.button').bind('click', Question.resultSelectTab);
        $('#questionResults div.tabs div.tab:not(:first-child)').hide();
    },

    resultSelectTab : function(n)
    {
        var n = $(this).attr('name');

        var tabs = $('#questionResults div.tabs div.tab');
        tabs.hide();
        tabs.eq(n).show();

        var buttons = $('#questionResults ul.menu li.button');
        buttons.removeClass('selected');
        buttons.eq(2).addClass('selected');
    }

};

