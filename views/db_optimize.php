<?php require_once('header.php'); ?>
      <div class="tab-content">
        <form id="frm_optimise" method="post" action="javascript:void(0)">
          <div class="db-form">
              <h3>Clean-up options</h3>
              <div class="form-group">
                  
                  <label class="switch">
                      <input type="checkbox" <?php checked((isset($settings['clean_draft_posts']))?$settings['clean_draft_posts']:0,1); ?> name="clean_draft_posts" id="clean_draft_posts" value="1" />
                    <div class="slider round"></div>
                  </label>
                  <span>Clean draft posts</span>
              </div>

              <div class="form-group">
                  <span>Clean auto draft posts</span>
                  <label class="switch">
                      <input type="checkbox"  <?php checked((isset($settings['clean_auto_draft_posts']))?$settings['clean_auto_draft_posts']:0,1); ?> name="clean_auto_draft_posts" id="clean_auto_draft_posts" value="1" />
                    <div class="slider round"></div>
                  </label>
              </div>

              <div class="form-group">
                  <span>Clean trash posts</span>
                  <label class="switch">
                      <input type="checkbox" <?php checked((isset($settings['clean_trash_posts']))?$settings['clean_trash_posts']:0,1); ?> name="clean_trash_posts" id="clean_trash_posts" value="1" />
                    <div class="slider round"></div>
                  </label>
              </div>

              <div class="form-group">
                  <span>Clean post revisions</span>
                  <label class="switch">
                      <input type="checkbox" <?php checked((isset($settings['clean_post_revisions']))?$settings['clean_post_revisions']:0,1); ?> name="clean_post_revisions" id="clean_post_revisions" value="1" />
                    <div class="slider round"></div>
                  </label>
              </div>

              <div class="form-group">
                  <span>Clean transient options</span>
                  <label class="switch">
                      <input type="checkbox" <?php checked((isset($settings['clean_transient_options']))?$settings['clean_transient_options']:0,1); ?>  name="clean_transient_options" id="clean_transient_options" value="1" />
                    <div class="slider round"></div>
                  </label>
              </div>

              <div class="form-group">
                  <span>Clean trash comments</span>
                  <label class="switch">
                      <input type="checkbox" <?php checked((isset($settings['clean_trash_comments']))?$settings['clean_trash_comments']:0,1); ?> name="clean_trash_comments" id="clean_trash_comments" value="1" />
                    <div class="slider round"></div>
                  </label>
              </div>

              <div class="form-group">
                  <span>Clean spam comments</span>
                  <label class="switch">
                      <input type="checkbox" <?php checked((isset($settings['clean_spam_comments']))?$settings['clean_spam_comments']:0,1); ?>  name="clean_spam_comments" id="clean_spam_comments" value="1" />
                    <div class="slider round"></div>
                  </label>
              </div>

              <h3>Action</h3>
              <div class="form-group">
                  <span>Optimise database</span>
                  <label class="switch">
                      <input type="checkbox" <?php checked((isset($settings['optimise_database']))?$settings['optimise_database']:0,1); ?> name="optimise_database" id="optimise_database" value="1" />
                    <div class="slider round"></div>
                  </label>
              </div>
              <h3>Automatic database optimisation</h3>
              <div class="form-group">
                  <label class="switch">
                      <input type="checkbox" <?php checked((isset($settings['auto_optimise']))?$settings['auto_optimise']:0,1); ?> name="auto_optimise" id="auto_optimise" value="1" />
                    <div class="slider round"></div>
                  </label>
              </div>

              <div class="form-group-alt" id="schedule_type_selector">
                <label>Select schedule type</label>
                <?php $settings['optimise_schedule_type'] =  isset($settings['optimise_schedule_type'])?$settings['optimise_schedule_type']:'daily'; ?>
                  <select name="optimise_schedule_type" id="optimise_schedule_type">
                      <option value="daily" <?php selected( $settings['optimise_schedule_type'], 'daily' ); ?>>Daily</option>
                      <option value="weekly" <?php selected( $settings['optimise_schedule_type'], 'weekly' ); ?>>Weekly</option>
                      <option value="fortnightly" <?php selected( $settings['optimise_schedule_type'], 'fortnightly' ); ?>>Fortnightly</option>
                      <option value="monthly" <?php selected( $settings['optimise_schedule_type'], 'monthly' ); ?>>Monthly</option>
                  </select>
            </div>
            <div class="form-group">
                <button type="submit" id="submit_optimise_btn">Update</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <?php require_once('sidebar.php'); ?>
  </div>
<script type="text/javascript">
  jQuery(document).ready(function($){
    if ($('#auto_optimise').is(':checked')) {
        $('#schedule_type_selector').show();
    } else{
        $('#schedule_type_selector').hide();
    }

     $('#auto_optimise').click(function(){
        if($(this).is(':checked')) {
          $('#schedule_type_selector').show();
        }else{
           $('#schedule_type_selector').hide();
        }
     })
  })

</script>