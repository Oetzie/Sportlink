Sportlink.panel.Home = function(config) {
    config = config || {};

    Ext.apply(config, {
        id          : 'sportlink-panel-home',
        cls         : 'container',
        items       : [{
            html        : '<h2>' + _('sportlink') + '</h2>',
            cls         : 'modx-page-header'
        }, {
            xtype       : 'modx-tabs',
            items       : [{
                layout      : 'form',
                title       : _('sportlink.teams'),
                items       : [{
                    html         : '<p>' + _('sportlink.teams_desc') + '</p>',
                    bodyCssClass  : 'panel-desc'
                }, {
                    html         : '<p>' + _('sportlink.sportlink_cronjob_notice_desc') + '</p>',
                    cls          : 'modx-config-error panel-desc',
                    hidden       : Sportlink.config.cronjob
                }, {
                    xtype       : 'sportlink-grid-teams',
                    cls         : 'main-wrapper',
                    preventRender : true
                }]
            }, {
                layout      : 'form',
                title       : _('sportlink.matches'),
                items       : [{
                    html        : '<p>' + _('sportlink.matches_desc') + '</p>',
                    bodyCssClass : 'panel-desc'
                }, {
                    html         : '<p>' + _('sportlink.sportlink_cronjob_notice_desc') + '</p>',
                    cls          : 'modx-config-error panel-desc',
                    hidden       : Sportlink.config.cronjob
                }, {
                    xtype       : 'sportlink-grid-matches',
                    cls         : 'main-wrapper',
                    preventRender : true
                }]
            }, {
                layout      : 'form',
                title       : _('sportlink.results'),
                items       : [{
                    html        : '<p>' + _('sportlink.results_desc') + '</p>',
                    bodyCssClass : 'panel-desc'
                }, {
                    html         : '<p>' + _('sportlink.sportlink_cronjob_notice_desc') + '</p>',
                    cls          : 'modx-config-error panel-desc',
                    hidden       : Sportlink.config.cronjob
                }, {
                    xtype       : 'sportlink-grid-results',
                    cls         : 'main-wrapper',
                    preventRender : true
                }]
            }]
        }]
    });

    Sportlink.panel.Home.superclass.constructor.call(this, config);
};

Ext.extend(Sportlink.panel.Home, MODx.FormPanel);

Ext.reg('sportlink-panel-home', Sportlink.panel.Home);