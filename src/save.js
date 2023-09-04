import { 
    InnerBlocks, 
    InspectorControls, 
    useBlockProps 
} from '@wordpress/block-editor';

export default function save( props ) {

	const blockProps = useBlockProps.save({
		className: `dmg-alert ${props.attributes.selectedOption}`,
	});

	return (
		<div {...blockProps}>
			<InnerBlocks.Content />
		</div>
	);
	
}
