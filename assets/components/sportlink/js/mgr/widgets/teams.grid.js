Sportlink.grid.Teams = function(config) {
    config = config || {};

    config.tbar = ['->', {
        xtype       : 'sportlink-combo-team-type',
        name        : 'sportlink-filter-teams-type',
        id          : 'sportlink-filter-teams-type',
        emptyText   : _('sportlink.filter_team_type'),
        listeners   : {
            'select'    : {
                fn          : this.filterType,
                scope       : this
            }
        }
    }, '-', {
        xtype       : 'textfield',
        name        : 'sportlink-filter-teams-search',
        id          : 'sportlink-filter-teams-search',
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
        id          : 'sportlink-filter-teams-clear',
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
            header      : _('sportlink.label_team_id'),
            dataIndex   : 'team_id',
            sortable    : true,
            editable    : false,
            width       : 100,
            fixed       : true
        }, {
            header      : _('sportlink.label_team_name'),
            dataIndex   : 'name',
            sortable    : true,
            editable    : false,
            width       : 150
        }, {
            header      : _('sportlink.label_team_type'),
            dataIndex   : 'type',
            sortable    : true,
            editable    : false,
            width       : 150,
            fixed       : true
        }, {
            header      : _('sportlink.label_team_sex'),
            dataIndex   : 'sex',
            sortable    : true,
            editable    : false,
            width       : 150,
            fixed       : true
        }, {
            header      : _('sportlink.label_team_category'),
            dataIndex   : 'category',
            sortable    : true,
            editable    : false,
            width       : 200,
            fixed       : true
        }, {
            header      : _('last_modified'),
            dataIndex   : 'editedon',
            sortable    : true,
            editable    : false,
            fixed       : true,
            width       : 200,
            renderer    : this.renderDate
        }]
    });
    
    Ext.applyIf(config, {
        cm          : columns,
        id          : 'sportlink-grid-teams',
        url         : Sportlink.config.connector_url,
        baseParams  : {
            action      : 'mgr/teams/getlist'
        },
        fields      : ['id', 'team_id', 'name', 'type', 'sex', 'category', 'editedon'],
        paging      : true,
        pageSize    : MODx.config.default_per_page > 30 ? MODx.config.default_per_page : 30,
        sortBy      : 'team_name'
    });
    
    Sportlink.grid.Teams.superclass.constructor.call(this, config);
};

Ext.extend(Sportlink.grid.Teams, MODx.grid.Grid, {
    filterType: function(tf, nv, ov) {
        this.getStore().baseParams.type = tf.getValue();

        this.getBottomToolbar().changePage(1);
    },
    filterSearch: function(tf, nv, ov) {
        this.getStore().baseParams.query = tf.getValue();
        
        this.getBottomToolbar().changePage(1);
    },
    clearFilter: function() {
        this.getStore().baseParams.type     = '';
        this.getStore().baseParams.query    = '';

        Ext.getCmp('sportlink-filter-teams-type').reset();
        Ext.getCmp('sportlink-filter-teams-search').reset();

        this.getBottomToolbar().changePage(1);
    },
    getMenu: function() {
        var menu = [{
            text    : '<i class="x-menu-item-icon icon icon-eye"></i>' + _('sportlink.team_view'),
            handler : this.viewTeam,
            scope   : this
        }];

        return menu;
    },
    viewTeam: function(btn, e) {
        MODx.loadPage('?a=team/team&namespace=' + MODx.request.namespace + '&id=' + this.menu.record.id);
    },
    removeTeam: function(btn, e) {
        MODx.msg.confirm({
            title       : _('sportlink.team_remove'),
            text        : _('sportlink.team_remove_confirm'),
            url         : Sportlink.config.connector_url,
            params      : {
                action      : 'mgr/teams/remove',
                id          : this.menu.record.id
            },
            listeners   : {
                'success'   : {
                    fn          : this.refresh,
                    scope       : this
                }
            }
        });
    },
    renderCompetition: function(d, c, e) {
        return d + ' ' + e.json.competition_type;
    },
    renderDate: function(a) {
        if (Ext.isEmpty(a)) {
            return '—';
        }

        return a;
    }
});

Ext.reg('sportlink-grid-teams', Sportlink.grid.Teams);