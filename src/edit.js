import { __ } from '@wordpress/i18n';
import { SelectControl, PanelBody  } from '@wordpress/components';
import { useState, Fragment } from '@wordpress/element';

import './style.scss';
import './editor.scss';

import { 
    InnerBlocks, 
    InspectorControls, 
    useBlockProps 
} from '@wordpress/block-editor';

import './editor.scss';

export default function Edit(props) {

	 // Use the useState hook to manage the selected option
	 const [selectedOption, setSelectedOption] = useState(props.attributes.selectedOption);

	 const allowed_inner_blocks = ['core/paragraph', 'core/list']

	 // Handle the option change
	 function onChangeOption(newOption) {
		 setSelectedOption(newOption); // Update the state
		 props.setAttributes({ selectedOption: newOption }); // Update the attribute
	 }
	 
	 const blockProps = useBlockProps({
		 className: `dmg-alert ${props.attributes.selectedOption}`,
	 });

	 return (
		 <div  {...blockProps}>
			 
			 <InspectorControls>
				 <PanelBody>
					 <SelectControl
						 label="Select your style"
						 value={selectedOption} // Use the state value
						 options={[
							 { label: '-- Please Select', value: '' },
							 { label: 'Notice', value: 'notice' },
							 { label: 'Warning', value: 'warning' },
							 { label: 'Error', value: 'error' },
						 ]}
						 onChange={onChangeOption} // Use the state updater function
					 />
				 </PanelBody>
			 </InspectorControls>
			 <InnerBlocks allowedBlocks={ allowed_inner_blocks } />
		 </div>
	 );

	
}
