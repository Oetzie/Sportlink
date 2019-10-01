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
            <tr>
                <td colspan="3" style="text-align: center;">[[%sportlink.no_results? &topic=`site`&namespace=`sportlink`]]</th>
            </tr>
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
            <tr>
                <td colspan="2" style="text-align: center;">[[%sportlink.no_matches? &topic=`site`&namespace=`sportlink`]]</th>
            </tr>
        </tbody>
    </table>
`]]