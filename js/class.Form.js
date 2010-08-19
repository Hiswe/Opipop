var Form =
{

    emailFilter : /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i,

    disable : function(form)
    {
        form.find('input[type=submit]').attr('disabled', 'disabled');
    },

    enable : function(form)
    {
        form.find('input[type=submit]').attr('disabled', '');
    },

    setError : function(input, message)
    {
        var form = input.parents('form');

        if (!form.hasClass('error'))
        {
            form.addClass('error');
            Form.disable(form);
        }
        if (input.hasClass('error'))
        {
            Form.cleanError(input);
        }
        var warning = $('<span/>',
        {
            'text' : message
        });
        form.data('error', (form.data('error')) ? form.data('error') + 1 : 1);
        input.data('warning', warning);
        input.addClass('error');
        input.parent('label').append(warning);
    },

    cleanError : function(input)
    {
        var form = input.parents('form');

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
    },

    getCleanInputValue : function(input)
    {
        Form.cleanInput(input);
        return input.val();
    },

    clean : function(input)
    {
        input.val('');
    }

};

