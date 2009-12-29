var lists = {};

function init(type)
{
    $('list').update();
    $('form').update();

    switch(type)
    {
        case 'question':
            if (!lists[type])
            {
                lists[type] = new List(
                {
                    script      : 'backoffice/remote/question_list.php',
                    model       : Question,
                    page        : 0,
                    itemPerPage : 10
                });
            }
            lists[type].init();
            break;
    }
};

