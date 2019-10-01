var Sportlink = function(config) {
    config = config || {};

    Sportlink.superclass.constructor.call(this, config);
};

Ext.extend(Sportlink, Ext.Component, {
    page    : {},
    window  : {},
    grid    : {},
    tree    : {},
    panel   : {},
    combo   : {},
    config  : {}
});

Ext.reg('sportlink', Sportlink);

Sportlink = new Sportlink();