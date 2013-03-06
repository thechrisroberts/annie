<?php
/*
Plugin Name: Annie
Plugin URI: http://croberts.me/annie/
Description: Provides comprehensive annotation tools for WordPress posts.
Version: 1.4.6
Author: Chris Roberts
Author URI: http://croberts.me/
*/

/*  Copyright 2012 Chris Roberts (email : columcille@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

// Add to the Admin function list
if (! function_exists('annie_addoptions')) {
  function annie_addoptions() {
    if (function_exists('add_options_page')) {
      add_options_page('Annie Plugin Options', 'Annie', 'manage_options', basename(__FILE__), 'annie_options_subpanel');
    }
  }
}

if (! function_exists('annie_options_subpanel')) {
  function annie_options_subpanel() {
    global $wpdb, $table_prefix;

    if (isset($_POST['info_update'])) {
		update_option('annie_footnoteDisplay', $_POST['annie_footnoteDisplay']);
		update_option('annie_footnoteShowNotes', $_POST['annie_footnoteShowNotes']);
		update_option('annie_footnoteNotesHeader', $_POST['annie_footnoteNotesHeader']);
		update_option('annie_defaultHighlight', $_POST['annie_defaultHighlight']);
		update_option('annie_defaultHighlightCustom', $_POST['annie_defaultHighlightCustom']);
		update_option('annie_showToolbox', $_POST['annie_showToolbox']);
		
		echo '<div class="updated"><p><strong>Your options have been updated.</strong></p></div>';
    }
?>

<style type="text/css">
	div.annieOptionSection {
		margin: 10px 0 20px 10px;
		width: 800px;
	}
	
	span.annieOptionLabel {
		font-size: 16px;
	}
	
	div.annieOptions {
		margin-left: 15px;
	}
	
	div.annieOptionLeft {
		width: 125px;
		float: left;
	}
	
	div.annieOptionRight {
		float: left;
	}
	
	div.clearOptions {
		margin-bottom: 5px;
		clear: both;
	}
</style>

<div class="wrap">
	<h2>Annie Options</h2>
	<br />
	<form method="post">

	<span class="annieOptionLabel">Annie Footnote Display Options</span><br />
	<div class="annieOptionSection">
	   <div class="annieOptions">
        	Should the footnote references be simple links or tooltips + links? (Tooltip requires <a href="http://croberts.me/tippy/">Tippy</a>)<br /><br />
			<input id="annie_footnote_link" name="annie_footnoteDisplay"  type="radio" value="link" <?php if (get_option('annie_footnoteDisplay', 'link') == "link") echo "checked" ?> />
				<label for="annie_footnote_link" title="Link only">
					Footnote references are simple links
				</label><br />

			<input id="annie_footnote_tooltip" name="annie_footnoteDisplay" type="radio" value="tooltip" <?php if (get_option('annie_footnoteDisplay', 'link') == "tooltip") echo "checked" ?> />
				<label for="annie_footnote_tooltip" title="Use Tooltip + link">
					Footnote references show a tooltip (Requires <a href="http://croberts.me/tippy/">Tippy</a>)
				</label><br /><br />
		</div>
		
		<div class="annieOptions">
			<input id="annie_footnote_showNotes" name="annie_footnoteShowNotes"  type="checkbox" value="show" <?php if (get_option('annie_footnoteShowNotes', 'show') == "show") echo "checked" ?> />
			
			<label for="annie_footnote_showNotes" title="Show Notes in Post">
				Footnote text should be included in the post. You might turn this off when using Tippy if you want to only display notes in the popup.
			</label><br /><br />
		</div>
		
		<div class="annieOptions">
        	What should be the header text for your footnotes at the bottom of the post:<br />
			<label for="annie_footnoteNotesHeader" title="Footnote Header Text">
				Footnote Header Text: 
			</label>
			<input id="annie_footnoteNotesHeader" name="annie_footnoteNotesHeader" size="20" type="text" value="<?php echo get_option('annie_footnoteNotesHeader', 'Notes:'); ?>" /><br />
			
		</div>
		
	</div>
	
	<span class="annieOptionLabel">Annie Highlighting Display Options</span><br />
	<div class="annieOptionSection">
		<div class="annieOptions">
        	What should be the default highlighting style?<br /><br />
			<input id="annie_defaultHighlight_yellow" name="annie_defaultHighlight"  type="radio" value="yellow" <?php if (get_option('annie_defaultHighlight', 'yellow') == "yellow") echo "checked" ?> />
				<label for="annie_defaultHighlight_yellow">
					<span class="annie_hilight_yellow">Yellow</span> highlighting style
				</label><br />
			
			<input id="annie_defaultHighlight_red" name="annie_defaultHighlight"  type="radio" value="red" <?php if (get_option('annie_defaultHighlight', 'yellow') == "red") echo "checked" ?> />
				<label for="annie_defaultHighlight_red">
					<span class="annie_hilight_red">Red</span> highlighting style
				</label><br />
			
			<input id="annie_defaultHighlight_green" name="annie_defaultHighlight"  type="radio" value="green" <?php if (get_option('annie_defaultHighlight', 'yellow') == "green") echo "checked" ?> />
				<label for="annie_defaultHighlight_green">
					<span class="annie_hilight_green">Green</span> highlighting style
				</label><br />
			
			<input id="annie_defaultHighlight_blue" name="annie_defaultHighlight"  type="radio" value="blue" <?php if (get_option('annie_defaultHighlight', 'yellow') == "blue") echo "checked" ?> />
				<label for="annie_defaultHighlight_blue">
					<span class="annie_hilight_blue">Blue</span> highlighting style
				</label><br />
			
			<input id="annie_defaultHighlight_yellow_underline" name="annie_defaultHighlight"  type="radio" value="yellow_underline" <?php if (get_option('annie_defaultHighlight', 'yellow') == "yellow_underline") echo "checked" ?> />
				<label for="annie_defaultHighlight_yellow_underline">
					<span class="annie_hilight_yellow_underline">Yellow Underline</span> highlighting style
				</label><br />
			
			<input id="annie_defaultHighlight_red_underline" name="annie_defaultHighlight"  type="radio" value="red_underline" <?php if (get_option('annie_defaultHighlight', 'yellow') == "red_underline") echo "checked" ?> />
				<label for="annie_defaultHighlight_red_underline">
					<span class="annie_hilight_red_underline">Red Underline</span> highlighting style
				</label><br />
			
			<input id="annie_defaultHighlight_green_underline" name="annie_defaultHighlight"  type="radio" value="green_underline" <?php if (get_option('annie_defaultHighlight', 'yellow') == "green_underline") echo "checked" ?> /> 
				<label for="annie_defaultHighlight_green_underline">
					<span class="annie_hilight_green_underline">Green Underline</span> highlighting style
				</label><br />
			
			<input id="annie_defaultHighlight_blue_underline" name="annie_defaultHighlight"  type="radio" value="blue_underline" <?php if (get_option('annie_defaultHighlight', 'yellow') == "blue_underline") echo "checked" ?> />
				<label for="annie_defaultHighlight_blue_underline">
					<span class="annie_hilight_blue_underline">Blue Underline</span> highlighting style
				</label><br />
			
			<input id="annie_defaultHighlight_custom" name="annie_defaultHighlight"  type="radio" value="custom" <?php if (get_option('annie_defaultHighlight', 'yellow') == "custom") echo "checked" ?> />
				<label for="annie_defaultHighlight_custom">
					Custom
				</label>
				
				<input id="annie_defaultHighightCustom" name="annie_defaultHighlightCustom" size="20" type="text" value="<?php echo get_option('annie_defaultHighlightCustom', ''); ?>" /><br />
				<br />
				
			To add a custom style, it needs to be called something like <i>annie_hilight_yourstyle</i> in your stylesheet and in the box above enter <i>yourstyle</i>. The style name in your stylesheet must begin with <i>annie_hilight_</i> and in the box above only enter the part that comes after <i>annie_hilight_</i>. I.e., for a style called <i>annie_hilight_yellow_red</i>, you would put <i>yellow_red above</i>.<br />
		</div>
		
	</div>
	
	<span class="annieOptionLabel">Annie Toolbox Options</span><br />
	<div class="annieOptionSection">
	   <div class="annieOptions">
        	Do you want to display the Annie toolbox at the bottom of the screen? The toolbox allows users to turn highlighting on and off. It also allows users to view just the highlighted text. The toolbox will only display if there is highlighted text. Styling can be adjusted in your stylesheet.<br /><br />
			<input id="annie_showToolbox_true" name="annie_showToolbox"  type="radio" value="true" <?php if (get_option('annie_showToolbox', 'true') == "true") echo "checked" ?> />
				<label for="annie_showToolbox_true">
					Show the toolbox
				</label><br />

			<input id="annie_showToolbox_false" name="annie_showToolbox" type="radio" value="false" <?php if (get_option('annie_showToolbox', 'true') == "false") echo "checked" ?> />
				<label for="annie_showToolbox_false">
					Do not show the toolbox
				</label><br /><br />
		</div>
		
	</div>

    <input type="submit" name="info_update" value="Update Options" /><br /><br />

	</form>
</div>

<?php
  }
}

$annie_highlightText = array();
if (! function_exists('annie_highlight_shortcode')) {
	function annie_highlight_shortcode($annie_attributes, $annieText = '')
	{
		global $annie_highlightText;
		
		$default_style = get_option('annie_defaultHighlight', 'yellow');
		
		if ($default_style == "custom") {
			$default_style = get_option('annie_defaultHighlightCustom', 'yellow');
		}
		
		extract( shortcode_atts( array(
			'style' => $default_style
		), $annie_attributes ) );
		
		$hilight_text = '<span id="" class="annie_hilight_'. $style .' annie_custom annie_highlightText" highlight="annie_hilight_'. $style .'">'. $annieText .'</span>';
		$annie_highlightText[] = $annieText;
		
		// Take care of any nested shortcodes
		$hilight_text = do_shortcode($hilight_text);
		
		$annie_showToolbox = true;
		
		return $hilight_text;
	}
}

if (! function_exists('annie_footnote_shortcode')) {
	// Keep track of how many footnotes we've added
	$annie_footcount = 1;
	$annie_footnoteText = array();
	
	function annie_footnote_shortcode($annie_attributes, $annieText = '')
	{
		global $annie_footcount, $annie_footnoteText, $annie_showToolbox, $post;
		
		// Store the text in our array
		$annie_footnoteText[$annie_footcount] = $annieText;
		
		// No markup for footnotes; just the text.
		$annieShortcodeText = do_shortcode($annieText);
		$annie_cleanText = strip_tags($annieShortcodeText);
		
		$annie_cleanText = str_replace('[', '{', $annie_cleanText);
		
		// Format the footnote reference
		if (function_exists('tippy_getLink') && get_option('annie_footnoteDisplay', 'link') == 'tooltip') {
			$annie_footnoteLink = get_permalink($post->ID) ."#foot_text_". $post->ID . "_". $annie_footcount;
			
			$annie_tippyValues = array(
				'header' => 'off',
				'title' => tippy_format_title($annie_footcount),
				'href' => $annie_footnoteLink,
				'text' => tippy_format_text($annie_cleanText),
				'class' => 'annie_footnoteRef annie_custom',
				'item' => 'foot_tip_'. $post->ID . "_". $annie_footcount
			);
			
			$annie_returnLink = tippy_getLink($annie_tippyValues);
			
			$annie_returnLink = str_replace('<a ', '<a name="foot_loc_'. $post->ID . '_'. $annie_footcount .'" ', $annie_returnLink);
		} else {
			$annie_returnLink = '<a name="foot_loc_'. $post->ID . '_'. $annie_footcount .'" class="annie_footnoteRef annie_custom" title="'. $annie_cleanText .'" href="'. get_permalink($post->ID) .'#foot_text_'. $post->ID . '_'. $annie_footcount .'">'. $annie_footcount .'</a>';
		}
		
		$annie_footcount++;
		$annie_showToolbox = true;
		
		return $annie_returnLink;
	}
}

if (! function_exists('annie_footnote_display_shortcode')) {
	$annie_footnotesShowing = false;
	
	function annie_footnote_display_shortcode($annie_attributes = '', $annie_text = '')
	{
		global $annie_footnotesShowing;
		
		$annie_returnText = annie_process_content('');
		
		$annie_footnotesShowing = true;
		
		return $annie_returnText;
	}
}

if (! function_exists('annie_process_content')) {
	// Handle extras when showing content
	function annie_process_content($content)
	{
		global $annie_footnotesShowing, $annie_footnoteText, $annie_footcount, $post, $is_page_val;
		
		if (!$annie_footnotesShowing && (is_single() || $is_page_val) && get_option('annie_footnoteShowNotes', 'show') == 'show' && sizeof($annie_footnoteText) > 0) {
			$footnoteHeader = get_option('annie_footnoteNotesHeader', 'Notes:');
			$content .= '<div class="annie_notes annie_custom"><span class="annie_noteHeader annie_custom">'. $footnoteHeader .'</span><br />';
			
			foreach ($annie_footnoteText as $footnoteIndex => $footnoteText) {
				$content .= "\n";
				$content .= '<div class="annie_note_container"><a name="foot_text_'. $post->ID . '_'. $footnoteIndex .'" href="#foot_loc_'. $post->ID . '_'. $footnoteIndex .'">'. $footnoteIndex .'</a>. '. $footnoteText .'</div>';
				$content .= "\n";
			}
			
			$content .= '</div>';
		}
		
		$annie_footnoteText = array();
		$annie_footcount = 1;
		
		return $content;
	}
}

if (! function_exists('annie_toolbox')) {
	function annie_toolbox()
	{
		global $annie_highlightText;
		
		if (sizeof($annie_highlightText) > 0) {
			annie_show_toolbox();
			
			echo '<div id="annie_highlightTextBox">';
			
			// Output the div with highlights
			foreach ($annie_highlightText as $discard => $annie_text)
			{
				echo $annie_text ."<br /><br />";
			}
			echo '</div>';
		}
	}
}

if (! function_exists('annie_show_toolbox')) {
	$annie_toolboxShowing = false;
	function annie_show_toolbox()
	{
		global $annie_toolboxShowing, $annie_highlightText;
		
		if (!$annie_toolboxShowing && get_option('annie_showToolbox', 'true') == "true")
		{
			// Toolbox code
			$annie_toolboxMarkup = '
<div id="annie_toolbox" showing="full">
	<a id="annie_toggle_highlight" class="annie_toggle" onclick="annie_toggleHighlights(\''. plugins_url() .'\');"><img style="width: 14px; height: 14px;" src="' . plugins_url() . '/annie/images/star_green.png" alt="Hide Highlights" title="Hide Highlights" /></a> <a class="annie_toggle" onclick="annie_showHighlights();"><img style="width: 14px; height: 14px;" src="' . plugins_url() . '/annie/images/comments.png" alt="Read Highlighted Text" title="Read Highlighted Text" /></a>
	<div id="annie_toolbox_toggle" onclick="annie_toggleToolbox();">&laquo;</div>
</div>
';
			
			echo $annie_toolboxMarkup;
			
			$annie_toolboxShowing = true;
		}
	}
}

if (! function_exists('annie_load_scripts')) {
	function annie_load_scripts()
	{
		// Load jQuery, if not already present
		wp_enqueue_script('jquery');
		
		// Load the Tippy script
		wp_register_script('Annie', plugins_url() .'/annie/annie.js', array('jquery'));
		wp_enqueue_script('Annie');
	}
}

if (! function_exists('annie_load_styles')) {
	function annie_load_styles()
	{
		wp_register_style('Annie', plugins_url() .'/annie/annie.css');
		wp_enqueue_style('Annie');
	}
}

if (! function_exists('annie_load_for_admin'))
{
	function annie_load_for_admin()
	{
		echo '<link rel="stylesheet" type="text/css" href="'. plugins_url() .'/annie/annie.css">';
	}
}

// Need this to test if we are on a single page. Since is_page() doesn't
// work inside the loop, grab the val at wp_head.
if (! function_exists('annie_load_globals'))
{
	$is_page_val = false;
	
	function annie_load_globals()
	{
		global $is_page_val;
		$is_page_val = is_page();
	}
}

add_action('wp_print_styles', 'annie_load_styles');
add_action('wp_print_scripts', 'annie_load_scripts');

add_shortcode('hi', 'annie_highlight_shortcode');
add_shortcode('foot', 'annie_footnote_shortcode');
add_shortcode('footnotes', 'annie_footnote_display_shortcode');

add_filter('the_content', 'annie_process_content', 20);
add_action('wp_footer', 'annie_toolbox');

add_action('admin_menu', 'annie_addoptions');
add_action('admin_head', 'annie_load_for_admin');

add_action('wp_head', 'annie_load_globals');
?>