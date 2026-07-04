/**
 * Avatice 3D Elementor Editor Controller
 */
(function($) {
    $(window).on('elementor/frontend/init', function() {

        elementorFrontend.hooks.addAction('frontend/element_ready/avatice_canvas.default', function($scope) {
            console.log("Avatice Canvas Ready in Editor");

            if (window.Avatice3DSceneInstance) {
                window.Avatice3DSceneInstance.dispose();
            }

            if (window.Avatice3DScene) {
                window.Avatice3DSceneInstance = new window.Avatice3DScene();
            }
        });

        if (window.elementor) {
            elementor.channels.editor.on('change', function(controlView, elementView) {
                const name = controlView.model.get('name');
                if (['fog_color', 'primary_light_color', 'secondary_light_color', 'scroll_speed'].includes(name)) {
                    if (window.Avatice3DSceneInstance) {
                        // Transfer settings to data attributes first if needed,
                        // or directly update config
                        setTimeout(() => {
                            window.Avatice3DSceneInstance.updateConfig();
                        }, 50);
                    }
                }
            });
        }
    });
})(jQuery);
