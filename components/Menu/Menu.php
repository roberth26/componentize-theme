<?php
require_once( get_component_directory() . '/AbstractComponent.php' );

class Menu extends AbstractComponent {
	function __construct() {
		// set the default props
		$this->set_default_props( array(
			'vertical' => false,
			'center' => false,
			'dark' => false,
			'menu_items' => array(),
			'current_page_id' => 0,
			'icon_menu' => false
		));
	}
	function render( $props ) { ?>
		<?php
			$class = '';
			if ( $props[ 'vertical' ] )
				$class .= 'menu--vertical';
			if ( $props[ 'center' ] )
				$class .= ' menu--center';
			if ( $props[ 'dark' ] )
				$class .= ' menu--dark';
			if ( $props[ 'icon_menu' ] )
				$class .= ' menu--icon';
		?>
		<ul class="menu <?php echo $class; ?>">
			<?php foreach( $props[ 'menu_items' ] as $menu_item ) : ?>
				<?php
					$class = '';
					if ( $menu_item->object_id == $props[ 'current_page_id' ] )
						$class = 'menu__item--current';
				?>
				<li class="menu__item <?php echo $class; ?>">
					<a href="<?php echo $menu_item->url; ?>">
						<?php echo do_shortcode( $menu_item->title ); ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php }
}
?>