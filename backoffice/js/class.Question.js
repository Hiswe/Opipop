var Question = function(param)
{
    this.param = param;
    this.data  = {};
    this.loaded = false;
    this.container = null;

    this.init = function()
    {
        var feelings = [
            { value : '1', label : 'None (aucuns)' },
            { value : '2', label : 'Personality (personalit&eacute;)' },
            { value : '3', label : 'Surroundings (environnement)'},
            { value : '4', label : 'Knowledge (connaissance)' },
            { value : '5', label : 'Experience (exp&eacute;rience)' },
            { value : '6', label : 'Thoughts (pens&eacute;es)'}
        ];

        this.container = new Element('form',
        {
            methode : 'post',
            action  : 'javascript:null'
        });

        this.container.insert(Form.newInputText(
        {
            label     : 'Question',
            id        : 'question_label',
            name      : 'label',
            value     : this.data['label'],
            maxlength : 255
        }));

        this.container.insert(Form.newInputText(
        {
            label     : 'Did you know',
            id        : 'question_didyouknow',
            name      : 'didyouknow',
            value     : this.data['didyouknow'],
            maxlength : 255
        }));

        this.container.insert(Form.newInputText(
        {
            label     : '1st answer',
            id        : 'question_answer1',
            name      : 'answer[]',
            value     : this.data['answer1'],
            maxlength : 32
        }));

        this.container.insert(Form.newInputText(
        {
            label     : '2nd answer',
            id        : 'question_answer2',
            name      : 'answer[]',
            value     : this.data['answer2'],
            maxlength : 32
        }));

        this.container.insert(Form.newSelect(
        {
            label     : '1st answer\'s feeling',
            id        : 'question_feeling1',
            name      : 'feeling[]',
            value     : this.data['feeling1'],
            values    : feelings
        }));

        this.container.insert(Form.newSelect(
        {
            label     : '2st answer\'s feeling',
            id        : 'question_feeling2',
            name      : 'feeling[]',
            value     : this.data['feeling2'],
            values    : feelings
        }));

        this.container.insert(Form.newInputSubmit('save'));
        this.container.observe('submit', this.save.bind(this));
    };

    this.create = function(label, callback)
    {
        var param =
        {
            label       : label,
            category_id : this.param.categoryId
        };
        new Ajax.Request(ROOT_PATH + 'backoffice/remote/question_add',
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
            new Ajax.Request(ROOT_PATH + 'backoffice/remote/question_load',
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
        $('form').show();
    };

    this.save = function()
    {
        this.data['label']      = $('question_label').value;
        this.data['didyouknow'] = $('question_didyouknow').value;
        this.data['answer1']    = $('question_answer1').value;
        this.data['answer2']    = $('question_answer2').value;
        this.data['feeling1']   = $('question_feeling1').value;
        this.data['feeling2']   = $('question_feeling2').value;
        var param =
        {
            'id'         : this.data['id'],
            'label'      : this.data['label'],
            'didyouknow' : this.data['didyouknow'],
            'answer[0]'  : this.data['answer1'],
            'answer[1]'  : this.data['answer2'],
            'feeling[0]' : this.data['feeling1'],
            'feeling[1]' : this.data['feeling2']
        };

        new Ajax.Request(ROOT_PATH + 'backoffice/remote/question_save',
        {
            parameters: $H(param).toQueryString(),
            onSuccess: function(xhr)
            {
                this.param.item.updateLabel(this.data['label']);
            }.bind(this)
        });
    };

    this.toggleStatus = function(callback)
    {
        var param =
        {
            id : this.param.item.getData('id')
        };
        new Ajax.Request(ROOT_PATH + 'backoffice/remote/question_toggleStatus',
        {
            parameters: $H(param).toQueryString(),
            onSuccess: callback
        });
    };
};

