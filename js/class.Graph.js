var Graph =
{

    gender : function(containerId, gender, data)
    {
        var size  = 28 * 5;
        var paper = Raphael(document.getElementById(containerId), size * 2, size * 2);
        var item  = [];
        var d     = 0;
        var types =
        [
            'black_bald',
            'black_black',
            'olive_bald',
            'olive_black',
            'white_bald',
            'white_black',
            'white_blonde',
            'white_brown',
            'white_ginger',
            'white_grey'
        ];
        var answer1 = data[0];
        var answer2 = data[1];

        if (answer1.value == 1)
        {
            paper.circle(size, size, size - 12).attr(
            {
                'fill'    : answer1.color,
                'stroke'  : '#ffffff',
                'opacity' : '0.10'
            });
        }
        else if (answer2.value == 1)
        {
            paper.circle(size, size, size - 12).attr(
            {
                'fill'    : answer2.color,
                'stroke'  : '#ffffff',
                'opacity' : '0.10'
            });
        }
        else
        {
            Graph.sector(paper, size, size, size - 12, 90 - (360 * answer1.value), 90,
            {
                'fill'         : answer1.color,
                'stroke'       : '#ffffff',
                'stroke-width' : '8',
                'opacity'      : '0.10'
            });
            Graph.sector(paper, size, size, size - 12, 90, (360 * answer2.value) + 90,
            {
                'fill'         : answer2.color,
                'stroke'       : '#ffffff',
                'stroke-width' : '8',
                'opacity'      : '0.10'
            });
        }

        paper.circle(size, size, 56).attr(
        {
            'fill'    : '#ffffff',
            'stroke'  : '#ffffff'
        });

        for (var x = 0; x < size * 2; x += 28)
        {
            for (var y = 0; y < size * 2; y += 28)
            {
                d = Math.sqrt(Math.pow(x-size,2) + Math.pow(y-size,2));
                if (d < size && d > 56)
                {
                    if ((Graph.angle(x-size, y-size) + 90)%360 < (360 * answer1.value))
                    {
                        item.push(paper.image('media/layout/user/24x24/' + gender + '/blue/' + types[Math.floor(Math.random() * types.length)] + '.png', x - 12, y - 12, 24, 24));
                    }
                    else
                    {
                        item.push(paper.image('media/layout/user/24x24/' + gender + '/pink/' + types[Math.floor(Math.random() * types.length)] + '.png', x - 12, y - 12, 24, 24));
                    }
                }
            }
        }
    },

    sector : function(paper, cx, cy, r, startAngle, endAngle, params)
    {
        var rad = Math.PI / 180;
        var x1  = cx + r * Math.cos(-startAngle * rad),
            x2  = cx + r * Math.cos(-endAngle * rad),
            y1  = cy + r * Math.sin(-startAngle * rad),
            y2  = cy + r * Math.sin(-endAngle * rad);
        return paper.path(["M", cx, cy, "L", x1, y1, "A", r, r, 0, +(endAngle - startAngle > 180), 0, x2, y2, "z"]).attr(params);
    },

    magnitude : function(x, y)
    {
        return Math.sqrt(Math.pow(x,2) + Math.pow(y,2));
    },

    angle : function(x, y)
    {
        var mag = Graph.magnitude(x, y);
        x /= mag;
        y /= mag;
        if (y < 0)
        {
            return Math.acos(x * -1) * (180 / Math.PI) + 180;
        }
        else
        {
            return Math.acos(x) * (180 / Math.PI);
        }
    }

};

