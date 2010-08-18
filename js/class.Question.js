var Question =
{

    archivePage : 0,
    working     : false,
    endReached  : false,

    initList : function()
    {
        $('#question_active .question').each(function(item)
        {
            $(this).find('.draggable').draggable(
            {
                scope          : $(this).attr('id'),
                zIndex         : 100,
                revert         : true,
                revertDuration : 300
            });
            $(this).find('.droppable').droppable(
            {
                scope       : $(this).attr('id'),
                drop        : Question.save,
                activeClass : 'active',
                hoverClass  : 'hover',
                tolerance   : 'intersect'
            });
        });
    },

    save : function(event, ui)
    {
        if ($(this).attr('id') == ui.draggable.parentsUntil('.droppable').parent().attr('id'))
        {
            return;
        }

        var draggable = ui.draggable.detach();
        var droppable = $(this);
        var question  = droppable.closest('li.question');

        droppable.find('ul.group').append(draggable);

        draggable.css(
        {
            'left' : 0,
            'top'  : 0
        });

        question.find('.droppable').each(function(index, item)
        {
            if ($(item).find('.user, .friend').length == 0)
            {
                $(item).find('.message').html('Vide ...');
            }
            else
            {
                $(item).find('.message').html('');
            }
        });

        var droppableData = droppable.attr('id').split('.');
        var draggableData = draggable.attr('id').split('.');

        var params =
        {
            'question' : droppableData[1]
        };

        switch (droppableData[0])
        {
            case 'answer':
                params['answer'] = droppableData[2];
                break;

            case 'pending':
                params['answer'] = 0;
                break;
        }

        switch (draggableData[0])
        {
            case 'vote':
                params['vote'] = draggableData[2];
                break;

            case 'guess':
                params['guess'] = draggableData[2];
                break;

            case 'friend':
                params['user']   = draggableData[2];
                params['friend'] = draggableData[3];
                break;
        }

        $.post(ROOT_PATH + 'remote/question/save', params, Question.saveCallback);
    },

    saveCallback : function(data)
    {
        if (data == 'register')
        {
            window.location = ROOT_PATH + 'register';
        }
    },

    initArchiveList : function()
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
        Question.showArchive(event);
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
        Question.showArchive(event);
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

    showArchiveCallback : function(data, message, xhr)
    {
        var json = xhr.getResponseHeader('X-JSON');
        if (json)
        {
            eval(json);
        }

        Question.working = false;

        $('#question_archive').replaceWith(data);
        $('#question_archive').fadeTo(0, 0);
        $('#question_archive').fadeTo(800, 1);

        if ($('#question_archive li').length == 0)
        {
            Question.setEndReached();
        }
    }

};

