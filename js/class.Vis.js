var Vis =
{

	animate : function(vis, duration, ease)
	{
		var t = 0;
		var clock = setInterval(function()
		{
			t += 1 / (duration / 33);
			vis.s = Transition[ease](0, t, 0, -1, 1);
			vis.render();
			if (t > 1)
			{
				clearInterval(clock);
			}
		}, 33);
	},

	simplePie : function(target, width, height, data)
	{
		new pv.Panel()
			.canvas(target)
			.width(width)
			.height(height)
		.add(pv.Wedge)
			.data(pv.normalize(data))
			.left(width / 2)
			.bottom(height / 2)
			.innerRadius(width / 8)
			.outerRadius(width / 2)
			.angle(function(d){ return d * 2 * Math.PI; })
			.lineWidth(width / 40)
			.strokeStyle('white')
			.fillStyle(vis_colorList())
		.root.render();
	}

};

