define(['Evozon_Secondary/js/lib/create-background-canvas', 'Evozon_Secondary/js/lib/pixel-image-canvas'], function (createBackgroundCanvas, pixelImageOnCanvas) {
    'use strict';

    return function (config, targetElement) {
        const src = config.src || '';
        const pixelSize = Math.max(config.pixelSize || 5, 1);
        const canvas = createBackgroundCanvas(targetElement);
        canvas.style.opacity = config.opacity || .5;

        const cols = Math.floor(canvas.scrollWidth / pixelSize);
        const rows = Math.floor(canvas.scrollHeight / pixelSize);

        pixelImageOnCanvas(canvas, src, cols, rows);

        return canvas;
    }
});
