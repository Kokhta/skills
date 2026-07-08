/**
 * Avatice 3D Elementor Editor Controller
 */
(function($) {
    $(window).on('elementor/frontend/init', function() {

        // Handle widget settings changes in the editor
        elementorFrontend.hooks.addAction('frontend/element_ready/avatice_canvas_core.default', function($scope) {
            console.log("Avatice Canvas Core Ready in Editor");

            // Clean up existing instance if it exists
            if (window.Avatice3DSceneInstance) {
                window.Avatice3DSceneInstance.dispose();
            }

            // Wait for DOM to settle and ensure THREE is loaded
            setTimeout(() => {
                if (window.Avatice3DScene) {
                    window.Avatice3DSceneInstance = new window.Avatice3DScene();
                    console.log("Avatice 3D Scene re-initialized in Editor");
                }
            }, 100);
        });

        // Force re-init on any section update if scene is lost
        elementorFrontend.hooks.addAction('frontend/element_ready/widget', function($scope) {
            if (!window.Avatice3DSceneInstance && $('.avatice-3d-layout-wrapper').length) {
                 if (window.Avatice3DScene) {
                    window.Avatice3DSceneInstance = new window.Avatice3DScene();
                 }
            }
        });

        // Listen for control changes in the editor sidebar
        if (window.elementor) {
            elementor.channels.editor.on('change', function(controlView, elementView) {
                const name = controlView.model.get('name');
                const widgetType = elementView.model.get('widgetType');

                if (widgetType === 'avatice_canvas_core' &&
                    ['fog_color', 'primary_light_color', 'secondary_light_color', 'scroll_speed', 'icon_count', 'camera_fov'].includes(name)) {

                    if (window.Avatice3DSceneInstance) {
                        // Debounce update
                        clearTimeout(window.avaticeUpdateTimer);
                        window.avaticeUpdateTimer = setTimeout(() => {
                            window.Avatice3DSceneInstance.updateConfig();
                        }, 50);
                    }
                }
            });
        }
    });
})(jQuery);
