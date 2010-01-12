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

    newOption : function(label, value)
    {
        var option = new Element('option');
        option.update(label);
        option.writeAttribute('value', value);
        return option;
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

        var option = null;
        input.insert(Form.newOption('...', 0));
        $A(param.values).each(function(item)
        {
            option = Form.newOption(item.label, item.value);
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
    },

    newUpload : function(param)
    {
        var previewImage = new Element('img',
        {
            src : param.src,
            id  : param.previewImageId
        });

        if (param.imageLink)
        {
            previewImage.setStyle(
            {
                cursor : 'pointer'
            });
            previewImage.observe('click', function()
            {
                window.open(param.imageLink);
            });
        }

        var previewBox = new Element('div',
        {
            id : param.previewBoxId
        });
        previewBox.insert(previewImage);

        var button = new Element('span').writeAttribute('id', param.buttonId);
        var progress = new Element('span').writeAttribute('id', param.progressId);

        var line = Form.newLine(param.label);
        line.insert(progress);
        line.insert(previewBox);
        line.insert(button);
        return line;
    }
};

