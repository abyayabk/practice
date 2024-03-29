import { useState } from 'react';

export default function Save(props){
    //const imagesArray = props.attributes.poster;
    const images = value.images; // Access the images array
    const arr = ['a', 'b', 'c']
    console.log(images)
    console.log(arr)  

    /*const [currentSlide, setCurrentSlide] = useState(0);

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
                        {}
                    </div>
                    <div className="right" onClick={handleNext}>
                        {}
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
    );*/
}