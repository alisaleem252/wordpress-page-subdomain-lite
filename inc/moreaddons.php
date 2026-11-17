<div class="wrap">
  <h1 class="wp-heading-inline">More Addons</h1>
  
  <div class="addons-grid">
    <div class="addon-card free">
      <div class="addon-icon">
        <span class="dashicons dashicons-admin-post"></span>
      </div>
      <h3>Post as Subdomain Free</h3>
      <p class="addon-description">Convert one post into subdomain with basic functionality - completely free!</p>
      <p class="addon-example">post-name.site.com</p>
      <button class="button button-primary install-plugin" data-slug="post-as-subdomain-free" data-plugin="post-as-subdomain-free/post.php">
        <span class="button-text">Install Plugin</span>
        <span class="spinner" style="display: none;"></span>
      </button>
    </div>

    <div class="addon-card featured">
      <div class="addon-icon">
        <span class="dashicons dashicons-admin-page"></span>
      </div>
      <h3>WordPress Page as Subdomain Pro</h3>
      <p class="addon-description">Convert thousands of pages into subdomain with single wildcard</p>
      <p class="addon-example">page.site.com</p>
      <a class="button button-primary" target="_blank" href="https://webostock.com/market-item/wordpress-page-subdomain-pro/31776/">Buy Now</a>
    </div>

    <div class="addon-card featured">
      <div class="addon-icon">
        <span class="dashicons dashicons-category"></span>
      </div>
      <h3>WordPress Category Subdomain Pro</h3>
      <p class="addon-description">Convert thousands of category pages into subdomain with single wildcard</p>
      <p class="addon-example">category.site.com/post-name</p>
      <a class="button button-primary" target="_blank" href="https://webostock.com/market-item/wordpress-category-subdomain-pro/3346/">Buy Now</a>
    </div>

    

    <div class="addon-card">
      <div class="addon-icon">
        <span class="dashicons dashicons-products"></span>
      </div>
      <h3>WooCommerce Category Subdomain Pro</h3>
      <p class="addon-description">Convert thousands of WooCommerce Products Category pages into subdomain with single wildcard</p>
      <p class="addon-example">woo-category.site.com/product-name</p>
      <a class="button button-primary" target="_blank" href="https://webostock.com/market-item/woocommerce-category-subdomain-pro/7266/">Buy Now</a>
    </div>

    <div class="addon-card featured">
      <div class="addon-icon">
        <span class="dashicons dashicons-admin-post"></span>
      </div>
      <h3>Posts as Subdomain Pro</h3>
      <p class="addon-description">Convert thousands of posts into subdomain with single wildcard</p>
      <p class="addon-example">post-name.site.com</p>
      <a class="button button-primary" target="_blank" href="https://webostock.com/market-item/wordpress-post-subdomain-pro/31490/">Buy Now</a>
    </div>

    <div class="addon-card upcoming">
      <div class="addon-icon">
        <span class="dashicons dashicons-admin-users"></span>
      </div>
      <h3>Authors as Subdomain Pro</h3>
      <p class="addon-description">Convert thousands of author pages into subdomain with single wildcard</p>
      <p class="addon-example">author.site.com</p>
      <a class="button button-secondary disabled" href="#">Coming Soon</a>
    </div>


    <div class="addon-card free">
      <div class="addon-icon">
        <span class="dashicons dashicons-admin-post"></span>
      </div>
      <h3>AI Post Generator</h3>
      <p class="addon-description">Generate AI-powered content for your posts with ease.</p>
      <p class="addon-example">https://app.rapidtextai.com/</p>
      <button class="button button-primary install-plugin" data-slug="ai-text-block" data-plugin="ai-text-block/rapidtext-ai-text-block.php">
        <span class="button-text">Install Plugin</span>
        <span class="spinner" style="display: none;"></span>
      </button>
    </div>

  </div>
</div>

<style>
.addons-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 20px;
  margin-top: 20px;
}

.addon-card {
  background: #fff;
  border: 1px solid #ddd;
  border-radius: 8px;
  padding: 24px;
  text-align: center;
  transition: all 0.3s ease;
  box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.addon-card:hover {
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  transform: translateY(-2px);
}

.addon-card.featured {
  border-color: #0073aa;
  position: relative;
}

.addon-card.featured::before {
  content: "Popular";
  position: absolute;
  top: -10px;
  left: 20px;
  background: #0073aa;
  color: white;
  padding: 4px 12px;
  border-radius: 4px;
  font-size: 12px;
  font-weight: 600;
}

.addon-card.upcoming {
  opacity: 0.7;
}

.addon-icon {
  width: 60px;
  height: 60px;
  background: #f0f0f1;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 16px;
}

.addon-icon .dashicons {
  font-size: 24px;
  color: #0073aa;
}

.addon-card h3 {
  margin: 0 0 12px;
  font-size: 18px;
  color: #1d2327;
}

.addon-description {
  color: #646970;
  font-size: 14px;
  line-height: 1.4;
  margin: 0 0 12px;
}

.addon-example {
  background: #f6f7f7;
  color: #0073aa;
  font-family: monospace;
  font-size: 12px;
  padding: 8px 12px;
  border-radius: 4px;
  margin: 12px 0 20px;
  font-weight: 600;
}

.addon-card .button {
  width: 100%;
  justify-content: center;
}

.button.disabled {
  pointer-events: none;
  opacity: 0.6;
}

@media (max-width: 768px) {
  .addons-grid {
    grid-template-columns: 1fr;
  }
}


.addon-card.free {
      border-color: #00aa4c;
      position: relative;
    }

    .addon-card.free::before {
      content: "Free";
      position: absolute;
      top: -10px;
      left: 20px;
      background: #00aa4c;
      color: white;
      padding: 4px 12px;
      border-radius: 4px;
      font-size: 12px;
      font-weight: 600;
    }
    .install-plugin .spinner {
    float: none;
    margin: 0 5px 0 0;
    vertical-align: middle;
}

.install-plugin:disabled {
    opacity: 0.6;
    pointer-events: none;
}
</style>

<script>
jQuery(document).ready(function($) {
    function pasfNotice(type, message) {
        $('.pasf-notice').remove();
        $('<div class="notice notice-' + type + ' is-dismissible pasf-notice"></div>').append($('<p>').text(message)).insertAfter('.wp-heading-inline');
    }
    $('.install-plugin').on('click', function(e) {
        e.preventDefault();
        
        var $button = $(this);
        var $spinner = $button.find('.spinner');
        var $text = $button.find('.button-text');
        var slug = $button.data('slug');
        var plugin = $button.data('plugin');
        
        // Disable button and show spinner
        $button.prop('disabled', true);
        $text.text('Installing...');
        $spinner.show();
        
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'install_plugin_ajax',
                plugin_slug: slug,
                plugin_file: plugin,
                nonce: '<?php echo wp_create_nonce('install_plugin_nonce'); ?>'
            },
            success: function(response) {
                if (response.success) {
                    $text.text('Installed & Activated');
                    $button.removeClass('button-primary').addClass('button-secondary');
                    $spinner.hide();
                    
                    // Show success message
                    pasfNotice('success', response.data);
                } else {
                    $text.text('Installation Failed');
                    $button.prop('disabled', false);
                    $spinner.hide();
                    
                    // Show error message
                    pasfNotice('error', response.data);
                }
            },
            error: function() {
                $text.text('Install Plugin');
                $button.prop('disabled', false);
                $spinner.hide();
                
                pasfNotice('error', 'AJAX request failed');
            }
        });
    });
    // Check if plugins are already installed on page load
    $('.install-plugin').each(function() {
      var $button = $(this);
      var plugin = $button.data('plugin');
      
      $.ajax({
        url: ajaxurl,
        type: 'POST',
        data: {
          action: 'check_plugin_status',
          plugin_file: plugin,
          nonce: '<?php echo wp_create_nonce('check_plugin_nonce'); ?>'
        },
        success: function(response) {
          if (response.success && response.data.installed) {
            var $text = $button.find('.button-text');
            if (response.data.active) {
              $text.text('Activated');
              $button.removeClass('button-primary').addClass('button-secondary');
            } else {
              $text.text('Installed');
              $button.removeClass('button-primary').addClass('button-secondary');
            }
            $button.prop('disabled', true);
          }
        }
      });
    });
});
</script>