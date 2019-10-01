Sportlink.combo.Week = function(config) {
    config = config || {};

    var data = [];
    var date = new Date();

    date.setUTCDate(date.getUTCDate() + 4 - (date.getUTCDay() || 7));

    var week = Math.ceil((((date - new Date(Date.UTC(date.getUTCFullYear(), 0, 1))) / 86400000) + 1) / 7);

    for (var i = 0; i < 5; i++) {
        if (config.offset) {
            if ('+' === config.offset) {
                data.push([i + 1, _('sportlink.week', {
                    week : week + i
                })]);
            } else if ('-' === config.offset) {
                data.push([(4 - i) + 1, _('sportlink.week', {
                    week : week - (4 - i)
                })]);
            }
        }
    }

    Ext.applyIf(config, {
        store       : new Ext.data.ArrayStore({
            mode        : 'local',
            fields      : ['type', 'label'],
            data        : data
        }),
        remoteSort  : ['label', 'asc'],
        hiddenName  : 'week',
        valueField  : 'type',
        displayField : 'label',
        mode        : 'local'
    });

    Sportlink.combo.Week.superclass.constructor.call(this,config);
};

Ext.extend(Sportlink.combo.Week, MODx.combo.ComboBox);

Ext.reg('sportlink-combo-week', Sportlink.combo.Week);

Sportlink.combo.TeamType = function(config) {
    config = config || {};

    Ext.applyIf(config, {
        store       : new Ext.data.ArrayStore({
            mode        : 'local',
            fields      : ['type', 'label'],
            data        : [
                [['veld', 've'], _('sportlink.team_type_veld')],
                [['zaal', 'za'], _('sportlink.team_type_zaal')],
                [['recreatief', 're'], _('sportlink.team_type_recreatief')]
            ]
        }),
        remoteSort  : ['label', 'asc'],
        hiddenName  : 'team_type',
        valueField  : 'type',
        displayField : 'label',
        mode        : 'local'
    });

    Sportlink.combo.TeamType.superclass.constructor.call(this,config);
};

Ext.extend(Sportlink.combo.TeamType, MODx.combo.ComboBox);

Ext.reg('sportlink-combo-team-type', Sportlink.combo.TeamType);

Sportlink.combo.CompetitionType = function(config) {
    config = config || {};

    Ext.applyIf(config, {
        store       : new Ext.data.ArrayStore({
            mode        : 'local',
            fields      : ['type', 'label'],
            data        : [
                ['beker', _('sportlink.competition_type_beker')],
                ['regulier', _('sportlink.competition_type_regulier')],
                ['regulier_nacompetitie', _('sportlink.competition_type_regulier_nacompetitie')],
                ['nacompetitie', _('sportlink.competition_type_nacompetitie')]
            ]
        }),
        remoteSort  : ['label', 'asc'],
        hiddenName  : 'competition_type',
        valueField  : 'type',
        displayField : 'label',
        mode        : 'local'
    });

    Sportlink.combo.CompetitionType.superclass.constructor.call(this,config);
};

Ext.extend(Sportlink.combo.CompetitionType, MODx.combo.ComboBox);

Ext.reg('sportlink-combo-competition-type', Sportlink.combo.CompetitionType);

Sportlink.combo.Competition = function(config) {
    config = config || {};

    Ext.applyIf(config, {
        url         : Sportlink.config.connector_url,
        baseParams  : {
            action      : 'mgr/competition/getlist',
            team_id     : config.team_id || 0,
            combo       : true
        },
        fields      : ['id', 'poule_id', 'type', 'class_formatted'],
        hiddenName  : 'competition',
        valueField  : 'poule_id',
        displayField : 'class_formatted',
        tpl         : new Ext.XTemplate('<tpl for=".">' +
            '<div class="x-combo-list-item">' +
                '{class_formatted} <em>({type})</em>' +
            '</div>' +
        '</tpl>')
    });

    Sportlink.combo.Competition.superclass.constructor.call(this,config);
};

Ext.extend(Sportlink.combo.Competition, MODx.combo.ComboBox);

Ext.reg('sportlink-combo-competition', Sportlink.combo.Competition);