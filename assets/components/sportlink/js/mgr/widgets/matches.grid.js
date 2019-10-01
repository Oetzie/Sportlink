Sportlink.grid.Matches = function(config) {
    config = config || {};

    config.tbar = ['->', {
        xtype       : 'sportlink-combo-week',
        offset      : '+',
        name        : 'sportlink-filter-matches-week',
        id          : 'sportlink-filter-matches-week',
        emptyText   : _('sportlink.filter_week'),
        listeners   : {
            'select'    : {
                fn          : this.filterWeek,
                scope       : this
            }
        }
    }, {
        xtype       : 'sportlink-combo-competition-type',
        name        : 'sportlink-filter-matches-competition',
        id          : 'sportlink-filter-matches-competition',
        emptyText   : _('sportlink.filter_competition_type'),
        listeners   : {
            'select'    : {
                fn      : this.filterCompetitionType,
                scope   : this
            }
        }
    }, {
        xtype       : 'textfield',
        name        : 'sportlink-filter-matches-search',
        id          : 'sportlink-filter-matches-search',
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
        id          : 'sportlink-filter-matches-clear',
        text        : _('filter_clear'),
        listeners   : {
            'click'     : {
                fn          : this.clearFilter,
                scope       : this
            }
        }
    }];
    
    var expander = new Ext.grid.RowExpander({
        getRowClass : function(record, rowIndex, p, ds) {
            return parseInt(record.json.status) === 2 ? 'grid-row-cancelled' : '';
        }
    });
    
    var columns = new Ext.grid.ColumnModel({
        columns     : [{
            header      : _('sportlink.label_match_date'),
            dataIndex   : 'match_date',
            sortable    : true,
            editable    : false,
            width       : 150,
            fixed       : true
        }, {
            header      : _('sportlink.label_match_name'),
            dataIndex   : 'match',
            sortable    : true,
            editable    : false,
            width       : 150,
            renderer    : this.renderMatch
        }, {
            header      : _('sportlink.label_team_type'),
            dataIndex   : 'team_type',
            sortable    : true,
            editable    : false,
            width       : 150,
            fixed       : true
        }, {
            header      : _('sportlink.label_match_competition'),
            dataIndex   : 'competition_type',
            sortable    : true,
            editable    : false,
            width       : 150,
            fixed       : true
        }, {
            header      : _('sportlink.label_match_accommodation'),
            dataIndex   : 'accommodation',
            sortable    : true,
            editable    : false,
            width       : 250,
            fixed       : true,
            renderer    : this.renderAccommodation
        }]
    });

    Ext.applyIf(config, {
        cm          : columns,
        id          : 'sportlink-grid-matches',
        url         : Sportlink.config.connector_url,
        baseParams  : {
            action      : 'mgr/matches/getlist',
            type        : 'matches'
        },
        fields      : ['id', 'match_id', 'match_nr', 'match_date', 'team1_id', 'team1_club', 'team1_name', 'team1_goals', 'team2_id', 'team2_club', 'team2_name', 'team2_goals', 'accommodation', 'city', 'type', 'status', 'team_type', 'competition_type'],
        paging      : true,
        pageSize    : MODx.config.default_per_page > 30 ? MODx.config.default_per_page : 30,
        plugins     : expander
    });
    
    Sportlink.grid.Matches.superclass.constructor.call(this, config);
};

Ext.extend(Sportlink.grid.Matches, MODx.grid.Grid, {
    filterWeek: function(tf, nv, ov) {
        this.getStore().baseParams.week = tf.getValue();
        
        this.getBottomToolbar().changePage(1);
    },
    filterCompetitionType: function(tf, nv, ov) {
        this.getStore().baseParams.competition_type = tf.getValue();
        
        this.getBottomToolbar().changePage(1);
    },
    filterSearch: function(tf, nv, ov) {
        this.getStore().baseParams.query = tf.getValue();
        
        this.getBottomToolbar().changePage(1);
    },
    clearFilter: function() {
        this.getStore().baseParams.week             = '';
        this.getStore().baseParams.competition_type = '';
        this.getStore().baseParams.query            = '';
        
        Ext.getCmp('sportlink-filter-matches-week').reset();
        Ext.getCmp('sportlink-filter-matches-competition').reset();
        Ext.getCmp('sportlink-filter-matches-search').reset();

        this.getBottomToolbar().changePage(1);
    },
    renderMatch: function(d, c, e) {
        if (Sportlink.config.club === e.json.team1_club) {
            return '<strong>' + e.json.team1_name + '</strong> - ' + e.json.team2_name;
        }

        return e.json.team1_name + ' - <strong>' + e.json.team2_name + '</strong>';
    },
    renderAccommodation: function(d, c, e) {
        if (!Ext.isEmpty(e.json.city)) {
            return d + ', ' + e.json.city;
        }

        return d;
    }
});

Ext.reg('sportlink-grid-matches', Sportlink.grid.Matches);