var Form =
{
    /*
    *   Generate a line to insert an input in
    *
    *   @message the label that appears on the line
    */
    newLine : function(message)
    {
        var label = new Element('label');
        label.update(message + ':');

        var line  = new Element('div');
        line.insert(label);
        return line;
    },

    /*
    *   Generate an option tag for select inputs
    *
    *   @label the label of the option
    *   @value the value of the option
    */
    newOption : function(label, value)
    {
        var option = new Element('option');
        option.update(label);
        option.writeAttribute('value', value);
        return option;
    },

    /*
    *   Generate a select input
    *
    *   @param.id the id of the input
    *   @param.name the name of the input
    *   @param.label the labl of the input
    *   @param.allowEmpty if true insert a empty option
    *   @param.values an array of option objects {label:..., value:...}
    */
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
        if (param.allowEmpty)
        {
            input.insert(Form.newOption('...', 0));
        }
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

    /*
    *   Generate a text input
    *
    *   @param.id the id of the input
    *   @param.name the name of the input
    *   @param.label the labl of the input
    *   @param.value the value of the input
    *   @param.maxlength the max number of char allowed
    */
    newInputText : function(param)
    {
        var input = new Element('input');
        if (param.id)
        {
            input.writeAttribute('id', param.id);
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
        input.writeAttribute('type', 'text');

        var line = Form.newLine(param.label);
        line.insert(input);
        return line;
    },

    /*
    *   Generate a submit input
    *
    *   @message the value of the input
    */
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

    /*
    *   Generate an upload space
    *
    *   @param.label the labl of the input
    *   @param.buttonId the id of the swf button container
    *   @param.progressId the id of the progress zone
    *   @param.previewImageId the id of the preview image tag
    *   @param.previewBoxId the id of the preview image container
    *   @param.imageLink the link to the image
    *   @param.src the src of the preview image
    */
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

