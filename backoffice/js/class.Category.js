var Category = function(param)
{
    this.param = param;
    this.data = {};
    this.loaded = false;
    this.list = null;

    this.init = function()
    {
        if (!this.list)
        {
            this.list = new List(
            {
                script      : 'backoffice/remote/question_list',
                container   : 'list_2',
                model       : Question,
                page        : 0,
                itemPerPage : 10,
                editStatus  : true,
                autoLoad    : true,
                parameters  :
                {
                    categoryId : this.param.item.getData('id')
                }
            });
        }
		this.loaded = true;
        this.list.init();
    };

    this.create = function(label, callback)
    {
        if (Job.working())
            return;
        Job.addJob();

        var param =
        {
            label : label
        };
        new Ajax.Request(ROOT_PATH + 'backoffice/remote/category_add',
        {
            parameters: $H(param).toQueryString(),
            onSuccess: function(xhr)
            {
                Job.endJob();

                this.loaded = true;
                this.data = xhr.responseJSON;
                callback(xhr.responseJSON);
            }.bind(this)
        });
    };

    this.toggle = function()
    {
        if (this.loaded)
        {
            this.show();
        }
        else
        {
            this.init();
        }
    };

    this.show = function()
    {
        this.list.show();
    };

    this.save = function()
    {
    };

    this.toggleStatus = function(callback)
    {
        var param =
        {
            id : this.param.item.getData('id')
        };
        new Ajax.Request(ROOT_PATH + 'backoffice/remote/category_toggleStatus',
        {
            parameters: $H(param).toQueryString(),
            onSuccess: callback
        });
    };

    this.updateLabel = function(label)
    {
        var param =
        {
            id    : this.param.item.getData('id'),
            label : label
        };
        new Ajax.Request(ROOT_PATH + 'backoffice/remote/category_updateLabel',
        {
            parameters: $H(param).toQueryString()
        });
    };

    this.updatePosition = function(shift)
    {
        var param =
        {
            id    : this.param.item.getData('id'),
            shift : shift
        };
        new Ajax.Request(ROOT_PATH + 'backoffice/remote/category_updatePosition',
        {
            parameters: $H(param).toQueryString()
        });
    };
};

