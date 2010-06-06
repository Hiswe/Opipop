window.onload = function ()
{
    init('category');
    init('submition');
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
                    itemPerPage  : 10,
                    autoLoad     : true,
                    interactive  : true,
                    addItem      : true
                });
            }
            lists[type].init();
            break;

        case 'submition':
            if (!lists[type])
            {
                lists[type] = new List(
                {
                    script       : 'backoffice/remote/submition_list',
                    container    : 'list_0',
                    model        : Submition,
                    page         : 0,
                    itemPerPage  : 5,
                    interactive  : false,
                    addItem      : false
                });
            }
            lists[type].init();
            break;
    }
};

