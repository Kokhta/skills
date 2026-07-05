(function($) {
    "use strict";

    $(window).on('elementor:init', function() {

        const OlympusEditor = {
            init: function() {
                // The event 'olympus:import:default' is triggered on the editor channel
                // but the arguments passed depend on how the button is clicked.
                // Elementor passes 'view' of the control that triggered the event.
                elementor.channels.editor.on('olympus:import:default', this.handleImport.bind(this));
            },

            handleImport: function(view) {
                if (!view || !view.model) return;

                const eventData = view.model.get('event_data');
                if (!eventData || !eventData.type) return;

                // The container we want to add widgets to is the parent container of the button's widget
                const container = view.container;

                if (!container) return;

                if (eventData.type === 'hero') {
                    this.importHero(container);
                } else if (eventData.type === 'intro') {
                    this.importIntro(container);
                }
            },

            importHero: function(container) {
                const widgets = [
                    { widgetType: 'video', settings: { video_type: 'hosted', autoplay: 'yes', loop: 'yes', mute: 'yes', controls: '', show_image_overlay: '', _class: 'hero-video' } },
                    { widgetType: 'html', settings: { html: '<div class="hero-overlay"></div>' } },
                    { widgetType: 'html', settings: { html: '<div class="hero-grain"></div>' } },
                    { widgetType: 'html', settings: { html: '<div class="hero-rule"></div>' } },
                    { widgetType: 'html', settings: { html: '<div class="corner tl"></div><div class="corner tr"></div><div class="corner bl"></div><div class="corner br"></div>' } },
                    { widgetType: 'heading', settings: { title: 'Ἐν ἀρχῇ ἦν τὸ Χάος', header_size: 'div', _class: 'hero-eyebrow' } },
                    { widgetType: 'html', settings: { html: '<div class="hero-gem"><div class="hero-gem-line"></div><div class="hero-gem-dot">✦</div><div class="hero-gem-line"></div></div>' } },
                    { widgetType: 'heading', settings: { title: 'OLYMPUS <span class="hero-title-greek">ΟΛΥΜΠΟΣ</span>', header_size: 'h1', _class: 'hero-title' } },
                    { widgetType: 'text-editor', settings: { content: 'Where thunder meets the stars, and mortals kneel<br>before the eternal throne of the divine', _class: 'hero-sub' } },
                    { widgetType: 'heading', settings: { title: 'Ζεύς · Ποσειδῶν · Ἅιδης · Ἀθηνᾶ · Ἀπόλλων · Ἄρης', header_size: 'div', _class: 'hero-gods' } },
                    { widgetType: 'html', settings: { html: '<div class="scroll-cue"><span>Scroll</span><div class="scroll-cue-line"></div></div>' } }
                ];

                this.addWidgets(container, widgets);
            },

            importIntro: function(container) {
                const widgets = [
                    { widgetType: 'text-editor', settings: { content: 'The Ancient World', _class: 'sec-label reveal' } },
                    { widgetType: 'html', settings: { html: '<div class="g-rule reveal"><div class="g-rule-line"></div><div class="g-rule-sym">⚡</div><div class="g-rule-line rev"></div></div>' } },
                    { widgetType: 'text-editor', settings: { content: '"From Chaos came the Earth, and from the Earth came all things divine — the <em>twelve immortals</em> who shaped the fate of gods and men alike from their thrones upon Mount Olympus."', _class: 'intro-quote reveal' } },
                    { widgetType: 'html', settings: { html: '<div class="g-rule reveal"><div class="g-rule-line"></div><div class="g-rule-sym">✦</div><div class="g-rule-line rev"></div></div>' } },
                    { widgetType: 'text-editor', settings: { content: '— Hesiod · Theogony · 700 BCE', _class: 'intro-source reveal' } }
                ];

                this.addWidgets(container, widgets);
            },

            addWidgets: async function(container, widgets) {
                // We add widgets sequentially to maintain order
                for (const config of widgets) {
                    try {
                        await $e.run('document/elements/create', {
                            container: container,
                            model: config,
                            options: {
                                at: container.children.length
                            }
                        });
                    } catch (e) {
                        console.error('Olympus Editor: Failed to create widget', config, e);
                    }
                }
            }
        };

        OlympusEditor.init();
    });

})(jQuery);
