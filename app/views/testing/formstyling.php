<?php $template = 'uikit'; ?>
<?php start_block(); ?>
    <?= CSScript('assets/css/app.css'); ?>
<?php $css = end_block('css'); ?>


<form action="#" method="post" style="">
    <fieldset>

        <legend><span>Login information</span></legend>

        <label for="username">
            <span>Username <abbr title="Required">*</abbr></span>
            <input type="text" name="username" id="username"
                   maxlength="20" />
        </label>

        <label for="password">
            <span>Password <abbr title="Required">*</abbr></span>
            <input type="password" name="password" id="password"
                   maxlength="20" />
        </label>

    </fieldset>
    <fieldset>

        <label for="remember">
            <input type="checkbox" name="remember" id="remember"
                   value="1" />
            <span>Remember me for next time</span>
        </label>

        <input type="submit" name="login" value="Login" />

    </fieldset>
</form>

<p>
    Be wary of over-styling interactive form elements.
    It should be immediately obvious to users which
    they are, without them having to play
    "hunt the cursor-change"!
</p>