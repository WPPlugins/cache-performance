<?php require_once('header.php'); ?>
        <div class="tab-content">        
            <form id="companyID" method="post" action="<?php echo admin_url( 'tools.php?page=optimisationio-update-cdn-enabler' ); ?>">          
                <div class="cdn-form">
                    <div class="form-left">
                        <div class="form-group">
                            <label>CDN Path</label>
                            <input type="text" name="cdn_root_url" id="cdn_root_url" value="<?php echo esc_attr($settings['cdn_root_url']) ?>" />
                        </div>

                        <div class="form-group">
                            <label>CSS CDN Path</label>
                            <input type="text" name="cdn_css_root_url" id="cdn_css_root_url" value="<?php echo esc_attr($settings['cdn_css_root_url']) ?>" />
                        </div>

                        <div class="form-group">
                            <label>JS Files CDN Path</label>
                            <input type="text" name="cdn_js_root_url" id="cdn_js_root_url" value="<?php echo esc_attr($settings['cdn_js_root_url']); ?>" />
                        </div>

                        <div class="form-group">
                            <input class="button-primary" type="submit" value="Update" name="submit"/>
                        </div>
                    </div>

                    <div class="form-right">
                        <div class="form-group">
                            <label>Image and file extensions</label>
                            <input type="text" name="cdn_file_extensions" id="cdn_file_extensions" value="<?php echo esc_attr($settings['cdn_file_extensions']) ?>" />
                        </div>

                        <div class="form-group">
                            <label>File Extensions for CSS</label>
                            <input type="text" name="cdn_css_file_extensions" id="cdn_css_file_extensions" value="<?php echo esc_attr($settings['cdn_css_file_extensions']) ?>" />
                        </div>

                        <div class="form-group">
                            <label>File Extensions for JS</label>
                            <input type="text" name="cdn_js_file_extensions" id="cdn_js_file_extensions" value="<?php echo esc_attr($settings['cdn_js_file_extensions']); ?>" />
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php require_once('sidebar.php'); ?>
</div>
