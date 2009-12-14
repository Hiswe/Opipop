var dragdrop =
{
    mouseX   : 0,
    mouseY   : 0,
    grabX    : 0,
    grabY    : 0,
    originX  : 0,
    originY  : 0,

    dragObject   : null,
    originObject : null,

    falsefunc : function()
    {
        return false;
    },

    // works on IE6,FF,Moz,Opera7
    getmouseXY : function(e)
    {
        // works on IE, but not NS (we rely on NS passing us the event)
        if (!e) e = window.event;

        if (e)
        {
            if (e.pageX || e.pageY)
            {
                // this doesn't work on IE6!! (works on FF,Moz,Opera7)
                dragdrop.mouseX = e.pageX;
                dragdrop.mouseY = e.pageY;
            }
            else if (e.clientX || e.clientY)
            {
                // works on IE6,FF,Moz,Opera7
                dragdrop.mouseX = e.clientX + document.body.scrollLeft;
                dragdrop.mouseY = e.clientY + document.body.scrollTop;
            }
        }
    },

    grab : function(e, context)
    {
        dragdrop.getmouseXY(e);

        dragdrop.dragObject = context.cloneNode(true);
        dragdrop.dragObject.style.position = "absolute";
        dragdrop.dragObject.style.zIndex = 10;

        dragdrop.originObject = context;
        dragdrop.originObject.style.visibility = "hidden";
        dragdrop.originObject.parentNode.insertBefore(dragdrop.dragObject, dragdrop.originObject);

        dragdrop.grabX = dragdrop.mouseX;
        dragdrop.grabY = dragdrop.mouseY;
        dragdrop.originX = dragdrop.originObject.offsetLeft;
        dragdrop.originY = dragdrop.originObject.offsetTop;

        document.onmousedown = dragdrop.falsefunc; // in NS this prevents cascading of events, thus disabling text selection
        document.onmousemove = dragdrop.drag;
        document.onmouseup = dragdrop.drop;
    },

    // parameter passing is important for NS family
    drag : function(e)
    {
        if (dragdrop.dragObject)
        {
            dragdrop.dragObject.style.left = (dragdrop.originX + (dragdrop.mouseX - dragdrop.grabX)).toString(10) + 'px';
            dragdrop.dragObject.style.top  = (dragdrop.originY + (dragdrop.mouseY - dragdrop.grabY)).toString(10) + 'px';
        }
        dragdrop.getmouseXY(e); // NS is passing (event), while IE is passing (null)
        return false;           // in IE this prevents cascading of events, thus text selection is disabled
    },

    drop : function()
    {
        if (dragdrop.dragObject)
        {
            dragdrop.originObject.parentNode.removeChild(dragdrop.dragObject);
            dragdrop.originObject.style.visibility = "visible";
        }
        document.onmouseup = null;
        document.onmousedown = null; // re-enables text selection on NS
    }
};

