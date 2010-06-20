var Question =
{

    archivePage : 1,
    workin      : false,
    data        :
    {
        vote  : {},
        guess : {}
    },

    initList : function()
    {
        $('#morePollsButton').bind('mousedown', Question.showArchive);
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
        $('#questionArchiveContainer').html(data);
    },

    selectAnswer : function(button, questionId, answerId, action)
    {
        var answerButtons = $('#question_' + questionId + ' button.answer');
        var saveButton    = $('#question_' + questionId + ' button.save');

        answerButtons.removeClass('selected');
        button.addClass('selected');
        saveButton.removeClass('hide');

        Question.data[action][questionId] = answerId;
    },

    save : function(button, questionId, action)
    {
        if (!Question.data[action][questionId])
        {
            return false;
        }

        button.remove();

        var params =
        {
            'question_id' : questionId,
            'answer_id'   : Question.data[action][questionId]
        };

        $.post(ROOT_PATH + 'remote/question/active/' + action, params, Question.saveCallback);
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
            $('#question_' + data.questionId + ' .content').html(data.content);
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

