var List = function(param)
{
    this.param = param;
    this.data  = [];

    this.init = function()
    {
        new Ajax.Request(ROOT_PATH + this.param.script,
        {
            onSuccess: function(xhr)
            {
                this.data = xhr.responseJSON;
                this.showPage(this.param.page);
            }.bind(this)
        });
    };

    this.showPage = function(p)
    {
        var item = null;
        var list = $('list');
        var from = p * this.param.itemPerPage;
        var to = from + this.param.itemPerPage;
        to = (to > this.data.length) ? this.data.length : to;

        for (var i = from; i < to; i ++)
        {
            item = new Item(
            {
                id    : i,
                data  : this.data,
                model : this.param.model
            });
            item.init();
            list.insert(item.container);
        }
    };
};

