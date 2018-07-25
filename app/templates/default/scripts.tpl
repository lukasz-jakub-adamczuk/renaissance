<img id="imagelightbox" src="" alt="" />

<script>
var conf = {ldelim}
    ctrl: '{$ctrl|default:"home"}',
    act: '{$act}',
    func: 'run{$ctrl|replace:"-":" "|capitalize|replace:" ":""}{$act|replace:"-":" "|capitalize|replace:" ":""}'
{rdelim};
{if $usr::set()}conf.user = {ldelim}
    id: '{$usr::getId()|default:0}',
    name: '{$usr::getName()}',
    slug: '{$usr::getSlug()}'
{rdelim};{/if}
</script>
{if $smarty.const.APP_ENV eq 'prod'}
    {literal}<script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-16220396-1', 'auto');
        ga('send', 'pageview');
    </script>{/literal}
{/if}
{if $smarty.const.APP_ENV eq 'prod'}
    {*<script type="text/javascript" src="{$base}/js/all.min.js?v={$smarty.const.VERSION}" async></script>*}
    <script type="text/javascript" src="{$base}/js/jquery-2.1.0.min.js"></script>
    <script type="text/javascript" src="{$base}/js/imagelightbox/imagelightbox.js"></script>
    <script type="text/javascript" src="{$base}/js/lazyload/lazyload.js"></script>
    <script type="text/javascript" src="{$base}/js/main.js"></script>
{else}
    <script type="text/javascript" src="{$base}/js/jquery-2.1.0.min.js"></script>
    <script type="text/javascript" src="{$base}/js/imagelightbox/imagelightbox.js"></script>
    <script type="text/javascript" src="{$base}/js/lazyload/lazyload.js"></script>
    <script type="text/javascript" src="{$base}/js/main.js"></script>
{/if}
