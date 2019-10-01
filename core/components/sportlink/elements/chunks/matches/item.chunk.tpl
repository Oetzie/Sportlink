[[+type:eq=`result`:then=`
    <tr>
        <td>[[+match_date]]</td>
        [[+team1_club_id:eq=`[[++sportlink.club]]`:then=`
            <td><strong>[[+team1_name]]</strong> - [[+team2_name]]</td>
            <td><strong>[[+team1_goals]]<s/trong> - [[+team2_goals]]</td>
        `:else=`
            <td>[[+team1_name]] - <strong>[[+team2_name]]</strong></td>
            <td>[[+team1_goals]] - <strong>[[+team2_goals]]</strong></td>
        `]]
    </tr>
`:else=`
    <tr>
        <td>[[+match_date]]</td>
        [[+team1_club_id:eq=`[[++sportlink.club]]`:then=`
            <td><strong>[[+team1_name]]</strong> - [[+team2_name]]</td>
        `:else=`
            <td>[[+team1_name]] - <strong>[[+team2_name]]</strong></td>
        `]]
    </tr>
`]]