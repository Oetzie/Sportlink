Ext.onReady(function() {
    MODx.load({
        xtype : 'sportlink-page-team'
    });
});

Sportlink.page.Team = function(config) {
    config = config || {};

    config.buttons = [];

    if (Sportlink.config.branding_url) {
        config.buttons.push({
            text        : 'Sportlink ' + Sportlink.config.version,
            cls         : 'x-btn-branding',
            handler     : this.loadBranding
        });
    }

    config.buttons.push({
        text        : '<i class="icon icon-arrow-left"></i>' + _('sportlink.back_to_teams'),
        handler     : this.toTeamsView,
        scope       : this
    }, {
        xtype       : 'sportlink-combo-competition',
        value       : MODx.request.poule_id || Sportlink.config.record.poule_id,
        name        : 'sportlink-filter-team-competition',
        id          : 'sportlink-filter-team-competition',
        emptyText   : _('sportlink.filter_competition'),
        listeners   : {
            'select'    : {
                fn          : this.filterCompetition,
                scope       : this
            }
        },
        team_id     : Sportlink.config.record.team_id
    });

    if (Sportlink.config.branding_url_help) {
        config.buttons.push({
            text        : _('help_ex'),
            handler     : MODx.loadHelpPane,
            scope       : this
        });
    }

    Ext.applyIf(config, {
        components  : [{
            xtype       : 'sportlink-panel-team',
            record      : Sportlink.config.record
        }]
    });

    Sportlink.page.Team.superclass.constructor.call(this, config);
};

Ext.extend(Sportlink.page.Team, MODx.Component, {
    loadBranding: function() {
        window.open(Sportlink.config.branding_url);
    },
    toTeamsView: function() {
        MODx.loadPage('home', 'namespace=' + MODx.request.namespace);
    },
    filterCompetition: function(tf) {
        MODx.loadPage('team/team', 'namespace=' + MODx.request.namespace + '&id=' + MODx.request.id + '&poule_id=' + tf.getValue());
    }
});

Ext.reg('sportlink-page-team', Sportlink.page.Team);