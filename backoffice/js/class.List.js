var List = function(param)
{
    this.param           = param;
    this.data            = null;
    this.itemList        = null;
    this.listContainer   = null;
    this.buttonContainer = null;

    this.init = function()
    {
        if (this.data === null)
        {
            new Ajax.Request(ROOT_PATH + this.param.script,
            {
                onSuccess: function(xhr)
                {
                    var addButton = new Element('li');
                    addButton.update('Add item');
                    addButton.observe('click', this.addItem.bind(this));

                    var nextButton = new Element('li');
                    nextButton.update('&#62;&#62;');
                    nextButton.observe('click', this.nextPage.bind(this));

                    var previousButton = new Element('li');
                    previousButton.update('&#60;&#60;');
                    previousButton.observe('click', this.previousPage.bind(this));

                    this.data = xhr.responseJSON;
                    this.listContainer = new Element('ul').addClassName('items');
                    this.buttonContainer = new Element('ul').addClassName('buttons');
                    this.buttonContainer.insert(previousButton);
                    this.buttonContainer.insert(nextButton);
                    this.buttonContainer.insert(addButton);
                    this.initCallback();
                }.bind(this)
            });
        }
        else
        {
            this.initCallback();
        }
    };

    this.initCallback = function()
    {
        $('list').update();
        $('list').insert(this.buttonContainer);
        $('list').insert(this.listContainer);

        this.showPage(this.param.page);
    };

    this.initTools = function()
    {
    };

    this.showPage = function(p)
    {
        this.itemList = [];
        this.listContainer.update();
        this.param.page = p;

        var item = null;
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
            this.itemList.push(item);
            this.listContainer.insert(item.container);
        }
    };

    this.previousPage = function()
    {
        if (this.param.page > 0)
        {
            this.showPage(this.param.page - 1);
        }
    };

    this.nextPage = function()
    {
        if (this.param.page + 1 < Math.ceil(this.data.length / this.param.itemPerPage))
        {
            this.showPage(this.param.page + 1);
        }
    };

    this.addItem = function()
    {
        var label = prompt('New item\'s label:');
        if (label.blank())
        {
            alert('Invalid label !');
            return;
        }

        var model = new this.param.model().create(label, function(data)
        {
            this.data.unshift(data);
            this.showPage(this.param.page);
        }.bind(this));
    };
};

