<?php 
if (!defined('ABSPATH')) {exit;}
$tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'general'; if(!in_array($tab, array('general','cloud'))) {$tab='general'; } ?>
<div class="wrap-in clearfix">
   <h2 class="wpdvr-title"><?php _e('Drivr - Google Drive Plugin by AWSM.in',$this->text_domain);?></h2>
   <div class="row clearfix">
      <div class="wpdvr-left-col">
         <ul class="wpdvr-tabs clearfix">
            <li class="<?php echo $this->getactive_menu($tab,'general');?>"><a href="<?php echo'options-general.php?page='.$this->settings_slug.'&tab=general';?>"><?php _e('General',$this->text_domain);?></a></li>
            <li class="<?php echo $this->getactive_menu($tab,'cloud');?>"><a href="<?php echo'options-general.php?page='.$this->settings_slug.'&tab=cloud';?>"><?php _e('Keys',$this->text_domain);?></a></li>
         </ul>
         <div class="wpdvr-tab-content">
            <?php if($tab =='general'):?>
            <div class="wpdvr-tab-pane active" id="wpdvr-general">
               <form method="post" action="options.php">
                  <?php settings_fields( 'drivr-settings-group' ); ?>
                  <div class="wpdvr-form-item">
                     <h3><?php _e('Manage services',$this->text_domain);?></h3>

                     <?php 
                        $service_order =   $this->options['drivr_service_list'];
                        $option_order  =   get_option('drivr_service_order', $this->settings['drivr_service_order'] ) ;
                        $order_array   =  explode(',',$option_order);
                        if(is_array($order_array)){
                           $service_order = array_merge(array_flip($order_array), $service_order);
                        }
                        $active_service  =   get_option('drivr_service_list',$this->settings['drivr_service_list']);
                        ?>
                     <ul class="wpdvr-service-list" id="drivr-service">
                        <?php 
                        foreach ($service_order as $key => $service):  
                        if(isset($this->options['drivr_service_list'][$key])):
                        ?>
                           <li id="<?php echo $key ;?>">
                              <span class="wpdvr-dragger"></span>
                              <?php echo $service; ?>
                              <label class="switch">
                                 <input name="drivr_service_list[<?php echo $key ;?>]" value="1" type="checkbox" <?php if(isset($active_service[$key])) checked( '1', $active_service[$key]); ?>>
                                 <div class="slider"></div>
                                 <span class="on"><?php _e('ON',$this->text_domain);?></span>
                                 <span class="off"><?php _e('OFF',$this->text_domain);?></span>
                              </label>
                           </li>
                        <?php 
                        endif;
                        endforeach;
                        ?>
                     </ul>
                  </div>
                  <input type="hidden" name="drivr_service_order" id="service_order" value="<?php echo $option_order;?>">
                  <!-- .wpdvr-form-item -->
                  <input type="submit" class="button button-primary button-large wpdvr-btn-lg" value="<?php _e('Save Settings',$this->text_domain);?>" />
               </form>
            </div>
            <!-- .wpdvr-tab-pane -->
            <?php elseif ($tab =='cloud'):?>
            <div class="wpdvr-tab-pane" id="wpdvr-keys">
               <form method="post" action="options.php">
               <?php settings_fields( 'drivr-cloud-group' ); ?>
                  <div class="wpdvr-form-item">
                     <h3><?php _e('Google API Access',$this->text_domain);?></h3>
                     <ul class="row clearfix">
                        <li class="form-col-2">
                           <label for="wpdvr-client-id"><?php _e('Client ID',$this->text_domain);?></label>
                           <input type="text" value="<?php echo get_option('drivr_clientid');?>" name="drivr_clientid" class="wpdvr-form-control" id="wpdvr-client-id"  />
                        </li>
                        <li  class="form-col-2">
                           <label for="wpdvr-api-key"><?php _e('API Key',$this->text_domain);?></label>
                           <input type="text" value="<?php echo get_option('drivr_apikey');?>" name="drivr_apikey" class="wpdvr-form-control" id="wpdvr-api-key"  />
                        </li>
                     </ul>
                     <p class="wpdvr-help-block"><a href="https://console.developers.google.com/project" target="_blank"><?php _e('Get my key',$this->text_domain);?></a> | <a href="https://awsm.in/drivr-documentation/#driveapi" target="_blank"><?php _e('How to get it?',$this->text_domain);?></a></p>
                  </div>
                  <!-- .wpdvr-form-item -->
                  <input type="submit" class="button button-primary button-large wpdvr-btn-lg" value="Save Keys" />
               </form>
            </div>
            <!-- .wpdvr-tab-pane -->
            <?php endif;?>
         </div>
         <!-- .wpdvr-tab-content -->
      </div>
      <!--.wpdvr-left-col-->
      <div class="wpdvr-right-col">
         <div class="wpdvr-right-widget we-are-awsm">
            <div class="awsm-branding">
               <img src="<?php echo $this->plugin_url;?>/images/awsm-logo.png" width="67" height="67" alt="AWSM Innovations">
               <div class="left-clear">
                  <h2><?php _e('Designed and developed by',$this->text_domain);?></h2>
                  <h3><a href="http://awsm.in/" target="_blank"><?php _e('awsm innovations',$this->text_domain);?></a></h3>
                  <ul class="awsm-social">
                     <li><a href="https://www.facebook.com/awsminnovations" target="_blank" title="AWSM Innovations"><span class="awsm-icon awsm-icon-facebook">Facebook</span></a></li>
                     <li><a href="https://twitter.com/awsmin" target="_blank" title="AWSM Innovations"><span class="awsm-icon awsm-icon-twitter">Twitter</span></a></li>
                     <li><a href="https://github.com/awsmin" target="_blank" title="AWSM Innovations"><span class="awsm-icon awsm-icon-github">Github</span></a></li>
                     <li><a href="https://www.behance.net/awsmin" target="_blank" title="AWSM Innovations"><span class="awsm-icon awsm-icon-behance">Behance</span></a></li>
                  </ul>
               </div>
            </div>
         </div>
         <!-- .wpdvr-right-inner -->
         <div class="clearfix row-2 wpdvr-right-widget">
            <div class="col-2">
               <a href="https://wordpress.org/support/view/plugin-reviews/embed-any-document#postform" target="_blank">
               <img src="<?php echo $this->plugin_url;?>images/star.gif"><?php _e('Like the plugin?', $this->text_domain);?><br/><?php _e('Rate Now!', $this->text_domain);?>
               </a>
            </div>
            <!-- .col-2 -->
            <div class="col-2">
               <a href="http://awsm.in/support" target="_blank">
               <img src="<?php echo $this->plugin_url;?>images/ticket.gif"><?php _e('Need Help?', $this->text_domain);?><br/><?php _e('Open a Ticket', $this->text_domain);?>
               </a>
            </div>
            <!-- .col-2 -->
         </div>
         <!-- .row -->
         <div class="wpdvr-right-inner">
            <h3><?php _e('More Links', $this->text_domain); ?></h3>
            <ol>
               <li><a href="http://awsm.in/drivr-documentation/#cloudapi" target="_blank" title="<?php _e('Getting Google Drive API Keys', $this->text_domain); ?>"><?php _e('Getting Google Drive API Keys', $this->text_domain); ?></a></li>
               <li><a href="http://awsm.in/drivr-documentation/#faqs" target="_blank" title="<?php _e('FAQs', $this->text_domain); ?>"><?php _e('FAQs', $this->text_domain); ?></a></li>
            </ol>
         </div>
         <!-- .wpdvr-right-inner -->
      </div>
      <!--.wpdvr-right-col-->
   </div>
   <!--.row -->
</div>
<!-- .wrap-in -->