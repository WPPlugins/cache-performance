<?php require_once('header.php'); ?>
<form id="companyID" method="post" action="<?php echo admin_url( 'tools.php?page=optimisationio-cache-settings' ); ?>">

            <div class="tab-content">
                <div class="cache-form">
                    <div class="form-group-alt">
                        <label>Cache Expiry</label>
                        <input type="number" name="cache_expires" id="cache_expires" value="<?php echo esc_attr($settings['cache_expires']) ?>" />
                        <p>0 = never expires. (Time in hours)</p>
                    </div>

                    <div class="form-group">
                        <span>Compress cache (<small>Disable if the you notice any weird issues in browser.</small>)</span>
                        <label class="switch">
                          <input type="checkbox" name="cache_compress" id="cache_compress" value="1" <?php checked('1', $settings['cache_compress']); ?> />
                          <div class="slider round"></div>
                        </label>
                    </div>

                    <div class="form-group">
                        <span>New Posts (<small>Wipe cache when you publish a new post.</small>)</span>
                        <label class="switch">
                          <input type="checkbox" name="cache_new_post" id="cache_new_post" value="1" <?php checked('1', $settings['cache_new_post']); ?> />
                          <div class="slider round"></div>
                        </label>
                    </div>

                    <div class="form-group">
                        <span>Enable Gzip Compression (<small>Only on Apache servers.</small>)</span>
                        <label class="switch">
                            <input type="checkbox" name="enable_gzip_compression" id="enable_gzip_compression" value="1" <?php checked('1', $settings['enable_gzip_compression']); ?> />
                          <div class="slider round"></div>
                        </label>
                    </div>

                    <div class="form-group">
                        <span>New comments (<small>Wipe Cache when new comments posted.</small>)</span>
                        <label class="switch">
                            <input type="checkbox" name="cache_new_comment" id="cache_new_comment" value="1" <?php checked('1', $settings['cache_new_comment']); ?> />
                          <div class="slider round"></div>
                        </label>
                    </div>

                    <div class="form-group">
                        <span>WebP Images (<small>Cache WebP images. See <a href=\"https://optmisation.io/\" target=\"_blank\">Optimisation.io</a> for more info.</small>)</span>
                        <label class="switch">
                            <input type="checkbox" name="cache_webp" id="cache_webp" value="1" <?php checked('1', $settings['cache_webp']); ?> />
                          <div class="slider round"></div>
                        </label>
                    </div>

                    <div class="form-group-alt">
                        <label>Exclusions</label>
                        <input type="text" name="excl_ids" id="excl_ids" value="<?php echo esc_attr($settings['excl_ids']) ?>" />
                        <p>Post or Pages IDs separated by a <code>,</code></p>
                    </div>

                    <div class="form-group">
                        <input type="submit" value="Update" name="submit"/>
                    </div>

                </div>
            
            </div>

    </form>
</div>
    <?php require_once('sidebar.php'); ?>
</div>
