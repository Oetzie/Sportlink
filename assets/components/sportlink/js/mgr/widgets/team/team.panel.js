Sportlink.panel.Team = function(config) {
    config = config || {};

    Ext.apply(config, {
        id          : 'sportlink-panel-home',
        cls         : 'container',
        items       : [{
            html        : '<h2>' + _('sportlink') + ': ' + config.record.name + '</h2>',
            cls         : 'modx-page-header'
        }, {
            xtype       : 'modx-tabs',
            items       : [{
                layout      : 'form',
                title       : _('sportlink.competition'),
                items       : [{
                    html        : '<p>' + _('sportlink.competitions_desc') + '</p>',
                    bodyCssClass : 'panel-desc'
                }, {
                    xtype       : 'sportlink-grid-team-competition',
                    cls         : 'main-wrapper',
                    preventRender : true,
                    record      : config.record
                }]
            }, {
                layout      : 'form',
                title       : _('sportlink.matches'),
                items       : [{
                    html        : '<p>' + _('sportlink.matches_desc') + '</p>',
                    bodyCssClass : 'panel-desc'
                }, {
                    xtype       : 'sportlink-grid-team-matches',
                    cls         : 'main-wrapper',
                    preventRender : true,
                    record      : config.record
                }]
            }, {
                layout      : 'form',
                title       : _('sportlink.results'),
                items       : [{
                    html        : '<p>' + _('sportlink.results_desc') + '</p>',
                    bodyCssClass : 'panel-desc'
                }, {
                    xtype       : 'sportlink-grid-team-results',
                    cls         : 'main-wrapper',
                    preventRender : true,
                    record      : config.record
                }]
            }]
        }]
    });

    Sportlink.panel.Team.superclass.constructor.call(this, config);
};

Ext.extend(Sportlink.panel.Team, MODx.FormPanel);

Ext.reg('sportlink-panel-team', Sportlink.panel.Team);