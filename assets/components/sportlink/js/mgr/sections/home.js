Ext.onReady(function() {
    MODx.load({
        xtype : 'sportlink-page-home'
    });
});

Sportlink.page.Home = function(config) {
    config = config || {};

    config.buttons = [];

    if (Sportlink.config.branding_url) {
        config.buttons.push({
            text        : 'Sportlink ' + Sportlink.config.version,
            cls         : 'x-btn-branding',
            handler     : this.loadBranding
        });
    }

    if (Sportlink.config.branding_url_help) {
        config.buttons.push({
            text        : _('help_ex'),
            handler     : MODx.loadHelpPane,
            scope       : this
        });
    }

    Ext.applyIf(config, {
        components  : [{
            xtype       : 'sportlink-panel-home',
            renderTo    : 'sportlink-panel-home-div'
        }]
    });

    Sportlink.page.Home.superclass.constructor.call(this, config);
};

Ext.extend(Sportlink.page.Home, MODx.Component, {
    loadBranding: function(btn) {
        window.open(Sportlink.config.branding_url);
    }
});

Ext.reg('sportlink-page-home', Sportlink.page.Home);