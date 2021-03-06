<?php
/**
 * Shortcode definitions and utils
 *
 * @package dazzling
 */

// Resource list
function resource_list_shortcode( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'title' => ''
	), $atts );
	$title = ($a['title'] == '' ? '' : '<h2 class="resource-title">' . $a['title'] . '</h2>');
	$section_start = '<div class="resources-list">';
	$section_end = '</div>';
	$content = parse_shortcode_content($content);

	return $section_start . $title . '<ul>' . do_shortcode($content) . '</ul>' . $section_end;
}
add_shortcode( 'resource_list', 'resource_list_shortcode' );

// Resource item
function resource_shortcode( $atts ) {
  $a = shortcode_atts( array(
		'title' => '',
    'id' => '',
    'url' => '',
  ), $atts );

	$anchor_start = '&bull;&nbsp; <a title="Opens in New Tab" target="_blank" href="';
	$anchor_end = '">';

	ob_start();
	if ($a['title'] == '') { // Included no title
		return;
	} else if ($a['id'] == '' && $a['url'] == '') { // Included no params
		return;
	} else if ($a['id']== '') { // Included url param
		echo '<li>';
		echo $anchor_start . $a['url'] . $anchor_end . $a['title'] . '</a>';
		echo '</li>';
	} else { // Included ID param
		echo '<li>';
		echo $anchor_start . get_permalink(intval($a['id'])) . $anchor_end . $a['title'] . '</a>';
		echo '</li>';
	}
	return ob_get_clean();
}
add_shortcode( 'resource', 'resource_shortcode' );

// Announcements
function announcements_shortcode( $atts, $content = null ) {
  $a = shortcode_atts( array(
		'title' => ''
  ), $atts );

	$title = ($a['title'] == '' ? '' : '<h2 class="resource-title">' . $a['title'] . '</h2>');
	$section_start = '<div class="resources-announcements">';
	$section_end = '</div>';
	$content = parse_shortcode_content($content);

	return $section_start . $title . do_shortcode($content) . $section_end;
}
add_shortcode( 'announcements', 'announcements_shortcode' );

// Announcement item
function announcement_item_shortcode( $atts, $content = null ) {
  $a = shortcode_atts( array(
		'title' => ''
  ), $atts );

	$title = ($a['title'] == '' ? '' : '<h4 class="resource-title">' . $a['title'] . '</h4>');
	$section_start = '<hr /><p class="resources-announcement">';
	$section_end = '</p>';

	return $section_start . $title . $content . $section_end;
}
add_shortcode( 'announcement', 'announcement_item_shortcode' );

// Calendar agenda
function agenda_shortcode( $atts, $content = null ) {
  $a = shortcode_atts( array(
		'title' => ''
  ), $atts );

	$title = ($a['title'] == '' ? '' : '<strong>' . $a['title'] . '</strong>');
	$section_start = '<ul class="calendar_agenda">';
	$section_end = '</ul>';
	$content = parse_shortcode_content($content);

	return $title . $section_start . do_shortcode($content) . $section_end;
}
add_shortcode( 'agenda', 'agenda_shortcode' );

// Calendar agenda item
function agenda_item_shortcode( $atts, $content = null ) {
  $a = shortcode_atts( array(
		'name' => '',
		'time' => '',
		'location' => ''
  ), $atts );
	$section_start = '<li>';
	$section_end = '</li>';
	$location = ($a['location'] == '' ? '' : ' @ ' . $a['location']);

	return $section_start . $a['name'] . '<br />' . $a['time'] . $location . $section_end;
}
add_shortcode( 'agenda_item', 'agenda_item_shortcode' );

function shortcode_helper( $atts, $content = null ) {
	echo '<br /><div class="postbox-container">';
	echo '<div class="postbox">';
	echo '<h3 class="hndle">Eta Sigma Shortcode Examples</h3>';
	echo '<div class="inside">';

		echo '<h4 style="margin-bottom: 5px;">Agenda Item</h4>';
		echo '[agenda_item name="Publications Commitee" time="Thu 4:30p" location="UCF Student Union"]';
		echo '<h4 style="margin-bottom: 5px;">Resource Item</h4>';
		echo '[resource title="National Song" url="http://localhost/etasigma/wp-content/uploads/2015/04/NationalSong.pdf"]';

	echo '</div></div></div>';
}
add_action( 'edit_form_after_editor', 'shortcode_helper' );

// Helper function for dealing with <p> tags in recursive shortcodes
function parse_shortcode_content( $content ) {

    /* Parse nested shortcodes and add formatting. */
    $content = trim( wpautop( do_shortcode( $content ) ) );

    /* Remove '</p>' from the start of the string. */
    if ( substr( $content, 0, 4 ) == '</p>' )
        $content = substr( $content, 4 );

    /* Remove '<p>' from the end of the string. */
    if ( substr( $content, -3, 3 ) == '<p>' )
        $content = substr( $content, 0, -3 );

    /* Remove any instances of '<p></p>'. */
    $content = str_replace( array( '<p></p>' ), '', $content );

    return $content;
}

function blank($title) {
	return '%s';
}
add_filter('protected_title_format', 'blank');
