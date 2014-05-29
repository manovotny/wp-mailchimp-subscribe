<form action="<?php echo $url; ?>" method="post">
    <fieldset class="fields">
        <ul class="items">
            <li class="item">
                <label class="label" for="mailchimp-signup-email">Email</label>
                <input
                    id="mailchimp-signup-email"
                    class="control"
                    name="EMAIL"
                    placeholder="Email"
                    required
                    type="email"
                />
            </li>
        </ul>
        <ul class="actions">
            <li class="action">
                <button type="submit">Submit</button>
            </li>
        </ul>
    </fieldset>
    <p class="message"></p>
</form>