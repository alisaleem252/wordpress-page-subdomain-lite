<?php


if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * This class is for admin menu and generating re-write rules remotely from other servers respecting privacy
 */

class PASFsubpageSubdomain{


    function  __construct() {

    //    $this->woofield ='product_cat';

	add_action('admin_menu',array(&$this,'admin_menu'));
	

    }
	function admin_menu(){
		add_submenu_page('edit.php?post_type=page', __( 'Page as Subdomain', 'page-as-subdomain-lite' ), __( 'Subdomain', 'page-as-subdomain-lite' ), 'manage_options', 'page_subdomain', array(&$this,'show_menu'));
	}
	function show_menu(){
		if ( isset( $_POST['spage'], $_POST['_wpnonce'] ) && current_user_can( 'manage_options' ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'pasf_action_savepageid' ) ) {

			$posted  = is_array( $_POST['spage'] ) ? reset( $_POST['spage'] ) : $_POST['spage'];
			$page_id = absint( wp_unslash( $posted ) );
			$valid   = $page_id && 'page' === get_post_type( $page_id ) && 'publish' === get_post_status( $page_id );
			update_option( 'pages_subdomain', $valid ? array( $page_id ) : array( 'no' ) );

			$subscribe_newsletter = isset( $_POST['subscribe_newsletter'] ) ? 1 : 0;
			update_option( 'pagessubdomain_subscribe_newsletter', $subscribe_newsletter );
			if ( $subscribe_newsletter ) {
				$this->subscribe_to_newsletter();
			}
			echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Settings saved.', 'page-as-subdomain-lite' ) . '</p></div>';
		}
        $subscribe_newsletter = get_option('pagessubdomain_subscribe_newsletter', 1);
		$selected_id   = pasf_selected_page_id();
		$selected_slug = pasf_selected_slug();
		$site_host     = preg_replace( '/^www\./i', '', (string) wp_parse_url( home_url(), PHP_URL_HOST ) );
		?>
        <div class="wrap">
            <div class="header-section" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; margin: 0 -20px 30px -20px; border-radius: 8px;">
                <h1 style="margin: 0; font-size: 28px; font-weight: 300;"><?php echo esc_html__("Page as Subdomain Settings",'page-as-subdomain-lite') ?></h1>
                <p style="margin: 10px 0 0 0; opacity: 0.9; font-size: 16px;"><?php echo esc_html__("Convert your pages into subdomains with ease",'page-as-subdomain-lite') ?></p>
            </div>

            <div class="settings-container" style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px; margin-bottom: 30px;">
                <!-- Main Settings Panel -->
                <div class="main-panel" style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 20px rgba(0,0,0,0.08); border: 1px solid #e1e5e9;">
                    <form method="post">
                        <div class="setting-group" style="margin-bottom: 30px;">
                            <h2 style="color: #1e293b; font-size: 20px; margin-bottom: 8px; font-weight: 600;"><?php echo esc_html__("Page Selection",'page-as-subdomain-lite') ?></h2>
                            <p style="color: #64748b; margin-bottom: 20px; font-size: 14px;"><?php echo esc_html__("You can have 1 page as subdomain in the lite version",'page-as-subdomain-lite') ?></p>
                            
                            <label style="display: block; font-weight: 500; color: #374151; margin-bottom: 8px;"><?php echo esc_html__("Select A Page",'page-as-subdomain-lite') ?>:</label>
                            
                            <?php $args = array(
                                'sort_order' => 'asc',
                                'sort_column' => 'post_title',
                                'parent' => 0,
                                'exclude_tree' => '',
                                'number' => '',
                                'post_type' => 'page',
                                'post_status' => 'publish'
                            ); 
                            $pages = get_pages($args); ?>
                            
                            <select name="spage[]" style="width: 100%; padding: 12px 16px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px; background: white; transition: border-color 0.2s;">
                                <option value="no" <?php selected( 0, $selected_id ); ?>><?php echo esc_html__("SELECT A PAGE",'page-as-subdomain-lite') ?></option>
                                <?php foreach ($pages as $page){ ?>
                                <option value="<?php echo (int) $page->ID; ?>" <?php selected( $selected_id, $page->ID ); ?>><?php echo esc_html( $page->post_title ); ?></option>
                                <?php } ?>
                            </select>
                            
                            <?php if ( '' !== $selected_slug ) { ?>
                            <div style="margin-top: 15px; padding: 15px; background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 8px;">
                                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                                    <span class="dashicons dashicons-external" style="color: #0ea5e9;"></span>
                                    <a target="_blank" rel="noopener" href="<?php echo esc_url( ( is_ssl() ? 'https://' : 'http://' ) . $selected_slug . '.' . $site_host ); ?>" style="color: #0ea5e9; text-decoration: none; font-weight: 500;"><?php echo esc_html( $selected_slug . '.' . $site_host ); ?></a>
                                </div>
                                <p style="margin: 0; color: #0c4a6e; font-size: 13px;"><?php echo esc_html__("The subdomain link will not show up in the dashboard, but if you have added this page link in the frontend it will be linked to subdomain, this is to avoid any conflicts.",'page-as-subdomain-lite') ?></p>
                            </div>
                            <?php } ?>
                        </div>

                        <div class="setting-group" style="margin-bottom: 30px;">
                            <h3 style="color: #1e293b; font-size: 16px; margin-bottom: 12px; font-weight: 600;"><?php echo esc_html__("Newsletter",'page-as-subdomain-lite') ?></h3>
                            <label style="display: flex; align-items: flex-start; gap: 12px; cursor: pointer;">
                                <input type="checkbox" name="subscribe_newsletter" <?php checked( 1, (int) $subscribe_newsletter ); ?> style="margin-top: 2px;" />
                                <div>
                                    <span style="font-weight: 500; color: #374151;"><?php echo esc_html__("Subscribe to our Newsletter",'page-as-subdomain-lite') ?></span>
                                    <p style="margin: 5px 0 0 0; color: #64748b; font-size: 13px; line-height: 1.5;"><?php echo esc_html__("Get plugin updates, tips and special offers straight to your inbox using your admin email address.",'page-as-subdomain-lite') ?></p>
                                </div>
                            </label>
                        </div>

                        <?php if ( function_exists('wp_nonce_field') ) wp_nonce_field('pasf_action_savepageid'); ?>
                        
                        <button type="submit" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 14px 28px; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;" 
                            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 20px rgba(102, 126, 234, 0.4)';" 
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                            <?php echo esc_html__("Save Settings",'page-as-subdomain-lite') ?>
                        </button>
                    </form>
                </div>

                <!-- Sidebar Panel -->
                <div class="sidebar-panel">
                    <!-- Freelance Profile Card -->
                    <div style="background: white; padding: 25px; border-radius: 12px; margin-bottom: 20px; text-align: center; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border: 1px solid #e1e5e9;">
                        <div role="img" aria-label="Ali Saleem - WordPress Developer" style="width: 100px; height: 100px; margin: 0 auto 15px; border-radius: 50%; box-shadow: 0 4px 15px rgba(0,0,0,0.15); background-image: url('https://alisaleem252.com/img/portrait1-2.svg'); background-repeat: no-repeat; background-size: auto 100%; background-position: 12.24% 50%;"></div>
                        <h3 style="color: #1e293b; margin: 0 0 15px 0; font-size: 16px; line-height: 1.4;"><?php echo esc_html__("Do you need a Custom WordPress & WooCommerce Development for Complex Business Requirements?",'page-as-subdomain-lite') ?></h3>
                        <a href="https://calendly.com/alisaleem252" target="_blank"
                            style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 12px 20px; border-radius: 6px; text-decoration: none; font-weight: 600; display: inline-block; transition: transform 0.2s; margin-bottom: 10px;"
                            onmouseover="this.style.transform='translateY(-2px)';"
                            onmouseout="this.style.transform='translateY(0)';">
                            <?php echo esc_html__("Book a Meeting",'page-as-subdomain-lite') ?>
                        </a>
                        <div>
                            <a href="https://alisaleem252.com/" target="_blank" style="color: #667eea; text-decoration: none; font-size: 13px; font-weight: 500;"><?php echo esc_html__("View my portfolio",'page-as-subdomain-lite') ?> &rarr;</a>
                        </div>
                    </div>

                    <!-- Upgrade Card -->
                    <div style="background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); color: white; padding: 25px; border-radius: 12px; margin-bottom: 20px; text-align: center;">
                        <div style="background: rgba(255,255,255,0.2); width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                            <span class="dashicons dashicons-star-filled" style="font-size: 24px;"></span>
                        </div>
                        <h3 style="margin: 0 0 10px 0; font-size: 18px;"><?php echo esc_html__("Upgrade to Pro",'page-as-subdomain-lite') ?></h3>
                        <p style="margin: 0 0 20px 0; opacity: 0.9; font-size: 14px;"><?php echo esc_html__("Convert unlimited pages to subdomains with wildcard support",'page-as-subdomain-lite') ?></p>
                        <a href="https://webostock.com/market-item/wordpress-page-subdomain-pro/31776/" target="_blank" 
                            style="background: white; color: #f59e0b; padding: 12px 20px; border-radius: 6px; text-decoration: none; font-weight: 600; display: inline-block; transition: transform 0.2s;"
                            onmouseover="this.style.transform='translateY(-2px)';" 
                            onmouseout="this.style.transform='translateY(0)';">
                            <?php echo esc_html__("Upgrade Now",'page-as-subdomain-lite') ?>
                        </a>
                    </div>

                    <!-- Configuration Info -->
                    <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border: 1px solid #e1e5e9;">
                        <h3 style="color: #1e293b; margin: 0 0 15px 0; font-size: 16px;"><?php echo esc_html__("WildCard Configuration",'page-as-subdomain-lite') ?></h3>
                        <p style="margin: 0 0 15px 0; color: #64748b; font-size: 13px; line-height: 1.5;">
                            <?php echo sprintf( __( 'Get %1$sPremium Version%2$s with unlimited pages as subdomain. Learn how to configure WildCard Subdomain %3$shere%4$s', 'page-as-subdomain-lite' ), 
                            '<a target="_blank" href="https://webostock.com/market-item/wordpress-page-as-subdomain-pro/8860/" style="color: #0ea5e9; text-decoration: none;">', 
                            '</a>', 
                            '<a target="_blank" rel="noopener" href="https://wordpress.org/documentation/article/configuring-wildcard-subdomains/" style="color: #0ea5e9; text-decoration: none;">', 
                            '</a>' );?>
                        </p>
                    </div>
                    <!-- Review Request -->
                    <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border: 1px solid #e1e5e9; margin-top: 20px;">
                        <h3 style="color: #1e293b; margin: 0 0 15px 0; font-size: 16px; display: flex; align-items: center; gap: 8px;">
                            <span class="dashicons dashicons-star-filled" style="color: #fbbf24;"></span>
                            <?php echo esc_html__("Love this plugin?",'page-as-subdomain-lite') ?>
                        </h3>
                        <p style="margin: 0 0 15px 0; color: #64748b; font-size: 13px; line-height: 1.5;">
                            <?php echo esc_html__("Help us spread the word! Your review helps other users discover this plugin and motivates us to keep improving it.",'page-as-subdomain-lite') ?>
                        </p>
                        <a href="https://wordpress.org/plugins/page-as-subdomain-lite/#reviews" target="_blank" 
                            style="background: #fbbf24; color: white; padding: 10px 16px; border-radius: 6px; text-decoration: none; font-weight: 500; font-size: 13px; display: inline-block; transition: transform 0.2s;"
                            onmouseover="this.style.transform='translateY(-1px)'; this.style.background='#f59e0b';" 
                            onmouseout="this.style.transform='translateY(0)'; this.style.background='#fbbf24';">
                            ⭐ <?php echo esc_html__("Write a Review",'page-as-subdomain-lite') ?>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Video Tutorial Section -->
            <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 20px rgba(0,0,0,0.08); border: 1px solid #e1e5e9;">
                <h2 style="color: #1e293b; margin: 0 0 20px 0; font-size: 20px; font-weight: 600; display: flex; align-items: center; gap: 10px;">
                    <span class="dashicons dashicons-video-alt3" style="color: #ef4444;"></span>
                    <?php echo esc_html__("How to use this plugin",'page-as-subdomain-lite') ?>?
                </h2>
                <div style="position: relative; width: 100%; height: 0; padding-bottom: 56.25%; border-radius: 8px; overflow: hidden;">
                    <iframe style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" 
                        src="https://www.youtube.com/embed/MOWZXJz17-I" 
                        frameborder="0" 
                        allow="autoplay; encrypted-media" 
                        allowfullscreen>
                    </iframe>
                </div>
            </div>

            <style>
                .wrap select:focus {
                    border-color: #667eea !important;
                    outline: none;
                    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
                }
                .wrap input[type="checkbox"]:focus {
                    outline: 2px solid #667eea;
                    outline-offset: 2px;
                }
                @media (max-width: 768px) {
                    .settings-container {
                        grid-template-columns: 1fr !important;
                    }
                }
            </style>
        </div>
        <?php require_once(pageassubdomainPATH.'/inc/moreaddons.php');
	}






    /**
     * Subscribes the site admin email to the newsletter via a proxy that keeps the Sendy API key off the client.
     * Sent once per admin email address, not on every save.
     */
    function subscribe_to_newsletter(){
        $admin_email = sanitize_email( get_option('admin_email') );
        if ( ! is_email( $admin_email ) || get_option('pagessubdomain_subscribed_email') === $admin_email ) {
            return;
        }
        $current_user = wp_get_current_user();
        $name = ( $current_user && $current_user->display_name ) ? $current_user->display_name : get_bloginfo('name');

        wp_remote_post('https://alisaleem252.com/api/subscribe.php', array(
            'timeout'  => 15,
            'blocking' => false,
            'body'     => array(
                'name'  => $name,
                'email' => $admin_email,
            ),
        ) );
        update_option('pagessubdomain_subscribed_email', $admin_email);
    }
}
