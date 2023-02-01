import './editor.scss';
import { useBlockProps, InnerBlocks, InspectorControls } from '@wordpress/block-editor';
import { RangeControl, Panel, PanelBody } from "@wordpress/components"
import { __ } from '@wordpress/i18n';

const ALLOWED_BLOCKS = [ 'umw/horizontal-scroller-column' ];

export default function Edit(props) {
	const blockProps = useBlockProps({
		className: 'umw-horizontal-scroller umw-custom-block'
	});

	return (
		<div {...blockProps}>
			<div className='edit-horizontal-scroller'>
				<label className="helper-label">Horizontal Scroller</label>
				<div className="edit-horizontal-scroller__grid" style={{'--desktop-columns': parseInt(props.attributes.columns)}}>
					<InnerBlocks orientation="horizontal" allowedBlocks={ALLOWED_BLOCKS} />
				</div>
			</div>

			<InspectorControls>
				<Panel>
					<PanelBody>
						<RangeControl
							label={__('Columns on desktop')}
							value={props.attributes.columns}
							onChange={value => props.setAttributes({ columns: value })}
							min={1}
							max={6}
						/>
					</PanelBody>
				</Panel>
			</InspectorControls>
		</div>
	);
}
