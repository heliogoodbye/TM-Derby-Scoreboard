<?php
/*
Plugin Name: TM Derby Scoreboard
Description: Displays roller derby game scores.
Plugin URI: https://thinmint333.com/wp-plugins/tm-derby-scoreboard/
Version: 1.7
Author: Thin Mint
Author URI: https://thinmint333.com/
License: GPL-3.0+
License URI: https://www.gnu.org/licenses/gpl-3.0.html
*/

// Register custom post type
function tm_derby_scoreboard_custom_post_type() {
    $labels = array(
        'name'               => _x( 'Game Scores', 'post type general name', 'tm-derby-scoreboard' ),
        'singular_name'      => _x( 'Game Score', 'post type singular name', 'tm-derby-scoreboard' ),
        'menu_name'          => _x( 'TM Derby Scoreboard', 'admin menu', 'tm-derby-scoreboard' ),
        'name_admin_bar'     => _x( 'Game Score', 'add new on admin bar', 'tm-derby-scoreboard' ),
        'add_new'            => _x( 'Add New', 'game', 'tm-derby-scoreboard' ),
        'add_new_item'       => __( 'Add New Game Score', 'tm-derby-scoreboard' ),
        'new_item'           => __( 'New Game Score', 'tm-derby-scoreboard' ),
        'edit_item'          => __( 'Edit Game Score', 'tm-derby-scoreboard' ),
        'view_item'          => __( 'View Game Score', 'tm-derby-scoreboard' ),
        'all_items'          => __( 'All Game Scores', 'tm-derby-scoreboard' ),
        'search_items'       => __( 'Search Game Scores', 'tm-derby-scoreboard' ),
        'parent_item_colon'  => __( 'Parent Game Scores:', 'tm-derby-scoreboard' ),
        'not_found'          => __( 'No game scores found.', 'tm-derby-scoreboard' ),
        'not_found_in_trash' => __( 'No game scores found in Trash.', 'tm-derby-scoreboard' )
    );

    $args = array(
        'labels'             => $labels,
        'description'        => __( 'Description.', 'tm-derby-scoreboard' ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'game-score' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 22,
        'supports'           => array( 'title' ),
        'menu_icon'          => 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAyOC4zLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiDQoJIHZpZXdCb3g9IjAgMCAyMCAyMCIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgMjAgMjA7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4NCjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+DQoJLnN0MHtmaWxsOiMwMTAxMDE7fQ0KPC9zdHlsZT4NCjxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik0xOC45LDQuMkMxNy41LDEuNywxNC44LDAsMTEuOCwwSDguMkMzLjcsMCwwLDMuOCwwLDguNGMwLDIuNCwxLDQuOSwxLjQsNS44YzIsMCw0LjEsMSw1LjItMC4yDQoJYzEuMywwLjUsMy4yLDEuNywzLjYsMy43Yy0wLjEsMC4xLTAuMSwwLjItMC4xLDAuNHYxYzAsMC41LDAuNCwwLjksMC44LDAuOXMwLjgtMC40LDAuOC0wLjl2LTFjMC0wLjEsMC0wLjMtMC4xLTAuNA0KCWMwLjItMy4zLDAuOC01LjcsMS4zLTdjMC42LTAuMSwxLjMtMC41LDEuOC0xQzE2LjIsOC40LDE4LjMsOC4zLDIwLDhDMjAsOCwxOS42LDUuNSwxOC45LDQuMnogTTUuMiwxMy4xYy0wLjMsMC0wLjUtMC4yLTAuNS0wLjUNCglzMC4yLTAuNSwwLjUtMC41YzAuMywwLDAuNSwwLjIsMC41LDAuNVM1LjQsMTMuMSw1LjIsMTMuMXogTTUuMSwxMC4ybDAuNC0zLjFMMi43LDUuOGwzLTAuNmwwLjMtMy4xbDEuNSwyLjdsMy0wLjZMOC41LDYuNUwxMCw5LjINCglMNy4yLDcuOUw1LjEsMTAuMnogTTEwLjYsMTUuMWMtMC45LTEuMi0yLjMtMS45LTMuMi0yLjRjMC0wLjEsMC4xLTAuMiwwLjEtMC40YzAuMy0xLjUsMS4zLTIuMiwyLjYtMi4yYzAuNCwwLDAuOCwwLjEsMS4yLDAuMw0KCWMwLjEsMC4xLDAuMiwwLjEsMC40LDAuMUMxMS4yLDExLjYsMTAuOCwxMy4xLDEwLjYsMTUuMXogTTEyLjcsOS4zYy0wLjMsMC0wLjUtMC4yLTAuNS0wLjVzMC4yLTAuNSwwLjUtMC41YzAuMywwLDAuNSwwLjIsMC41LDAuNQ0KCVMxMyw5LjMsMTIuNyw5LjN6Ii8+DQo8L3N2Zz4NCg==', // Add your SVG icon in base64 format here
    );

    register_post_type( 'game-score', $args );
}
add_action( 'init', 'tm_derby_scoreboard_custom_post_type' );

// Add custom fields to custom post type
function tm_derby_scoreboard_custom_fields() {
    add_meta_box( 'tm_derby_scoreboard_meta', 'Game Score Details', 'tm_derby_scoreboard_meta_callback', 'game-score' );
}
add_action( 'add_meta_boxes', 'tm_derby_scoreboard_custom_fields' );

function tm_derby_scoreboard_meta_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'tm_derby_scoreboard_nonce' );

    $date = get_post_meta( $post->ID, 'game_date', true );
    // Convert date format to "Month Day, Year"
    $formatted_date = date('F j, Y', strtotime($date));
    $title = get_post_meta( $post->ID, 'game_title', true );
    $venue = get_post_meta( $post->ID, 'venue', true );
    $location = get_post_meta( $post->ID, 'location', true );
    $team1fullname = get_post_meta( $post->ID, 'team_1_fullname', true );
	$team1 = get_post_meta( $post->ID, 'team_1', true );
    $team1name2 = get_post_meta( $post->ID, 'team_1_name2', true );
    $score1 = get_post_meta( $post->ID, 'score_1', true );
    $team2fullname = get_post_meta( $post->ID, 'team_2_fullname', true );
    $team2 = get_post_meta( $post->ID, 'team_2', true );
    $team2name2 = get_post_meta( $post->ID, 'team_2_name2', true );
    $score2 = get_post_meta( $post->ID, 'score_2', true );
   ?>
	<h3>
		Game Details
	</h3>
    <table class="custom-data-table">
        <tr>
            <td><label for="game_date">Game Date:</label></td>
            <td><input type="date" id="game_date" name="game_date" value="<?php echo esc_attr($date); ?>"></td>
        </tr>
        <tr>
            <td><label for="game_title">Game Title:</label></td>
            <td><input type="text" id="game_title" name="game_title" value="<?php echo esc_attr($title); ?>"></td>
        </tr>
		<tr>
            <td><label for="venue">Venue:</label></td>
            <td><input type="text" id="venue" name="venue" value="<?php echo esc_attr($venue); ?>"></td>
        </tr>
		<tr>
            <td><label for="location">Location:</label></td>
            <td><input type="text" id="location" name="location" value="<?php echo esc_attr($location); ?>"></td>
        </tr>
    </table>
	<hr />
	<h3>
		Visitor
	</h3>
	<table class="custom-data-table">
		<tr>
            <td><label for="location">Visitor Full Name:</label></td>
            <td><input type="text" id="team_1_fullname" name="team_1_fullname" value="<?php echo esc_attr($team1fullname); ?>"></td>
			<td><em>Example:</em> Example City Roller Derby Stingers <em>or</em> Example City Roller Derby</td>
        </tr>
		<tr>
            <td><label for="location">Visitor Name 1 (Location or City) *optional:</label></td>
            <td><input type="text" id="team_1" name="team_1" value="<?php echo esc_attr($team1); ?>"></td>
			<td><em>Example:</em> Example City <em>or</em> Example City Roller Derby</td>
        </tr>
		<tr>
            <td><label for="location">Visitor Name 2 (Mascot or Sub Team Name) *optional:</label></td>
            <td><input type="text" id="team_1_name2" name="team_1_name2" value="<?php echo esc_attr($team1name2); ?>"></td>
			<td><em>Example:</em> Roller Derby <em>or</em> Stingers</td>
        </tr>
		<tr>
            <td><label for="location">Visitor Score:</label></td>
            <td><input type="text" id="score_1" name="score_1" value="<?php echo esc_attr($score1); ?>"></td>
        </tr>
	</table>
	<hr />
	<h3>
		Home
	</h3>
	<table class="custom-data-table">
		<tr>
            <td><label for="location">Home Full Name:</label></td>
            <td><input type="text" id="team_2_fullname" name="team_2_fullname" value="<?php echo esc_attr($team2fullname); ?>"></td>
			<td><em>Example:</em> Example City Roller Derby Stingers <em>or</em> Example City Roller Derby</td>
        </tr>
		<tr>
            <td><label for="location">Home Name 1 (Location or City) *optional:</label></td>
            <td><input type="text" id="team_2" name="team_2" value="<?php echo esc_attr($team2); ?>"></td>
			<td><em>Example:</em> Example City <em>or</em> Example City Roller Derby</td>
        </tr>
		<tr>
            <td><label for="location">Home Name 2 (Mascot or Sub Team Name) *optional:</label></td>
            <td><input type="text" id="team_2_name2" name="team_2_name2" value="<?php echo esc_attr($team2name2); ?>"></td>
			<td><em>Example:</em> Roller Derby <em>or</em> Stingers</td>
        </tr>
		<tr>
            <td><label for="location">Home Score:</label></td>
            <td><input type="text" id="score_2" name="score_2" value="<?php echo esc_attr($score2); ?>"></td>
        </tr>
	</table>
    <?php
}

// Save custom fields data
function tm_derby_scoreboard_save_custom_fields( $post_id ) {
    if ( ! isset( $_POST['tm_derby_scoreboard_nonce'] ) || ! wp_verify_nonce( $_POST['tm_derby_scoreboard_nonce'], basename( __FILE__ ) ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( isset( $_POST['game_date'] ) ) {
        update_post_meta( $post_id, 'game_date', sanitize_text_field( $_POST['game_date'] ) );
    }
    if ( isset( $_POST['game_title'] ) ) {
        update_post_meta( $post_id, 'game_title', sanitize_text_field( $_POST['game_title'] ) );
    }
    if ( isset( $_POST['venue'] ) ) {
        update_post_meta( $post_id, 'venue', sanitize_text_field( $_POST['venue'] ) );
    }
    if ( isset( $_POST['location'] ) ) {
        update_post_meta( $post_id, 'location', sanitize_text_field( $_POST['location'] ) );
    }
    if ( isset( $_POST['team_1_fullname'] ) ) {
        update_post_meta( $post_id, 'team_1_fullname', sanitize_text_field( $_POST['team_1_fullname'] ) );
    }
	if ( isset( $_POST['team_1'] ) ) {
        update_post_meta( $post_id, 'team_1', sanitize_text_field( $_POST['team_1'] ) );
    }
    if ( isset( $_POST['team_1_name2'] ) ) {
        update_post_meta( $post_id, 'team_1_name2', sanitize_text_field( $_POST['team_1_name2'] ) );
    }
    if ( isset( $_POST['score_1'] ) ) {
        update_post_meta( $post_id, 'score_1', sanitize_text_field( $_POST['score_1'] ) );
    }
	if ( isset( $_POST['team_2_fullname'] ) ) {
        update_post_meta( $post_id, 'team_2_fullname', sanitize_text_field( $_POST['team_2_fullname'] ) );
    }
    if ( isset( $_POST['team_2'] ) ) {
        update_post_meta( $post_id, 'team_2', sanitize_text_field( $_POST['team_2'] ) );
    }
    if ( isset( $_POST['team_2_name2'] ) ) {
        update_post_meta( $post_id, 'team_2_name2', sanitize_text_field( $_POST['team_2_name2'] ) );
    }
    if ( isset( $_POST['score_2'] ) ) {
        update_post_meta( $post_id, 'score_2', sanitize_text_field( $_POST['score_2'] ) );
    }
}
add_action( 'save_post', 'tm_derby_scoreboard_save_custom_fields' );

// Shortcode to display game scores
function tm_derby_scoreboard_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'category' => '',
        'count' => 1, // Default to 1 if not specified
        'layout' => 'grid', // Default to grid layout
        'game_date' => '', // Use game_date attribute for filtering
    ), $atts );

    $count = intval( $atts['count'] ); // Convert count to integer
    $layout = $atts['layout'];
    $game_date = $atts['game_date']; // Get the game_date attribute

    // Extract year from the game_date attribute
    $year = '';
    if (!empty($game_date)) {
        $date_parts = explode('-', $game_date);
        $year = isset($date_parts[0]) ? $date_parts[0] : '';
    }

    $args = array(
        'post_type'      => 'game-score',
        'posts_per_page' => $count,
        'orderby'        => 'meta_value',
        'meta_key'       => 'game_date',
        'order'          => 'DESC'
    );
    
    // Add meta query to filter by year if available
    if (!empty($year)) {
        $args['meta_query'] = array(
            array(
                'key'     => 'game_date',
                'value'   => $year,
                'compare' => 'LIKE',
            ),
        );
    }

    if ( ! empty( $atts['category'] ) ) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'category',
                'field'    => 'slug',
                'terms'    => $atts['category'],
            ),
        );
    }

    $query = new WP_Query( $args );

    $output = '';

    if ( $query->have_posts() ) {
        if ($layout === 'grid') {
            $output .= '<div class="tm-derby-scoreboard-grid">';
        } else {
            $output .= '<div class="tm-derby-scoreboard-list">';
        }
        
        while ( $query->have_posts() ) {
            $query->the_post();
            $date = get_post_meta( get_the_ID(), 'game_date', true );
            // Convert date format to "Month Day, Year"
            $formatted_date = date('F j, Y', strtotime($date));
            $title = get_post_meta( get_the_ID(), 'game_title', true );
            $venue = get_post_meta( get_the_ID(), 'venue', true ); 
            $location = get_post_meta( get_the_ID(), 'location', true );
            $team1 = get_post_meta( get_the_ID(), 'team_1', true );
            $team1name2 = get_post_meta( get_the_ID(), 'team_1_name2', true );
            $team1fullname = get_post_meta( get_the_ID(), 'team_1_fullname', true ); // New line added
            $score1 = get_post_meta( get_the_ID(), 'score_1', true );
            $team2 = get_post_meta( get_the_ID(), 'team_2', true );
            $team2name2 = get_post_meta( get_the_ID(), 'team_2_name2', true );
            $team2fullname = get_post_meta( get_the_ID(), 'team_2_fullname', true ); // New line added
            $score2 = get_post_meta( get_the_ID(), 'score_2', true );

            // Check if Team1 and Team1name2 are empty, if so, use team1fullname
            if (empty($team1) && empty($team1name2)) {
                $team1name2 = $team1fullname;
            }
			if (empty($team2) && empty($team2name2)) {
                $team2name2 = $team2fullname;
            }

            if ($layout === 'grid') {
                $output .= '<div class="tm-derby-scoreboard-grid-container">';
				$output .= '<div class="tm-derby-scoreboard-grid-item"><h3>' . $team1 . '</h3> <h2>' . $team1name2 . '</h2></div>';
				$output .= '<div class="tm-derby-scoreboard-grid-item"><h1>' . $score1 . '</h1></div>';
    			$output .= '<div class="tm-derby-scoreboard-grid-item"><h3>' . $team2 . '</h3> <h2>' . $team2name2 . '</h2></div>';
				$output .= '<div class="tm-derby-scoreboard-grid-item"><h1>' . $score2 . '</h1></div>';
				$output .= '<div class="tm-derby-scoreboard-footer"><p><strong>' . $title . '</strong>&nbsp;&nbsp;|&nbsp;&nbsp;' . $formatted_date . '&nbsp;&nbsp;|&nbsp;&nbsp;' . $venue . '&nbsp;&nbsp;|&nbsp;&nbsp;' . $location . '</p></div>';
                $output .= '</div>';	
            } else {
                $output .= '<div class="tm-derby-scoreboard">';
                $output .= '<span class="game-date">' . $date . '</span>: ';
                $output .= '<span class="team">' . $team1 . '</span> ' . $score1 . ' - ' . $score2 . ' <span class="team">' . $team2 . '</span>';
                $output .= '</div>';
            }
        }
        $output .= '</div>'; // Close the container div
        wp_reset_postdata();
    } else {
        $output .= 'No game scores found.';
    }

    return $output;
}
add_shortcode( 'derby_scores', 'tm_derby_scoreboard_shortcode' );

$date = get_post_meta( $post->ID, 'game_date', true );
// Convert date format to "Month Day, Year"
$formatted_date = date('F j, Y', strtotime($date));
$title = get_post_meta( $post->ID, 'game_title', true );
$venue = get_post_meta( $post->ID, 'venue', true );
$location = get_post_meta( $post->ID, 'location', true );
$team1 = get_post_meta( $post->ID, 'team_1', true );
$team1name2 = get_post_meta( $post->ID, 'team_1_name2', true );
$score1 = get_post_meta( $post->ID, 'score_1', true );
$team2 = get_post_meta( $post->ID, 'team_2', true );
$team2name2 = get_post_meta( $post->ID, 'team_2_name2', true );
$score2 = get_post_meta( $post->ID, 'score_2', true );

// Enqueue stylesheet
function tm_derby_scoreboard_enqueue_style() {
    wp_enqueue_style( 'tm-derby-scoreboard-style', plugins_url( 'css/tm-derby-scoreboard-styles.css', __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'tm_derby_scoreboard_enqueue_style' );


// Generate XML document of derby games
function tm_derby_export_xml() {
    // Check if the tm_derby_export parameter is set
    if ( isset( $_GET['tm_derby_scoreboard'] ) && $_GET['tm_derby_scoreboard'] === 'xml' ) {
        $args = array(
            'post_type'      => 'game-score',
            'posts_per_page' => -1,
            'meta_key'       => 'game_date', // Custom field name for the game date
            'orderby'        => 'meta_value', // Order by custom field value
            'order'          => 'DESC', // Order by date in descending order
        );

        $query = new WP_Query( $args );

        if ( $query->have_posts() ) {
            $xml = new XMLWriter();
            $xml->openMemory();
            $xml->setIndent(true);
            $xml->startDocument('1.0', 'UTF-8');
            $xml->startElement('derby_scoreboard');

            while ( $query->have_posts() ) {
                $query->the_post();

                // Get custom field values
                $date = get_post_meta( get_the_ID(), 'game_date', true );
                $title = get_post_meta( get_the_ID(), 'game_title', true );
                $venue = get_post_meta( get_the_ID(), 'venue', true );
                $location = get_post_meta( get_the_ID(), 'location', true );
                $team1fullname = get_post_meta( get_the_ID(), 'team_1_fullname', true );
				$team1 = get_post_meta( get_the_ID(), 'team_1', true );
                $team1name2 = get_post_meta( get_the_ID(), 'team_1_name2', true );
                $score1 = get_post_meta( get_the_ID(), 'score_1', true );
                $team2fullname = get_post_meta( get_the_ID(), 'team_2_fullname', true );
                $team2 = get_post_meta( get_the_ID(), 'team_2', true );
                $team2name2 = get_post_meta( get_the_ID(), 'team_2_name2', true );
                $score2 = get_post_meta( get_the_ID(), 'score_2', true );

                // Check if any of the values are empty
                if ( empty( $score1 ) || empty( $score2 ) ) {
                    continue; // Skip this post if any value is empty
                }

                // Start derby_game element
                if (!$xml->startElement('derby_game')) {
                    continue; // Skip if unable to start element
                }
                $xml->writeAttribute('id', get_the_ID());

                $xml->writeElement('game_date', $date);
                $xml->writeElement('game_title', $title);
                $xml->writeElement('venue', $venue); 
                $xml->writeElement('location', $location); 
                $xml->writeElement('team_1_fullname', $team1fullname); 
                $xml->writeElement('team_1', $team1);            
                $xml->writeElement('team_1_name2', $team1name2);
                $xml->writeElement('score_1', $score1);
				$xml->writeElement('team_2_fullname', $team2fullname); 
                $xml->writeElement('team_2', $team2);
                $xml->writeElement('team_2_name2', $team2name2);
                $xml->writeElement('score_2', $score2);
                $xml->endElement(); // End derby_game
            }

            $xml->endElement(); // End derby_games
            $xml->endDocument();

            // Output XML content
            header('Content-type: text/xml');
            echo $xml->outputMemory(true);
            exit; // Exit to prevent WordPress from rendering anything else
        }

        wp_reset_postdata();
    }
}
add_action( 'template_redirect', 'tm_derby_export_xml' );
