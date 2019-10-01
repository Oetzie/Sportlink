Sportlink.grid.TeamCompetition = function(config) {
    config = config || {};

    config.tbar = ['->', {
        xtype       : 'textfield',
        name        : 'sportlink-filter-team-competition-search',
        id          : 'sportlink-filter-team-competition-search',
        emptyText   : _('search') + '...',
        listeners   : {
            'change'    : {
                fn          : this.filterSearch,
                scope       : this
            },
            'render'    : {
                fn          : function(cmp) {
                    new Ext.KeyMap(cmp.getEl(), {
                        key     : Ext.EventObject.ENTER,
                        fn      : this.blur,
                        scope   : cmp
                    });
                },
                scope       : this
            }
        }
    }, {
        xtype       : 'button',
        cls         : 'x-form-filter-clear',
        id          : 'sportlink-filter-team-competition-clear',
        text        : _('filter_clear'),
        listeners   : {
            'click'     : {
                fn          : this.clearFilter,
                scope       : this
            }
        }
    }];
    
    var columns = new Ext.grid.ColumnModel({
        columns     : [{
            header      : _('sportlink.label_competition_rank'),
            dataIndex   : 'rank',
            sortable    : true,
            editable    : false,
            width       : 50,
            fixed       : true,
            renderer    : this.renderTeam
        }, {
            header      : _('sportlink.label_competition_name'),
            dataIndex   : 'name',
            sortable    : true,
            editable    : false,
            width       : 150,
            renderer    : this.renderTeamName
        }, {
            header      : _('sportlink.label_competition_matches'),
            dataIndex   : 'matches',
            sortable    : true,
            editable    : false,
            width       : 50,
            fixed       : true,
            renderer    : this.renderTeam
        }, {
            header      : _('sportlink.label_competition_wins'),
            dataIndex   : 'wins',
            sortable    : true,
            editable    : false,
            width       : 50,
            fixed       : true,
            renderer    : this.renderTeam
        }, {
            header      : _('sportlink.label_competition_draws'),
            dataIndex   : 'draws',
            sortable    : true,
            editable    : false,
            width       : 50,
            fixed       : true,
            renderer    : this.renderTeam
        }, {
            header      : _('sportlink.label_competition_loses'),
            dataIndex   : 'loses',
            sortable    : true,
            editable    : false,
            width       : 50,
            fixed       : true,
            renderer    : this.renderTeam
        }, {
            header      : _('sportlink.label_competition_goals_for'),
            dataIndex   : 'goals_for',
            sortable    : true,
            editable    : false,
            width       : 50,
            fixed       : true,
            renderer    : this.renderTeam
        }, {
            header      : _('sportlink.label_competition_goals_against'),
            dataIndex   : 'goals_against',
            sortable    : true,
            editable    : false,
            width       : 50,
            fixed       : true,
            renderer    : this.renderTeam
        }, {
            header      : _('sportlink.label_competition_goal_balance'),
            dataIndex   : 'goal_balance',
            sortable    : true,
            editable    : false,
            width       : 50,
            fixed       : true,
            renderer    : this.renderTeam
        }, {
            header      : _('sportlink.label_competition_points'),
            dataIndex   : 'points',
            sortable    : true,
            editable    : false,
            width       : 50,
            fixed       : true,
            renderer    : this.renderTeam
        }]
    });
    
    Ext.applyIf(config, {
        cm          : columns,
        id          : 'sportlink-grid-team-competition',
        url         : Sportlink.config.connector_url,
        baseParams  : {
            action      : 'mgr/competition/standing/getlist',
            poule_id    : MODx.request.poule_id || config.record.poule_id
        },
        fields      : ['id', 'poule_id', 'club_id', 'rank', 'name', 'logo', 'matches', 'wins', 'draws', 'loses', 'goals_for', 'goals_against', 'goal_balance', 'points_deducted', 'points'],
        paging      : true,
        pageSize    : MODx.config.default_per_page > 30 ? MODx.config.default_per_page : 30,
        sortBy      : 'rank'
    });
    
    Sportlink.grid.TeamCompetition.superclass.constructor.call(this, config);
};

Ext.extend(Sportlink.grid.TeamCompetition, MODx.grid.Grid, {
    filterSearch: function(tf, nv, ov) {
        this.getStore().baseParams.query = tf.getValue();
        
        this.getBottomToolbar().changePage(1);
    },
    clearFilter: function() {
        this.getStore().baseParams.query = '';

        Ext.getCmp('sportlink-filter-team-competition-search').reset();

        this.getBottomToolbar().changePage(1);
    },
    getMenu: function() {
        return [{
            text    : '<i class="x-menu-item-icon icon icon-edit"></i>' + _('sportlink.team_logo_update'),
            handler : this.updateTeamLogo,
            scope   : this
        }];
    },
    updateTeamLogo: function(btn, e) {
        if (this.updateTeamLogoWindow) {
            this.updateTeamLogoWindow.destroy();
        }

        this.updateTeamLogoWindow = MODx.load({
            xtype       : 'sportlink-window-team-logo-update',
            record      : this.menu.record,
            closeAction : 'close',
            listeners   : {
                'success'   : {
                    fn          : this.refresh,
                    scope       : this
                }
            }
        });

        this.updateTeamLogoWindow.setValues(this.menu.record);
        this.updateTeamLogoWindow.show(e.target);
    },
    renderTeam: function(d, c, e) {
        if (Sportlink.config.club === e.data.club_id) {
            return '<strong>' + d + '</strong>';
        }

        return d;
    },
    renderTeamName: function(d, c, e) {
        if (Ext.isEmpty(e.json.logo)) {
            var logo = '/assets/components/sportlink/img/mgr/no-team-logo.png';
        } else {
            var logo = e.json.logo;
        }

        if (Sportlink.config.club === e.json.club_id) {
            return '<img src="' + logo + '" class="club-logo" alt="' + d + '" /><strong>' + d + '</strong>';
        }

        return '<img src="' + logo + '" class="club-logo" alt="' + d + '" />' + d;
    }
});

Ext.reg('sportlink-grid-team-competition', Sportlink.grid.TeamCompetition);

Sportlink.window.UpdateTeamLogo = function(config) {
    config = config || {};
    
    Ext.applyIf(config, {
        width       : 400,
    	autoHeight  : true,
        title       : _('sportlink.team_logo_update'),
        url         : Sportlink.config.connector_url,
        baseParams  : {
            action      : 'mgr/competition/updatelogo'
        },
        fields      : [{
            xtype       : 'hidden',
            name        : 'club_id'
        }, {
            xtype       : 'modx-combo-browser',
            fieldLabel  : _('sportlink.label_team_logo'),
            description : MODx.expandHelp ? '' : _('sportlink.label_team_logo_desc'),
            name        : 'logo',
            anchor      : '100%',
            allowedFileTypes : 'jpg,jpeg,png,gif,svg'
        }, {
            xtype       : MODx.expandHelp ? 'label' : 'hidden',
            html        : _('sportlink.label_team_logo_desc'),
            cls         : 'desc-under'
        }]
    });
    
    Sportlink.window.UpdateTeamLogo.superclass.constructor.call(this, config);
};

Ext.extend(Sportlink.window.UpdateTeamLogo, MODx.Window);

Ext.reg('sportlink-window-team-logo-update', Sportlink.window.UpdateTeamLogo);