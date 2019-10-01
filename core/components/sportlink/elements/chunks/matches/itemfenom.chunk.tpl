{if $type === 'result'}
    <tr>
        <td>{$match_date}</td>
        {if $team1_club_id === $_modx->config['sportlink.club']}
            <td><strong>{$team1_name}</strong> - {$team2_name}</td>
            <td><strong>{$team1_goals}</strong> - {$team2_goals}</td>
        {else}
            <td>{$team1_name} - <strong>{$team2_name}</strong></td>
            <td width="150">{$team1_goals} - <strong>{$team2_goals}</strong></td>
        {/if}
    </tr>
{else}
    <tr>
        <td>{$match_date}</td>
        {if $team1_club_id === $_modx->config['sportlink.club']}
            <td><strong>{$team1_name}</strong> - {$team2_name}</td>
        {else}
            <td>{$team1_name} - <strong>{$team2_name}</strong></td>
        {/if}
    </tr>
{/if}