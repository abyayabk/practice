import { TextControl, Flex, FlexBlock, Button, FlexItem } from '@wordpress/components';
import { useState, useEffect, useRef } from 'react';
import { InspectorControls, useBlockProps } from "@wordpress/block-editor"
import { PanelBody, RangeControl } from "@wordpress/components"; 

export default function Edit(props){
    console.log("hello from edittttt");
    const { attributes, setAttributes } = props

    const { poster} = attributes

    const images = value.images; // Access the images array
    
    console.log(images)
    const [currentSlide, setCurrentSlide] = useState(0);

    useEffect( () =>{
        setAttributes({poster: images})
    }, images)

    console.log(poster)

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