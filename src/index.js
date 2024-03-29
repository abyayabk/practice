import "./index.scss";
import { TextControl, Flex, FlexBlock, Button, FlexItem } from '@wordpress/components';
import { useState, useEffect, useRef } from 'react';
import { InspectorControls, useBlockProps } from "@wordpress/block-editor"
import { PanelBody, RangeControl } from "@wordpress/components";
import Save from './viewscript.js';
//import Edit from './edit.js';


wp.blocks.registerBlockType('my-plugin/view-block', {
    title: "View Block",
    icon: 'smiley',
    category: 'common',
    attributes: {},
    edit: Edit,
})

export default function Edit(props){
    const { attributes, setAttributes } = props

    const images = value.images; // Access the images array

    useEffect(() => {
        // Set the poster attribute to the images array directly
        setAttributes({ poster: value.images });
    }, [value.images]);   
    
    const [currentSlide, setCurrentSlide] = useState(0);    

    const handleNext = () => {
        setCurrentSlide((prevIndex) =>
            prevIndex + 1 === images.length ? 0 : prevIndex + 1
        );
    };

    const handlePrevious = () => {
        setCurrentSlide((prevIndex) =>
            prevIndex - 1 < 0 ? images.length - 1 : prevIndex - 1
        );
    };

    const handleDotClick = (index) => {
        setCurrentSlide(index);
    };

    function CarouselSlider() {
        return (
            <div className="carousel" style={{ width: "500px", height: "500px" }}>
                <div className='slider'>
                    <img style={{ width: "500px", height: "500px" }}
                        key={currentSlide}
                        src={images[currentSlide]}
                    />
                </div>
                <div className="slide_direction">
                    <div className="left" onClick={handlePrevious}>
                        {/* Left arrow SVG */}
                    </div>
                    <div className="right" onClick={handleNext}>
                        {/* Right arrow SVG */}
                    </div>
                </div>
                <div className="indicator">
                    {images.map((_, index) => (
                        <div
                            key={index}
                            className={`dot ${currentSlide === index ? "active" : ""}`}
                            onClick={() => handleDotClick(index)}
                        ></div>
                    ))}
                </div>
            </div>
        );
    }

    return (
        <div>
            <CarouselSlider />
        </div>
    );
}

