<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'WC_Background_Process', false ) ) {
    if( file_exists( WC_ABSPATH . 'includes/abstracts/class-wc-background-process.php' ) ) {
      include_once WC_ABSPATH . 'includes/abstracts/class-wc-background-process.php';
    } else {
      include_once dirname( __FILE__ ) . '/class-wc-background-process.php';
    }
    // WC_Background_Process is only available in WooCommerce >= 3.0.0
    // if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '3.0.0' ) >= 0 ) {
    //     include_once WC_ABSPATH . 'includes/abstracts/class-wc-background-process.php';
    // } else {
    //     include_once dirname( __FILE__ ) . '/class-wc-background-process.php';
    // }
}

class Ivole_Background_Importer extends WC_Background_Process {

    public function __construct() {
        $this->prefix = 'wp_' . get_current_blog_id();
        $this->action = 'ivole_importer';

        parent::__construct();
    }

    /**
     * Validate and import reviews
     */
    protected function task( $reviews ) {
        global $wpdb;

        $results = array(
            'imported' => 0,
            'skipped'  => 0,
            'errors'   => 0
        );

        $columns = Ivole_Admin_Import::get_columns();

        $review_content_index = array_search( 'review_content', $columns );
        $review_score_index   = array_search( 'review_score', $columns );
        $date_index           = array_search( 'date', $columns );
        $product_id_index     = array_search( 'product_id', $columns );
        $display_name_index   = array_search( 'display_name', $columns );
        $email_index          = array_search( 'email', $columns );

        $hashes = array();
        $product_ids = array();
        // Ensure mandatory fields are provided
        foreach ( $reviews as $index => $review ) {
            $review_score = intval( $review[$review_score_index] );
            if ( $review_score < 1 || $review_score > 5 ) {
                unset( $reviews[$index] );
                $results['errors']++;
                continue;
            }

            $product_id = intval( $review[$product_id_index] );
            if ( $product_id < 1 ) {
                unset( $reviews[$index] );
                $results['errors']++;
                continue;
            }
            $ppp = wc_get_product( $product_id );
            if( !$ppp || ($ppp && wp_get_post_parent_id( $product_id ) > 0 ) ) {
                unset( $reviews[$index] );
                $results['errors']++;
                continue;
            }

            $display_name = $review[$display_name_index];
            if ( empty( $display_name ) ) {
                unset( $reviews[$index] );
                $results['errors']++;
                continue;
            }

            $email = $review[$email_index];
            if ( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
                unset( $reviews[$index] );
                $results['errors']++;
                continue;
            }

            // Quick way to check for duplicates within $reviews array
            $hash = md5( $review[$review_content_index] . '|' . $review_score . '|' . $product_id . '|' . $email );

            if ( in_array( $hash, $hashes ) ) {
                unset( $reviews[$index] );
                $results['skipped']++;
                continue;
            }

            $hashes[] = $hash;

            if ( ! in_array( $product_id, $product_ids ) ) {
                $product_ids[] = $product_id;
            }
        }

        $existing_reviews = $wpdb->get_results(
            "SELECT com.*, meta.meta_value AS rating
            FROM {$wpdb->comments} AS com LEFT JOIN {$wpdb->commentmeta} AS meta
            ON com.comment_ID = meta.comment_id AND meta.meta_key = 'rating'
            WHERE com.comment_post_ID IN(" . implode( ',', $product_ids ) . ")",
            ARRAY_A
        );

        if ( ! is_array( $existing_reviews ) ) {
            $existing_reviews = array();
        }

        $existing_reviews = array_reduce( $existing_reviews, function( $existing, $review ) {
            if ( ! isset( $existing[$review['comment_post_ID']] ) ) {
                $existing[$review['comment_post_ID']] = array();
            }

            $existing[$review['comment_post_ID']][] = $review;

            return $existing;
        }, [] );

        $timezone_string = get_option( 'timezone_string' );
        $timezone_string = empty( $timezone_string ) ? 'gmt': $timezone_string;
        $site_timezone = new DateTimeZone( $timezone_string );
        $gmt_timezone  = new DateTimeZone( 'gmt' );
        // Check for duplicates and add review
        foreach ( $reviews as $review ) {
            $product_id = intval( $review[$product_id_index] );

            if ( ! empty( $review[$date_index] ) ) {
                $date_string = str_ireplace( 'UTC', 'GMT', $review[$date_index] );

                try {
                    if ( strpos( $date_string, 'GMT' ) !== false ) {
                        $date = new DateTime( $date_string );
                    } else {
                        $date = new DateTime( $date_string, $site_timezone );
                    }
                } catch ( Exception $exception ) {
                    $date = new DateTime( 'now', $site_timezone );
                }

            } else {
                $date = new DateTime( 'now', $site_timezone );
            }

            $review_date = $date->format( 'Y-m-d H:i:s' );
            $date->setTimezone( $gmt_timezone );
            $review_date_gmt = $date->format( 'Y-m-d H:i:s' );

            if ( isset( $existing_reviews[$product_id] ) ) {

                foreach ( $existing_reviews[$product_id] as $review_of_product ) {
                    if ( $review[$review_content_index] == $review_of_product['comment_content']
                        && $review[$email_index] == $review_of_product['comment_author_email']
                        && $review[$review_score_index] == intval( $review_of_product['rating'] ) ) {
                        $results['skipped']++;
                        continue 2;
                    }

                }

            }

            $review_id = wp_insert_comment(
                array(
                    'comment_author'       => $review[$display_name_index],
                    'comment_author_email' => $review[$email_index],
                    'comment_content'      => $review[$review_content_index],
                    'comment_post_ID'      => $product_id,
                    'comment_date'         => $review_date,
                    'comment_date_gmt'     => $review_date_gmt,
                    'comment_meta'         => array(
                        'rating' => $review[$review_score_index]
                    )
                )
            );

            if ( $review_id ) {
                $results['imported']++;
            } else {
                $results['errors']++;
            }
        }

        return $results;
    }

    protected function get_post_args() {
        if ( property_exists( $this, 'post_args' ) ) {
            return $this->post_args;
        }

        // Pass cookies through with the request so nonces function.
        $cookies = array();

        foreach ( $_COOKIE as $name => $value ) {
            if ( 'PHPSESSID' === $name ) {
                continue;
            }
            $cookies[] = new WP_Http_Cookie( array(
                'name'  => $name,
                'value' => $value,
            ) );
        }

        return array(
            'timeout'   => 0.01,
            'blocking'  => false,
            'body'      => $this->data,
            'cookies'   => $cookies,
            'sslverify' => apply_filters( 'https_local_ssl_verify', false ),
        );
    }

    protected function handle() {
        global $wpdb;

        $this->lock_process();

        do {
            // One batch represents one CSV import job
            $batch = $this->get_batch();

            if ( empty( $batch->data ) ) {
                break;
            }

            $progress = get_transient( $batch->data['progress_id'] );

            if ( ! $progress ) {
                $progress = array();
            }

            $file_offset = $batch->data['offset'];
            $file = fopen( $batch->data['file'], 'r' );

            if ( $file === false || empty( $progress ) ) {
                // Import failed
                $this->delete( $batch->key );
                $progress['status'] = 'failed';
                $progress['finished'] = current_time( 'timestamp' );
                set_transient( $batch->data['progress_id'], $progress );
                continue;
            }

            $cancelled = get_transient( 'cancel' . $batch->data['progress_id'] );
            if ( $cancelled ) {
                $this->delete( $batch->key );
                $progress['status'] = 'cancelled';
                $progress['finished'] = current_time( 'timestamp' );
                set_transient( $batch->data['progress_id'], $progress );
                continue;
            }

            $cancel_query = $wpdb->prepare(
                "SELECT option_value FROM {$wpdb->options} WHERE option_name = %s",
                '_transient_cancel' . $batch->data['progress_id']
            );

            fseek( $file, $file_offset );

            /**
             * Review buffer will fill up with 5 reviews and then attempt to
             * import them. This is to limit the amount of database interactions
             * while still providing regular progress information.
             */
            $review_buffer = array();
            $review_buffer_size = 5;
            /**
             * Normally using feof in the iteration condition is a bug,
             * but memory/time constraints will prevent hanging in this situation.
             */
            while ( ! feof( $file ) ) {
                $review_data = fgetcsv( $file );

                if ( $review_data !== false ) {
                    $review_buffer[] = $review_data;
                }

                if ( count( $review_buffer ) >= $review_buffer_size || $review_data === false || feof( $file ) ) {
                    $import = $this->task( $review_buffer );

                    $wpdb->flush();
                    $cancelled = $wpdb->get_var( $cancel_query );
                    if ( $cancelled ) {
                        $this->delete( $batch->key );
                        $progress['status'] = 'cancelled';
                        $progress['finished'] = current_time( 'timestamp' );
                        set_transient( $batch->data['progress_id'], $progress );
                        continue 2;
                    }

                    /*
                     * It is important that file offset is only updated after the import has been completed
                     * as it is possible that the process will abort before attempting to import reviews in buffer.
                     */
                    $file_offset = ftell( $file );

                    $progress['reviews']['imported'] += $import['imported'];
                    $progress['reviews']['errors']   += $import['errors'];
                    $progress['reviews']['skipped']  += $import['skipped'];

                    set_transient( $batch->data['progress_id'], $progress );

                    $review_buffer = array();
                }

                if ( $this->time_exceeded() || $this->memory_exceeded() || $review_data === false ) {
                    break;
                }
            }

            if ( feof( $file ) ) {
                // Import is complete
                $this->delete( $batch->key );
                $progress['status'] = 'complete';
                $progress['finished'] = current_time( 'timestamp' );
                set_transient( $batch->data['progress_id'], $progress );
                @unlink( $batch->data['file'] );
            } else {
                $batch->data['offset'] = $file_offset;
                $this->update( $batch->key, $batch->data );
            }

            fclose( $file );
        } while ( ! $this->time_exceeded() && ! $this->memory_exceeded() && ! $this->is_queue_empty() );

        $this->unlock_process();

        if ( ! $this->is_queue_empty() ) {
            $this->dispatch();
        } else {
            $this->complete();
        }
    }

}
