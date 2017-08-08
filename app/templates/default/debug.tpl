        <div class="debug-panel">
            <div>
                <span><b>Controller:</b> {$debugPanel.vars.ctrl.0}</span>
                <span><b>Action:</b> {$debugPanel.vars.act.0}</span>
                <span><b>View:</b> {$debugPanel.vars.view.0}</span>
                <span><b>Template:</b> {$debugPanel.vars.tpl.0}</span>
            </div>
        </div>
        <style>
            #toggle-debug-flow + label + .debug {
                 display: none; 
            }
            #toggle-debug-flow:checked + label + .debug {
                 display: block; 
            }
        </style>
        <input id="toggle-debug-flow" type="checkbox">
        <label for="toggle-debug-flow">Toggle Debug Flow</label>
        {if $aLogs}
        <div class="debug">
            <strong>DEBUG CONSOLE</strong>
            {if isset($smarty.session._params_.console)}
                <a id="console-tgr" href="{$base}/{$ctrl}/reset/console" data-href="{$base}/{$ctrl}/set/console/1">Konsola (ukryj)</a>
            {else}
                <a id="console-tgr" href="{$base}/{$ctrl}/set/console/1" data-href="{$base}/{$ctrl}/reset/console">Konsola (pokaż)</a>
            {/if}
            <div class="stack">
                {foreach from=$aLogs item=log}
                <div{if isset($log.logtype)} class="{$log.logtype}"{/if}>
                    <p><span class="line"><strong>{$log.line}</strong></span><span class="file" title="{$log.file}">{$log.file_short}</span><span class="name">{$log.name|default:'unknown'}</span></p>
                    {*if $log.array}
                    <p><pre>{$log.var}</pre></p>
                    {else*}
                    <p>{$log.var}</p>
                    {*/if*}
                </div>
                {/foreach}
            </div>
        </div>
        {/if}