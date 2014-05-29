<fieldset class="wp-mailchimp-subscribe fields">
    <ul class="items">
        <li class="item">
            <label class="label" for="<?php esc_attr_e( $this->get_field_id( 'title' ) ); ?>">Title</label>
            <input class="control" id="<?php esc_attr_e( $this->get_field_id( 'title' ) ); ?>" name="<?php esc_attr_e( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo $title; ?>" />
        </li>
        <li class="item">
            <label class="label" for="<?php esc_attr_e( $this->get_field_id( 'url' ) ); ?>">URL</label>
            <input class="control" id="<?php esc_attr_e( $this->get_field_id( 'url' ) ); ?>" name="<?php esc_attr_e( $this->get_field_name( 'url' ) ); ?>" type="text" value="<?php echo $url; ?>" />
        </li>
    </ul>
</fieldset>