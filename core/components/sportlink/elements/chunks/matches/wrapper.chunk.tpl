[[+type:eq=`result`:then=`
    <table cellpadding="0" cellspacing="0" border="0">
        <thead>
            <tr>
                <th width="150">[[%sportlink.date? &topic=`site`&namespace=`sportlink`]]</th>
                <th>[[%sportlink.match? &topic=`site`&namespace=`sportlink`]]</th>
                <th width="150">[[%sportlink.result? &topic=`site`&namespace=`sportlink`]]</th>
            </tr>
        </thead>
        <tbody>
            [[+output]]
        </tbody>
    </table>
`:else=`
    <table cellpadding="0" cellspacing="0" border="0">
        <thead>
            <tr>
                <th width="150">[[%sportlink.date? &topic=`site`&namespace=`sportlink`]]</th>
                <th>[[%sportlink.match? &topic=`site`&namespace=`sportlink`]]</th>
            </tr>
        </thead>
        <tbody>
            [[+output]]
        </tbody>
    </table>
`]]