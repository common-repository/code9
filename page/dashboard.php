<?php
function code9_dashboard() {
  

  wp_enqueue_style('code9-style', $GLOBALS['CODE9_PLUGIN_URL'] . 'assets/code9.css', array(), '1.0.1');
  wp_enqueue_style('gridjs_mermaid', $GLOBALS['CODE9_PLUGIN_URL'] . 'assets/mermaid.min.css');
  wp_enqueue_style( 'wp-color-picker' );
  wp_enqueue_style( 'code-editor' );
  
  wp_enqueue_script('code9-spa', $GLOBALS['CODE9_PLUGIN_URL'] . 'assets/spa.js');
  wp_enqueue_script('gridjs', $GLOBALS['CODE9_PLUGIN_URL'] . 'assets/gridjs.umd.js');

  $js = ['language.js','crypto-js.min.js', 'aes.min.js','crypto.js','cookie.js','api.js','query.js','string_random.js','form_obj.js','dom_loading.js','slider.js'];

  foreach($js as $name) {
    wp_enqueue_script($name, $GLOBALS['CODE9_PLUGIN_URL'] . 'assets/' . $name, array());
  }
  
  wp_enqueue_script( 'code-editor' );
  wp_enqueue_script( 'csslint' );
  wp_enqueue_script( 'jshint' );
  wp_enqueue_script( 'jsonlint' );
  wp_enqueue_script( 'wp-color-picker');
  
  wp_enqueue_style('code9-page-editor-style-component_confirm', $GLOBALS['CODE9_PLUGIN_URL'] . 'assets/component/confirm/confirm.css', array() , '1.0.0');
  wp_enqueue_script('code9-page-editor-component-confirm' , $GLOBALS['CODE9_PLUGIN_URL'] . 'assets/component/confirm/confirm.js', array() , '1.0.0', true);

  wp_enqueue_style('code9-page-editor-style-component_noti', $GLOBALS['CODE9_PLUGIN_URL'] . 'assets/component/noti/noti.css', array() , '1.0.0');
  wp_enqueue_script('code9-page-editor-component-noti' , $GLOBALS['CODE9_PLUGIN_URL'] . 'assets/component/noti/noti.js', array() , '1.0.0', true);

  wp_enqueue_style('code9-page-editor-style-component_popup', $GLOBALS['CODE9_PLUGIN_URL'] . 'assets/component/popup/popup.css', array() , '1.0.0');
  wp_enqueue_script('code9-page-editor-component-popup' , $GLOBALS['CODE9_PLUGIN_URL'] . 'assets/component/popup/popup.js', array() , '1.0.0', true);

  wp_enqueue_style('code9-page-editor-style-component_popup_drag', $GLOBALS['CODE9_PLUGIN_URL'] . 'assets/component/popup_drag/popup_drag.css', array() , '1.0.0');
  wp_enqueue_script('code9-page-editor-component-popup_drag' , $GLOBALS['CODE9_PLUGIN_URL'] . 'assets/component/popup_drag/popup_drag.js', array() , '1.0.0', true);

  wp_enqueue_style('code9-page-editor-style-component_tab', $GLOBALS['CODE9_PLUGIN_URL'] . 'assets/component/tab/tab.css', array() , '1.0.0');
  wp_enqueue_script('code9-page-editor-component-tab' , $GLOBALS['CODE9_PLUGIN_URL'] . 'assets/component/tab/tab.js', array() , '1.0.0', true);


  wp_enqueue_media();
?>
<script type="text/javascript">
var C9_WP = {
  admin_url: "<?php echo admin_url(); ?>"
};
</script>
<div id="c9-wrap">
  <div class="c9-margin-bottom-small">
    <h1 class="c9-title"><span class="c9-logo"></span> Code9</h1>
  </div>

  <div id="c9-body">
    <div class="c9-grid">
      <div id="c9-side" class="c9-width-auto@m c9-width-1-1">      
        <div id="c9-side-middle">
            <?php
            $menus = [
              [
                "label"=>'security',
                "uppercase"=>false,
                "icon"=>'<span class="dashicons dashicons-admin-network"></span>'
              ],
            ];

            for($index=0; $index<count($menus); $index++) {
              echo "<a href=\"". admin_url( 'admin.php?page=code9&spa=' . $menus[$index]["label"] ) . "\"" . ($menus[$index]["uppercase"] === true ? " class=\"c9-text-uppercase\"" : "") . " data-link=\"{$menus[$index]["label"]}\">{$menus[$index]["icon"]} {$menus[$index]["label"]}</a>";
            }

            ?>
          </div>
        </div>
      <div class="c9-width-expand@m c9-width-1-1">
        <div id="c9-main">
          <span class="c9-loading"></span>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
}

?>