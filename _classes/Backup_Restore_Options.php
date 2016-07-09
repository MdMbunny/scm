<?php

if ( ! class_exists( 'Backup_Restore_Options' ) ) {

	class Backup_Restore_Options {

		function Backup_Restore_Options( $lang = '' ) {

			$this->lang = $lang;
			$this->slug = sanitize_title( get_bloginfo() );
			$this->theme = sanitize_title( get_template() );

			add_action('admin_menu', array(&$this, 'admin_menu'));

		}

		function admin_menu() {
			
			$page = add_submenu_page('tools.php', __('Backup Options', $this->lang), __('Backup Options', $this->lang), 'manage_options', 'backup-options', array(&$this, 'options_page'));
			add_action("load-{$page}", array(&$this, 'import_export'));
		}

		function import_export() {
			global $SCM_siteslug;

			if (isset($_GET['action']) && ($_GET['action'] == 'download')) {
				header("Cache-Control: public, must-revalidate");
				header("Pragma: hack");
				header("Content-Type: text/plain");
				header('Content-Disposition: attachment; filename="' . $this->slug . '-' . $this->theme . '-options-'.date("ymd").'.dat"');
				echo serialize($this->_get_options());
				die();
			}
			if (isset($_POST['upload']) && check_admin_referer($this->theme . '_restoreOptions', $this->theme . '_restoreOptions')) {
				if ($_FILES["file"]["error"] > 0) {
					// error
				} else {
					$options = unserialize(file_get_contents($_FILES["file"]["tmp_name"]));
					if ($options) {
						foreach ($options as $option) {
							update_option($option->option_name, $option->option_value);
						}
					}
				}
				wp_redirect(admin_url('tools.php?page=backup-options'));
				exit;
			}
		}

		function options_page() { ?>

			<div class="wrap">
				<?php screen_icon(); ?>
				<h2>Backup/Restore Theme Options</h2>
				<form action="" method="POST" enctype="multipart/form-data">
					<style>#backup-options td { display: block; margin-bottom: 20px; }</style>
					<table id="backup-options">
						<tr>
							<td>
								<h3>Backup/Export</h3>
								<p>Here are the stored settings for the current theme:</p>
								<p><textarea class="widefat code" rows="20" cols="100" onclick="this.select()"><?php echo serialize($this->_get_options()); ?></textarea></p>
								<p><a href="?page=backup-options&action=download" class="button-secondary">Download as file</a></p>
							</td>
							<td>
								<h3>Restore/Import</h3>
								<p><label class="description" for="upload">Restore a previous backup</label></p>
								<p><input type="file" name="file" /> <input type="submit" name="upload" id="upload" class="button-primary" value="Upload file" /></p>
								<?php if (function_exists('wp_nonce_field')) wp_nonce_field($this->theme . '_restoreOptions', $this->theme . '_restoreOptions'); ?>
							</td>
						</tr>
					</table>
				</form>
			</div>

		<?php }

		function _display_options() {
			$options = unserialize($this->_get_options());
		}

		function _get_options() {
			global $wpdb;
			$options = $wpdb->get_results("SELECT option_name, option_value FROM {$wpdb->options}");
			$new = array();
			foreach ($options as $elem) {
		        if( isset( $elem->option_name ) && strpos( $elem->option_name, 'options_' ) === 0 ) $new[] = $elem;
		    }

		    return $new;
		}
	}
}

?>