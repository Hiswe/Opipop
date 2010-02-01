window.onload = function ()
{
    init('category');
};

var lists = {};

function init(type)
{
    $('working').hide();
    $('list_1').update();
    $('list_2').update();
    $('form').hide();

    switch(type)
    {
        case 'category':
            if (!lists[type])
            {
                lists[type] = new List(
                {
                    script       : 'backoffice/remote/category_list',
                    container    : 'list_1',
                    model        : Category,
                    editStatus   : true,
                    editPosition : true,
                    page         : 0,
                    itemPerPage  : 10
                });
            }
            lists[type].init();
            break;
    }
};

