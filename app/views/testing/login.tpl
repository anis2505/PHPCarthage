{extends file='templates/layout.tpl'}

{block name='title'}
        Smarty testing from subfolder
    {/block}


{block name='css'}
    {css file='assets/css/ap1p.css'}
{/block}
{block name='js'}
    {js file='assets/js1/jquery-2.1.3.js'}
{/block}

{block name='body'}
    <div class="one-half column">
        {form_open form='form'}
        <fieldset>
            {form_show_label field='username'}
            {form_show field='username' class='u-full-width'}
        </fieldset>
        <fieldset>
            {form_show_label field='pwd'}
            {form_show field='pwd' class='u-full-width'}
        </fieldset>
        <fieldset>
            {form_show field='submit' class='green'}
        </fieldset>
        {form_end form='form'}

    </div>
{/block}