var Question =
{

    archivePage : 0,
    working     : false,
    endReached  : false,

    initList : function()
    {
        $('#nextQuestionButton').bind('click', Question.showNextArchive);
        $('#previousQuestionButton').bind('click', Question.showPreviousArchive);
    },

    setEndReached : function()
    {
        Question.endReached = true;
        $('#nextQuestionButton').addClass('disable');
    },

    showNextArchive : function(event)
    {
        event.preventDefault();
        if (Question.endReached)
        {
            return;
        }
        $('#previousQuestionButton').removeClass('disable');
        Question.archivePage ++;
        Question.showArchive();
    },

    showPreviousArchive : function(event)
    {
        event.preventDefault();
        if (Question.archivePage == 0)
        {
            return;
        }
        Question.endReached = false;
        Question.archivePage = (Question.archivePage > 0) ? Question.archivePage - 1 : 0;
        if (Question.archivePage == 0)
        {
            $('#previousQuestionButton').addClass('disable');
        }
        $('#nextQuestionButton').removeClass('disable');
        Question.showArchive();
    },

    showArchive : function()
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
        $('#questionArchiveContainer').replaceWith(data);
        if ($('#questionArchiveContainer li').length == 0)
        {
            Question.setEndReached();
        }
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
        $('ul.menu li.button').bind('click', Question.resultSelectTab);
        $('#questionResults div.tab:not(:first-child)').hide();
    },

    resultSelectTab : function()
    {
        var $currentButton = $(this);
        var $buttons = $('ul.menu li.button');
        var $tabs = $('#questionResults div.tab');
        var index = $(this).index();

        $tabs.hide();
        $tabs.eq(index).show();

        $buttons.filter('selected').removeClass('selected');
        $currentButton.addClass('selected');
    }

};

