<?php

/**
  ReduxFramework Sample Config File
  For full documentation, please visit: https://docs.reduxframework.com
 * */

if (!class_exists('welcome_Redux_Framework_config')) {

    class welcome_Redux_Framework_config {

        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if (!class_exists('ReduxFramework')) {
                return;
            }

            // This is needed. Bah WordPress bugs.  ;)
            if ( true == Redux_Helpers::isTheme( __FILE__ ) ) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }

        }

        public function initSettings() {

            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            // If Redux is running as a plugin, this will remove the demo notice and links
            add_action( 'redux/loaded', array( $this, 'remove_demo' ) );
            
            // Function to test the compiler hook and demo CSS output.
            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
            //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 2);
            
            // Change the arguments after they've been declared, but before the panel is created
            //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
            
            // Change the default value of a field after it's been set, but before it's been useds
            //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
            
            // Dynamically add a section. Can be also used to modify sections/fields
            //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        /**

          This is a test function that will let you see when the compiler hook occurs.
          It only runs if a field	set with compiler=>true is changed.

         * */
        function compiler_action($options, $css) {
            //echo '<h1>The compiler hook has run!';
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )

            /*
              // Demo of how to use the dynamic CSS and write your own static CSS file
              $filename = dirname(__FILE__) . '/style' . '.css';
              global $wp_filesystem;
              if( empty( $wp_filesystem ) ) {
                require_once( ABSPATH .'/wp-admin/includes/file.php' );
              WP_Filesystem();
              }

              if( $wp_filesystem ) {
                $wp_filesystem->put_contents(
                    $filename,
                    $css,
                    FS_CHMOD_FILE // predefined mode settings for WP files
                );
              }
             */
        }

        /**

          Custom function for filtering the sections array. Good for child themes to override or add to the sections.
          Simply include this function in the child themes functions.php file.

          NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
          so you must use get_template_directory_uri() if you want to use any of the built in icons

         * */
        function dynamic_section($sections) {
            //$sections = array();
            $sections[] = array(
                'title' => __('Section via hook', 'welcome'),
                'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'welcome'),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }

        /**

          Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.

         * */
        function change_arguments($args) {
            //$args['dev_mode'] = true;

            return $args;
        }

        /**

          Filter hook for filtering the default value of any given field. Very useful in development mode.

         * */
        function change_defaults($defaults) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }

        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {

            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::instance(), 'plugin_metalinks'), null, 2);

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
            }
        }

        public function setSections() {

            /**
              Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
            $sample_patterns_path   = ReduxFramework::$_dir . '../sample/patterns/';
            $sample_patterns_url    = ReduxFramework::$_url . '../sample/patterns/';
            $sample_patterns        = array();

            if (is_dir($sample_patterns_path)) :

                if ($sample_patterns_dir = opendir($sample_patterns_path)) :
                    $sample_patterns = array();

                    while (( $sample_patterns_file = readdir($sample_patterns_dir) ) !== false) {

                        if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
                            $name = explode('.', $sample_patterns_file);
                            $name = str_replace('.' . end($name), '', $sample_patterns_file);
                            $sample_patterns[]  = array('alt' => $name, 'img' => $sample_patterns_url . $sample_patterns_file);
                        }
                    }
                endif;
            endif;

            ob_start();

            $ct             = wp_get_theme();
            $this->theme    = $ct;
            $item_name      = $this->theme->get('Name');
            $tags           = $this->theme->Tags;
            $screenshot     = $this->theme->get_screenshot();
            $class          = $screenshot ? 'has-screenshot' : '';

            $customize_title = sprintf(__('Customize &#8220;%s&#8221;', 'welcome'), $this->theme->display('Name'));
            
            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                        </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                <?php endif; ?>

                <h4><?php echo $this->theme->display('Name'); ?></h4>

                <div>
                    <ul class="theme-info">
                        <li><?php printf(__('By %s', 'welcome'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(__('Version %s', 'welcome'), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . __('Tags', 'welcome') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo $this->theme->display('Description'); ?></p>
            <?php
            if ($this->theme->parent()) {
                printf(' <p class="howto">' . __('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.') . '</p>', __('http://codex.wordpress.org/Child_Themes', 'welcome'), $this->theme->parent()->display('Name'));
            }
            ?>

                </div>
            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();

            $sampleHTML = '';
            if (file_exists(dirname(__FILE__) . '/info-html.html')) {
                /** @global WP_Filesystem_Direct $wp_filesystem  */
                global $wp_filesystem;
                if (empty($wp_filesystem)) {
                    require_once(ABSPATH . '/wp-admin/includes/file.php');
                    WP_Filesystem();
                }
                $sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__) . '/info-html.html');
            }

            // ACTUAL DECLARATION OF SECTIONS
            $this->sections[] = array(
                'title'     => __('Home Settings', 'welcome'),
                
                'icon'      => 'el-icon-home',
                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                'fields'    => array(

                   
                    array(
                        'id'        => 'logo',
                        'type'      => 'media',
                        'url'       => true,
                        'title'     => __('Upload Logo', 'welcome'),
                        'compiler'  => 'true',
                        //'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                        //'desc'      => __('Basic media uploader with disabled URL input field.', 'welcome'),
                        'subtitle'  => __('Upload logo for your website', 'welcome'),
                        'default'   => '',
                        //'hint'      => array(
                        //    'title'     => 'Hint Title',
                        //    'content'   => 'This is a <b>hint</b> for the media field with a Title.',
                        //)
                    ),
                    array(
                        'id'        => 'section-media-end',
                        'type'      => 'section',
                        'indent'    => false // Indent all options below until the next 'section' option is set.
                    ),
                   
                  
                    array(
                        'id'        => 'defaulthumb',
                        'type'      => 'media',
                        'url'       => true,
                        'title'     => __('Default Thumbnail', 'welcome'),
                        'compiler'  => 'true',
                        //'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                        //'desc'      => __('Basic media uploader with disabled URL input field.', 'welcome'),
                        'subtitle'  => __('Upload Default Thumbnail for Posts', 'welcome'),
                        'default'   => array('url' => get_template_directory_uri()  . '/images/thumb.jpg' ),
                        //'hint'      => array(
                        //    'title'     => 'Hint Title',
                        //    'content'   => 'This is a <b>hint</b> for the media field with a Title.',
                        //)
                    ),
                  
                   
                /*****    array(
                        'id'        => 'opt-presets',
                        'type'      => 'image_select',
                        'presets'   => true,
                        'title'     => __('Preset', 'welcome'),
                        'subtitle'  => __('This allows you to set a json string or array to override multiple preferences in your theme.', 'welcome'),
                        'default'   => 0,
                        'desc'      => __('This allows you to set a json string or array to override multiple preferences in your theme.', 'welcome'),
                        'options'   => array(
                            '1'         => array('alt' => 'Preset 1', 'img' => ReduxFramework::$_url . '../sample/presets/preset1.png', 'presets' => array('switch-on' => 1, 'switch-off' => 1, 'switch-custom' => 1)),
                            '2'         => array('alt' => 'Preset 2', 'img' => ReduxFramework::$_url . '../sample/presets/preset2.png', 'presets' => '{"slider1":"1", "slider2":"0", "switch-on":"0"}'),
                        ),
                    ), ***/
					
					  array(
                        'id'        => 'welcome-typography',
                        'type'      => 'typography',
                        'title'     => __('Body Font', 'welcome'),
                        'subtitle'  => __('Change Website Fonts', 'welcome'),
                        'description'  => __('<div class="pro"><a href="http://www.insertcart.com/welcome" title="insertcart.com">Upgrade to Pro</a> Version and Get Access to 500+ Google Fonts </div> ', 'welcome'),
                        'google'    => false,
						 'line-height'   => false,
						 'text-align'   => false,
                        'default'   => array(
                            'color'         => '#474747',
                            'font-size'     => '15px',
                            'font-family'   => 'Verdana, Geneva, sans-serif',
                            'font-weight'   => 'Normal',
                        ),
                    ),
					
					 array(
                        'id'        => 'copyright',
                        'type'      => 'textarea',
                        'title'     => __('<div class="protext">Footer Copyright Text</div>', 'welcome'),
                        'subtitle'  => __('<div class="protext">Put copyright Text HTML allowed here</div>', 'welcome'),
                        'validate'  => 'html', //see http://codex.wordpress.org/Function_Reference/wp_kses_post
                        'default'   => '....Pro Users Only... Copyright  &#169; 2014 Theme: <a href="http://www.insertcart.com/welcome" title="insertcart.com">Welcome</a> '
                    ),
                ),
            );

            $this->sections[] = array(
                'type' => 'divide',
            );

          

            $this->sections[] = array(
                'icon'      => 'el-icon-website',
                'title'     => __('Styling Options', 'welcome'),
                'fields'    => array(
				
				
                    array(
                        'id'        => 'opt-textarea',
                        'type'      => 'textarea',
                        'required'  => array('layout', 'equals', '1'),
                        'title'     => __('Tracking Code', 'welcome'),
                        'subtitle'  => __('Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.', 'welcome'),
                        'validate'  => 'js',
                        'desc'      => 'Validate that it\'s javascript!',
                    ),
                    array(
                        'id'        => 'csseditor',
                        'type'      => 'ace_editor',
                        'title'     => __('CSS Code', 'welcome'),
                        'subtitle'  => __('Paste your CSS code here.', 'welcome'),
                        'mode'      => 'css',
                        'theme'     => 'monokai',                    
                        'default'   => "#header{\nmargin: 0 auto;\n}"
                    ),
                   
					
					  array(
                        'id'        => 'opt-notice-success',
                        'type'      => 'info',
                        'notice'    => true,
                        'style'     => 'success',
                        'icon'      => 'el-icon-info-sign',
                        'title'     => __('Change Background Color & Image.', 'welcome'),
                        'desc'      => __('You can change background using WordPress core features at Appearance > Background', 'welcome')
                    ),
					
					
					   array(
                        'id'        => 'opt-notice-critical',
                        'type'      => 'info',
                        'notice'    => true,
                        'style'     => 'critical',
                        'icon'      => 'el-icon-info-sign',
                        'title'     => __('<span class="pro">Only Pro User are allwed to customize Colors and Style <a href="http://www.insertcart.com/welcome" title="insertcart.com">Upgrade to Pro</a></span></p>', 'welcome'),
                                            ),
					  array(
                        'id'        => 'opt-layout',
                        'type'      => 'image_select',
                        'compiler'  => true,
                        'title'     => __('<div class="protext">Main Layout</div>', 'welcome'),
                        'subtitle'  => __('<div class="protext">Select main content and sidebar alignment. Choose between 1, 2 or 3 column layout.</div>', 'welcome'),
                        'options'   => array(
                            '1' => array('alt' => '1 Column',       'img' => ReduxFramework::$_url . 'assets/img/1col.png'),
                            '2' => array('alt' => '2 Column Left',  'img' => ReduxFramework::$_url . 'assets/img/2cl.png'),
                            '3' => array('alt' => '2 Column Right', 'img' => ReduxFramework::$_url . 'assets/img/2cr.png'),
                            '4' => array('alt' => '3 Column Middle','img' => ReduxFramework::$_url . 'assets/img/3cm.png'),
                            '5' => array('alt' => '3 Column Left',  'img' => ReduxFramework::$_url . 'assets/img/3cl.png'),
                            '6' => array('alt' => '3 Column Right', 'img' => ReduxFramework::$_url . 'assets/img/3cr.png')
                        ),
                        'default'   => '2'
                    ),
                 
                    array(
                        'id'        => 'headerbgcolor',
                        'type'      => 'color',
                        'title'     => __('<div class="protext">Header Background Color</div>', 'welcome'),
                        'subtitle'  => __('<div class="protext">Pick a background color for the header (default: #fff).</div>', 'welcome'),
					    'default'   => '#fff',
                        'validate'  => 'color',
                    ),
					array(
                        'id'        => 'navigationbg',
                        'type'      => 'color',
                        'title'     => __('<div class="protext">Navigation Background Color</div>', 'welcome'),
                        'subtitle'  => __('<div class="protext">Pick a background color for the Top Navigation (default: #FCFCFC).</div">', 'welcome'),
                        'default'   => '#FCFCFC',
                        'validate'  => 'color',
                    ),
					array(
                        'id'        => 'navborder',
                        'type'      => 'color',
                        'title'     => __('<div class="protext">Navigation bottom border Color</div>', 'welcome'),                        
                        'default'   => '#F86E6E',
                        'validate'  => 'color',
                    ),
					array(
                        'id'        => 'contentarea',
                        'type'      => 'color',
                        'title'     => __('<div class="protext">Change main contant area</div>', 'welcome'),
						'subtitle'  => __('<div class="protext">Background color for main content area (default: #FFF).</div>', 'welcome'),							
                        'default'   => '#fff',
                        'validate'  => 'color',
                    ),	
					array(
                        'id'        => 'readmore',
                        'type'      => 'color',
                        'title'     => __('<div class="protext">Read More background color</div>', 'welcome'),
						'subtitle'  => __('<div class="protext">Background color for Read More Button(default: #FD4326).</div>', 'welcome'),							
                        'default'   => '#FD4326',
                        'validate'  => 'color',
                    ),
					array(
                        'id'        => 'widgetbg',
                        'type'      => 'color',
                        'title'     => __('<div class="protext">Change widget background color</div>', 'welcome'), 
						'subtitle'  => __('<div class="protext">Background color for widget (default: #FFF).</div>', 'welcome'),						
                        'default'   => '#fff',
                        'validate'  => 'color',
                    ),
					array(
                        'id'        => 'footerbgcolor',
                        'type'      => 'color',
                        'title'     => __('<div class="protext">Footer Background Color</div>', 'welcome'),
                        'subtitle'  => __('<div class="protext">Pick a background color for the footer (default: #333).</div>', 'welcome'),
                        'default'   => '#333',
                        'validate'  => 'color',
                    ),
              
               
                    array(
                        'id'        => 'linkcolor',
                        'type'      => 'link_color',
                        'title'     => __('<div class="protext">Links Color Option</div>', 'welcome'),
                        'subtitle'  => __('<div class="protext">Link Colors Customize </div>', 'welcome'),
                        'default'   => array(
                            'regular'   => '#2D89A7',
                            'hover'     => '#13E290',
                           
                        )
                    ),
                   
                               
                    
                )
            );

           
            $this->sections[] = array(
                'icon'      => 'el-icon-check',
                'title'     => __('Social Profiles', 'welcome'),
                'desc'      => __('<p class="description">Put Links to your social fan follow pages </p>', 'welcome'),
                'fields'    => array(
                      array(
                        'id'        => 'socialicons',
                        'type'      => 'switch',
                        'title'     => __('Enable Social Links', 'welcome'),
                        'subtitle'  => __('Turn this on!', 'welcome'),
                        'default'   => true,
                    ),
					
					array(
	                        'id'        => 'welcome_fb',
	                        'type'      => 'text',
	                        'title'     => __('Facebook', 'welcome'),
	                        'subtitle'  => __('Enter Complete URL including http://', 'welcome'),
	                        'validate'  => 'url',
	                        'default'   => 'http://facebook.com/#/',
                        ),
                        array(
	                        'id'        => 'welcome_tw',
	                        'type'      => 'text',
	                        'title'     => __('Twitter', 'welcome'),
	                        'subtitle'  => __('Enter Complete URL including http://', 'welcome'),
	                        'validate'  => 'url',
	                        'default'   => 'http://twitter.com/#/',
                        ),
                        array(
	                        'id'        => 'welcome_gp',
	                        'type'      => 'text',
	                        'title'     => __('Google+', 'welcome'),
	                        'subtitle'  => __('Enter Complete URL including http://', 'welcome'),
	                        'validate'  => 'url',
	                        'default'   => 'http://plus.google.com/#/',
                        ),
                        array(
	                        'id'        => 'welcome_rss',
	                        'type'      => 'text',
	                        'title'     => __('RSS Feed', 'welcome'),
	                        'subtitle'  => __('Enter Complete URL including http://', 'welcome'),
	                        'validate'  => 'url',
	                        'default'   => 'http://feeds.feedburner.com/#/',
                        ),  
						array(
	                        'id'        => 'welcome_youtube',
	                        'type'      => 'text',
	                        'title'     => __('YouTube Channel', 'welcome'),
	                        'subtitle'  => __('Enter Complete URL including http://', 'welcome'),
	                        'validate'  => 'url',
	                        'default'   => 'http://www.youtube.com/#/',
                        ),
						array(
	                        'id'        => 'welcome_in',
	                        'type'      => 'text',
	                        'title'     => __('LinkedIn', 'welcome'),
	                        'subtitle'  => __('Enter Complete URL including http://', 'welcome'),
	                        'validate'  => 'url',
	                        'default'   => 'http://feeds.feedburner.com/#/',
                        ),
						array(
	                        'id'        => 'welcome_pinterest',
	                        'type'      => 'text',
	                        'title'     => __('Pinterest In URL', 'welcome'),
	                        'subtitle'  => __('Enter Complete URL including http://', 'welcome'),
	                        'validate'  => 'url',
	                        'default'   => 'http://feeds.feedburner.com/#/',
                        ),
						
                      /**  array(
	                        'id'        => 'instagram',
	                        'type'      => 'text',
	                        'title'     => __('Instagram', 'welcome'),
	                        'subtitle'  => __('Enter Complete URL including http://', 'welcome'),
	                        'validate'  => 'url',
	                        'default'   => 'http://instagram.com/#/',
                        ), */
                        array(
	                        'id'        => 'welcome_flickr',
	                        'type'      => 'text',
	                        'title'     => __('Flickr', 'welcome'),
	                        'subtitle'  => __('Enter Complete URL including http://', 'welcome'),
	                        'validate'  => 'url',
	                        'default'   => 'http://flickr.com/#/',
                        ),   
						array(
	                        'id'        => 'welcome_skype',
	                        'type'      => 'text',
	                        'title'     => __('Skype', 'welcome'),
	                        'subtitle'  => __('Enter Complete URL including http://', 'welcome'),
	                        'validate'  => 'url',
	                        'default'   => 'http://www.skype.com/#',
                        ),	
						array(
	                        'id'        => 'welcomeimeo',
	                        'type'      => 'text',
	                        'title'     => __('vimeo', 'welcome'),
	                        'subtitle'  => __('Enter Complete URL including http://', 'welcome'),
	                        'validate'  => 'url',
	                        'default'   => 'http://www.vimeo.com/#',
                        ),
						array(
	                        'id'        => 'welcome_dribbble',
	                        'type'      => 'text',
	                        'title'     => __('Dribbble', 'welcome'),
	                        'subtitle'  => __('Enter Complete URL including http://', 'welcome'),
	                        'validate'  => 'url',
	                        'default'   => 'http://www.dribbble.com/#',
                        ),
						 array(
                        'id'        => 'flowshare',
                        'type'      => 'switch',
                        'title'     => __('<div class="protext">Social Share</div>', 'welcome'),
                        'subtitle'  => __('<div class="protext">Social sharing buttonts</div>', 'welcome'),
						'default'   => false,
                    ), 
					  array(
                        'id'    => 'opt-info-critical',
                        'type'  => 'info',
                        'style' => 'critical',
                        'icon'  => 'el-icon-info-sign',
                        'title' => __('<a href="' . esc_url(__('http://www.insertcart.com/welcome','welcome')) . '" target="_blank">' . esc_attr__( 'Upgrade TO Pro Version', 'digital' ) . '</a> ', 'welcome') ,
                        'desc'  => __('Premium theme user can request custom social link field or any other option in theme.', 'welcome')
                    ),
					
					
				
                )
            );
            
            $this->sections[] = array(
                'icon'      => 'el-icon-list-alt',
                'title'     => __('Advance Options', 'welcome'),
        
                'fields'    => array(
					array(
                        'id'        => 'authorfile',
                        'type'      => 'switch',
                        'title'     => __('Author Profile', 'welcome'),
                        'subtitle'  => __('Show author information below post', 'welcome'),
                        'default'   => true,
                    ),
				       array(
                        'id'        => 'welcome_latest',
                        'type'      => 'switch',
                        'title'     => __('Enable Latest Posts widget', 'welcome'),
                        'subtitle'  => __('Show numbers or latest post from blogs with thumbnail', 'welcome'),
                        'default'   => 0,
                        'on'        => 'Enabled',
                        'off'       => 'Disabled',
                    ),
					
					  array(
                        'id'            => 'latestpostnumber',
                        'type'          => 'slider',
                        'title'         => __('Numbers of Posts', 'welcome'),
                       
                        'desc'          => __('Min: 1, max: 25, default value: 5', 'welcome'),
                        'default'       => 5,
                        'min'           => 1,
                        'step'          => 1,
                        'max'           => 25,
                        'display_value' => 'label'
                    ),
					
					   array(
                        'id'        => 'latestcategories',
                        'type'      => 'select',
                        'data'      => 'categories',
                        'title'     => __('<div class="protext">Select Categories</div>', 'welcome'),
                        'desc'      => __('Select Categorie from which post to be shown.', 'welcome'),
						
                    ),
					
					array(
                        'id'        => 'popular',
                        'type'      => 'switch',
                        'title'     => __('Enable Popular Posts widget', 'welcome'),
                        'subtitle'  => __('Show numbers or popular post from blogs with thumbnail', 'welcome'),
                        'default'   => 0,
                        'on'        => 'Enabled',
                        'off'       => 'Disabled',
						
						),
						 array(
                        'id'        => 'opt-notice-critical',
                        'type'      => 'info',
                        'notice'    => true,
                        'style'     => 'critical',
                        'icon'      => 'el-icon-info-sign',
                        'title'     => __('<span class="pro">Only Pro User are allwed to use fetures below this <a href="http://www.insertcart.com/welcome" title="insertcart.com">Upgrade to Pro</a></span>', 'welcome'),
                                            ),
							  array(
                        'id'            => 'popularnumbers',
                        'type'          => 'slider',
                        'title'         => __('<div class="protext">Show Numbers of Posts</div>', 'welcome'),
                        'desc'          => __('<div class="protext">Min: 1, max: 25, default value: 5</div>', 'welcome'),
                        'default'       => 5,
                        'min'           => 1,
                        'step'          => 1,
                        'max'           => 25,
                        'display_value' => 'label'
                    ),
                    
					
					
					array(
						
                        'id'        => 'footerwidget',
                        'type'      => 'switch',
                        'title'     => __('<div class="protext">Enable Footer widget Area</div>', 'welcome'),
                        'subtitle'  => __('<div class="protext">Show Footer Widget Area</div>', 'welcome'),
                        'default'   => 0,
                        'on'        => 'Show',
                        'off'       => 'Hide',
						
						),
						array(
                        'id'        => 'breadcrumbs',
                        'type'      => 'switch',
                        'title'     => __('<div class="protext">Enable Breadcrumbs</div>', 'welcome'),
                        'subtitle'  => __('<div class="protext">Enable Breadcrumbs on posts and pages</div>', 'welcome'),
                        'default'   => 0,
                        'on'        => 'Show',
                        'off'       => 'Hide',
						),
						
						
						     array(
                        'id'        => 'postmeta',
                        'type'      => 'checkbox',
                        'title'     => __('<div class="protext">Post Meta Data</div>', 'welcome'),
                        'subtitle'  => __('<div class="protext">Check the box to show meta information into post</div>', 'welcome'),
                        
                        //Must provide key => value pairs for multi checkbox options
                        'options'   => array(
                            '1' => 'Show Author name and Date of Post', 
                            '2' => 'Display categories name', 
                            '3' => 'Show Numbers of Comment',
                            '4' => 'Show tags'
                        ),
                        
                        //See how std has changed? you also don't need to specify opts that are 0.
                        'default'   => array(
                            '1' => '0', 
                            '2' => '0', 
                            '3' => '0',
                            '4' => '0'
                        )
                    ),
					array(
                        'id'        => 'postnavi',
                        'type'      => 'switch',
                        'title'     => __('<div class="protext">Post navigation</div>', 'welcome'),
                        'subtitle'  => __('<div class="protext">navigation to next and previous post</div>', 'welcome'),
                        'default'   => 0,
                        'on'        => 'Enabled',
                        'off'       => 'Disabled',
                    ),
				   array(
                        'id'        => 'readit',
                        'type'      => 'switch',
                        'title'     => __('<div class="protext">Control Read More Button</div>', 'welcome'),
                        'subtitle'  => __('<div class="protext">Enable option to show and edit text of read more</div>', 'welcome'),
                        'default'   => 0,
                        'on'        => 'Enabled',
                        'off'       => 'Disabled',
                    ),
					array(
                        'id'        => 'readtext',
                        'type'      => 'text',
                        'required'  => array('readit', '=', '1'),
                        'title'     => __('Text for Read More button', 'welcome'),
                        'default'   => __('Read More', 'welcome'),
                    ),	
					
                )
            );

            $theme_info  = '<div class="redux-framework-section-desc">';
            $theme_info .= '<p class="redux-framework-theme-data description theme-uri">' . __('<strong>Theme URL:</strong> ', 'welcome') . '<a href="' . $this->theme->get('ThemeURI') . '" target="_blank">' . $this->theme->get('ThemeURI') . '</a></p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-author">' . __('<strong>Author:</strong> ', 'welcome') . $this->theme->get('Author') . '</p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-version">' . __('<strong>Version:</strong> ', 'welcome') . $this->theme->get('Version') . '</p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-description">' . $this->theme->get('Description') . '</p>';
            $tabs = $this->theme->get('Tags');
            if (!empty($tabs)) {
                $theme_info .= '<p class="redux-framework-theme-data description theme-tags">' . __('<strong>Tags:</strong> ', 'welcome') . implode(', ', $tabs) . '</p>';
            }
            $theme_info .= '</div>';

            if (file_exists(dirname(__FILE__) . '/../README.md')) {
                $this->sections['theme_docs'] = array(
                    'icon'      => 'el-icon-list-alt',
                    'title'     => __('Documentation', 'welcome'),
                    'fields'    => array(
                        array(
                            'id'        => '17',
                            'type'      => 'raw',
                            'markdown'  => true,
                            'content'   => WP_Filesystem(dirname(__FILE__) . '/../README.md')
                        ),
                    ),
                );
            }
            
            // You can append a new section at any time.
            $this->sections[] = array(
                'icon'      => 'el-icon-eye-open',
                'title'     => __('Ads & Banners', 'welcome'),
                'desc'      => __('<p class="description">This is the Description. Again HTML is allowed</p>', 'welcome'),
                'fields'    => array(
                 	array(
                        'id'        => 'bannertop',
                        'type'      => 'editor',
                        'title'     => __('Top Banner Code', 'welcome'),
                        'subtitle'  => __('You can use the following shortcodes in your footer text: [wp-url] [site-url] [theme-url] [login-url] [logout-url] [site-title] [site-tagline] [current-year]', 'welcome'),
                        'default'   => '',
                    ),
					array(
                        'id'        => 'singleads',
                        'type'      => 'editor',
                        'title'     => __('Single Post Ads Area', 'welcome'),
                        'subtitle'  => __('Advertise and banner area for single posts', 'welcome'),
                        'default'   => '',
                    ),
					array(
                        'id'        => 'footerads',
                        'type'      => 'editor',
                        'title'     => __('Footer Ads Area', 'welcome'),
                        'subtitle'  => __('Advertise and banner area for footer below page navigation and above footer area.', 'welcome'),
                        'default'   => '',
                    ),
					
					
                    
                )
            );

            $this->sections[] = array(
                'title'     => __('Import / Export', 'welcome'),
                'desc'      => __('Import and Export your Redux Framework settings from file, text or URL.', 'welcome'),
                'icon'      => 'el-icon-refresh',
                'fields'    => array(
                    array(
                        'id'            => 'opt-import-export',
                        'type'          => 'import_export',
                        'title'         => 'Import Export',
                        'subtitle'      => 'Save and restore your Redux options',
                        'full_width'    => false,
                    ),
                ),
            );                     
                    
            $this->sections[] = array(
                'type' => 'divide',
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-info-sign',
                'title'     => __('Theme Information', 'welcome'),
                'desc'      => __('<p class="description">Theme will look like this after fully setup</p>', 'welcome'),
                'fields'    => array(
                    array(
                        'id'        => 'opt-raw-info',
                        'type'      => 'raw',
                        'content'   => $item_info, 
                    )
                ),
            );

            if (file_exists(trailingslashit(dirname(__FILE__)) . 'README.html')) {
                $tabs['docs'] = array(
                    'icon'      => 'el-icon-book',
                    'title'     => __('Documentation', 'welcome'),
                    'content'   => nl2br(WP_Filesystem(trailingslashit(dirname(__FILE__)) . 'README.html'))
                );
            }
        }

        public function setHelpTabs() {

            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-1',
                'title'     => __('Theme Information 1', 'welcome'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'welcome')
            );

            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-2',
                'title'     => __('Theme Information 2', 'welcome'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'welcome')
            );

            // Set the help sidebar
            $this->args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'welcome');
        }

        /**

          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                'opt_name' => 'welcome',
                'page_slug' => 'welcome_options',
                'page_title' => 'Welcome Options',
                'intro_text' => '<div class="tesingh"><h2 style="color: #FFF !important">Upgrade to Premium Theme & Enable Full Features!</h2>
                          <li>SEO Optimized WordPress Theme.</li>
                          <li>Footer CopyRight Customize</li>
                          <li>Theme Customization help & Support Forum.</li>
                          <li>Page Speed Optimize for better result.</li>
                          <li>Color Customize of theme.</li>
                          <li>Custom Widgets and Functions.</li>
                          <li>Social Media Integration.</li>
                          <li>Responsive Website Design.</li>
                          <li>Different Website Layout to Select.</li>
                          <li>Many of Other customize feature for your blog or website.</li>
                          <p><span class="buypre"><a href="http://www.insertcart.com/esell" target="_blank">Upgrade to Pro Now</a></span><span class="buypred"><a href="http://www.wrock.org/setup-esell-woocommerce-premium-theme-guide/" target="_blank">How to Setup Theme !</a></span></p></div>',
                'admin_bar' => '1',
                'menu_type' => 'menu',
                'menu_title' => 'Theme Options',
                'allow_sub_menu' => '1',
                'page_parent_post_type' => 'your_post_type',
                'customizer' => '1',
                'hints' => 
                array(
                  'icon' => 'el-icon-question-sign',
                  'icon_position' => 'right',
                  'icon_size' => 'normal',
                  'tip_style' => 
                  array(
                    'color' => 'light',
                  ),
                  'tip_position' => 
                  array(
                    'my' => 'top left',
                    'at' => 'bottom right',
                  ),
                  'tip_effect' => 
                  array(
                    'show' => 
                    array(
                      'duration' => '500',
                      'event' => 'mouseover',
                    ),
                    'hide' => 
                    array(
                      'duration' => '500',
                      'event' => 'mouseleave unfocus',
                    ),
                  ),
                ),
                'output' => '1',
                'output_tag' => '1',
                'compiler' => '1',
                'page_icon' => 'icon-themes',
                'page_permissions' => 'manage_options',
                'save_defaults' => '1',
                'show_import_export' => '1',
                'transient_time' => '3600',
                'network_sites' => '1',
              );

            $theme = wp_get_theme(); // For use with some settings. Not necessary.
            $this->args["display_name"] = $theme->get("Name");
            $this->args["display_version"] = $theme->get("Version");

// SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
            $this->args['share_icons'][] = array(
                'url'   => 'http://www.insertcart.com/welcome',
                'title' => 'Visit us on Website',
                'icon'  => 'el-icon-github'
                //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
            );
            $this->args['share_icons'][] = array(
                'url'   => 'https://www.facebook.com/allnewtricks',
                'title' => 'Like us on Facebook',
                'icon'  => 'el-icon-facebook'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'http://twitter.com/wrockorg',
                'title' => 'Follow us on Twitter',
                'icon'  => 'el-icon-twitter'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'http://forum.insertcart.com',
                'title' => 'Support Forum',
                'icon'  => 'el-icon-linkedin'
            );

        }

    }
    
    global $reduxConfig;
    $reduxConfig = new welcome_Redux_Framework_config();
}

/**
  Custom function for the callback referenced above
 */
if (!function_exists('welcome_my_custom_field')):
    function welcome_my_custom_field($field, $value) {
        print_r($field);
        echo '<br/>';
        print_r($value);
    }
endif;

/**
  Custom function for the callback validation referenced above
 * */
if (!function_exists('welcomealidate_callback_function')):
    function welcomealidate_callback_function($field, $value, $existing_value) {
        $error = false;
        $value = 'just testing';

        /*
          do your validation

          if(something) {
            $value = $value;
          } elseif(something else) {
            $error = true;
            $value = $existing_value;
            $field['msg'] = 'your custom error message';
          }
         */

        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }
endif;
