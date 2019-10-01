{if $type === 'result'}
    <table cellpadding="0" cellspacing="0" border="0">
        <thead>
            <tr>
                <th width="150">{'sportlink.date' | lexicon}</th>
                <th>{'sportlink.match' | lexicon}</th>
                <th width="100">{'sportlink.result' | lexicon}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="3" style="text-align: center;">{'sportlink.no_results' | lexicon}</th>
            </tr>
        </tbody>
    </table>
{else}
    <table cellpadding="0" cellspacing="0" border="0">
        <thead>
            <tr>
                <th width="150">{'sportlink.date' | lexicon}</th>
                <th>{'sportlink.match' | lexicon}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="2" style="text-align: center;">{'sportlink.no_matches' | lexicon}</th>
            </tr>
        </tbody>
    </table>
{/if}