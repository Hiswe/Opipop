var Form =
{
    newInputText : function(message, attribute)
    {
        var line  = new Element('div');
        var label = new Element('label');
        var input = new Element('input', attribute);

        label.update(message + ':');
        line.insert(label);
        line.insert(input);
        return line;
    },

    newInputSubmit : function(message)
    {
        var line  = new Element('div');
        var input = new Element('input',
        {
            type  : 'submit',
            name  : 'submit',
            value : message
        });

        line.insert(input);
        return line;
    }
};

