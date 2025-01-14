// Created by Michael Morales
// JavaScript for Custom Gutenberg CTA Block Editor

const { registerBlockType } = wp.blocks;
const { TextControl } = wp.components;
const { useState } = wp.element;

// Registering the custom Gutenberg block
registerBlockType('custom/cta-block', {
    title: 'Custom CTA Block',
    icon: 'megaphone',
    category: 'common',
    attributes: {
        ctaText: {
            type: 'string',
            default: 'Click here for more!',
        },
    },

    // Edit function for the block's editor interface
    edit({ attributes, setAttributes }) {
        const [ctaText, setCtaText] = useState(attributes.ctaText);

        const handleChange = (value) => {
            setCtaText(value);
            setAttributes({ ctaText: value });
        };

        return (
            <div className="cta-block-editor">
                <TextControl
                    label="Call to Action Text"
                    value={ctaText}
                    onChange={handleChange}
                />
            </div>
        );
    },

    // Save function to render content on the front-end
    save({ attributes }) {
        return (
            <div className="cta-block">
                <p>{attributes.ctaText}</p>
            </div>
        );
    },
});
