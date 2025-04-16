<?php

/*
$ vagrant ssh
$ cd $(wp theme path --dir lightning)
$ bash bin/install-wp-tests.sh wordpress_test root 'WordPress' localhost latest
$ phpunit
*/

class VKFS_Deactive_Plugin_Test extends WP_UnitTestCase {
	function test_vkfs_pro_deactivate_plugin() {

		print PHP_EOL;
		print '------------------------------------' . PHP_EOL;
		print 'is_vkfs_deactivate_plugin' . PHP_EOL;
		print '------------------------------------' . PHP_EOL;
        require_once ABSPATH . 'wp-admin/includes/plugin.php';

        update_option( 'active_plugins', array(
			'vk-filter-search/vk-filter-search.php'
		) );
        update_option( 'active_plugins', array(
            'vk-filter-search-pro/vk-filter-search-pro.php'
        ) );
        $this->assertTrue( ! is_plugin_active( 'vk-filter-search/vk-filter-search.php' ) );
        /*
        deactivate_plugins( 'vk-filter-search/vk-filter-search.php' );
        deactivate_plugins( 'vk-filter-search-pro/vk-filter-search-pro.php' );
        activate_plugins( 'vk-filter-search/vk-filter-search.php' );
        activate_plugins( 'vk-filter-search-pro/vk-filter-search-pro.php' );
        $this->assertTrue( ! is_plugin_active( 'vk-filter-search-pro/vk-filter-search-pro.php' ) );
        */        
        update_option( 'active_plugins', array(
			'vk-filter-search/vk-filter-search.php'
		) );
        update_option( 'active_plugins', array(
            'vk-filter-search-pro-global-edition/vk-filter-search-pro-global-edition.php'
        ) );
        /*
        deactivate_plugins( 'vk-filter-search-pro/vk-filter-search-pro.php' );
        deactivate_plugins( 'vk-filter-search-pro-global-edition/vk-filter-search-pro-global-edition.php' );
        activate_plugins( 'vk-filter-search-pro/vk-filter-search-pro.php' );
        activate_plugins( 'vk-filter-search-pro-global-edition/vk-filter-search-pro-global-edition.php' );
        $this->assertTrue( ! is_plugin_active( 'vk-filter-search-pro/vk-filter-search-pro.php' ) );
        */
        $this->assertTrue( ! is_plugin_active( 'vk-filter-search/vk-filter-search.php' ) );
	}
}
