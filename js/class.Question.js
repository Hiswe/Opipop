var Question =
{

    archivePage : 0,
    working     : false,
    endReached  : false,

    initList : function()
    {
        $('#questions li.question').each(function(item)
        {
            $(this).find('li.draggable').draggable(
            {
                scope  : $(this).attr('id'),
                revert : true
            });
            $(this).find('li.droppable').droppable(
            {
                scope       : $(this).attr('id'),
                drop        : Question.save,
                activeClass : 'active',
                hoverClass  : 'hover',
                tolerance   : 'touch'
            });
        });
    },

    save : function(event, ui)
    {
        var draggable = ui.draggable.detach();
        var droppable = $(this);

        droppable.append(draggable);

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
                params['vote'] = droppableData[2];
                break;

            case 'guess':
                params['guess'] = droppableData[2];
                break;

            case 'friend':
                params['user']   = droppableData[2];
                params['friend'] = droppableData[3];
                break;
        }

        $.post(ROOT_PATH + 'remote/question/save', params, Question.saveCallback);
    },

    saveCallback : function(data)
    {
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

    showArchiveCallback : function(data)
    {
        Question.working = false;
        $('#questionArchiveContainer').replaceWith(data);
        if ($('#questionArchiveContainer li').length == 0)
        {
            Question.setEndReached();
        }
    }

};

