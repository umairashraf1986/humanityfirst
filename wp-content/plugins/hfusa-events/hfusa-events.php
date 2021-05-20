<?php
    /*
    Plugin Name: HFUSA Events
    Plugin URI: http://usa.humanityfirst.org
    Description: A custom plugin for HFUSA Events
    Version: 1.0
    Author: Oracular
    Author URI: http://oracular.com
    License: GPL2
    */

    add_action( 'admin_menu', 'hfusa_add_admin_menu' );
    add_action( 'admin_init', 'hfusa_settings_init' );


    function hfusa_add_admin_menu(  ) {

        add_submenu_page( 'edit.php?post_type=hf_events', 'Bookings', 'Bookings', 'manage_options', 'events_bookings', 'hfusa_options_page' );

    }


    function hfusa_settings_init(  ) {

        register_setting( 'pluginPage', 'hfusa_settings' );

    }


    function hfusa_text_field_0_render(  ) {

        $options = get_option( 'hfusa_settings' );
        ?>
        <input type='text' name='hfusa_settings[hfusa_text_field_0]' value='<?php echo $options['hfusa_text_field_0']; ?>'>
        <?php

    }


    function hfusa_radio_field_1_render(  ) {

        $options = get_option( 'hfusa_settings' );
        ?>
        <input type='radio' name='hfusa_settings[hfusa_radio_field_1]' <?php checked( $options['hfusa_radio_field_1'], 1 ); ?> value='1'>
        <?php

    }


    function hfusa_textarea_field_2_render(  ) {

        $options = get_option( 'hfusa_settings' );
        ?>
        <textarea cols='40' rows='5' name='hfusa_settings[hfusa_textarea_field_2]'>
          <?php echo $options['hfusa_textarea_field_2']; ?>
      </textarea>
      <?php

  }


  function hfusa_settings_section_callback(  ) {

    echo __( 'This section description', 'sage' );


    if(!class_exists('WP_List_Table')){
        require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
    }

    class TT_Example_List_Table extends WP_List_Table {

        /** ************************************************************************
         * Normally we would be querying data from a database and manipulating that
         * for use in your list table. For this example, we're going to simplify it
         * slightly and create a pre-built array. Think of this as the data that might
         * be returned by $wpdb->query()
         *
         * In a real-world scenario, you would make your own custom query inside
         * this class' prepare_items() method.
         *
         * @var array
         **************************************************************************/
        var $example_data = array(
            array(
                'ID'        => 1,
                'title'     => '300',
                'rating'    => 'R',
                'director'  => 'Zach Snyder'
            ),
            array(
                'ID'        => 2,
                'title'     => 'Eyes Wide Shut',
                'rating'    => 'R',
                'director'  => 'Stanley Kubrick'
            ),
            array(
                'ID'        => 3,
                'title'     => 'Moulin Rouge!',
                'rating'    => 'PG-13',
                'director'  => 'Baz Luhrman'
            ),
            array(
                'ID'        => 4,
                'title'     => 'Snow White',
                'rating'    => 'G',
                'director'  => 'Walt Disney'
            ),
            array(
                'ID'        => 5,
                'title'     => 'Super 8',
                'rating'    => 'PG-13',
                'director'  => 'JJ Abrams'
            ),
            array(
                'ID'        => 6,
                'title'     => 'The Fountain',
                'rating'    => 'PG-13',
                'director'  => 'Darren Aronofsky'
            ),
            array(
                'ID'        => 7,
                'title'     => 'Watchmen',
                'rating'    => 'R',
                'director'  => 'Zach Snyder'
            ),
            array(
                'ID'        => 8,
                'title'     => '2001',
                'rating'    => 'G',
                'director'  => 'Stanley Kubrick'
            ),
        );


        /** ************************************************************************
         * REQUIRED. Set up a constructor that references the parent constructor. We
         * use the parent reference to set some default configs.
         ***************************************************************************/
        function __construct(){
            global $status, $page;

            //Set parent defaults
            parent::__construct( array(
                'singular'  => 'movie',     //singular name of the listed records
                'plural'    => 'movies',    //plural name of the listed records
                'ajax'      => false        //does this table support ajax?
            ) );

        }


        /** ************************************************************************
         * Recommended. This method is called when the parent class can't find a method
         * specifically build for a given column. Generally, it's recommended to include
         * one method for each column you want to render, keeping your package class
         * neat and organized. For example, if the class needs to process a column
         * named 'title', it would first see if a method named $this->column_title()
         * exists - if it does, that method will be used. If it doesn't, this one will
         * be used. Generally, you should try to use custom column methods as much as
         * possible.
         *
         * Since we have defined a column_title() method later on, this method doesn't
         * need to concern itself with any column with a name of 'title'. Instead, it
         * needs to handle everything else.
         *
         * For more detailed insight into how columns are handled, take a look at
         * WP_List_Table::single_row_columns()
         *
         * @param array $item A singular item (one full row's worth of data)
         * @param array $column_name The name/slug of the column to be processed
         * @return string Text or HTML to be placed inside the column <td>
         **************************************************************************/
        function column_default($item, $column_name){
            switch($column_name){
                case 'rating':
                case 'director':
                return $item[$column_name];
                default:
                    return print_r($item,true); //Show the whole array for troubleshooting purposes
                }
            }


        /** ************************************************************************
         * Recommended. This is a custom column method and is responsible for what
         * is rendered in any column with a name/slug of 'title'. Every time the class
         * needs to render a column, it first looks for a method named
         * column_{$column_title} - if it exists, that method is run. If it doesn't
         * exist, column_default() is called instead.
         *
         * This example also illustrates how to implement rollover actions. Actions
         * should be an associative array formatted as 'slug'=>'link html' - and you
         * will need to generate the URLs yourself. You could even ensure the links
         *
         *
         * @see WP_List_Table::::single_row_columns()
         * @param array $item A singular item (one full row's worth of data)
         * @return string Text to be placed inside the column <td> (movie title only)
         **************************************************************************/
        function column_title($item){

            //Build row actions
            $actions = array(
                'edit'      => sprintf('<a href="?page=%s&action=%s&movie=%s">Edit</a>',$_REQUEST['page'],'edit',$item['ID']),
                'delete'    => sprintf('<a href="?page=%s&action=%s&movie=%s">Delete</a>',$_REQUEST['page'],'delete',$item['ID']),
            );

            //Return the title contents
            return sprintf('%1$s <span style="color:silver">(id:%2$s)</span>%3$s',
                /*$1%s*/ $item['title'],
                /*$2%s*/ $item['ID'],
                /*$3%s*/ $this->row_actions($actions)
            );
        }


        /** ************************************************************************
         * REQUIRED if displaying checkboxes or using bulk actions! The 'cb' column
         * is given special treatment when columns are processed. It ALWAYS needs to
         * have it's own method.
         *
         * @see WP_List_Table::::single_row_columns()
         * @param array $item A singular item (one full row's worth of data)
         * @return string Text to be placed inside the column <td> (movie title only)
         **************************************************************************/
        function column_cb($item){
            return sprintf(
                '<input type="checkbox" name="%1$s[]" value="%2$s" />',
                /*$1%s*/ $this->_args['singular'],  //Let's simply repurpose the table's singular label ("movie")
                /*$2%s*/ $item['ID']                //The value of the checkbox should be the record's id
            );
        }


        /** ************************************************************************
         * REQUIRED! This method dictates the table's columns and titles. This should
         * return an array where the key is the column slug (and class) and the value
         * is the column's title text. If you need a checkbox for bulk actions, refer
         * to the $columns array below.
         *
         * The 'cb' column is treated differently than the rest. If including a checkbox
         * column in your table you must create a column_cb() method. If you don't need
         * bulk actions or checkboxes, simply leave the 'cb' entry out of your array.
         *
         * @see WP_List_Table::::single_row_columns()
         * @return array An associative array containing column information: 'slugs'=>'Visible Titles'
         **************************************************************************/
        function get_columns(){
            $columns = array(
                'cb'        => '<input type="checkbox" />', //Render a checkbox instead of text
                'title'     => 'Title',
                'rating'    => 'Rating',
                'director'  => 'Director'
            );
            return $columns;
        }


        /** ************************************************************************
         * Optional. If you want one or more columns to be sortable (ASC/DESC toggle),
         * you will need to register it here. This should return an array where the
         * key is the column that needs to be sortable, and the value is db column to
         * sort by. Often, the key and value will be the same, but this is not always
         * the case (as the value is a column name from the database, not the list table).
         *
         * This method merely defines which columns should be sortable and makes them
         * clickable - it does not handle the actual sorting. You still need to detect
         * the ORDERBY and ORDER querystring variables within prepare_items() and sort
         * your data accordingly (usually by modifying your query).
         *
         * @return array An associative array containing all the columns that should be sortable: 'slugs'=>array('data_values',bool)
         **************************************************************************/
        function get_sortable_columns() {
            $sortable_columns = array(
                'title'     => array('title',false),     //true means it's already sorted
                'rating'    => array('rating',false),
                'director'  => array('director',false)
            );
            return $sortable_columns;
        }


        /** ************************************************************************
         * Optional. If you need to include bulk actions in your list table, this is
         * the place to define them. Bulk actions are an associative array in the format
         * 'slug'=>'Visible Title'
         *
         * If this method returns an empty value, no bulk action will be rendered. If
         * you specify any bulk actions, the bulk actions box will be rendered with
         * the table automatically on display().
         *
         * Also note that list tables are not automatically wrapped in <form> elements,
         * so you will need to create those manually in order for bulk actions to function.
         *
         * @return array An associative array containing all the bulk actions: 'slugs'=>'Visible Titles'
         **************************************************************************/
        function get_bulk_actions() {
            $actions = array(
                'delete'    => 'Delete'
            );
            return $actions;
        }


        /** ************************************************************************
         * Optional. You can handle your bulk actions anywhere or anyhow you prefer.
         * For this example package, we will handle it in the class to keep things
         * clean and organized.
         *
         * @see $this->prepare_items()
         **************************************************************************/
        function process_bulk_action() {

            //Detect when a bulk action is being triggered...
            if( 'delete'===$this->current_action() ) {
                wp_die('Items deleted (or they would be if we had items to delete)!');
            }

        }


        /** ************************************************************************
         * REQUIRED! This is where you prepare your data for display. This method will
         * usually be used to query the database, sort and filter the data, and generally
         * get it ready to be displayed. At a minimum, we should set $this->items and
         * $this->set_pagination_args(), although the following properties and methods
         * are frequently interacted with here...
         *
         * @global WPDB $wpdb
         * @uses $this->_column_headers
         * @uses $this->items
         * @uses $this->get_columns()
         * @uses $this->get_sortable_columns()
         * @uses $this->get_pagenum()
         * @uses $this->set_pagination_args()
         **************************************************************************/
        function prepare_items() {
            global $wpdb; //This is used only if making any database queries

            /**
             * First, lets decide how many records per page to show
             */
            $per_page = 5;


            /**
             * REQUIRED. Now we need to define our column headers. This includes a complete
             * array of columns to be displayed (slugs & titles), a list of columns
             * to keep hidden, and a list of columns that are sortable. Each of these
             * can be defined in another method (as we've done here) before being
             * used to build the value for our _column_headers property.
             */
            $columns = $this->get_columns();
            $hidden = array();
            $sortable = $this->get_sortable_columns();


            /**
             * REQUIRED. Finally, we build an array to be used by the class for column
             * headers. The $this->_column_headers property takes an array which contains
             * 3 other arrays. One for all columns, one for hidden columns, and one
             * for sortable columns.
             */
            $this->_column_headers = array($columns, $hidden, $sortable);


            /**
             * Optional. You can handle your bulk actions however you see fit. In this
             * case, we'll handle them within our package just to keep things clean.
             */
            $this->process_bulk_action();


            /**
             * Instead of querying a database, we're going to fetch the example data
             * property we created for use in this plugin. This makes this example
             * package slightly different than one you might build on your own. In
             * this example, we'll be using array manipulation to sort and paginate
             * our data. In a real-world implementation, you will probably want to
             * use sort and pagination data to build a custom query instead, as you'll
             * be able to use your precisely-queried data immediately.
             */
            $data = $this->example_data;


            /**
             * This checks for sorting input and sorts the data in our array accordingly.
             *
             * In a real-world situation involving a database, you would probably want
             * to handle sorting by passing the 'orderby' and 'order' values directly
             * to a custom query. The returned data will be pre-sorted, and this array
             * sorting technique would be unnecessary.
             */
            function usort_reorder($a,$b){
                $orderby = (!empty($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : 'title'; //If no sort, default to title
                $order = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : 'asc'; //If no order, default to asc
                $result = strcmp($a[$orderby], $b[$orderby]); //Determine sort order
                return ($order==='asc') ? $result : -$result; //Send final sort direction to usort
            }
            usort($data, 'usort_reorder');


            /***********************************************************************
             * ---------------------------------------------------------------------
             * vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv
             *
             * In a real-world situation, this is where you would place your query.
             *
             * For information on making queries in WordPress, see this Codex entry:
             * http://codex.wordpress.org/Class_Reference/wpdb
             *
             * ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
             * ---------------------------------------------------------------------
             **********************************************************************/


            /**
             * REQUIRED for pagination. Let's figure out what page the user is currently
             * looking at. We'll need this later, so you should always include it in
             * your own package classes.
             */
            $current_page = $this->get_pagenum();

            /**
             * REQUIRED for pagination. Let's check how many items are in our data array.
             * In real-world use, this would be the total number of items in your database,
             * without filtering. We'll need this later, so you should always include it
             * in your own package classes.
             */
            $total_items = count($data);


            /**
             * The WP_List_Table class does not handle pagination for us, so we need
             * to ensure that the data is trimmed to only the current page. We can use
             * array_slice() to
             */
            $data = array_slice($data,(($current_page-1)*$per_page),$per_page);



            /**
             * REQUIRED. Now we can add our *sorted* data to the items property, where
             * it can be used by the rest of the class.
             */
            $this->items = $data;


            /**
             * REQUIRED. We also have to register our pagination options & calculations.
             */
            $this->set_pagination_args( array(
                'total_items' => $total_items,                  //WE have to calculate the total number of items
                'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
                'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
            ) );
        }


    }

    function tt_render_list_page(){

        //Create an instance of our package class...
        $testListTable = new TT_Example_List_Table();
        //Fetch, prepare, sort, and filter our data...
        $testListTable->prepare_items();

        ?>
        <div class="wrap">

            <div id="icon-users" class="icon32"><br/></div>
            <h2>List Table Test</h2>

            <div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
                <p>This page demonstrates the use of the <tt><a href="http://codex.wordpress.org/Class_Reference/WP_List_Table" target="_blank" style="text-decoration:none;">WP_List_Table</a></tt> class in plugins.</p>
                <p>For a detailed explanation of using the <tt><a href="http://codex.wordpress.org/Class_Reference/WP_List_Table" target="_blank" style="text-decoration:none;">WP_List_Table</a></tt>
                    class in your own plugins, you can view this file <a href="<?php echo admin_url( 'plugin-editor.php?plugin='.plugin_basename(__FILE__) ); ?>" style="text-decoration:none;">in the Plugin Editor</a> or simply open <tt style="color:gray;"><?php echo __FILE__ ?></tt> in the PHP editor of your choice.</p>
                    <p>Additional class details are available on the <a href="http://codex.wordpress.org/Class_Reference/WP_List_Table" target="_blank" style="text-decoration:none;">WordPress Codex</a>.</p>
                </div>

                <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
                <form id="movies-filter" method="get">
                    <!-- For plugins, we also need to ensure that the form posts back to our current page -->
                    <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
                    <!-- Now we can render the completed list table -->
                    <?php $testListTable->display() ?>
                </form>

            </div>
            <?php
        }


    }


    function hfusa_options_page(  ) {


        global $wpdb;

        $event_id = !empty($_GET['event_id']) ?  $_GET['event_id'] : ''; 

        if(!empty($event_id)){

            $event_tickets_available =get_post_meta( $event_id, 'hfusa-event_tickets_available',true );
            $event_date =get_post_meta( $event_id, 'hfusa-event_date',true );
            $event_start_time =get_post_meta( $event_id, 'hfusa-event_start_time',true );
            $event_end_time =get_post_meta( $event_id, 'hfusa-event_end_time',true );
            $event_location =get_post_meta( $event_id, 'hfusa-event_location',true );
            $event_location = !empty($event_location) ? $event_location : 'N/A';   


        }



        if(isset($_GET['booking_id']) && !empty($_GET['booking_id'])){



            $user_id =  $_GET['user_id']; 
            $booking_id =  $_GET['booking_id']; 


            $userDetails=get_userdata( $user_id );
            $user_email  = isset($userDetails->data->user_email) ? $userDetails->data->user_email : '';

            $booking_role=get_user_meta( $user_id, 'hf_user_role', true );
            $booking_company=get_user_meta( $user_id, 'hf_user_company', true );
            $first_name=get_user_meta( $user_id, 'first_name', true );
            $last_name=get_user_meta( $user_id, 'last_name', true );  


            ?>

            <h1>Edit Booking</h1>


            <div class="meta-box-sortables ui-sortable" id="poststuff">
                <div class="postbox" id="events_fields">
                    <h2 class="hndle ui-sortable-handle">
                        <span>Events Details</span></h2>
                        <div class="inside">                
                            <strong>Name </strong>
                            <a href="<?php echo get_the_permalink($event_id); ?>"><strong><?php echo get_the_title($event_id); ?></strong></a>
                        </div>
                        <div class="inside">                
                            <strong>Date/Time </strong>
                            <?php 
                            if(!empty($event_date)){
                                echo date("F d, Y", strtotime($event_date)); 
                            }
                            if(!empty($event_date) && !empty($event_start_time) ){
                                echo ' - ';
                                echo $event_start_time;
                            }
                            if(!empty($event_start_time) && !empty($event_end_time) ){
                                echo '-';
                                echo $event_end_time;
                            }
                            ?>
                        </div>
                    </div>
                </div>


                <div class="meta-box-sortables ui-sortable" id="poststuff">
                    <div class="postbox" id="events_fields" style="overflow: hidden;">
                        <h2 class="hndle ui-sortable-handle">
                            <span>Primary Booking</span></h2>

                            <div style="float: left;margin-top: 10px;margin-left: 15px;margin-bottom: 15px;">

                                <?php echo get_avatar( $user_id ); ?> 

                            </div>


                            <div style="float: left;">
                                <div class="inside" style=" padding-top: 0;padding-bottom: 5px;">                
                                    <strong>Name : </strong>
                                    <a href="<?php echo get_admin_url(); ?>/user-edit.php?user_id=<?php echo $user_id; ?>"><strong><?php echo $first_name.' '.$last_name; ?></strong></a>
                                </div>
                                <div class="inside" style=" padding-top: 0;padding-bottom: 5px;">                
                                    <strong>Email : </strong>
                                    <?php echo $user_email; ?>
                                </div>
                                <div class="inside" style=" padding-top: 0;padding-bottom: 5px;">                
                                    <strong>Company : </strong>
                                    <?php echo !empty($booking_company) ? $booking_company : 'N/A'; ?>
                                </div>
                                <div class="inside" style=" padding-top: 0;padding-bottom: 5px;">                
                                    <strong>Role : </strong>
                                    <?php echo !empty($booking_role) ? $booking_role : 'N/A'; ?>
                                </div>
                            </div>

                        </div>
                    </div>





                    <div class="meta-box-sortables ui-sortable" id="poststuff">
                        <div class="postbox" id="events_fields">
                            <h2 class="hndle ui-sortable-handle">
                                <span>Guest Bookings</span></h2>
                                <div class="inside">        

                                    <?php


                                    $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}guest_bookings WHERE booking_id=$booking_id" );

                                    if($results){
                                        ?>
                                        <table class="wp-list-table widefat  striped posts" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th width="5%">S.No</th>
                                                    <th width="10%">Booking ID</th>
                                                    <th width="30%">Full Name</th>
                                                    <th width="30%">Email</th>
                                                    <th width="15%">Affiliated Organization</th>
                                                    <th width="10%">Entree</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i=1;
                                                foreach($results as $result){

                                                 $id= $result->id;
                                                 $first_name= $result->first_name;
                                                 $last_name= $result->last_name;
                                                 $email= $result->email;
                                                 $affiliated_org= $result->affiliated_org;
                                                 $role= $result->entree;
                                                 ?>

                                                 <tr>  
                                                    <td><?php echo $i++; ?></td>
                                                    <td><?php echo $id; ?></td>
                                                    <td><?php echo $first_name.' '.$last_name; ?></td>
                                                    <td><?php echo $email; ?></td>
                                                    <td><?php echo $affiliated_org; ?></td>
                                                    <td><?php echo $role; ?></td>

                                                </tr>

                                                <?php

                                            }

                                            ?>



                                        </tbody>
                                    </table>
                                    <?php } else {
                                        ?>

                                        No guests bookings found.!
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>

                            <?php

                        }else if(isset($_GET['event_id']) && !empty($_GET['event_id'])){



                            ?>

                            <h1><?php echo get_the_title($event_id); ?></h1>

                            <div style=" padding-top: 0;padding-bottom: 5px;">
                                <strong>Event Name :</strong>
                                <?php echo get_the_title($event_id); ?><br />
                            </div>
                            <div style=" padding-top: 0;padding-bottom: 5px;">
                                <strong>Availability :</strong>

                                <span> <?php 
                                echo event_booking_spaces($event_id); 
                                echo '/';
                                echo !empty($event_tickets_available) ? $event_tickets_available : 0;
                                ?> Spaces confirmed</span>
                                <br />
                            </div>
                            <div style=" padding-top: 0;padding-bottom: 5px;">
                                <strong>Date :</strong>
                                <?php 
                                if(!empty($event_date)){
                                    echo date("F d, Y", strtotime($event_date)); 
                                }
                                if(!empty($event_date) && !empty($event_start_time) ){
                                    echo ' - ';
                                    echo $event_start_time;
                                }
                                if(!empty($event_start_time) && !empty($event_end_time) ){
                                    echo '-';
                                    echo $event_end_time;
                                }
                                ?><br />
                            </div>
                            <div style=" padding-top: 0;padding-bottom: 5px;">
                                <strong>Location :</strong>
                                <?php echo $event_location; ?><br />
                            </div>
                            <div>
                                <h2>Bookings</h2>                
                            </div>
                            <?php
                            $items_per_page = 20;
                            $page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
                            $offset = ( $page * $items_per_page ) - $items_per_page;
                            $table_name=$wpdb->prefix.'bookings';
                            $query = 'SELECT * FROM '.$table_name.' WHERE event_id='.$event_id.' AND status="approved"';
                            $total_query = "SELECT COUNT(1) FROM (${query}) AS combined_table";
                            $total = $wpdb->get_var( $total_query );
                            $results = $wpdb->get_results( $query.' ORDER BY id DESC LIMIT '. $offset.', '. $items_per_page);

                            if($results){
                                ?>
                                <table class="wp-list-table widefat  striped posts" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="10%">Booking ID</th>
                                            <th width="15%">Name</th>
                                            <th width="20%">Event</th>
                                            <th width="15%">Affiliated Organization</th>
                                            <th width="10%">Entree</th>
                                            <th width="5%">Spaces</th>
                                            <th width="10%">Total</th>
                                            <th width="10%">Booking Date</th>
                                            <th width="5%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach($results as $result){

                                            $id= $result->id;
                                            $userId= $result->user_id;
                                            $booking_date= $result->booking_date;
                                            $booking_spaces= $result->booking_spaces;
                                            $booking_total= $result->booking_total;
                                            $first_name=get_user_meta( $userId, 'first_name', true );
                                            $last_name=get_user_meta( $userId, 'last_name', true );
                                            $affiliated_org=get_user_meta( $userId, 'hf_user_affiliated_org', true );
                                            $entree=get_user_meta( $userId, 'hf_user_entree', true );

                                            ?>

                                            <tr>  
                                                <td><?php echo $id; ?></td>
                                                <td><a href="<?php echo get_admin_url(); ?>/user-edit.php?user_id=<?php echo $userId; ?>"><?php echo $first_name.' '.$last_name; ?></a></td>                      
                                                <td><?php echo get_the_title($event_id); ?></td>
                                                <td><?php echo $affiliated_org; ?></td>
                                                <td><?php echo $entree; ?></td>
                                                <td><?php echo $booking_spaces; ?></td>
                                                <td>$ <?php echo number_format($booking_total,2); ?></td>
                                                <td>
                                                    <?php 
                                                    $booking_date = strtotime( $booking_date );
                                                    echo date( 'F jS, Y', $booking_date );
                                                    ?>                                                    
                                                </td>
                                                <td><a href="<?php echo get_admin_url(); ?>/edit.php?post_type=hf_events&page=events_bookings&booking_id=<?php echo $id; ?>&event_id=<?php echo $event_id; ?>&user_id=<?php echo $userId; ?>">View</a></td>
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

                                echo 'Booking record not found for this event.';
                            }
                        }else{
                           ?>

                           <h2>Event Bookings Dashboard</h2>
                           <?php
                           $paged = isset($_GET['paged']) ? $_GET['paged'] : 1;

                           $args = array(
                            'post_type' => 'hf_events',
                            'posts_per_page' => 20,
                            'paged' => $paged,
                        );

                           $the_query = new WP_Query( $args );
                           if ( $the_query->have_posts() ) { 
                            ?>
                            <table class="wp-list-table widefat  striped posts" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Event</th>
                                        <th>Date and time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ( $the_query->have_posts() ) {
                                        $the_query->the_post();
                                        $postId=get_the_ID();
                                        $event_date =get_post_meta( $postId, 'hfusa-event_date',true );
                                        $event_start_time =get_post_meta( $postId, 'hfusa-event_start_time',true );
                                        $event_end_time =get_post_meta( $postId, 'hfusa-event_end_time',true );
                                        $event_tickets_available =get_post_meta( $postId, 'hfusa-event_tickets_available',true );
                                        ?>
                                        <tr>                        
                                            <td width="80%">
                                                <a href="<?php echo get_admin_url(); ?>/edit.php?post_type=hf_events&page=events_bookings&event_id=<?php echo $postId; ?>">
                                                    <?php the_title(); ?>
                                                </a> 
                                                <span> - Booked Spaces : <?php echo event_booking_spaces($postId); 
                                                echo '/';
                                                echo !empty($event_tickets_available) ? $event_tickets_available : 0;
                                                ?></span>
                                            </td>
                                            <td width="20%"><?php 
                                            if(!empty($event_date)){
                                                echo date("F d, Y", strtotime($event_date)); 
                                            }
                                            if(!empty($event_date) && !empty($event_start_time) ){
                                                echo ' - ';
                                                echo $event_start_time;
                                            }
                                            if(!empty($event_start_time) && !empty($event_end_time) ){
                                                echo '-';
                                                echo $event_end_time;
                                            }
                                            ?>                                
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


function event_booking_spaces($event_id=''){
    $spaces_count=0;
    if(!empty($event_id)){
        global $wpdb;
        $booking_spaces= $wpdb->get_var( "SELECT SUM(booking_spaces) FROM {$wpdb->prefix}bookings WHERE event_id=$event_id  AND status='approved'" );
        if($booking_spaces){
            $spaces_count=$booking_spaces;
        }
    }
    return $spaces_count;
}
