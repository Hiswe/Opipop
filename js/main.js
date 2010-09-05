// ON READY
function onReady()
{
    Question.initList();
    Question.initArchiveList();
    User.initFriends();
    User.initSearch();

    // NYROMODAL
    $.fn.nyroModal.settings.debug        = false;
    $.fn.nyroModal.settings.bgColor      = '#ffffff';
    $.fn.nyroModal.settings.minHeight    = 50;
    $.fn.nyroModal.settings.minWidth     = 50;
    $.fn.nyroModal.settings.windowResize = false;
    $.fn.nyroModal.settings.resizable    = false;
    $.fn.nyroModal.settings.closeButton  = '<a href="#" class="nyroModalClose"></a>';
    $.fn.nyroModal.settings.hideContent  = function(elts, settings, callback)
    {
        callback();
    };
}
$(document).ready(onReady);

