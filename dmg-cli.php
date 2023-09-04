<?php
if (defined('WP_CLI') && WP_CLI) {
    
    function dmg_alert_search($args, $assoc_args) {
        // Get the date parameters from the CLI command
        $date_before = isset($assoc_args['date-before']) ? $assoc_args['date-before'] : date('d-m-Y', strtotime('-30 days'));
        $date_after = isset($assoc_args['date-after']) ? $assoc_args['date-after'] : date('d-m-Y', strtotime('0 day'));

        // Extract date for the query
        $date_array_before = date_parse_from_format("d-m-Y", $date_before);
        $day_before = $date_array_before["day"];
        $month_before = $date_array_before["month"];
        $year_before = $date_array_before["year"];
        
        $date_array_after = date_parse_from_format("d-m-Y", $date_after);
        $day_after = $date_array_after["day"];
        $month_after = $date_array_after["month"];
        $year_after = $date_array_after["year"];

        // Get number of results per page and page number if available
        $results_per_page = isset($assoc_args['results-per-page']) ? intval($assoc_args['results-per-page']) : 10;
        $page = isset($assoc_args['page']) ? intval($assoc_args['page']) : 1;

        // Calculate the offset based on the page number
        $offset = ($page - 1) * $results_per_page;

        // Define WP_Query arguments with pagination
        $query_args = array(
            'post_type' => 'post',
            'posts_per_page' => $results_per_page,
            'offset' => $offset,
            'date_query' => array(
                array(
                    'after'  => array(
                        'year'   => $year_before,
                        'month'  => $month_before,
                        'day'    => $day_before,
                    ),
                    'before'     => array(
                        'year'   => $year_after,
                        'month'  => $month_after,
                        'day'    => $day_after,
                    ),
                    'inclusive'  => true,
                )
            ),
            's' => 'create-block/dmgblock',
        );

        $query = new WP_Query($query_args);

        // Check for results
        if ($query->have_posts()) {
            foreach ($query->posts as $post) {
                WP_CLI::line("Post ID: {$post->ID}");
            }
        } else {
            // $json_data = json_encode($query);
            WP_CLI::line('No posts found.');
        }
    }

    // Register my wp-cli command
    WP_CLI::add_command('dmg-alert search', 'dmg_alert_search');
}