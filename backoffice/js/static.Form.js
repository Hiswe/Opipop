var Form =
{
	newLine : function(message)
	{
        var label = new Element('label');
        label.update(message + ':');

        var line  = new Element('div');
        line.insert(label);
        return line;
	},

    newSelect : function(param)
    {
        var input = new Element('select');
		if (param.id)
		{
			input.writeAttribute('id', param.id);
		}
		if (param.name)
		{
			input.writeAttribute('name', param.name);
		}

		$A(param.values).each(function(item)
		{
			option = new Element('option');
			option.update(item.label);
			option.writeAttribute('value', item.value);
			if (item.value == param.value)
			{
				option.writeAttribute('selected', 'selected');
			}
			input.insert(option);
		});

		var line = Form.newLine(param.label);
        line.insert(input);
        return line;
    },

    newInputText : function(param)
    {
        var input = new Element('input');
		if (param.id)
		{
			input.writeAttribute('id', param.id);
		}
		if (param.type)
		{
			input.writeAttribute('type', param.type);
		}
		if (param.name)
		{
			input.writeAttribute('name', param.name);
		}
		if (param.value)
		{
			input.writeAttribute('value', param.value);
		}
		if (param.maxlength)
		{
			input.writeAttribute('maxlength', param.maxlength);
		}

		var line = Form.newLine(param.label);
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

