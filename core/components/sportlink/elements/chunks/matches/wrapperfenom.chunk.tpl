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
            {$output}
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
            {$output}
        </tbody>
    </table>
{/if}