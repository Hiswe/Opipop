var Item = function(param)
{
    this.param = param;
    this.model = null;
    this.container = null;

    this.init = function()
    {
        this.model = new this.param.model(
        {
            item : this
        });
        this.container = new Element('li');
        this.container.update(this.getData('label'));
        this.container.observe('click', this.clickCallback.bind(this));
    };

    this.getData = function(field)
    {
        return this.param.data[this.param.id][field];
    };

    this.setData = function(field, value)
    {
        this.param.data[this.param.id][field] = value;
    };

    this.clickCallback = function()
    {
        this.model.toggle();
    };

    this.updateLabel = function(message)
    {
        this.setData('label', message);
        this.container.update(message);
    };
};

