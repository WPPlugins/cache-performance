jQuery(document).ready(function($){
	$('#frm_optimise').submit(function(){
		var clean_draft_posts = 0;
		var clean_auto_draft_posts = 0;
		var clean_trash_posts = 0;
		var clean_post_revisions = 0;
		var clean_transient_options = 0;
		var clean_spam_comments = 0;
		var optimise_database = 0;
		var clean_post_meta = 0;
		var auto_optimise = 0;
		if($('#clean_draft_posts').is(':checked')){
			clean_draft_posts = 1;
		}	

		if($('#clean_auto_draft_posts').is(':checked')){
			clean_auto_draft_posts = 1;
		}	
		if($('#clean_trash_posts').is(':checked')){
			clean_trash_posts = 1;
		}	
		if($('#clean_post_revisions').is(':checked')){
			clean_post_revisions = 1;
		}	
		if($('#clean_transient_options').is(':checked')){
			clean_transient_options = 1;
		}	
		if($('#clean_spam_comments').is(':checked')){
			clean_spam_comments = 1;
		}
		if($('#clean_post_meta').is(':checked')){
			clean_post_meta = 1;
		}
		if($('#optimise_database').is(':checked')){
			optimise_database = 1;
		}	
		if($('#auto_optimise').is(':checked')){
			auto_optimise = 1;
		}	
		$('#submit_optimise_btn').html('<img src="'+optimisationioscript.imageUrl+'" style="height:15px;">');
		jQuery.post(ajaxurl, 
		    {
		        'action': 'optimise_db_ajx',
		         'clean_draft_posts':clean_draft_posts,
		         'clean_auto_draft_posts':clean_auto_draft_posts,
		         'clean_trash_posts':clean_trash_posts,
		         'clean_post_revisions':clean_post_revisions,
		         'clean_transient_options':clean_transient_options,
		         'clean_spam_comments':clean_spam_comments,
		         'optimise_database':optimise_database,
		         'auto_optimise':auto_optimise,
		         'optimise_schedule_type':$('#optimise_schedule_type').val()
		    }, 
		    function(data){
		      if (data.status == 'success') {
		      	$('#submit_optimise_btn').html('Update');
		      }
		    },'json');	
	})
	
})

