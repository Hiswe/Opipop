function init(type)
{
    $('list').update();
    $('pagination').update();
    $('form').update();

    switch(type)
    {
        case 'question':
            var list = new List(
            {
                script      : 'backoffice/remote/question_list.php',
                model       : Question,
                page        : 0,
                itemPerPage : 12
            });
            list.init();
            break;
    }
};

