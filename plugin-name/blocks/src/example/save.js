import './style.scss';
import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';

export default function save(props) {
	return (
		<div {...useBlockProps.save({
			className: 'umw-horizontal-scroller umw-custom-block',
			'data-module': 'horizontal-scroller',
		})}>
			<div className='umw-horizontal-scroller__inner'>
				<div className='umw-horizontal-scroller__wrapper'>
					<div className={`umw-horizontal-scroller__grid umw-horizontal-scroller__grid--columns-${parseInt(props.attributes.columns)}`}>
						<InnerBlocks.Content />
						<div className='umw-horizontal-scroller__spacer' />
					</div>
				</div>
			</div>
		</div>
	);
}
