<?php

add_action( 'admin_menu', 'hfusa_admin_menu_working_hours' );


function hfusa_admin_menu_working_hours(  ) {

	add_submenu_page( 'edit.php?post_type=hf_projects', 'Working Hours', 'Working Hours', 'manage_options', 'working_hours', 'hfusa_options_page_working_hours' );
}




function hfusa_options_page_working_hours(  ) {

	global $wpdb;


	if(isset($_GET['project_id']) && !empty($_GET['project_id'])){

		$project_id = $_GET['project_id'];
		?>

		<div class="clearfix"></div><br>
		<a href="<?php echo get_admin_url(); ?>/edit.php?post_type=hf_projects&page=working_hours">Back</a>

		<div style=" padding-top: 0;padding-bottom: 5px;">
			<strong>Project Name :</strong>
			<?php echo get_the_title($project_id); ?><br />
		</div>
		<div style=" padding-top: 0;padding-bottom: 5px;">
			<strong>Time:</strong>
			<span> <?php 
			$totalTime = $wpdb->get_var( "SELECT SUM(hours_worked) FROM {$wpdb->prefix}hours_worked WHERE project_id=$project_id" );

			if(!empty($totalTime) && $totalTime>0){
				$hours_worked = floor($totalTime/60);
				$minuts = $totalTime % 60;

				if($hours_worked > 0){
					echo $hours_worked;
					echo ($hours_worked==1) ? ' hour' : ' hours ';
				}

				if($minuts > 0){
					echo $minuts;
					echo ($minuts==1) ? ' minute' : ' minutes ';
				}
				
			}else{
				echo '--';
			}

			
			?></span>
			<br />
		</div>
		<div>
			<h2>Working Hours</h2>                
		</div>
		<?php
		$items_per_page = 20;
		$page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
		$offset = ( $page * $items_per_page ) - $items_per_page;
		$table_name=$wpdb->prefix.'hours_worked';
		$query = 'SELECT * FROM '.$table_name.' WHERE project_id='.$project_id.'';
		$total_query = "SELECT COUNT(1) FROM (${query}) AS combined_table";
		$total = $wpdb->get_var( $total_query );
		$results = $wpdb->get_results( $query.' ORDER BY id DESC LIMIT '. $offset.', '. $items_per_page);

		if($results){
			?>
			<table class="wp-list-table widefat  striped posts" cellspacing="0">
				<thead>
					<tr>
						<th width="10%">User Name</th>
						<th width="30%">Project</th>
						<th width="20%">Working Hours</th>
						<th width="20%">Start Date</th>
						<th width="20%">End Date</th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach($results as $result){

						$id= $result->id;
						$userId= $result->user_id;
						$project_id= $result->project_id;
						$totalTime= $result->hours_worked;
						$startDate= $result->start_date;
						$endDate= $result->end_date;
						$first_name=get_user_meta( $userId, 'first_name', true );
						$last_name=get_user_meta( $userId, 'last_name', true );
						?>
						<tr>  
							<td><a href="<?php echo get_admin_url(); ?>/user-edit.php?user_id=<?php echo $userId; ?>"><?php echo $first_name.' '.$last_name; ?></a></td>                   
							<td><?php echo get_the_title($project_id); ?></td>
							<td><?php 

							if(!empty($totalTime) && $totalTime>0){
								$hours_worked = floor($totalTime/60);
								$minuts = $totalTime % 60;

								if($hours_worked > 0){
									echo $hours_worked;
									echo ($hours_worked==1) ? ' hour ' : ' hours ';
								}

								if($minuts > 0){
									echo $minuts;
									echo ($minuts==1) ? ' minute' : ' minutes ';
								}

							}else{
								echo '--';
							}

							?></td>
							<td><?php  echo date("F jS, Y", strtotime($startDate));  ?></td>
							<td><?php  echo date("F jS, Y", strtotime($endDate));  ?></td>
						</tr>
						<?php
					}
					?>
				</tbody>
			</table>
			<div class="tablenav">
				<div class="tablenav-pages"  style="float: left;">
					<span class="pagination-links">
						<?php
						echo paginate_links( array(
							'base' => add_query_arg( 'cpage', '%#%' ),
							'format' => '',
							'prev_text' => __('&laquo;'),
							'next_text' => __('&raquo;'),
							'total' => ceil($total / $items_per_page),
							'current' => $page
						));
						?>
					</span>
				</div>
			</div>
			<?php
		}else{

			echo 'Record not found.';
		}

	}else{

		$paged = isset($_GET['paged']) ? $_GET['paged'] : 1;
		$args = array(
			'post_type' => 'hf_projects',
			'posts_per_page' => 20,
			'paged' => $paged,
		);

		$the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) { 
			?>
			<table class="wp-list-table widefat  striped posts" cellspacing="0">
				<thead>
					<tr>
						<th width="90%">Projects</th>
						<th width="10%">Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php
					while ( $the_query->have_posts() ) {
						$the_query->the_post();
						$postId=get_the_ID();
						?>
						<tr>                        
							<td width="80%">
								<a href="<?php echo get_edit_post_link( $postId ); ?>">
									<?php the_title(); ?>
								</a> 
							</td>                     
							<td width="80%">
								<a href="<?php echo get_admin_url(); ?>/edit.php?post_type=hf_projects&page=working_hours&project_id=<?php echo $postId; ?>">
									View
								</a> 
							</td>						
						</tr>
						<?php
					}
					?>
				</tbody>
			</table>

			<div class="tablenav">
				<div class="tablenav-pages"  style="float: left;">
					<span class="pagination-links">
						<?php
						global $wp_query;
                        $big = 999999999; // need an unlikely integer
                        echo paginate_links( array(
                        	'format' => '?paged=%#%',
                        	'current' => max( 1, $paged ),
                        	'total' => $the_query->max_num_pages,
                        	'prev_text'          => __('«'),
                        	'next_text'          => __('»'),
                        ));
                        ?> 
                    </span>
                </div>
            </div>
            <?php
        }else{
        	echo 'Booking record not found.';
        }
    }
}
?>