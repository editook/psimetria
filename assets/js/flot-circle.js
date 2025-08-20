(function ($) {
    function roundedBorder(plot, options) {
        plot.hooks.draw.push(function (plot, ctx) {
            var opts = plot.getOptions();
            var br = opts.grid.borderRadius || 0;
            var bw = opts.grid.borderWidth || 1;
            var bc = opts.grid.borderColor || '#000';
            var margin = opts.grid.innerMargin || 0; // nuevo parámetro

            var offset = plot.getPlotOffset();
            var width = plot.width();
            var height = plot.height();

            // Reducir ancho y alto para dejar margen
            var left = offset.left + margin;
            var top = offset.top + margin;
            var right = offset.left + width - margin;
            var bottom = offset.top + height - margin;

            ctx.save();
            ctx.beginPath();
            ctx.moveTo(left + br, top);
            ctx.lineTo(right - br, top);
            ctx.quadraticCurveTo(right, top, right, top + br);
            ctx.lineTo(right, bottom - br);
            ctx.quadraticCurveTo(right, bottom, right - br, bottom);
            ctx.lineTo(left + br, bottom);
            ctx.quadraticCurveTo(left, bottom, left, bottom - br);
            ctx.lineTo(left, top + br);
            ctx.quadraticCurveTo(left, top, left + br, top);
            ctx.closePath();

            ctx.lineWidth = bw;
            ctx.strokeStyle = bc;
            ctx.stroke();
            ctx.restore();
        });
    }

    $.plot.plugins.push({
        init: roundedBorder,
        options: {
            grid: {
                borderRadius: 0,
                innerMargin: 0 // valor por defecto
            }
        },
        name: 'roundedBorder',
        version: '1.2'
    });
})(jQuery);
