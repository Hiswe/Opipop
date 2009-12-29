var lists = {};

function init(type)
{
    $('pagination').update();
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
                    itemPerPage : 12
                });
            }
            lists[type].init();
            break;
    }
};

