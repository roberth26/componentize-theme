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
			$c = $this->get_classes();
			$class = '';
			if ( $props[ 'vertical' ] )
				$class .= $c[ 'menu--vertical' ];
			if ( $props[ 'center' ] )
				$class .= ' ' . $c[ 'menu--center' ];
			if ( $props[ 'dark' ] )
				$class .= ' ' . $c[ 'menu--dark' ];
			if ( $props[ 'icon_menu' ] )
				$class .= ' ' . $c[ 'menu--icon' ];
		?>
		<ul class="<?= $c[ 'menu' ]; ?> <?php echo $class; ?>">
			<?php foreach( $props[ 'menu_items' ] as $menu_item ) : ?>
				<?php
					$class = '';
					if ( $menu_item->object_id == $props[ 'current_page_id' ] )
						$class = $c[ 'item--current' ];
				?>
				<li class="<?= $c[ 'item' ]; ?> <?= $class; ?>">
					<a href="<?php echo $menu_item->url; ?>">
						<?php echo do_shortcode( $menu_item->title ); ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php }
}
?>