import { InnerBlocks } from '@wordpress/block-editor';

export default function save() {
	return (
		<div className='edit-horizontal-scroller'>
			<div className='edit-horizontal-scroller__grid'>
				<InnerBlocks.Content />
			</div>
		</div>
	);
}