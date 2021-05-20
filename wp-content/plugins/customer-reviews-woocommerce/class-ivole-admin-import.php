<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Ivole_Admin_Import' ) ):

    class Ivole_Admin_Import {

        protected static $background_importer;

        public static $columns = array(
            'review_content',
            'review_score',
            'date',
            'product_id',
            'display_name',
            'email'
        );

        public function __construct() {
            $this->ivole_id = 'ivole';
            $this->section_id = 'ivole_import';
            //$this->ver = '3.34';
            $this->page_url = add_query_arg( array(
                'page'     => 'wc-settings',
                'tab'      => $this->ivole_id,
                'section'  => $this->section_id
            ), admin_url( 'admin.php' ) );

            add_action( 'woocommerce_settings_' . $this->ivole_id, array( $this, 'output' ) );
            add_action( 'admin_print_scripts', array( $this, 'print_scripts' ) );
            add_action( 'admin_init', array( $this, 'handle_template_download' ) );
            add_action( 'admin_enqueue_scripts', array( $this, 'include_scripts' ) );
            add_action( 'wp_ajax_ivole_import_upload_csv', array( $this, 'handle_upload' ) );
            add_action( 'wp_ajax_ivole_check_import_progress', array( $this, 'check_import_progress' ) );
            add_action( 'wp_ajax_ivole_cancel_import', array( $this, 'cancel_import' ) );
            add_action( 'init', array( 'Ivole_Admin_Import', 'init_background_importer' ) );
        }

        /**
         * Display the import section of the settings page
         */
        public function output() {
            global $current_section;

            $download_template_url = add_query_arg( array(
                'action'   => 'ivole-download-import-template',
                '_wpnonce' => wp_create_nonce( 'download_csv_template' )
            ), $this->page_url );

            $max_upload_size = size_format(
                wp_max_upload_size()
            );

            if( $current_section === $this->section_id ) {
                $GLOBALS['hide_save_button'] = true;
                ?>
                <div class="ivole-import-container">
                    <h2><?php echo _e( 'Import Reviews from CSV File', IVOLE_TEXT_DOMAIN ); ?></h2>
                    <p><?php echo _e( 'A utility to import reviews from a CSV file', IVOLE_TEXT_DOMAIN ); ?></p>
                    <div id="ivole-import-upload-steps">
                        <div class="ivole-import-step">
                            <h3 class="ivole-step-title"><?php _e( 'Step 1: Download template', IVOLE_TEXT_DOMAIN ); ?></h3>
                            <a href="<?php echo esc_url( $download_template_url ); ?>" target="_blank">
                                <div class="button button-secondary"><?php _e( 'Download', IVOLE_TEXT_DOMAIN ); ?></div>
                            </a>
                        </div>

                        <div class="ivole-import-step">
                            <h3 class="ivole-step-title"><?php _e( 'Step 2: Enter reviews into the template', IVOLE_TEXT_DOMAIN ); ?></h3>
                        </div>

                        <div class="ivole-import-step">
                            <h3 class="ivole-step-title"><?php _e( 'Step 3: Upload template with your reviews', IVOLE_TEXT_DOMAIN ); ?></h3>
                            <p id="ivole-import-status"></p>
                            <div id="ivole-import-filelist">
                                <?php _e( 'No file selected', IVOLE_TEXT_DOMAIN ); ?>
                            </div>
                            <div id="ivole-upload-container">
                                <table border="0" cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <button type="button" id="ivole-select-button"><?php _e( 'Choose File', IVOLE_TEXT_DOMAIN ); ?></button><br/>
                                                <small>
                                                <?php
                                                printf(
                                                    __( 'Maximum size: %s', IVOLE_TEXT_DOMAIN ),
                                                    $max_upload_size
                                                );
                                                ?>
                                                </small>
                                            </td>
                                            <td>
                                                <button type="button" class="button button-primary" id="ivole-upload-button"><?php _e( 'Upload', IVOLE_TEXT_DOMAIN ); ?></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div id="ivole-import-progress">
                        <h2 id="ivole-import-text"><?php _e( 'Import is in progress', IVOLE_TEXT_DOMAIN ); ?></h2>
                        <progress id="ivole-progress-bar" max="100" value="0"></progress>
                        <div>
                            <button id="ivole-import-cancel" class="button button-secondary"><?php _e( 'Cancel', IVOLE_TEXT_DOMAIN ); ?></button>
                        </div>
                    </div>
                    <div id="ivole-import-results">
                        <h3 id="ivole-import-result-status"><?php _e( 'Upload Completed', IVOLE_TEXT_DOMAIN ); ?></h3>
                        <p id="ivole-import-result-started"></p>
                        <p id="ivole-import-result-finished"></p>
                        <p id="ivole-import-result-imported"></p>
                        <p id="ivole-import-result-skipped"></p>
                        <p id="ivole-import-result-errors"></p>
                        <br>
                        <a href="" class="button button-secondary"><?php _e( 'New Upload', IVOLE_TEXT_DOMAIN ); ?></a>
                    </div>
                </div>
                <?php
            }
        }

        /**
         * Print CSS when the import section is visible
         */
        public function print_scripts() {
            global $current_section;

            if( $current_section === $this->section_id ) {
                ?>
                <style>
                .ivole-import-container {
                    color: #555555;
                }

                .ivole-import-container .ivole-import-step {
                    padding-bottom: 15px;
                }

                .ivole-import-container .ivole-import-step .ivole-step-title {
                    font-weight: normal;
                }

                #ivole-import-status {
                    display: none;
                }

                #ivole-import-status.status-error {
                    color: red;
                }

                #ivole-upload-container table td {
                    vertical-align: top;
                    padding: 5px 20px 0px 0px;
                }

                #ivole-import-progress {
                    max-width: 700px;
                    margin: 40px auto;
                    display: none;
                    text-align: center;
                }

                #ivole-import-progress h2 {
                    text-align: center;
                    font-weight: normal;
                }

                #ivole-import-progress progress {
                    width: 100%;
                    height: 42px;
                    margin: 0 auto 24px;
                    display: block;
                    -webkit-appearance: none;
                    background: #ffffff;
                    border: 2px solid #eee;
                    border-radius: 4px;
                    padding: 0;
                    box-shadow: 0 1px 0px 0 rgba(255, 255, 255, 0.2);
                }

                #ivole-import-progress progress::-webkit-progress-bar {
                    background: transparent none;
                    border: 0;
                    border-radius: 4px;
                    padding: 0;
                    box-shadow: none;
                }

                #ivole-import-progress progress::-webkit-progress-value {
                    border-radius: 3px;
                    box-shadow: inset 0 1px 1px 0 rgba(255, 255, 255, 0.4);
                    background: #A46497;
                    background: linear-gradient( top, #A46497, #66405F ), #A46497;
                    transition: width 1s ease;
                }

                #ivole-import-progress progress::-moz-progress-bar {
                    border-radius: 3px;
                    box-shadow: inset 0 1px 1px 0 rgba(255, 255, 255, 0.4);
                    background: #A46497;
                    background: linear-gradient( top, #A46497, #66405F ), #A46497;
                    transition: width 1s ease;
                }

                #ivole-import-progress progress::-ms-fill {
                    border-radius: 3px;
                    box-shadow: inset 0 1px 1px 0 rgba(255, 255, 255, 0.4);
                    background: #A46497;
                    background: linear-gradient( to bottom, #A46497, #66405F ), #A46497;
                    transition: width 1s ease;
                }

                #ivole-import-results {
                    display: none;
                }

                #ivole-import-results p {
                    font-size: 15px;
                }

                #ivole-import-cancel {
                    font-size: 15px;
                    line-height: 32px;
                    height: 34px;
                    padding: 0 20px 1px;
                }
                </style>
                <?php
            }
        }

        /**
         * Include scripts when the import section is visible
         */
        public function include_scripts() {
            global $current_section;

            if ( $current_section === $this->section_id ) {
            wp_register_script( 'ivole-admin-import', plugins_url( 'js/admin-import.js', __FILE__ ), [ 'wp-plupload', 'media', 'jquery' ]/*, $this->ver*/ );

                wp_localize_script( 'ivole-admin-import', 'ivoleImporterStrings', array(
                    'uploading'        => __( 'Upload progress: %s%', IVOLE_TEXT_DOMAIN ),
                    'importing'        => __( 'Import is in progress (%s/%s completed)', IVOLE_TEXT_DOMAIN ),
                    'filelist_empty'   => __( 'No file selected', IVOLE_TEXT_DOMAIN ),
                    'cancelling'       => __( 'Cancelling', IVOLE_TEXT_DOMAIN ),
                    'cancel'           => __( 'Cancel', IVOLE_TEXT_DOMAIN ),
                    'upload_cancelled' => __( 'Upload Cancelled', IVOLE_TEXT_DOMAIN ),
                    'upload_failed'    => __( 'Upload Failed', IVOLE_TEXT_DOMAIN ),
                    'result_started'   => __( 'Started: %s', IVOLE_TEXT_DOMAIN ),
                    'result_finished'  => __( 'Finished: %s', IVOLE_TEXT_DOMAIN ),
                    'result_cancelled' => __( 'Cancelled: %s', IVOLE_TEXT_DOMAIN ),
                    'result_imported'  => __( '%d review(s) successfully uploaded', IVOLE_TEXT_DOMAIN ),
                    'result_skipped'   => __( '%d duplicate review(s) skipped', IVOLE_TEXT_DOMAIN ),
                    'result_errors'    => __( '%d error(s)', IVOLE_TEXT_DOMAIN )
                ) );

                wp_enqueue_media();
                wp_enqueue_script( 'ivole-admin-import' );
            }
        }

        /**
         * Generates a CSV template file and sends it to the browser
         */
        public function handle_template_download() {
            if( isset( $_GET['action'] ) && $_GET['action'] === 'ivole-download-import-template' ) {
                // Ensure a valid nonce has been provided
                if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( $_GET['_wpnonce'], 'download_csv_template' ) ) {
                    wp_die( sprintf( __( 'Failed to download template: invalid nonce. <a href="%s">Return to settings</a>', IVOLE_TEXT_DOMAIN ), $this->page_url ) );
                }

                $template_data = array(
                    array(
                        'review_content',
                        'review_score',
                        'date',
                        'product_id',
                        'display_name',
                        'email'
                    ),
                    array(
                        __( 'This product is great!', IVOLE_TEXT_DOMAIN ),
                        '5',
                        '2018-07-01 15:30:05',
                        12,
                        __( 'Example Customer', IVOLE_TEXT_DOMAIN ),
                        'example.customer@mail.com'
                    ),
                    array(
                        __( 'This product is not so great.', IVOLE_TEXT_DOMAIN ),
                        '1',
                        '2017-04-15 09:54:32',
                        22,
                        __( 'Sample Customer', IVOLE_TEXT_DOMAIN ),
                        'sample.customer@mail.com'
                    )
                );

                $stdout = fopen( 'php://output', 'w' );
                $length = 0;

                foreach ( $template_data as $row ) {
                    $length += fputcsv( $stdout, $row );
                }

                header( 'Content-Description: File Transfer' );
                header( 'Content-Type: application/octet-stream' );
                header( 'Content-Disposition: attachment; filename="review-import-template.csv"' );
                header( 'Content-Transfer-Encoding: binary' );
                header( 'Connection: Keep-Alive' );
                header( 'Expires: 0' );
                header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
                header( 'Pragma: public' );
                header( 'Content-Length: ' . $length );
                fclose( $stdout );
                exit;
            }
        }

        /**
         * Receives a CSV file via ajax, validates it and counts reviews
         */
        public function handle_upload() {
            if ( ! current_user_can( 'upload_files' ) ) {
                echo wp_json_encode(
                    array(
                        'success' => false,
                        'data'    => array(
                            'message' => __( 'Permission denied', IVOLE_TEXT_DOMAIN )
                        ),
                    )
                );
                wp_die();
            }

            if ( ! isset( $_FILES['file'] ) || ! is_array( $_FILES['file'] ) ) {
                echo wp_json_encode(
                    array(
                        'success' => false,
                        'data'    => array(
                            'message' => __( 'No file was uploaded', IVOLE_TEXT_DOMAIN )
                        ),
                    )
                );
                wp_die();
            }

            $wp_filetype = wp_check_filetype_and_ext( $_FILES['file']['tmp_name'], $_FILES['file']['name'] );

		    if ( $wp_filetype['ext'] !== 'csv' ) {
                echo wp_json_encode(
                    array(
                        'success' => false,
                        'data'    => array(
                            'message'  => __( 'The uploaded file is not a valid CSV file', IVOLE_TEXT_DOMAIN ),
                            'filename' => $_FILES['file']['name'],
                        )
                    )
                );
                wp_die();
            }

            $file_data = wp_handle_upload( $_FILES['file'], array(
                'action' => 'ivole_import_upload_csv'
            ) );

            if ( isset( $file_data['error'] ) ) {
                echo wp_json_encode(
                    array(
                        'success' => false,
                        'data'    => array(
                            'message'  => $file_data['error'],
                            'filename' => $_FILES['file']['name'],
                        )
                    )
                );
                wp_die();
            }

            $file_stats = $this->validate_csv_file( $file_data['file'] );

            if ( is_wp_error( $file_stats ) ) {
                echo wp_json_encode(
                    array(
                        'success' => false,
                        'data'    => array(
                            'message'  => $file_stats->get_error_message(),
                            'filename' => $_FILES['file']['name'],
                        )
                    )
                );
                wp_die();
            }

            $progress_id = 'import_progress_' . uniqid();
            $progress = array(
                'status'  => 'importing',
                'started' => current_time( 'timestamp' ),
                'reviews' => array(
                    'total'    => $file_stats['num_reviews'],
                    'imported' => 0,
                    'skipped'  => 0,
                    'errors'   => 0
                )
            );

            set_transient( $progress_id, $progress, WEEK_IN_SECONDS );

            $batch = array(
                'file'        => $file_data['file'],
                'offset'      => $file_stats['offset'],
                'progress_id' => $progress_id
            );

            self::$background_importer->data( $batch );

            self::$background_importer->save()->dispatch();

            echo wp_json_encode(
                array(
                    'success' => true,
                    'data'    => array(
                        'file_path'   => $file_data['file'],
                        'num_rows'    => $file_stats['num_reviews'],
                        'progress_id' => $progress_id
                    )
                )
            );
            wp_die();
        }

        /**
         * Ensures the first line of the csv is formatted correctly and returns
         * the number of reviews in the file and the offset for the first review
         */
        protected function validate_csv_file( $file_path ) {
            if ( ! is_readable( $file_path ) ) {
                return new WP_Error( 'failed_read_file', __( 'Cannot read CSV file', IVOLE_TEXT_DOMAIN ) );
            }

            $file = fopen( $file_path, 'r' );
            $columns = fgetcsv( $file );

            if ( ! is_array( $columns ) || $columns != self::get_columns() ) {
                fclose( $file );
                return new WP_Error( 'malformed_columns', __( 'The CSV file contains invalid or missing column headings, please refer to the template in step 1', IVOLE_TEXT_DOMAIN ) );
            }

            $offset = ftell( $file );

            $num_reviews = 0;
            while ( ( $row = fgetcsv( $file ) ) !== false ) {
                $num_reviews++;
            }

            fclose( $file );

            if ( $num_reviews < 1 ) {
                return new WP_Error( 'no_reviews', __( 'The CSV file contains no reviews', IVOLE_TEXT_DOMAIN ) );
            }

            return array(
                'offset'      => $offset,
                'num_reviews' => $num_reviews
            );
        }

        public function check_import_progress() {
            $progress_id = $_POST['progress_id'];
            $progress = get_transient( $progress_id );

            wp_send_json( $progress, 200 );
            wp_die();
        }

        public function cancel_import() {
            $progress_id = $_POST['progress_id'];

            set_transient( 'cancel' . $progress_id, true, WEEK_IN_SECONDS );

            wp_die();
        }

        /**
         * Initialize the background importer process
         */
        public static function init_background_importer() {
            if ( ! class_exists( 'Ivole_Background_Importer' ) ) {
                include_once dirname( __FILE__ ) . '/class-ivole-background-importer.php';
            }

            self::$background_importer = new Ivole_Background_Importer();
        }

        public static function get_columns() {
            return self::$columns;
        }
    }

endif;
