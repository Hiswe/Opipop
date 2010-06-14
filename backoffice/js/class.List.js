var List = function(param)
{
    this.param           = param;
    this.data            = null;
    this.itemList        = [];
    this.listContainer   = null;
    this.buttonContainer = null;

    this.init = function()
    {
        if (this.data === null)
        {
            new Ajax.Request(ROOT_PATH + this.param.script,
            {
                parameters: $H(this.param.parameters).toQueryString(),
                onSuccess: function(xhr)
                {
                    this.data = xhr.responseJSON;
                    this.listContainer = new Element('ul').addClassName('items');
                    this.initTools();
                    this.show();
                }.bind(this)
            });
        }
        else
        {
            this.show();
        }
    };

    this.show = function()
    {
        $(this.param.container).update();
        $(this.param.container).insert(this.buttonContainer);
        $(this.param.container).insert(this.listContainer);

        this.showPage(this.param.page);

        if (this.param.autoLoad && this.itemList.length != 0)
        {
            this.itemList[0].clickCallback();
        }
    };

    this.initTools = function()
    {
        if (this.param.addItem)
        {
            var addButton = new Element('li');
            addButton.update('Add item');
            addButton.observe('click', this.addItem.bind(this));
        }

        var nextButton = new Element('li');
        nextButton.update('&#62;&#62;');
        nextButton.observe('click', this.nextPage.bind(this));

        var previousButton = new Element('li');
        previousButton.update('&#60;&#60;');
        previousButton.observe('click', this.previousPage.bind(this));

        var currentPage = new Element('li');
        currentPage.addClassName('list_currentPage');

        this.buttonContainer = new Element('ul').addClassName('buttons');
        this.buttonContainer.insert(previousButton);
        this.buttonContainer.insert(currentPage);
        this.buttonContainer.insert(nextButton);
        this.buttonContainer.insert(addButton);
    };

    this.getItem = function(i)
    {
        if (!this.itemList[i])
        {
            item = new Item(
            {
                list  : this,
                data  : new Object(this.data[i]),
                model : this.param.model
            });
            item.init();
            this.itemList[i] = item;
        }
        return this.itemList[i];
    };

    this.showPage = function(p)
    {
        this.listContainer.update();
        this.param.page = (typeof p != 'undefined') ? p : this.param.page;

        var item = null;
        var from = this.param.page * this.param.itemPerPage;
        var to = from + this.param.itemPerPage;
        to = (to > this.data.length) ? this.data.length : to;

        for (var i = from; i < to; i ++)
        {
            this.listContainer.insert(this.getItem(i).container);
        }

        $(this.param.container).down('.list_currentPage').update((this.param.page + 1) + ' / ' + this.getTotalPages());
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
        if (this.param.page + 1 < this.getTotalPages())
        {
            this.showPage(this.param.page + 1);
        }
    };

    this.getTotalPages = function()
    {
        return Math.ceil(this.data.length / this.param.itemPerPage);
    };

    this.addItem = function()
    {
        var label = prompt('New item\'s label:');
        if (!label || label.blank())
        {
            return;
        }

        var model = new this.param.model(this.param.parameters).create(label, function(data)
        {
            this.itemList.unshift(false);
            this.data.unshift(data);
            this.showPage(this.param.page);
        }.bind(this));
    };

    this.focusItem = function(item)
    {
        $A(this.itemList).each(function(i)
        {
            if (i == item)
            {
                i.container.addClassName('on');
            }
            else
            {
                i.container.removeClassName('on');
            }
        });
    };

    this.moveItem = function(item, shift, callback)
    {
        for (var i = 0; i < this.data.length; i ++)
        {
            if (this.getItem(i) == item)
            {
                if ((shift > 0 || i - shift > 1) && (shift < 0 || i + shift < this.data.length))
                {
                    var itemBis = this.getItem(i + shift);
                    this.itemList[i + shift] = this.getItem(i);
                    this.itemList[i] = itemBis;
                    var dataBis = this.data[i + shift];
                    this.data[i + shift] = this.data[i];
                    this.data[i] = dataBis;
                    this.showPage();
                    callback();
                }
                break;
            }
        }
    };
};

