var Item = function(param)
{
    this.param           = param;
    this.model           = null;
    this.container       = null;
    this.container       = null;
    this.labelContainer  = null;
    this.statusContainer = null;
    this.editContainer   = null;
    this.upContainer     = null;
    this.downContainer   = null;

    this.init = function()
    {
        this.model = new this.param.model(
        {
            item : this
        });

        this.container = new Element('li');
        this.container.observe('click', this.clickCallback.bind(this));

        if (this.param.list.param.editStatus)
        {
            this.statusContainer = new Element('span');
            this.statusContainer.addClassName('status');
            this.statusContainer.addClassName((this.getData('status') == 1) ? 'on' : '');
            this.statusContainer.observe('click', this.toggleStatus.bind(this));
            this.container.insert(this.statusContainer);
        }

        if (this.param.list.param.editLabel)
        {
            this.editContainer = new Element('span');
            this.editContainer.addClassName('edit');
            this.editContainer.observe('click', this.editLabel.bind(this));
            this.container.insert(this.editContainer);
        }

        if (this.param.list.param.editPosition)
        {
            this.upContainer = new Element('span');
            this.upContainer.addClassName('up');
            this.upContainer.observe('click', this.positionUp.bind(this));
            this.container.insert(this.upContainer);

            this.downContainer = new Element('span');
            this.downContainer.addClassName('down');
            this.downContainer.observe('click', this.positionDown.bind(this));
            this.container.insert(this.downContainer);
        }

        this.labelContainer = new Element('span');
        this.labelContainer.insert(this.getData('label'));
        this.container.insert(this.labelContainer);

    };

    this.getData = function(field)
    {
        return this.param.data[field];
    };

    this.setData = function(field, value)
    {
        this.param.data[field] = value;
    };

    this.clickCallback = function()
    {
        if (Job.working())
            return;

        this.param.list.focusItem(this);
        this.model.toggle();
    };

    this.updateLabel = function(message)
    {
        this.setData('label', message);
        this.labelContainer.update(message);
    };

    this.toggleStatus = function(e)
    {
        e.stop();

        this.model.toggleStatus(function()
        {
            this.statusContainer.toggleClassName('on');
        }.bind(this));
    };

    this.editLabel = function(e)
    {
        e.stop();

        var label = prompt('Item\'s label:', this.getData('label'));
        if (!label || label.blank())
        {
            return;
        }

        this.model.updateLabel(label);
        this.updateLabel(label);
    };

    this.positionUp = function(e)
    {
        e.stop();

        this.param.list.moveItem(this, -1, function()
        {
            this.model.updatePosition(-1);
        }.bind(this));
    };

    this.positionDown = function(e)
    {
        e.stop();

        this.param.list.moveItem(this, 1, function()
        {
            this.model.updatePosition(1);
        }.bind(this));
    };
};

