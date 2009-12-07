
    function unselect(element){
        element.innerHTML = element.innerHTML;
    }

    function strRemoveNotnum(str){
        return str.replace(/([^0-9])/g, '');
    }

    function XMLresult(xml, n, field){
    	var node;

    	if (node = xml.getElementsByTagName(field)[n].firstChild){
    		return node.nodeValue;
    	}
    }

    function XMLcount(xml){
    	return xml.documentElement.getElementsByTagName('item').length;
    }

    function checkEmail (str){
		var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;

		if (filter.test (str))
		{
			return true;
		}

		return false;
	}

	// Decimal to Hex
	function d2h (d) {return d.toString(16);}

	// Hex to Decimal
	function h2d (h) {return parseInt(h,16);}

