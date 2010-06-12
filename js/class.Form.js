var Form =
{

    disable : function(form)
    {
        form.children('input[type=submit]').attr('disabled', 'disabled');
    },

    enable : function(form)
    {
        form.children('input[type=submit]').attr('disabled', '');
    },

    setError : function(input, message)
    {
        var form = input.parent('form');

        if (!form.hasClass('error'))
        {
            form.addClass('error');
            Form.disable(form);
        }
        if (!input.hasClass('error'))
        {
            var warning = $('<span/>',
            {
                'text' : message
            });
            form.data('error', (form.data('error')) ? form.data('error') + 1 : 1);
            input.data('warning', warning);
            input.addClass('error');
            input.parentsUntil('div').append(warning);
        }
    },

    cleanError : function(input)
    {
        var form = input.parent('form');

        if (input.hasClass('error'))
        {
            form.data('error', (form.data('error')) ? form.data('error') - 1 : 0);
            input.removeClass('error');
            input.data('warning').remove();
        }
        if (form.data('error') == 0 && form.hasClass('error'))
        {
            form.removeClass('error');
            Form.enable(form);
        }
        if (form.data('error') && !form.hasClass('error'))
        {
            form.addClass('error');
        }
    },

    cleanInput : function(input)
    {
        input.val(input.val().replace(/<\w+(\s+("[^"]*"|'[^']*'|[^>])+)?>|<\/\w+>/gi, ''));
        input.val(input.val().replace(new RegExp('<script[^>]*>([\\S\\s]*?)<\/script>', 'img'), ''));
        input.val(input.val().replace(/^\s+/, '').replace(/\s+$/, ''));
    }

};

