<?php

/**
 * Virtual Robots.txt - Admin - Admin class
 *
 * @package Virtual Robots.txt
 * @subpackage Virtual Robots.txt Admin
 */
class VRTRBT_Admin {



	/**
	 * Main admin form
	 */
	public static function form() {

		// Dependencies
		require_once(VRTRBT_PATH.'/core/robots.php');

		// Check form submit
		if (isset($_POST['vrtrbt-nonce'])) {

			// Check valid nonce
			if (!wp_verify_nonce($_POST['vrtrbt-nonce'], VRTRBT_FILE)) {
				$error = 'Invalid security code, please try to submit the form again.';

			// Valid
			} else {

				// Attempt to remove physical file
				if (!VRTRBT_Core_Robots::remove_robotstxt_file())
					$warning = 'Unable to remove the physical robots.txt file in:<br />'.VRTRBT_Core_Robots::robotstxt_path().'<br />Please check file or directory permissions.';

				// Save content
				VRTRBT_Core_Robots::set_value(trim($_POST['vrtrbt-content']));

				// Done
				$success = true;
			}
		}

		// Current URL status
		$robotstxt_url = home_url('robots.txt');
		$robotstxt_file = file_exists(VRTRBT_Core_Robots::robotstxt_path())? 'physical file' : 'virtual file';

		?><div class="wrap">

			<h1>Virtual Robots.txt</h1>

			<?php if (isset($success)) : ?><div class="notice notice-success"><p>Data saved successfully.</p></div><?php endif; ?>

			<?php if (isset($error)) : ?><div class="notice notice-error"><p><?php echo $error; ?></p></div><?php endif; ?>

			<?php if (isset($warning)) : ?><div class="notice notice-warning"><p><?php echo $warning; ?></p></div><?php endif; ?>

			<form method="post">

				<input type="hidden" name="vrtrbt-nonce" value="<?php echo wp_create_nonce(VRTRBT_FILE); ?>" />

				<p><textarea name="vrtrbt-content" class="regular-text" rows="25" style="width: 600px;"><?php echo esc_html(VRTRBT_Core_Robots::get_value()); ?></textarea></p>

				<p>Current robots.txt URL:<br />
				<a href="<?php echo esc_url($robotstxt_url); ?>" target="_blank"><?php echo esc_html($robotstxt_url); ?></a> &nbsp; <strong>(<?php echo $robotstxt_file; ?>)</strong></p>

				<ul>
					<li>When you click <strong><?php esc_attr_e( 'Save' ); ?></strong>, any physical robots.txt in your server root will be permanently deleted.</li>
					<li>When using this function, the "Search Engine Visibility" <a href="<?php echo esc_url(admin_url( 'options-reading.php' )); ?>" target="_blank">setting</a> will be ignored.</li>
					<li>Need advice? Check this <a href="<?php echo esc_url( 'https://www.littlebizzy.com/blog/robots-txt' ); ?>" target="_blank">blog post</a> for recommended robots.txt settings.</li>
				</ul>

				<p><input type="submit" class="button button-primary" value="<?php esc_attr_e( 'Save' ); ?>" /></p>

			</form>

		</div><?php
	}



}
