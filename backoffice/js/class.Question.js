var Question = function(param)
{
    this.param = param;
    this.data  = {};
    this.loaded = false;
    this.container = null;

    this.init = function()
    {
        this.container = new Element('form',
        {
            methode : 'post',
            action  : 'javascript:null'
        });

        this.container.insert(Form.newInputText('Question',
        {
            id        : 'question_label',
            type      : 'text',
            name      : 'label',
            value     : this.data['label'],
            maxlength : 255
        }));

        this.container.insert(Form.newInputSubmit('save'));
        this.container.observe('submit', this.save.bind(this));
    };

    this.create = function(label, callback)
    {
        var param =
        {
            label : label
        };
        new Ajax.Request(ROOT_PATH + 'backoffice/remote/question_add.php',
        {
            parameters: $H(param).toQueryString(),
            onSuccess: function(xhr)
            {
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
            var param =
            {
                id : this.param.item.getData('id')
            };
            new Ajax.Request(ROOT_PATH + 'backoffice/remote/question_load.php',
            {
                parameters: $H(param).toQueryString(),
                onSuccess: function(xhr)
                {
                    this.loaded = true;
                    this.data = xhr.responseJSON;
                    this.init();
                    this.show();
                }.bind(this)
            });
        }
    };

    this.show = function()
    {
        $('form').update(this.container);
    };

    this.save = function()
    {
        this.data['label'] = $('question_label').value;
        var param =
        {
            id    : this.data['id'],
            label : this.data['label']
        };

        new Ajax.Request(ROOT_PATH + 'backoffice/remote/question_save.php',
        {
            parameters: $H(param).toQueryString(),
            onSuccess: function(xhr)
            {
                this.param.item.updateLabel(this.data['label']);
            }.bind(this)
        });
    };
};

