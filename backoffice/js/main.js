window.onload = function ()
{
    init('question');
};

var lists = {};

function init(type)
{
    $('working').hide();
    $('list').update();
    $('form').hide();

    switch(type)
    {
        case 'question':
            if (!lists[type])
            {
                lists[type] = new List(
                {
                    script      : 'backoffice/remote/question_list.php',
                    container   : 'list',
                    model       : Question,
                    editStatus  : true,
                    page        : 0,
                    itemPerPage : 10
                });
            }
            lists[type].init();
            break;
    }
};

